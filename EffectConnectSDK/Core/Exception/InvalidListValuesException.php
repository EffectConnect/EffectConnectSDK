<?php
    namespace EffectConnect\PHPSdk\Core\Exception;
    /**
     * Class InvalidStatusException
     *
     * @author  Mark Thiesen
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     */
    final class InvalidListValuesException extends \Exception
    {
        public function __construct()
        {
            parent::__construct('Invalid list values.');
        }
    }