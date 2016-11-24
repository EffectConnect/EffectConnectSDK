<?php
    namespace EffectConnectSDK\Core\Exception;

    /**
     * Class InvalidCallTypeException
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     */
    final class InvalidCallTypeException extends \Exception
    {
        public function __construct()
        {
            parent::__construct('Invalid calltype.');
        }
    }