<?php

namespace EffectConnect\PHPSdk\Core\Model\Request;

use EffectConnect\PHPSdk\Core\Abstracts\ApiModel;
use EffectConnect\PHPSdk\Core\Interfaces\ApiModelInterface;

class OrderLineAttributeValues extends ApiModel implements ApiModelInterface
{
    /**
     * @var string[] $_value
     */
    protected $_value;

    public function getName()
    {
        return 'values';
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->_value;
    }

    /**
     * @param string[] $value
     * @return $this
     */
    public function setValue($values)
    {
        $this->_value = $values;

        return $this;
    }

    protected function isIterator()
    {
        return true;
    }

}
