<?php

    namespace EffectConnectSDK\Core\Exception;

    /**
     * Class MissingCertificateLocationException
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package BlackBox
     */
    final class MissingCertificateLocationException extends \Exception
    {
        public function __construct()
        {
            parent::__construct('Missing certificate location. Set the ApiCall::CERTIFICATE_LOCATION value.');
        }
    }