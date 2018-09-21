<?php
    namespace EffectConnect\PHPSdk;

    use EffectConnect\PHPSdk\Core\Exception\InvalidPropertyException;
    use EffectConnect\PHPSdk\Core\Exception\MissingCertificateFileException;
    use EffectConnect\PHPSdk\Core\Exception\MissingCertificateLocationException;
    use EffectConnect\PHPSdk\Core\Interfaces\CallTypeInterface;
    use EffectConnect\PHPSdk\Core\Abstracts\ApiModel;

    /**
     * Class ApiCall
     *
     * @author  Stefan Van den Heuvel
     * @company Koek & Peer
     * @product EffectConnect
     * @package EffectConnectSDK
     *
     */
    class ApiCall
    {
        const API_ENDPOINT          = 'https://submit.effectconnect.com/v1';
        const CERTIFICATE_LOCATION  = '';

        /**
         * @var \DateTime $_callDate
         */
        protected $_callDate;

        /**
         * @var string $_callVersion
         */
        protected $_callVersion = '1.0';

        /**
         * @var int $_curlErrNo
         */
        protected $_curlErrNo;

        /**
         * @var array $_curlErrors
         */
        protected $_curlErrors = [];

        /**
         * @var array $_curlInfo
         */
        protected $_curlInfo = [];

        /**
         * @var string $_curlResponse
         */
        protected $_curlResponse;

        /**
         * @var array $_headers
         */
        protected $_headers;

        /**
         * @var string $_method
         *
         */
        protected $_method;

        /**
         * @var mixed $_payload
         */
        protected $_payload;

        /**
         * @var string $_publicKey
         */
        protected $_publicKey;

        /**
         * @var string $_responseLanguage
         */
        protected $_responseLanguage = 'en';

        /**
         * @var string $_responseType
         *
         */
        protected $_responseType = CallTypeInterface::RESPONSE_TYPE_XML;

        /**
         * @var string $_secretKey
         */
        protected $_secretKey;
        /**
         * @var int $_timeout
         */
        protected $_timeout = 3;
        /**
         * @var string $_uri
         *
         * The endpoint we're attempting to reach
         */
        protected $_uri;

        /**
         * @return ApiCall
         *
         * @throws MissingCertificateFileException
         * @throws MissingCertificateLocationException
         */
        public function call()
        {
            $postFields = $this->_payload;
            if ($this->_payload instanceof \CURLFile)
            {
                /**
                 * Allowing a longer timeout to upload the file to EffectConnect.
                 */
                $this->_timeout = 30;
                /**
                 * Sending the CURLFile as an array.
                 */
                $postFields     = [$this->_payload];
            }
            if (!self::CERTIFICATE_LOCATION)
            {
                throw new MissingCertificateLocationException();
            }
            if (!file_exists(self::CERTIFICATE_LOCATION))
            {
                throw new MissingCertificateFileException(self::CERTIFICATE_LOCATION);
            }
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_HTTPHEADER      => $this->_getHeaders(),
                CURLOPT_URL             => self::API_ENDPOINT.$this->_uri,
                CURLOPT_CUSTOMREQUEST   => $this->_method,
                CURLOPT_TIMEOUT         => $this->_timeout,
                CURLOPT_POSTFIELDS      => $postFields,
                CURLOPT_RETURNTRANSFER  => true,
                CURLOPT_SSL_VERIFYHOST  => 2,
                CURLOPT_CAINFO          => self::CERTIFICATE_LOCATION
            ]);
            $this->_curlResponse = curl_exec($ch);
            $this->_curlErrors[] = curl_error($ch);
            $this->_curlErrNo    = (int)curl_errno($ch);
            $this->_curlInfo     = curl_getinfo($ch);
            curl_close($ch);

            return $this;
        }

        /**
         * @return array
         */
        public function getCurlErrors()
        {
            if ($this->_curlErrNo > 0)
            {
                $this->_curlErrors[] = sprintf('Curl error %d', $this->_curlErrNo);
            }
            return $this->_curlErrors;
        }

        /**
         * @return string
         */
        public function getCurlResponse()
        {
            switch ($this->_responseType)
            {
                case CallTypeInterface::RESPONSE_TYPE_XML:
                    $dom = new \DOMDocument();
                    $dom->loadXML($this->_curlResponse);
                    $dom->formatOutput       = true;
                    $dom->preserveWhiteSpace = false;
                    return $dom->saveXML();
                    break;
                case CallTypeInterface::RESPONSE_TYPE_JSON:
                    return '<pre>'.print_r($this->_curlResponse, true).'</pre>';
                    break;
                default:
                    return $this->_curlResponse;
                    break;
            }
        }

        /**
         * @return bool
         */
        public function isSuccess()
        {
            return (count($this->_curlErrors) === 0 && $this->_curlErrNo === 0 && $this->_curlResponse !== '');
        }

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
         * @param string $callVersion
         *
         * @return ApiCall
         */
        public function setCallVersion($callVersion)
        {
            $this->_callVersion = $callVersion;

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
         * @param string $method
         *
         * @return ApiCall
         */
        public function setMethod($method)
        {
            $this->_method = $method;

            return $this;
        }

        /**
         * @param \EffectConnect\PHPSdk\Core\Abstracts\ApiModel $payload
         *
         * @return $this
         * @throws InvalidPropertyException
         */
        public function setPayload($payload=null)
        {
            if ($payload instanceof ApiModel)
            {
                $this->_payload = $payload->getXml();
            } elseif ($payload instanceof \CURLFile)
            {
                $this->_payload = $payload;
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
         * @param $timeout
         *
         * @return ApiCall
         */
        public function setTimeout($timeout)
        {
            $this->_timeout = $timeout;

            return $this;
        }

        /**
         * @return array
         */
        protected function _getHeaders()
        {
            $headers = [
                'KEY: '.$this->_publicKey,
                'VERSION: '.$this->_callVersion,
                'URI: '.$this->_uri,
                'RESPONSETYPE: '.$this->_responseType,
                'RESPONSELANGUAGE: '.$this->_responseLanguage,
                'TIME: '.$this->_callDate->format('Y-m-d\TH:i:sP'),
                'SIGNATURE: '.$this->_signApiCall()
            ];
            if ($this->_payload instanceof \CURLFile)
            {
                /**
                 * Setting the Content-Type header for sending our file.
                 */
                $headers[] = 'Content-Type: text/xml';
            }

            return $headers;
        }

        /**
         * @return string
         */
        protected function _signApiCall()
        {
            if ($this->_payload instanceof \CURLFile)
            {
                $size = filesize($this->_payload->getFilename());
            } else
            {
                $size = strlen((string)$this->_payload);
            }
            $digest = [
                $size,
                $this->_method,
                $this->_uri,
                $this->_callVersion,
                $this->_callDate->format('Y-m-d\TH:i:sP')
            ];
            return base64_encode(hash_hmac('sha512', implode('', $digest), $this->_secretKey, true));
        }
    }