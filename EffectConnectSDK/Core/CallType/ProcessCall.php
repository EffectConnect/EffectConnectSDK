<?php
    namespace EffectConnect\PHPSdk\Core\CallType;

    use EffectConnect\PHPSdk\Core\Abstracts\CallType;
    use EffectConnect\PHPSdk\ApiCall;
    use EffectConnect\PHPSdk\Core\Exception\InvalidActionForCallTypeException;
    use EffectConnect\PHPSdk\Core\Interfaces\CallTypeInterface;
    use EffectConnect\PHPSdk\Core\Model\ProcessReadRequest;
    use EffectConnect\PHPSdk\Core\Validation\ProcessValidator;
    use EffectConnect\PHPSdk\Core\Validation\ProductsValidator;

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