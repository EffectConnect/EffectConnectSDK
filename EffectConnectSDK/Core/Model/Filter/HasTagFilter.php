<?php

    namespace EffectConnect\PHPSdk\Core\Model\Filter;

    use EffectConnect\PHPSdk\Core\Abstracts\ApiModel;
    use EffectConnect\PHPSdk\Core\Exception\InvalidPropertyValueException;
    use EffectConnect\PHPSdk\Core\Interfaces\OrderListFilterInterface;

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

        public function setFilterValue($filterValue)
        {
            if (!is_array($filterValue))
            {
                $filterValue = [$filterValue];
            }
            foreach ($filterValue as $value)
            {
                if (!$value instanceof TagFilterValue)
                {
                    throw new InvalidPropertyValueException('filterValue');
                }
                $this->_filterValue[] = $value;
            }
        }

        protected function isIterator()
        {
            return true;
        }
    }