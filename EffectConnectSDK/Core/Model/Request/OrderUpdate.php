<?php
    namespace EffectConnect\PHPSdk\Core\Model\Request;

    use EffectConnect\PHPSdk\Core\Abstracts\ApiModel;
    use EffectConnect\PHPSdk\Core\Exception\InvalidPropertyValueException;
    use EffectConnect\PHPSdk\Core\Helper\Reflector;
    use EffectConnect\PHPSdk\Core\Interfaces\ApiModelInterface;

    /**
     * Class OrderUpdate
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     */
    final class OrderUpdate extends ApiModel implements ApiModelInterface
    {
        const TYPE_CONNECTION_IDENTIFIER    = 'connectionIdentifier';
        const TYPE_CONNECTION_INVOICE       = 'connectionInvoice';
        const TYPE_CONNECTION_NUMBER        = 'connectionNumber';
        const TYPE_EFFECTCONNECT_IDENTIFIER = 'effectConnectIdentifier';
        const TYPE_EFFECTCONNECT_NUMBER     = 'effectConnectNumber';
        const TYPE_CHANNEL_IDENTIFIER       = 'channelIdentifier';
        const TYPE_CHANNEL_NUMBER           = 'channelNumber';

        /**
         * REQUIRED
         *
         * @var string $_orderIdentifierType
         *
         * This type is used to identify the order you're trying to update.
         */
        protected $_orderIdentifierType;

        /**
         * REQUIRED
         *
         * @var string $_orderIdentifier
         */
        protected $_orderIdentifier;
        /**
         * @var array $_addTags
         *
         * A list of tags to add to this order
         */
        protected $_addTags    = [];
        /**
         * @var array $_removeTags
         *
         * A list of tags to remove from this order
         */
        protected $_removeTags = [];

        public function getName()
        {
            return 'orderUpdate';
        }

        /**
         * @param $identifierType
         *
         * @return OrderUpdate
         *
         * @throws InvalidPropertyValueException
         * @throws \Exception
         */
        public function setOrderIdentifierType($identifierType)
        {
            if (!Reflector::isValid(OrderUpdate::class, $identifierType))
            {
                throw new InvalidPropertyValueException('identifierType');
            }
            $this->_orderIdentifierType = $identifierType;

            return $this;
        }

        public function setOrderIdentifier($identifier)
        {
            $this->_orderIdentifier = $identifier;

            return $this;
        }

        /**
         * @param $tag
         *
         * @return OrderUpdate
         */
        public function addTag($tag)
        {
            $this->_addTags['tag'][] = $tag;

            return $this;
        }

        /**
         * @param $tag
         *
         * @return OrderUpdate
         */
        public function removeTag($tag)
        {
            $this->_removeTags['tag'][] = $tag;

            return $this;
        }

        /**
         * @return string
         */
        public function getOrderIdentifierType()
        {
            return $this->_orderIdentifierType;
        }

        /**
         * @return string
         */
        public function getOrderIdentifier()
        {
            return $this->_orderIdentifier;
        }

        /**
         * @return array
         */
        public function getAddTags()
        {
            return $this->_addTags;
        }

        /**
         * @return array
         */
        public function getRemoveTags()
        {
            return $this->_removeTags;
        }

        protected function isIterator()
        {
            return true;
        }
    }