<?php
    namespace EffectConnectSDK\Core\Exception;

    /**
     * Class InvalidResponseTypeException
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     */
    final class InvalidResponseTypeException extends \Exception
    {
        public function __construct()
        {
            parent::__construct('Invalid response type.');
        }
    }