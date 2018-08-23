<?php

    namespace EffectConnect\PHPSdk\Core\Model\Filter;

    use EffectConnect\PHPSdk\Core\Abstracts\ApiModel;
    use EffectConnect\PHPSdk\Core\Exception\InvalidPropertyValueException;
    use EffectConnect\PHPSdk\Core\Helper\EffectConnectXMLElement;
    use EffectConnect\PHPSdk\Core\Helper\Reflector;
    use EffectConnect\PHPSdk\Core\Interfaces\OrderListFilterInterface;

    /**
     * Class HasStatusFilter
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     */
    final class HasStatusFilter extends ApiModel implements OrderListFilterInterface
    {
        const STATUS_PAID               = 'paid';
        const STATUS_COMPLETED          = 'completed';
        const STATUS_CANCELLED          = 'cancelled';
        const STATUS_RETURNING          = 'returning';
        const STATUS_PARTIALLY_SHIPPED  = 'partially_shipped';
        const STATUS_PARTIALLY_RETURNED = 'partially_returned';

        /**
         * @var array $_filterValue
         */
        protected $_filterValue = [];

        public function getName()
        {
            return 'hasStatusFilter';
        }

        public function isIterator()
        {
            return true;
        }

        public function getFilterValue()
        {
            return $this->_filterValue;
        }

        /**
         * @param $filterValue
         *
         * @return $this
         * @throws InvalidPropertyValueException
         * @throws \Exception
         */
        public function setFilterValue($filterValue)
        {
            if (!is_array($filterValue))
            {
                $filterValue = [$filterValue];
            }
            foreach ($filterValue as $value)
            {
                if (!Reflector::isValid(HasStatusFilter::class, $value))
                {
                    throw new InvalidPropertyValueException('filterValue');
                }
            }

            $this->_filterValue = $filterValue;

            return $this;
        }
    }