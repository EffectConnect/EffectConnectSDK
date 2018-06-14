<?php
    namespace EffectConnectSDK\Core\CallType;

    use EffectConnectSDK\Core\Abstracts\CallType;
    use EffectConnectSDK\ApiCall;
    use EffectConnectSDK\Core\Exception\InvalidActionForCallTypeException;
    use EffectConnectSDK\Core\Interfaces\CallTypeInterface;
    use EffectConnectSDK\Core\Model\ProcessReadRequest;
    use EffectConnectSDK\Core\Validation\ProcessValidator;
    use EffectConnectSDK\Core\Validation\ProductsValidator;

    /**
     * Class ProcessCall
     *
     * CallType class for retrieving the process status report
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     * @method ApiCall read(ProcessReadRequest $processReadRequest)
     */
    final class ProcessCall extends CallType implements CallTypeInterface
    {
        protected $validatorClass = ProcessValidator::class;

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
                ->setUri('/process')
                ->setMethod($method)
            ;

            return $apiCall;
        }
    }