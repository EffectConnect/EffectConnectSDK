<?php
    namespace EffectConnectSDK\Core\CallType;

    use EffectConnectSDK\Core\Abstracts\CallType;
    use EffectConnectSDK\ApiCall;
    use EffectConnectSDK\Core\Exception\InvalidActionForCallTypeException;
    use EffectConnectSDK\Core\Interfaces\CallTypeInterface;
    use EffectConnectSDK\Core\Model\Order;
    use EffectConnectSDK\Core\Model\OrderReadRequest;
    use EffectConnectSDK\Core\Model\OrderUpdateRequest;
    use EffectConnectSDK\Core\Validation\OrderValidator;

    /**
     * Class OrderCall
     *
     * CallType class for creating single order calls to the EffectConnect API
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     * @method ApiCall create(Order $order)
     * @method ApiCall read(OrderReadRequest $readRequest)
     * @method ApiCall update(OrderUpdateRequest $updateRequest)
     */
    final class OrderCall extends CallType implements CallTypeInterface
    {
        protected $callVersion    = '2.0';
        protected $validatorClass = OrderValidator::class;

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
                case CallTypeInterface::ACTION_CREATE:
                    $method = 'POST';
                    break;
                case CallTypeInterface::ACTION_UPDATE:
                    $method = 'PUT';
                    break;
                default:
                    throw new InvalidActionForCallTypeException();
            }
            $apiCall
                ->setUri('/orders')
                ->setMethod($method)
            ;

            return $apiCall;
        }
    }