<?php

    namespace EffectConnect\PHPSdk\Core\Model;

    /**
     * Class EffectConnectEvent
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     */
    final class EffectConnectEvent
    {
        /**
         * @var string $_event
         */
        private $_event;
        /**
         * @var string $_payload
         */
        private $_payload;
        /**
         * @var \DateTime $_time
         */
        private $_time;

        public function __construct($event, $payload, $time)
        {
            $this->_event   = $event;
            $this->_payload = $payload;
            $this->_time    = $time;
        }

        /**
         * @return string
         */
        public function getEvent()
        {
            return $this->_event;
        }

        /**
         * @return string
         */
        public function getPayload()
        {
            return $this->_payload;
        }

        /**
         * @return \DateTime
         */
        public function getTime()
        {
            return $this->_time;
        }
    }