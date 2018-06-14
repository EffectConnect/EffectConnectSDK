<?php
    namespace EffectConnectSDK\Core\CallType;

    use EffectConnectSDK\Core\Abstracts\CallType;
    use EffectConnectSDK\ApiCall;
    use EffectConnectSDK\Core\Exception\InvalidActionForCallTypeException;
    use EffectConnectSDK\Core\Interfaces\CallTypeInterface;
    use EffectConnectSDK\Core\Model\ReportReadRequest;
    use EffectConnectSDK\Core\Validation\ReportValidator;

    /**
     * Class ReportCall
     *
     * CallType class for retrieving the process report.
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     * @method ApiCall read(ReportReadRequest $reportReadRequest)
     */
    final class ReportCall extends CallType implements CallTypeInterface
    {
        protected $validatorClass = ReportValidator::class;

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
                ->setUri('/report')
                ->setMethod($method)
            ;

            return $apiCall;
        }
    }