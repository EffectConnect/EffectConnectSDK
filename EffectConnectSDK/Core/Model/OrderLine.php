<?php

    namespace EffectConnectSDK\Core\Model;

    use EffectConnectSDK\Abstracts\ApiModel;

    /**
     * Class OrderLine
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     */
    final class OrderLine extends ApiModel
    {

        /**
         * REQUIRED
         * @var int $_amount
         *
         * The amount of products
         */
        protected $_amount;

        /**
         * OPTIONAL
         * @var string $_ean
         *
         * Product European Article Number
         */
        protected $_ean;

        /**
         * REQUIRED
         * @var int $_id
         *
         * Line Identifier
         */
        protected $_id;

        /**
         * REQUIRED
         * @var int $_optionId
         *
         * Product option ID
         */
        protected $_optionId;

        /**
         * REQUIRED
         * @var int $_price
         *
         * Product unit price
         */
        protected $_price;

        /**
         * OPTIONAL
         * @var string $_sku
         *
         * Product Stock Keeping Unit
         */
        protected $_sku;

        /**
         * OPTIONAL
         * @var int $_transactionFee
         *
         * Transaction fee in cents
         */
        protected $_transactionFee;

        /**
         * @return string
         */
        public function getName()
        {
            return 'orderLine';
        }

        /**
         * @return int
         */
        public function getAmount()
        {
            return $this->_amount;
        }

        /**
         * @param int $amount
         *
         * @return OrderLine
         */
        public function setAmount($amount)
        {
            $this->_amount = $amount;

            return $this;
        }

        /**
         * @return int
         */
        public function getId()
        {
            return $this->_id;
        }

        /**
         * @param int $id
         *
         * @return OrderLine
         */
        public function setId($id)
        {
            $this->_id = $id;

            return $this;
        }

        /**
         * @return int
         */
        public function getOptionId()
        {
            return $this->_optionId;
        }

        /**
         * @param int $optionId
         *
         * @return OrderLine
         */
        public function setOptionId($optionId)
        {
            $this->_optionId = $optionId;

            return $this;
        }

        /**
         * @return int
         */
        public function getPrice()
        {
            return $this->_price;
        }

        /**
         * @param int $price
         *
         * @return OrderLine
         */
        public function setPrice($price)
        {
            $this->_price = $price;

            return $this;
        }

        /**
         * @return int
         */
        public function getTransactionFee()
        {
            return $this->_transactionFee;
        }

        /**
         * @param int $transactionFee
         *
         * @return OrderLine
         */
        public function setTransactionFee($transactionFee)
        {
            $this->_transactionFee = $transactionFee;

            return $this;
        }

        /**
         * @return string
         */
        public function getEan()
        {
            return $this->_ean;
        }

        /**
         * @param string $ean
         *
         * @return OrderLine
         */
        public function setEan($ean)
        {
            $this->_ean = $ean;

            return $this;
        }

        /**
         * @return string
         */
        public function getSku()
        {
            return $this->_sku;
        }

        /**
         * @param string $sku
         *
         * @return OrderLine
         */
        public function setSku($sku)
        {
            $this->_sku = $sku;

            return $this;
        }
    }