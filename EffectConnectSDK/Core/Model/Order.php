<?php
    namespace EffectConnectSDK\Core\Model;

    use EffectConnectSDK\Abstracts\ApiModel;
    use EffectConnectSDK\Core\Exception\InvalidReflectionException;
    use EffectConnectSDK\Core\Exception\InvalidStatusException;
    use EffectConnectSDK\Core\Helper\Reflector;
    use EffectConnectSDK\Core\Interfaces\ApiModelInterface;

    /**
     * Class Order
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     */
    final class Order extends ApiModel implements ApiModelInterface
    {
        const STATUS_NEW        = 'new';
        const STATUS_PAID       = 'paid';
        const STATUS_COMPLETED  = 'completed';
        const STATUS_CANCELED   = 'canceled';
        const STATUS_RETURN     = 'return';

        /**
         * @return string
         */
        public function getName()
        {
            return 'order';
        }

        /**
         * REQUIRED
         * @var string $_number
         *
         * Order number
         */
        protected $_number;

        /**
         * OPTIONAL
         * @var int $_fulfilmentNumber
         *
         * Fulfilment number
         */

        protected $_fulfilmentNumber;
        /**
         * REQUIRED
         * @var string(3) $_currency
         *
         * Currency string in ISO 4217 format
         * http://www.currency-iso.org/dam/downloads/lists/list_one.xml
         */

        protected $_currency;
        /**
         * REQUIRED
         * @var string $_status
         */
        protected $_status;

        /**
         * REQUIRED
         * @var \DateTime $_date
         *
         * The order date
         */
        protected $_date;

        /**
         * OPTIONAL
         * @var int $_shippingCost
         *
         * Shipping cost in cents
         */
        protected $_shippingCost;

        /**
         * OPTIONAL
         * @var int $_handlingCost
         *
         * Handling cost in cents
         */
        protected $_handlingCost;

        /**
         * REQUIRED for Updates
         * @var string $_trackingCode
         *
         * Tracking code
         */
        protected $_trackingCode;

        /**
         * REQUIRED
         * @var OrderAddress $_billingAddress
         *
         * Customer billing address
         */
        protected $_billingAddress;

        /**
         * REQUIRED
         * @var OrderAddress $_shippingAddress
         *
         * Customer shipping address
         */
        protected $_shippingAddress;

        /**
         * REQUIRED
         * @var OrderLine[] $_orderLines
         *
         * Order lines
         */
        protected $_orderLines;

        /**
         * @return mixed
         */
        public function getNumber()
        {
            return $this->_number;
        }

        /**
         * @param mixed $number
         *
         * @return Order
         */
        public function setNumber($number)
        {
            $this->_number = $number;

            return $this;
        }

        /**
         * @return string
         */
        public function getFulfilmentNumber()
        {
            return $this->_fulfilmentNumber;
        }

        /**
         * @param string $fulfilmentNumber
         *
         * @return Order
         */
        public function setFulfilmentNumber($fulfilmentNumber)
        {
            $this->_fulfilmentNumber = $fulfilmentNumber;

            return $this;
        }

        /**
         * @return string
         */
        public function getStatus()
        {
            return $this->_status;
        }

        /**
         * @param $status
         *
         * @return $this
         * @throws InvalidStatusException
         * @throws InvalidReflectionException
         */
        public function setStatus($status)
        {
            if (!Reflector::isValid(Order::class, $status, 'STATUS_%'))
            {
                throw new InvalidStatusException();
            }
            $this->_status = $status;

            return $this;
        }

        /**
         * @return string
         */
        public function getDate()
        {
            if ($this->_date)
            {
                return $this->_date->format('Y-m-d\TH:i:sP');
            }

            return null;
        }

        /**
         * @param \DateTime $date
         *
         * @return Order
         */
        public function setDate(\DateTime $date)
        {
            $this->_date = $date;

            return $this;
        }

        /**
         * @return int
         */
        public function getShippingCost()
        {
            return $this->_shippingCost;
        }

        /**
         * @param int $shippingCost
         *
         * @return Order
         */
        public function setShippingCost($shippingCost)
        {
            $this->_shippingCost = $shippingCost;

            return $this;
        }

        /**
         * @return int
         */
        public function getHandlingCost()
        {
            return $this->_handlingCost;
        }

        /**
         * @param int $handlingCost
         *
         * @return Order
         */
        public function setHandlingCost($handlingCost)
        {
            $this->_handlingCost = $handlingCost;

            return $this;
        }

        /**
         * @return OrderAddress
         */
        public function getShippingAddress()
        {
            return $this->_shippingAddress;
        }

        /**
         * @return OrderAddress
         */
        public function getBillingAddress()
        {
            return $this->_billingAddress;
        }

        /**
         * @param OrderAddress $address
         *
         * @return Order
         */
        public function setShippingAddress(OrderAddress $address)
        {
            $this->_shippingAddress = $address;

            return $this;
        }

        /**
         * @param OrderAddress $address
         *
         * @return Order
         */
        public function setBillingAddress(OrderAddress $address)
        {
            $this->_billingAddress = $address;

            return $this;
        }

        /**
         * @param OrderLine $orderLine
         *
         * @return Order
         */
        public function addOrderLine(OrderLine $orderLine)
        {
            $this->_orderLines[] = $orderLine;

            return $this;
        }

        /**
         * @return OrderLine[]
         */
        public function getOrderLines()
        {
            return $this->_orderLines;
        }

        /**
         * @return string
         */
        public function getCurrency()
        {
            return $this->_currency;
        }

        /**
         * @param string $currency
         *
         * @return Order
         */
        public function setCurrency($currency)
        {
            $this->_currency = $currency;

            return $this;
        }

        /**
         * @return string
         */
        public function getTrackingCode()
        {
            return $this->_trackingCode;
        }

        /**
         * @param string $trackingCode
         *
         * @return Order
         */
        public function setTrackingCode($trackingCode)
        {
            $this->_trackingCode = $trackingCode;

            return $this;
        }
    }