<?php
namespace EffectConnectSDK\Core\Validation;

use EffectConnectSDK\Core\Abstracts\Validator;
use EffectConnectSDK\Core\Exception\InvalidPayloadException;
use EffectConnectSDK\Core\Interfaces\CallTypeInterface;
use EffectConnectSDK\Core\Interfaces\CallValidatorInterface;
use EffectConnectSDK\Core\Model\OrderList;

/**
 * Class OrderListValidator
 *
 * @author  Mark Thiesen
 * @company Koek & Peer
 * @product EffectConnect
 * @package EffectConnectSDK
 *
 */
final class OrderListValidator extends Validator implements CallValidatorInterface
{
    protected $validActions = [
        CallTypeInterface::ACTION_READ,
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
            if ($argument instanceof OrderList)
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

    protected function _setupRead()
    {
        $this->identifierRequired  = false;
        $this->payloadRequired     = true;
    }
}