<?php
    namespace EffectConnectSDK\Core\Exception;

    /**
     * Class InvalidStatusException
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     */
    final class InvalidStatusException extends \Exception
    {
        public function __construct()
        {
            parent::__construct('Invalid order status.');
        }
    }