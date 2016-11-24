<?php
    namespace EffectConnectSDK\Core\Interfaces;
    use EffectConnectSDK\Core\Exception\InvalidCallActionException;
    use EffectConnectSDK\Core\Exception\InvalidPayloadException;

    /**
     * Interface CallValidatorInterface
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     */
    interface CallValidatorInterface
    {
        /**
         * @param string $callAction
         *
         * @throws InvalidCallActionException
         */
        public function setup($callAction);

        /**
         * @param $argument
         *
         * @return bool
         *
         * @throws InvalidPayloadException
         */
        public function validateCall($argument);
    }