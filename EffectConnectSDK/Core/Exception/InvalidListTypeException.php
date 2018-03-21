<?php
    namespace EffectConnectSDK\Core\Exception;
    /**
     * Class InvalidStatusException
     *
     * @author  Mark Thiesen
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     */
    final class InvalidListTypeException extends \Exception
    {
        public function __construct()
        {
            parent::__construct('Invalid list type.');
        }
    }