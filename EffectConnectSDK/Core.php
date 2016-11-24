<?php
    namespace EffectConnectSDK;

    use EffectConnectSDK\Core\CallType\KeyCall;
    use EffectConnectSDK\Core\CallType\OrderCall;
    use EffectConnectSDK\Core\Exception\InvalidApiCallException;
    use EffectConnectSDK\Core\Helper\Keychain;

    /**
     * Class Core
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     * @method OrderCall OrderCall()
     * @method KeyCall KeyCall()
     */
    final class Core
    {
        const SDK_VERSION   = '1.0';
        /**
         * @var Keychain
         */
        private $_keychain;

        public function __construct(Keychain $keychain)
        {
            $this->_keychain = $keychain;
        }

        public function __call($name, $arguments)
        {
            $class = 'EffectConnectSDK\Core\CallType\\'.$name;
            if (class_exists($class))
            {
                return new $class($this->_keychain);
            }

            throw new InvalidApiCallException($name);
        }
    }