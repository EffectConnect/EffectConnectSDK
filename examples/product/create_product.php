<?php
    // 1. Require the SDK base file.
    require_once(realpath(__DIR__.'/..').'/base.php');

    /**
     * @var \EffectConnectSDK\Core $effectConnectSDK
     * @var \EffectConnectSDK\Core\CallType\OrderCall $orderCallType
     *
     * 2. Get the Product call type.
     */
    $productCallType = $effectConnectSDK->ProductCall();
    /**
     * 3. Create a CURLFile containing the product feed
     */
    try
    {
        $productCreateFileLocation = realpath(__DIR__).'/files/product_create.xml';
        $curlFile                  = new CURLFile($productCreateFileLocation);
    } catch (Exception $exception)
    {
        echo sprintf('Error in creating CURLFile: `%s`', $exception->getMessage());
        die();
    }
    /**
     * 4. Make the call
     */
    $apiCall = $productCallType->create($curlFile);
    $apiCall->call();

    echo $apiCall->getCurlResponse();