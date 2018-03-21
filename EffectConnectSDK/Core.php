<?php
    namespace EffectConnectSDK;

    use EffectConnectSDK\Core\CallType\OrderCall;
    use EffectConnectSDK\Core\CallType\OrderListCall;
    use EffectConnectSDK\Core\CallType\ProductsCall;
    use EffectConnectSDK\Core\Exception\InvalidApiCallException;
    use EffectConnectSDK\Core\Helper\Keychain;
    use EffectConnectSDK\Core\Interfaces\CallTypeInterface;

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
        public function __construct($keychain)
        {
            if (!$keychain->_isValid())
            {
                throw new \Exception('Invalid keychain.');
            }
            $this->_keychain = $keychain;
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