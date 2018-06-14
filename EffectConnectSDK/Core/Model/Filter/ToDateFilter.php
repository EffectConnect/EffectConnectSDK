<?php

    namespace EffectConnectSDK\Core\Model\Filter;

    use EffectConnectSDK\Core\Abstracts\ApiModel;
    use EffectConnectSDK\Core\Exception\InvalidPropertyValueException;
    use EffectConnectSDK\Core\Interfaces\OrderListFilterInterface;

    /**
     * Class ToDateFilter
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     */
    final class ToDateFilter extends ApiModel implements OrderListFilterInterface
    {
        /**
         * @var \DateTime $_filterValue
         */
        protected $_filterValue;

        public function getName()
        {
            return 'toDateFilter';
        }

        public function getFilterValue()
        {
            return $this->_filterValue->format('Y-m-d\TH:i:sP');
        }

        /**
         * @param $filterValue
         *
         * @return ToDateFilter
         * @throws InvalidPropertyValueException
         */
        public function setFilterValue($filterValue)
        {
            if (!$filterValue instanceof \DateTime)
            {
                throw new InvalidPropertyValueException('filterValue');
            }

            $this->_filterValue = $filterValue;

            return $this;
        }
    }