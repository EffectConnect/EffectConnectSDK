<?php
    namespace EffectConnectSDK\Core\Validation;

    use EffectConnectSDK\Core\Abstracts\Validator;
    use EffectConnectSDK\Core\Exception\InvalidPayloadException;
    use EffectConnectSDK\Core\Interfaces\CallTypeInterface;
    use EffectConnectSDK\Core\Interfaces\CallValidatorInterface;

    /**
     * Class ProductValidator
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     */
    final class ProductsValidator extends Validator implements CallValidatorInterface
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
            if ($this->payloadRequired)
            {
                if ($argument instanceof \CURLFile)
                {
                    $valid = true;
                }
            } elseif ($this->identifierRequired)
            {
                if (is_int($argument))
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

        protected function _setupUpdate()
        {
            $this->identifierRequired  = false;
            $this->payloadRequired     = true;
        }

        protected function _setupDelete()
        {
            $this->identifierRequired  = false;
            $this->payloadRequired     = true;
        }
    }