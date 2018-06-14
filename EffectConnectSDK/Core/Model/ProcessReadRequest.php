<?php

    namespace EffectConnectSDK\Core\Model;

    use EffectConnectSDK\Core\Abstracts\ApiModel;
    use EffectConnectSDK\Core\Interfaces\ApiModelInterface;

    /**
     * Class ProcessReadRequest
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package BlackBox
     */
    final class ProcessReadRequest extends ApiModel implements ApiModelInterface
    {
        /**
         * @var string $_ID
         */
        protected $_ID;

        public function getName()
        {
            return 'process';
        }

        /**
         * @return string
         */
        public function getID()
        {
            return $this->_ID;
        }

        /**
         * @param $id
         *
         * @return ProcessReadRequest
         */
        public function setID($id)
        {
            $this->_ID = $id;

            return $this;
        }
    }