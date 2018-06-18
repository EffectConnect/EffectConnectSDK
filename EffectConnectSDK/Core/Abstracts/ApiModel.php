<?php
    namespace EffectConnectSDK\Core\Abstracts;

    use EffectConnectSDK\Core\Exception\InvalidPropertyException;
    use EffectConnectSDK\Core\Helper\EffectConnectXMLElement;

    /**
     * Class ApiModel
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     */
    abstract class ApiModel
    {
        /**
         * @param array|null $productData
         */
        public function __construct($productData=null)
        {
            if ($productData)
            {
                $this->_hydrate($productData);
            }
        }

        /**
         * @param array $productData
         */
        private function _hydrate($productData)
        {
            foreach ($productData as $property => $value)
            {
                if (property_exists($this, '_'.$property))
                {
                    call_user_func([$this, 'set'.ucfirst($property)], $value);
                }
            }
        }

        /**
         * @return string
         *
         * @throws InvalidPropertyException
         */
        public function getXml()
        {
            $xmlPayload = new \SimpleXMLElement('<'.$this->getName().'/>');
            $properties  = get_object_vars($this);
            foreach (array_keys($properties) as $property)
            {
                $cleanProperty = ltrim($property, '_');
                $action = 'get'.ucfirst($cleanProperty);
                if (!method_exists($this, $action))
                {
                    throw new InvalidPropertyException();
                }
                $value = $this->{$action}();
                if ($value !== null)
                {
                    if ($value instanceof ApiModel)
                    {
                        $modelValue = simplexml_load_string($value->getXml());
                        EffectConnectXMLElement::insert($xmlPayload, $modelValue);
                    } elseif (is_array($value))
                    {
                        if ($this->isIterator())
                        {
                            foreach ($value as $parent => $list) {
                                if ($list instanceof ApiModel)
                                {
                                    $xml = simplexml_load_string($list->getXml());
                                    EffectConnectXMLElement::insert($xmlPayload, $xml);
                                } elseif (is_string($list))
                                {
                                    EffectConnectXMLElement::addCDataChild($xmlPayload, $cleanProperty, $list);
                                } elseif (is_array($list))
                                {
                                    $container = $xmlPayload->addChild($cleanProperty);
                                    foreach ($list as $item)
                                    {
                                        EffectConnectXMLElement::addCDataChild($container, $parent, $item);
                                    }
                                } else
                                {
                                    if (is_bool($list))
                                    {
                                        $list = $list?'true':'false';
                                    }
                                    $xmlPayload->addChild($parent, $list);
                                }
                            }
                        } else
                        {
                            $iterableElement = $xmlPayload->addChild($cleanProperty);
                            foreach ($value as $parent => $list)
                            {
                                if ($list instanceof ApiModel)
                                {
                                    EffectConnectXMLElement::insert($iterableElement, simplexml_load_string($list->getXml()));
                                } elseif(is_array($list))
                                {
                                    EffectConnectXMLElement::addCDataChild($iterableElement, key($list), current($list));
                                }
                                else
                                {
                                    if (is_string($list))
                                    {
                                        EffectConnectXMLElement::addCDataChild($iterableElement, $parent, $list);
                                    } else
                                    {
                                        if (is_bool($list))
                                        {
                                            $list = $list?'true':'false';
                                        }
                                        $iterableElement->addChild($parent, $list);
                                    }
                                }
                            }
                        }
                    } else
                    {
                        if (is_string($value))
                        {
                            EffectConnectXMLElement::addCDataChild($xmlPayload, $cleanProperty, $value);
                        } else
                        {
                            if (is_bool($value))
                            {
                                $value = $value?'true':'false';
                            }
                            $xmlPayload->addChild($cleanProperty, $value);
                        }
                    }
                }
            }

            return $xmlPayload->asXML();
        }

        public function __get($name)
        {
            if(property_exists($this, $name))
            {
                return $this->{'_'.$name};
            }
            return null;
        }

        protected function isIterator()
        {
            return false;
        }

        public abstract function getName();
    }