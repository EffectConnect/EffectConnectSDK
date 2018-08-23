<?php
    namespace EffectConnect\PHPSdk\Core\CallType;

    use EffectConnect\PHPSdk\Core\Abstracts\CallType;
    use EffectConnect\PHPSdk\ApiCall;
    use EffectConnect\PHPSdk\Core\Exception\InvalidActionForCallTypeException;
    use EffectConnect\PHPSdk\Core\Interfaces\CallTypeInterface;
    use EffectConnect\PHPSdk\Core\Model\Order;
    use EffectConnect\PHPSdk\Core\Model\OrderReadRequest;
    use EffectConnect\PHPSdk\Core\Model\OrderUpdateRequest;
    use EffectConnect\PHPSdk\Core\Validation\OrderValidator;

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