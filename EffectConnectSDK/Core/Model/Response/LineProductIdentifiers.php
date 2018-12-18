<?php
    namespace EffectConnect\PHPSdk\Core\Model\Response;

    use EffectConnect\PHPSdk\Core\Helper\Payload;

    /**
     * Class LineProductIdentifiers
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     */
    final class LineProductIdentifiers
    {
        /**
         * @var string $_id
         */
        private $_id;
        /**
         * @var string $_ean
         */
        private $_ean;
        /**
         * @var string $_sku
         */
        private $_sku;

        /**
         * LineProductIdentifiers constructor.
         *
         * @param $payload
         */
        public function __construct($payload)
        {
            if ($payload === null)
            {
                return;
            }
            $this->_id  = Payload::extract($payload, 'ID');
            $this->_ean = Payload::extract($payload, 'EAN');
            $this->_sku = Payload::extract($payload, 'SKU');
        }

        /**
         * @return string
         */
        public function getId()
        {
            return $this->_id;
        }

        /**
         * @return string
         */
        public function getEan()
        {
            return $this->_ean;
        }

        /**
         * @return string
         */
        public function getSku()
        {
            return $this->_sku;
        }
    }