<?php
    namespace EffectConnectSDK\Core\Helper;

    use EffectConnectSDK\Core\Exception\InvalidKeyException;

    /**
     * Class Keychain
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     */
    final class Keychain
    {
        /**
         * @var string $_publicKey
         */
        private $_publicKey;

        /**
         * @var string $_secretKey
         */
        private $_secretKey;

        /**
         * @return string
         */
        public function getPublicKey()
        {
            return $this->_publicKey;
        }

        /**
         * @param string $publicKey
         *
         * @return Keychain
         * @throws InvalidKeyException
         */
        public function setPublicKey($publicKey)
        {
            if (strlen($publicKey) !== 24)
            {
                throw new InvalidKeyException('Public');
            }
            $this->_publicKey = $publicKey;

            return $this;
        }

        /**
         * @return string
         */
        public function getSecretKey()
        {
            return $this->_secretKey;
        }

        /**
         * @param string $secretKey
         *
         * @return Keychain
         * @throws InvalidKeyException
         */
        public function setSecretKey($secretKey)
        {
            if (strlen($secretKey) !== 32)
            {
                throw new InvalidKeyException('Secret');
            }
            $this->_secretKey = $secretKey;

            return $this;
        }
    }