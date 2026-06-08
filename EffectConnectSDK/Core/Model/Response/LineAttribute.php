<?php
    namespace EffectConnect\PHPSdk\Core\Model\Response;

    use EffectConnect\PHPSdk\Core\Helper\Payload;

    /**
     * Class LineFee
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     */
    final class LineAttribute
    {
        /**
         * @var string $_code
         */
        private $_code;
        /**
         * @var string[] $_values
         */
        private $_values;

        /**
         * LineFee constructor.
         *
         * @param $payload
         */
        public function __construct($payload)
        {
            if ($payload === null)
            {
                return;
            }

            $this->_code     = Payload::extract($payload, 'code');
            $extractedValues = Payload::extract($payload, 'values', true);
            foreach ($extractedValues as $value) {
                $this->_values[] = (string) $value;
            }
        }

        /**
         * @return string
         */
        public function getCode()
        {
            return $this->_code;
        }

        /**
         * @return string[]
         */
        public function getValues()
        {
            return $this->_values;
        }

    }
