<?php
    namespace EffectConnectSDK\Core\Exception;

    /**
     * Class InvalidAddressTypeException
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     */
    final class InvalidAddressTypeException extends \Exception
    {
        public function __construct()
        {
            parent::__construct('Incorrect address type.');
        }
    }