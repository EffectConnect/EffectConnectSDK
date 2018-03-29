<?php

    namespace EffectConnectSDK\Core\Exception;

    /**
     * Class MissingCertificateFileException
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package BlackBox
     */
    final class MissingCertificateFileException extends \Exception
    {
        public function __construct($location)
        {
            parent::__construct(sprintf('Certificate at location `%s` does not exist.', $location));
        }
    }