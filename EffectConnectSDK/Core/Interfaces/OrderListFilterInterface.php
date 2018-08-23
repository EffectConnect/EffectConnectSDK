<?php

    namespace EffectConnect\PHPSdk\Core\Interfaces;

    /**
     * Interface OrderListFilterInterface
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     */
    interface OrderListFilterInterface extends ApiModelInterface
    {
        public function getFilterValue();

        public function setFilterValue($filterValue);
    }