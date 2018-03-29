<?php

    namespace EffectConnectSDK\Core\Model;

    use EffectConnectSDK\Core\Abstracts\ApiModel;
    use EffectConnectSDK\Core\Interfaces\ApiModelInterface;

    /**
     * Class OrderUpdateRequest
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     */
    final class OrderUpdateRequest extends ApiModel implements ApiModelInterface
    {
        /**
         * @var OrderLineUpdate[] $_lines
         */
        protected $_lineUpdate = [];

        public function getName()
        {
            return 'lines';
        }

        public function isIterator()
        {
            return true;
        }

        /**
         * @return OrderLineUpdate[]
         */
        public function getLineUpdate()
        {
            return $this->_lineUpdate;
        }

        /**
         * @param OrderLineUpdate $line
         *
         * @return OrderUpdateRequest
         */
        public function addLineUpdate(OrderLineUpdate $line)
        {
            $this->_lineUpdate[] = $line;

            return $this;
        }
    }