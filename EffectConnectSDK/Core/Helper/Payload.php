<?php
    namespace EffectConnect\PHPSdk\Core\Helper;

    /**
     * Class Payload
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     */
    final class Payload
    {
        /**
         * @param      $payload
         * @param      $field
         * @param bool $recursive
         *
         * @return mixed|null|\SimpleXMLElement|string
         */
        final public static function extract($payload, $field, $recursive=false)
        {
            if (is_array($payload))
            {
                return self::_extractFromJson($payload, $field, $recursive);
            } elseif ($payload instanceof \SimpleXMLElement)
            {
                return self::_extractFromXml($payload, $field, $recursive);
            }

            return null;
        }

        /**
         * @param $payload
         * @param $field
         *
         * @return bool
         */
        final public static function contains($payload, $field)
        {
            if (is_array($payload))
            {
                return array_key_exists($field, $payload);
            } elseif ($payload instanceof \SimpleXMLElement)
            {
                return isset($payload->{$field});
            }

            return false;
        }

        /**
         * @param array $payload
         * @param       $field
         * @param bool  $recursive
         *
         * @return mixed|null
         */
        private static function _extractFromJson(array $payload, $field, $recursive=false)
        {
            if (array_key_exists($field, $payload))
            {
                return $payload[$field];
            }
            if ($recursive)
            {
                return reset($payload);
            }

            return null;
        }

        /**
         * @param \SimpleXMLElement $payload
         * @param                   $field
         * @param bool              $recursive
         *
         * @return array|null|\SimpleXMLElement|string
         */
        private static function _extractFromXml(\SimpleXMLElement $payload, $field, $recursive=false)
        {
            if (isset($payload->{$field}))
            {
                $value = $payload->{$field};
                if (count($value->children()) === 0)
                {
                    return (string)$value;
                } else
                {
                    $newValue = $value;
                    if ($recursive)
                    {
                        $newValue = [];
                        foreach ($value->children() as $child)
                        {
                            $newValue[] = $child;
                        }
                    }
                    return $newValue;
                }
            } elseif ($recursive)
            {
                return $payload;
            }

            return null;
        }
    }