<?php

    namespace EffectConnectSDK\Core\Exception;

    /**
     * Class InvalidSignatureException
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     */
    final class InvalidSignatureException extends \Exception
    {
        public function __construct()
        {
            parent::__construct('Invalid signature');
        }
    }