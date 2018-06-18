<?php
    namespace EffectConnectSDK\Core\Validation;

    use EffectConnectSDK\Core\Abstracts\Validator;
    use EffectConnectSDK\Core\Exception\InvalidPayloadException;
    use EffectConnectSDK\Core\Interfaces\CallTypeInterface;
    use EffectConnectSDK\Core\Interfaces\CallValidatorInterface;
    use EffectConnectSDK\Core\Model\Order;
    use EffectConnectSDK\Core\Model\OrderReadRequest;
    use EffectConnectSDK\Core\Model\OrderUpdateRequest;

    /**
     * Class OrderValidator
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     */
    final class OrderValidator extends Validator implements CallValidatorInterface
    {
        protected $validActions = [
            CallTypeInterface::ACTION_CREATE,
            CallTypeInterface::ACTION_READ,
            CallTypeInterface::ACTION_UPDATE
        ];
        /**
         * @param $argument
         *
         * @return bool
         * @throws InvalidPayloadException
         */
        public function validateCall($argument)
        {
            $valid = false;
            switch ($this->action)
            {
                case CallTypeInterface::ACTION_CREATE:
                    if ($argument instanceof Order)
                    {
                        $valid = true;
                    }
                    break;
                case CallTypeInterface::ACTION_READ:
                    if (
                        $argument instanceof OrderReadRequest &&
                        $argument->getIdentifierType() !== null &&
                        $argument->getIdentifier() !== null
                    )
                    {
                        $valid = true;
                    }
                    break;
                case CallTypeInterface::ACTION_UPDATE:
                    if (
                        $argument instanceof OrderUpdateRequest &&
                        count($argument->getOrderlines())+count($argument->getOrders()) > 0
                    )
                    {
                        $valid = true;
                    }
                    break;
            }
            if (!$valid)
            {
                throw new InvalidPayloadException($this->action);
            }

            return true;
        }
    }