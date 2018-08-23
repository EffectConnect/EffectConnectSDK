<?php
    namespace EffectConnect\PHPSdk\Core\Interfaces;

    use EffectConnect\PHPSdk\ApiCall;
    use EffectConnect\PHPSdk\Core\Exception\InvalidCallTypeException;
    use EffectConnect\PHPSdk\Core\Helper\Keychain;

    /**
     * Interface CallTypeInterface
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     */
    interface CallTypeInterface
    {
        const ACTION_CREATE         = 'create';
        const ACTION_READ           = 'read';
        const ACTION_UPDATE         = 'update';
        const ACTION_DELETE         = 'delete';

        const RESPONSE_TYPE_XML     = 'xml';
        const RESPONSE_TYPE_JSON    = 'json';

        /**
         * @param Keychain $keychain
         */
        public function __construct($keychain);

        /**
         * @param string $responseType
         *
         * @return CallTypeInterface
         */
        public function setResponseType($responseType);

        /**
         * @param string $responseLanguage
         *
         * @return CallTypeInterface
         */
        public function setResponseLanguage($responseLanguage);
    }