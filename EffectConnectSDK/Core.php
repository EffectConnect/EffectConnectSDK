<?php
    namespace EffectConnectSDK;

    use EffectConnectSDK\Core\CallType\OrderCall;
    use EffectConnectSDK\Core\CallType\OrderListCall;
    use EffectConnectSDK\Core\CallType\ProcessCall;
    use EffectConnectSDK\Core\CallType\ProductsCall;
    use EffectConnectSDK\Core\CallType\ReportCall;
    use EffectConnectSDK\Core\Exception\InvalidApiCallException;
    use EffectConnectSDK\Core\Exception\InvalidKeyException;
    use EffectConnectSDK\Core\Exception\InvalidSignatureException;
    use EffectConnectSDK\Core\Exception\MissingArgumentException;
    use EffectConnectSDK\Core\Helper\Keychain;
    use EffectConnectSDK\Core\Interfaces\CallTypeInterface;
    use EffectConnectSDK\Core\Model\EffectConnectEvent;

    /**
     * Class Core
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     * @method OrderCall     OrderCall()
     * @method OrderListCall OrderListCall()
     * @method ProductsCall  ProductsCall()
     * @method ProcessCall   ProcessCall()
     * @method ReportCall    ReportCall()
     */
    final class Core
    {
        /**
         * @var Keychain
         */
        private $_keychain;

        /**
         * Core constructor.
         *
         * @param Keychain $keychain
         *
         * @throws \Exception
         */
        public function __construct(Keychain $keychain)
        {
            if (!$keychain->_isValid())
            {
                throw new \Exception('Invalid keychain.');
            }
            $this->_keychain = $keychain;
        }

        /**
         * @return EffectConnectEvent
         *
         * @throws InvalidKeyException
         * @throws InvalidSignatureException
         * @throws MissingArgumentException
         */
        final public function readEvent()
        {
            $publicKey  = $_SERVER['HTTP_KEY'];
            if ($publicKey !== $this->_keychain->getPublicKey())
            {
                throw new InvalidKeyException('Public');
            }
            $event               = $_SERVER['HTTP_EVENT'];
            $timestamp           = $_SERVER['HTTP_TIME'];
            $signature           = $_SERVER['HTTP_SIGNATURE'];
            $digest              = [$publicKey, $event, $timestamp];
            $signatureValidation = base64_encode(hash_hmac('sha512', implode('', $digest), $this->_keychain->getSecretKey(), true));
            if ($signature !== $signatureValidation)
            {
                throw new InvalidSignatureException();
            }
            if (!array_key_exists('eventPayload', $_POST) || $_POST['eventPayload'] === '')
            {
                throw new MissingArgumentException('$_POST["eventPayload"]');
            }
            $message    = base64_decode($_POST['eventPayload'], true);
            $size       = openssl_cipher_iv_length('aes-256-ctr');
            $nonce      = mb_substr($message, 0, $size, '8bit');
            $encrypted  = mb_substr($message, $size, null, '8bit');
            $decrypted  = openssl_decrypt($encrypted, 'aes-256-ctr', hex2bin(md5($signature.$this->_keychain->getSecretKey())), OPENSSL_RAW_DATA, $nonce);
            $eventModel = new EffectConnectEvent($event, $decrypted, new \DateTime($timestamp, new \DateTimeZone('Europe/Amsterdam')));

            return $eventModel;
        }

        /**
         * @param $name
         * @param $arguments
         *
         * @return CallTypeInterface
         * @throws \Exception
         */
        final public function __call($name, $arguments)
        {
            try
            {
                $reflection = new \ReflectionClass('EffectConnectSDK\Core\CallType\\'.$name);

                return $reflection->newInstanceArgs([$this->_keychain]);
            } catch (\Exception $exception)
            {
                throw new InvalidApiCallException($name);
            }
        }
    }