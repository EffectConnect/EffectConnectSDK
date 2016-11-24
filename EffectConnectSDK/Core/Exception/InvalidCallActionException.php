<?php
    namespace EffectConnectSDK\Core\Exception;

    /**
     * Class InvalidCallActionException
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     */
    final class InvalidCallActionException extends \Exception
    {
        public function __construct()
        {
            parent::__construct('Invalid call action.');
        }
    }