<?php
    namespace EffectConnectSDK;

    use EffectConnectSDK\Core\Exception\InvalidPropertyException;
    use EffectConnectSDK\Core\Interfaces\CallTypeInterface;
    use EffectConnectSDK\Core\Abstracts\ApiModel;

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
         * @var \DateTime $_callDate
         */
        private $_callDate;

        /**
         * @var string $_callVersion
         */
        private $_callVersion = '1.0';

        /**
         * @var int $_curlErrNo
         */
        private $_curlErrNo;

        /**
         * @var array $_curlErrors
         */
        private $_curlErrors = [];

        /**
         * @var array $_curlInfo
         */
        private $_curlInfo = [];

        /**
         * @var string $_curlResponse
         */
        private $_curlResponse;

        /**
         * @var array $_headers
         */
        private $_headers;

        /**
         * @var string $_method
         *
         */
        private $_method;

        /**
         * @var mixed $_payload
         */
        private $_payload;

        /**
         * @var string $_publicKey
         */
        private $_publicKey;

        /**
         * @var string $_responseLanguage
         */
        private $_responseLanguage = 'en';

        /**
         * @var string $_responseType
         *
         */
        private $_responseType = CallTypeInterface::RESPONSE_TYPE_XML;

        /**
         * @var string $_secretKey
         */
        private $_secretKey;
        /**
         * @var string $_uri
         *
         * The endpoint we're attempting to reach
         */
        private $_uri;

        /**
         * @return ApiCall
         */
        final public function call()
        {
            $timeout    = 3;
            $postFields = $this->_payload;
            if ($this->_payload instanceof \CURLFile)
            {
                /**
                 * Allowing a longer timeout to upload the file to EffectConnect.
                 */
                $timeout    = 30;
                /**
                 * Sending the CURLFile as an array.
                 */
                $postFields = [$this->_payload];
            }
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_HTTPHEADER      => $this->_getHeaders(),
                CURLOPT_URL             => self::API_ENDPOINT.$this->_uri,
                CURLOPT_CUSTOMREQUEST   => $this->_method,
                CURLOPT_TIMEOUT         => $timeout,
                CURLOPT_POSTFIELDS      => $postFields,
                CURLOPT_RETURNTRANSFER  => true,
                CURLOPT_SSL_VERIFYPEER  => true,
                CURLOPT_CAINFO          => 'your_certificate'
            ]);
            $this->_curlResponse = curl_exec($ch);
            $this->_curlErrors   = curl_error($ch);
            $this->_curlErrNo    = (int)curl_errno($ch);
            $this->_curlInfo     = curl_getinfo($ch);
            curl_close($ch);

            return $this;
        }

        /**
         * @return array
         */
        final public function getCurlErrors()
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
        final public function getCurlResponse()
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
        final public function isSuccess(): bool
        {
            return (count($this->_curlErrors) === 0 && $this->_curlErrNo === 0 && $this->_curlResponse !== '');
        }

        /**
         * @param \DateTime $callDate
         *
         * @return ApiCall
         */
        final public function setCallDate(\DateTime $callDate)
        {
            $this->_callDate = $callDate;

            return $this;
        }

        /**
         * @param string $callVersion
         *
         * @return ApiCall
         */
        final public function setCallVersion(string $callVersion)
        {
            $this->_callVersion = $callVersion;

            return $this;
        }

        /**
         * @param array $headers
         *
         * @return ApiCall
         */
        final public function setHeaders(array $headers)
        {
            $this->_headers = $headers;

            return $this;
        }

        /**
         * @param string $method
         *
         * @return ApiCall
         */
        final public function setMethod($method)
        {
            $this->_method = $method;

            return $this;
        }

        /**
         * @param \EffectConnectSDK\Core\Abstracts\ApiModel $payload
         *
         * @return $this
         * @throws InvalidPropertyException
         */
        final public function setPayload($payload=null)
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
        final public function setPublicKey($publicKey)
        {
            $this->_publicKey = $publicKey;

            return $this;
        }

        /**
         * @param string $responseLanguage
         *
         * @return ApiCall
         */
        final public function setResponseLanguage($responseLanguage)
        {
            $this->_responseLanguage = $responseLanguage;

            return $this;
        }

        /**
         * @param string $responseType
         *
         * @return ApiCall
         */
        final public function setResponseType($responseType)
        {
            $this->_responseType = $responseType;

            return $this;
        }

        /**
         * @param string $secretKey
         *
         * @return ApiCall
         */
        final public function setSecretKey($secretKey)
        {
            $this->_secretKey = $secretKey;

            return $this;
        }

        /**
         * @param string $uri
         *
         * @return ApiCall
         */
        final public function setUri($uri)
        {
            $this->_uri = $uri;

            return $this;
        }

        /**
         * @return array
         */
        private function _getHeaders()
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
        private function _signApiCall()
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