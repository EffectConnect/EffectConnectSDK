<?php
    namespace EffectConnectSDK\Core\CallType;

    use EffectConnectSDK\Core\Abstracts\CallType;
    use EffectConnectSDK\ApiCall;
    use EffectConnectSDK\Core\Exception\InvalidActionForCallTypeException;
    use EffectConnectSDK\Core\Interfaces\CallTypeInterface;
    use EffectConnectSDK\Core\Model\OrderList;
    use EffectConnectSDK\Core\Validation\OrderListValidator;

    /**
     * Class OrderListCall
     *
     * CallType class receiving orders from the EffectConnect Api.
     *
     * @author  Mark Thiesen
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     * @method ApiCall read(OrderList $list)
     */
    final class OrderListCall extends CallType implements CallTypeInterface
    {
        protected $validatorClass = OrderListValidator::class;

        /**
         * @param ApiCall $apiCall
         *
         * @return ApiCall
         * @throws InvalidActionForCallTypeException
         */
        public function _prepareCall($apiCall)
        {
            switch ($this->action)
            {
                case CallTypeInterface::ACTION_READ:
                    $method = 'GET';
                    break;
                default:
                    throw new InvalidActionForCallTypeException();
            }
            $apiCall
                ->setUri('/orderlist')
                ->setMethod($method)
            ;

            return $apiCall;
        }
    }