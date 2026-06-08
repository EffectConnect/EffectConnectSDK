<?php

namespace EffectConnect\PHPSdk\Core\Model\Request;

use EffectConnect\PHPSdk\Core\Abstracts\ApiModel;
use EffectConnect\PHPSdk\Core\Interfaces\ApiModelInterface;

class OrderLineAttribute extends ApiModel implements ApiModelInterface
{
    /**
     * @var string $_code
     */
    protected $_code;

    /**
     * @var OrderLineAttributeValues $_values
     */
    protected $_values;

    public function getName()
    {
        return 'attribute';
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->_code;
    }

    /**
     * @param $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->_code = $code;

        return $this;
    }

    /**
     * @return OrderLineAttributeValues
     */
    public function getValues()
    {
        return $this->_values;
    }

    /**
     * @param OrderLineAttributeValues $value
     * @return $this
     */
    public function setValues(OrderLineAttributeValues $value)
    {
        $this->_values = $value;

        return $this;
    }
}
