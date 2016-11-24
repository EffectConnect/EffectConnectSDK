<?php
    namespace EffectConnectSDK\Core\Helper;
    use EffectConnectSDK\Core\Exception\InvalidReflectionException;

    /**
     * Class Reflector
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     */
    final class Reflector
    {
        const TYPE_NO_ADDITIONS      = 0;
        const TYPE_PREFIXED_ADDITION = 1;
        const TYPE_SUFFIXED_ADDITION = 2;
        const TYPE_FULL_ADDITION     = 3;

        /**
         * @param string $class
         * @param mixed $variable
         * @param string|null $predefined
         *
         * @return bool
         *
         * @throws InvalidReflectionException
         */
        public static function isValid($class, $variable, $predefined=null)
        {
            $additionType    = self::TYPE_NO_ADDITIONS;
            $reflection      = new \ReflectionClass($class);
            $prefix          = $suffix = '';
            if ($predefined !== null)
            {
                $exploded = array_filter(explode('%', $predefined));
                if (count($exploded) == 1)
                {
                    if (strpos($predefined, '%') === 0)
                    {
                        $additionType = self::TYPE_SUFFIXED_ADDITION;
                        $suffix = strrev(array_shift($exploded));
                    } else
                    {
                        $additionType = self::TYPE_PREFIXED_ADDITION;
                        $prefix = array_shift($exploded);
                    }
                } else
                {
                    if (count($exploded) > 2)
                    {
                        throw new InvalidReflectionException();
                    }
                    $additionType = self::TYPE_FULL_ADDITION;
                    $prefix       = array_shift($exploded);
                    $suffix       = array_shift($exploded);
                }
            }
            foreach ($reflection->getConstants() as $constant => $validConstant)
            {
                if ($validConstant !== $variable)
                {
                    continue;
                }
                switch ($additionType)
                {
                    case self::TYPE_PREFIXED_ADDITION:
                        if (strpos($constant, $prefix) === 0)
                        {
                            return true;
                        }
                        break;
                    case self::TYPE_SUFFIXED_ADDITION:
                        $flippedConstant = strrev($constant);
                        if (strpos($flippedConstant, $suffix) === 0)
                        {
                            return true;
                        }
                        break;
                    case self::TYPE_FULL_ADDITION:
                        $flippedConstant = strrev($constant);
                        if ((strpos($constant, $prefix) === 0 && strpos($flippedConstant, $suffix) === 0))
                        {
                            return true;
                        }
                        break;
                    case self::TYPE_NO_ADDITIONS:
                    default:
                        return true;
                        break;
                }
            }

            return false;
        }
    }