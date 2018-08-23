<?php

    namespace EffectConnect\PHPSdk\Core\Exception;

    /**
     * Class MissingArgumentException
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     */
    final class MissingArgumentException extends \Exception
    {
        public function __construct($argument)
        {
            parent::__construct(vsprintf('Missing argument `%s`.', [$argument]));
        }
    }