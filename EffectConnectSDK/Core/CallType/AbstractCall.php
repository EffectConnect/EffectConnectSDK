<?php
    namespace EffectConnectSDK\Core\CallType;

    use EffectConnectSDK\Core\Exception\IncorrectArgumentException;
    use EffectConnectSDK\Core\Exception\InvalidCallTypeException;
    use EffectConnectSDK\Core\Exception\InvalidResponseTypeException;
    use EffectConnectSDK\Core\Exception\InvalidValidatorClassException;
    use EffectConnectSDK\Core\Exception\MissingValidatorClassException;
    use EffectConnectSDK\Core\Helper\Keychain;
    use EffectConnectSDK\Core\Helper\Reflector;
    use EffectConnectSDK\Core\Interfaces\CallTypeInterface;
    use EffectConnectSDK\Core\Interfaces\CallValidatorInterface;

    /**
     * Class AbstractCall
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     */
    abstract class AbstractCall
    {
        /**
         * @var string $_action
         */
        protected $action;

        /**
         * @var \DateTime $callDate
         *
         * Time the call is made.
         */
        protected $callDate;

        /**
         * @var string $callType
         *
         * Defines the payload format
         */
        protected $callType = CallTypeInterface::CALLTYPE_XML;

        /**
         * @var Keychain $keychain
         *
         * Key container for basic key validation
         */
        protected $keychain;

        /**
         * @var mixed $payload
         */
        protected $payload;

        /**
         * @var string $responseLanguage
         *
         * Defines the response language (feedback and errors)
         */
        protected $responseLanguage = 'en';

        /**
         * @var string $responseType
         *
         * Defines how the response will be formatted
         */
        protected $responseType = CallTypeInterface::RESPONSE_TYPE_XML;

        /**
         * @var CallValidatorInterface $validator
         */
        protected $validator;

        /**
         * @var string $validatorClass
         */
        protected $validatorClass;

        public function __construct(Keychain $keychain)
        {
            $this->keychain = $keychain;
            $this->callDate = new \DateTime('now', new \DateTimeZone('Europe/Amsterdam'));
            if (!$this->validatorClass)
            {
                throw new MissingValidatorClassException();
            }
            if (!class_exists($this->validatorClass))
            {
                throw new InvalidValidatorClassException();
            }
            $this->validator = new $this->validatorClass();
        }

        public function __call($name, $arguments)
        {
            if (count($arguments) !== 1)
            {
                throw new IncorrectArgumentException();
            }
            $this->payload = array_shift($arguments);
            $this->action  = $name;
            $this->validator->setup($this->action);
            $this->validator->validateCall($this->payload);

            return $this->doCall();
        }

        /**
         * @param string $callType
         *
         * @return CallTypeInterface
         * @throws InvalidCallTypeException
         */
        public function setCallType($callType)
        {
            if (Reflector::isValid(CallTypeInterface::class, $callType, 'CALLTYPE_%') === true)
            {
                $this->callType = $callType;
            } else
            {
                throw new InvalidCallTypeException();
            }

            /** @var CallTypeInterface $this */
            return $this;
        }

        /**
         * @param $responseLanguage
         *
         * @return CallTypeInterface
         */
        public function setResponseLanguage($responseLanguage)
        {
            $this->responseLanguage = $responseLanguage;

            /** @var CallTypeInterface $this */
            return $this;
        }

        /**
         * @param string $responseType
         **
         * @return CallTypeInterface
         * @throws InvalidResponseTypeException
         */
        public function setResponseType($responseType)
        {
            if (Reflector::isValid(CallTypeInterface::class, $responseType, 'RESPONSE_TYPE_%') === true)
            {
                $this->responseType = $responseType;
            } else
            {
                throw new InvalidResponseTypeException();
            }

            /** @var CallTypeInterface $this */
            return $this;
        }

        public abstract function doCall();
    }