<?php
    namespace EffectConnectSDK\Core\Model;

    use EffectConnectSDK\Core\Abstracts\ApiModel;
    use EffectConnectSDK\Core\Exception\InvalidListTypeException;
    use EffectConnectSDK\Core\Exception\InvalidListValuesException;
    use EffectConnectSDK\Core\Exception\InvalidStatusException;
    use EffectConnectSDK\Core\Helper\Reflector;
    use EffectConnectSDK\Core\Interfaces\ApiModelInterface;
    use EffectConnectSDK\Core\Interfaces\OrderListFilterInterface;

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
        /**
         * OPTIONAL
         * @var OrderListFilterInterface[] $_filters
         *
         * List of filters
         */
        protected $_filters = [];

        /**
         * @return string
         */
        public function getName()
        {
            return 'list';
        }

        /**
         * @return OrderListFilterInterface[]
         */
        public function getFilters()
        {
            return $this->_filters;
        }

        /**
         * @param OrderListFilterInterface $filter
         *
         * @return OrderList
         */
        public function addFilter(OrderListFilterInterface $filter)
        {
            $this->_filters[] = $filter;

            return $this;
        }
    }