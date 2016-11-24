<?php
    namespace EffectConnectSDK\Core\Exception;

    /**
     * Class IncorrectArgumentException
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     */
    final class IncorrectArgumentException extends \Exception
    {
        public function __construct()
        {
            parent::__construct('Incorrect number of arguments given.');
        }
    }