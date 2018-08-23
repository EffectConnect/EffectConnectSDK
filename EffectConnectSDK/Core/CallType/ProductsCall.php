<?php
    namespace EffectConnect\PHPSdk\Core\CallType;

    use EffectConnect\PHPSdk\Core\Abstracts\CallType;
    use EffectConnect\PHPSdk\ApiCall;
    use EffectConnect\PHPSdk\Core\Exception\InvalidActionForCallTypeException;
    use EffectConnect\PHPSdk\Core\Interfaces\CallTypeInterface;
    use EffectConnect\PHPSdk\Core\Validation\ProductsValidator;

    /**
     * Class ProductsCall
     *
     * CallType class for creating batch product calls to the EffectConnect API
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     * @method ApiCall create(\CURLFile $productFile)
     * @method ApiCall read($id)
     * @method ApiCall update(\CURLFile $productFile)
     */
    final class ProductsCall extends CallType implements CallTypeInterface
    {
        protected $validatorClass = ProductsValidator::class;

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
                ->setUri('/products')
                ->setMethod($method)
            ;

            return $apiCall;
        }
    }