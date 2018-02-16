<?php

    namespace EffectConnectSDK\Core\Interfaces;

    /**
     * Interface ApiModelInterface
     *
     * @author  Mark Thiesen
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     */
    interface ApiModelInterface
    {
        /**
         * @return string
         *
         * Returns the xml root node
         */
        public function getName();

        /**
         * @return string
         */
        public function getXml();
    }