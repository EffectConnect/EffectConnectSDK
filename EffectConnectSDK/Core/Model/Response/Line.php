<?php
    namespace EffectConnect\PHPSdk\Core\Model\Response;

    use EffectConnect\PHPSdk\Core\Helper\Payload;

    /**
     * Class Line
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     */
    final class Line
    {
        /**
         * @var LineIdentifiers $_identifiers
         */
        private $_identifiers;
        /**
         * @var int $_productId
         */
        private $_productId;
        /**
         * @var string $_productTitle
         */
        private $_productTitle;
        /**
         * @var float $_lineAmount
         */
        private $_lineAmount;
        /**
         * @var string $_status
         */
        private $_status;
        /**
         * @var LineStatusHistory[] $_statusHistory
         */
        private $_statusHistory = [];
        /**
         * @var LineFee[] $_fees
         */
        private $_fees          = [];
        /**
         * @var LineAttribute[] $_attributes
         */
        private $_attributes    = [];
        /**
         * @var LineProductIdentifiers $_product
         */
        private $_product;

        /**
         * Line constructor.
         *
         * @param $payload
         */
        public function __construct($payload)
        {
            $this->_identifiers   = new LineIdentifiers(Payload::extract($payload, 'identifiers'));
            $this->_productId     = Payload::extract($payload, 'productId');
            $this->_productTitle  = Payload::extract($payload, 'productTitle');
            $this->_lineAmount    = (float)Payload::extract($payload, 'lineAmount');
            $this->_status        = Payload::extract($payload, 'status');
            $this->_product = new LineProductIdentifiers(Payload::extract($payload, 'product'));
            if (Payload::contains($payload, 'statusHistory'))
            {
                foreach (Payload::extract($payload, 'statusHistory', true) as $historyNode)
                {
                    $this->_statusHistory[] = new LineStatusHistory($historyNode);
                }
            }
            if (Payload::contains($payload, 'fees'))
            {
                foreach (Payload::extract($payload, 'fees', true) as $fee)
                {
                    $this->_fees[] = new LineFee($fee);
                }
            }
            if (Payload::contains($payload, 'attributes'))
            {
                foreach (Payload::extract($payload, 'attributes', true) as $attribute)
                {
                    $this->_attributes[] = new LineAttribute($attribute);
                }
            }
        }

        /**
         * @return LineIdentifiers
         */
        public function getIdentifiers()
        {
            return $this->_identifiers;
        }

        /**
         * @return int
         */
        public function getProductId()
        {
            return $this->_productId;
        }

        /**
         * @return string
         */
        public function getProductTitle()
        {
            return $this->_productTitle;
        }

        /**
         * @return float
         */
        public function getLineAmount()
        {
            return $this->_lineAmount;
        }

        /**
         * @return string
         */
        public function getStatus()
        {
            return $this->_status;
        }

        /**
         * @return LineStatusHistory[]
         */
        public function getStatusHistory()
        {
            return $this->_statusHistory;
        }

        /**
         * @return LineFee[]
         */
        public function getFees()
        {
            return $this->_fees;
        }

        /**
         * @return LineAttribute[]
         */
        public function getAttributes(): array
        {
            return $this->_attributes;
        }

        /**
         * @return LineProductIdentifiers
         */
        public function getProduct()
        {
            return $this->_product;
        }
    }
