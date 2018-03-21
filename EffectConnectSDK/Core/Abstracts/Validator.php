<?php
    namespace EffectConnectSDK\Core\Abstracts;

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
    abstract class Validator
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
        final public function setup($callAction)
        {
            $this->action = $callAction;
            if (!in_array($callAction, $this->validActions))
            {
                throw new InvalidActionForCallTypeException();
            }
            switch ($callAction)
            {
                case CallTypeInterface::ACTION_CREATE:
                    $this->_setupCreate();
                    break;
                case CallTypeInterface::ACTION_READ:
                    $this->_setupRead();
                    break;
                case CallTypeInterface::ACTION_UPDATE:
                    $this->_setupUpdate();
                    break;
                case CallTypeInterface::ACTION_DELETE:
                    $this->_setupDelete();
                    break;
                default:
                    throw new InvalidCallActionException();
                    break;
            }
        }

        protected function _setupCreate()
        {
            $this->identifierRequired  = false;
            $this->payloadRequired     = true;
        }

        protected function _setupRead()
        {
            $this->identifierRequired  = true;
            $this->payloadRequired     = false;
        }

        protected function _setupUpdate()
        {
            $this->identifierRequired  = true;
            $this->payloadRequired     = true;
        }

        protected function _setupDelete()
        {
            $this->identifierRequired  = true;
            $this->payloadRequired     = false;
        }
    }