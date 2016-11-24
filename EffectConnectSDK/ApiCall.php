<?php
    namespace EffectConnectSDK;

    use EffectConnectSDK\Core\Interfaces\CallTypeInterface;
    use EffectConnectSDK\Core\Model\ApiModel;

    /**
     * Class ApiCall
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     */
    final class ApiCall
    {
        const API_ENDPOINT  = 'https://submit.effectconnect.com/v1';

        /**
         * @var string $_uri
         *
         * The endpoint we're attempting to reach
         */
        private $_uri;

        /**
         * @var string $_method
         *
         */
        private $_method;

        /**
         * @var string $_responseType
         *
         */
        private $_responseType = CallTypeInterface::RESPONSE_TYPE_XML;
        /**
         * @var string $_callType
         *
         */
        private $_callType = CallTypeInterface::CALLTYPE_XML;

        /**
         * @var string $_responseLanguage
         */
        private $_responseLanguage = 'en';

        /**
         * @var mixed $_payload
         */
        private $_payload;

        /**
         * @var string $_publicKey
         */
        private $_publicKey;

        /**
         * @var string $_secretKey
         */
        private $_secretKey;

        /**
         * @var \DateTime $_callDate
         */
        private $_callDate;

        /**
         * @var array $_headers
         */
        private $_headers;

        /**
         * @var string $_response
         */
        private $_response;

        /**
         * @var array $_errors
         */
        private $_errors = [];

        /**
         * @param \DateTime $callDate
         *
         * @return ApiCall
         */
        public function setCallDate(\DateTime $callDate)
        {
            $this->_callDate = $callDate;

            return $this;
        }

        /**
         * @param string $uri
         *
         * @return ApiCall
         */
        public function setUri($uri)
        {
            $this->_uri = $uri;

            return $this;
        }

        /**
         * @param string $method
         *
         * @return ApiCall
         */
        public function setMethod($method)
        {
            $this->_method = $method;

            return $this;
        }

        public function setCallType($callType)
        {
            $this->_callType = $callType;

            return $this;
        }

        /**
         * @param string $responseType
         *
         * @return ApiCall
         */
        public function setResponseType($responseType)
        {
            $this->_responseType = $responseType;

            return $this;
        }

        /**
         * @param string $responseLanguage
         *
         * @return ApiCall
         */
        public function setResponseLanguage($responseLanguage)
        {
            $this->_responseLanguage = $responseLanguage;

            return $this;
        }

        /**
         * @param mixed $payload
         *
         * @return ApiCall
         */
        public function setPayload(ApiModel $payload)
        {
            if ($this->_callType === 'XML')
            {
                $this->_payload = $payload->getXml();
            } elseif ($this->_callType === 'JSON')
            {
                $this->_payload = $payload->getJson();
            }

            return $this;
        }

        /**
         * @param string $publicKey
         *
         * @return ApiCall
         */
        public function setPublicKey($publicKey)
        {
            $this->_publicKey = $publicKey;

            return $this;
        }

        /**
         * @param string $secretKey
         *
         * @return ApiCall
         */
        public function setSecretKey($secretKey)
        {
            $this->_secretKey = $secretKey;

            return $this;
        }

        /**
         * @param string $signature
         *
         * @return ApiCall
         */
        public function setSignature($signature)
        {
            $this->_signature = $signature;

            return $this;
        }

        /**
         * @param array $headers
         *
         * @return ApiCall
         */
        public function setHeaders(array $headers)
        {
            $this->_headers = $headers;

            return $this;
        }

        /**
         * @return array
         */
        private function _getHeaders()
        {
            return [
                'Content-Length: '.strlen((string)$this->_payload),
                'KEY: '.$this->_publicKey,
                'VERSION: '.Core::SDK_VERSION,
                'URI: '.$this->_uri,
                'RESPONSETYPE: '.$this->_responseType,
                'RESPONSELANGUAGE: '.$this->_responseLanguage,
                'TIME: '.$this->_callDate->format('Y-m-d\TH:i:sP'),
                'SIGNATURE: '.$this->_signApiCall()
            ];
        }

        /**
         * @return string
         */
        private function _signApiCall()
        {
            $digest = [
                strlen((string)$this->_payload),
                $this->_method,
                $this->_uri,
                Core::SDK_VERSION,
                $this->_callDate->format('Y-m-d\TH:i:sP')
            ];
            return base64_encode(hash_hmac('sha512', implode('', $digest), $this->_secretKey, true));
        }

        /**
         * @return ApiCall
         */
        public function call()
        {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_HTTPHEADER      => $this->_getHeaders(),
                CURLOPT_URL             => self::API_ENDPOINT.$this->_uri,
                CURLOPT_CUSTOMREQUEST   => $this->_method,
                CURLOPT_TIMEOUT         => 3,
                CURLOPT_POSTFIELDS      => (string)$this->_payload,
                CURLOPT_RETURNTRANSFER  => true
            ]);
            $this->_response = curl_exec($ch);
            $this->_errors   = curl_error($ch);
            curl_close($ch);

            return $this;
        }

        public function getErrors()
        {
            return $this->_errors;
        }

        public function getResponse()
        {
            switch ($this->_responseType)
            {
                case CallTypeInterface::RESPONSE_TYPE_XML:
                    $dom = new \DOMDocument();
                    $dom->loadXML($this->_response);
                    $dom->formatOutput       = true;
                    $dom->preserveWhiteSpace = false;
                    return $dom->saveXML();
                    break;
                case CallTypeInterface::RESPONSE_TYPE_JSON:
                    return '<pre>'.print_r($this->_response, true).'</pre>';
                    break;
                default:
                    return $this->_response;
                    break;
            }
        }
    }