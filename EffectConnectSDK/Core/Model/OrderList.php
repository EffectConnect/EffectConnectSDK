<?php
    namespace EffectConnect\PHPSdk\Core\Model;

    use EffectConnect\PHPSdk\Core\Abstracts\ApiModel;
    use EffectConnect\PHPSdk\Core\Exception\InvalidListTypeException;
    use EffectConnect\PHPSdk\Core\Exception\InvalidListValuesException;
    use EffectConnect\PHPSdk\Core\Exception\InvalidStatusException;
    use EffectConnect\PHPSdk\Core\Helper\Reflector;
    use EffectConnect\PHPSdk\Core\Interfaces\ApiModelInterface;
    use EffectConnect\PHPSdk\Core\Interfaces\OrderListFilterInterface;

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