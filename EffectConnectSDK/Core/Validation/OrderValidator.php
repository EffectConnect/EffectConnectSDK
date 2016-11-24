<?php
    namespace EffectConnectSDK\Core\Validation;

    use EffectConnectSDK\Core\Exception\InvalidPayloadException;
    use EffectConnectSDK\Core\Interfaces\CallTypeInterface;
    use EffectConnectSDK\Core\Interfaces\CallValidatorInterface;
    use EffectConnectSDK\Core\Model\Order;

    /**
     * Class OrderValidator
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     */
    final class OrderValidator extends AbstractValidator implements CallValidatorInterface
    {
        protected $validActions = [
            CallTypeInterface::ACTION_CREATE,
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
            if ($this->payloadRequired && $this->identifierRequired)
            {
                if ($argument instanceof Order && $argument->getNumber() !== null)
                {
                    $valid = true;
                }
            } elseif ($this->payloadRequired)
            {
                if ($argument instanceof Order)
                {
                    $valid = true;
                }
            } elseif ($this->identifierRequired)
            {
                if (is_int($argument) || ($argument instanceof Order && $argument->getNumber() !== null))
                {
                    $valid = true;
                }
            }
            if (!$valid)
            {
                throw new InvalidPayloadException($this->action);
            }

            return true;
        }
    }