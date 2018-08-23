<?php

    namespace EffectConnect\PHPSdk\Core\Model;

    use EffectConnect\PHPSdk\Core\Abstracts\ApiModel;
    use EffectConnect\PHPSdk\Core\Interfaces\ApiModelInterface;

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