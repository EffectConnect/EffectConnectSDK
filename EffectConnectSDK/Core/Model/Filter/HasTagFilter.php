<?php

    namespace EffectConnectSDK\Core\Model\Filter;

    use EffectConnectSDK\Core\Abstracts\ApiModel;
    use EffectConnectSDK\Core\Exception\InvalidPropertyValueException;
    use EffectConnectSDK\Core\Helper\Reflector;
    use EffectConnectSDK\Core\Interfaces\OrderListFilterInterface;

    /**
     * Class HasTagFilter
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     */
    final class HasTagFilter extends ApiModel implements OrderListFilterInterface
    {
        /**
         * @var array $_filterValue
         */
        protected $_filterValue = [];

        public function getName()
        {
            return 'hasTagFilter';
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