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
                case CallTypeInterface::ACTION_READ:
                case CallTypeInterface::ACTION_UPDATE:
                case CallTypeInterface::ACTION_DELETE:
                    break;
                default:
                    throw new InvalidCallActionException();
                    break;
            }
        }
    }