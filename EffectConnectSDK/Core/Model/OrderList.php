<?php
    namespace EffectConnectSDK\Core\Model;

    use EffectConnectSDK\Core\Abstracts\ApiModel;
    use EffectConnectSDK\Core\Exception\InvalidListTypeException;
    use EffectConnectSDK\Core\Exception\InvalidListValuesException;
    use EffectConnectSDK\Core\Exception\InvalidStatusException;
    use EffectConnectSDK\Core\Helper\Reflector;
    use EffectConnectSDK\Core\Interfaces\ApiModelInterface;

    /**
     * Class OrderList
     *
     * @author  Mark Thiesen
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     */
    final class OrderList extends ApiModel implements ApiModelInterface
    {
        const TYPE_STATUS = 'status';
        /**
         * OPTIONAL
         *
         * @var string $_type
         *
         * Type of list
         */
        protected $_type;
        /**
         * @var array $_values
         */
        protected $_values;

        /**
         * @return string
         */
        public function getName()
        {
            return 'list';
        }

        /**
         * @return string
         */
        public function getType()
        {
            return $this->_type;
        }

        /**
         * @param $type
         *
         * @return $this
         * @throws InvalidListTypeException
         * @throws \Exception
         */
        public function setType($type)
        {
            if (!Reflector::isValid(OrderList::class, $type, 'TYPE_%'))
            {
                throw new InvalidListTypeException();
            }
            $this->_type = $type;

            return $this;
        }

        public function getValues()
        {
            return $this->_values;
        }

        /**
         * @param string $value
         *
         * @return $this
         * @throws InvalidListValuesException
         * @throws \Exception
         */
        public function addValue($value)
        {
            $valid = true;
            switch ($this->getType())
            {
                case self::TYPE_STATUS:
                    if (!Reflector::isValid(Order::class, $value, 'STATUS_%'))
                    {
                        $valid = false;
                    }
                    break;
                default:
                    $valid = false;
                    break;
            }
            if (!$valid)
            {
                throw new InvalidListValuesException();
            }
            $this->_values[] = ['value' => $value];

            return $this;
        }
    }