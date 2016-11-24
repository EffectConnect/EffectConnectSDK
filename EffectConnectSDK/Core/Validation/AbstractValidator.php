<?php
    namespace EffectConnectSDK\Core\Validation;

    use EffectConnectSDK\Core\Exception\InvalidActionForCallTypeException;
    use EffectConnectSDK\Core\Exception\InvalidCallActionException;
    use EffectConnectSDK\Core\Interfaces\CallTypeInterface;

    /**
     * Class AbstractValidator
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     */
    abstract class AbstractValidator
    {
        /**
         * @var string $action
         */
        protected $action;

        /**
         * @var bool $identifierRequired
         */
        protected $identifierRequired;

        /**
         * @var bool $payloadRequired
         */
        protected $payloadRequired;

        protected $validActions = [
            CallTypeInterface::ACTION_CREATE,
            CallTypeInterface::ACTION_READ,
            CallTypeInterface::ACTION_UPDATE,
            CallTypeInterface::ACTION_DELETE
        ];

        /**
         * @param $callAction
         *
         * @throws InvalidCallActionException
         * @throws InvalidActionForCallTypeException
         */
        public function setup($callAction)
        {
            $this->action = $callAction;
            if (!in_array($callAction, $this->validActions))
            {
                throw new InvalidActionForCallTypeException();
            }
            switch ($callAction)
            {
                case CallTypeInterface::ACTION_CREATE:
                    $this->identifierRequired  = false;
                    $this->payloadRequired     = true;
                    break;
                case CallTypeInterface::ACTION_UPDATE:
                    $this->identifierRequired  = true;
                    $this->payloadRequired     = true;
                    break;
                case CallTypeInterface::ACTION_DELETE:
                case CallTypeInterface::ACTION_READ:
                    $this->identifierRequired  = true;
                    $this->payloadRequired     = false;
                    break;
                default:
                    throw new InvalidCallActionException();
                    break;
            }
        }
    }