<?php
    // 1. Require the SDK base file.
    require_once(realpath(__DIR__.'/..').'/base.php');

    /**
     * @var EffectConnectSDK\Core\CallType\OrderCall $orderCallType
     *
     * 2. Get the Order call type.
     */
    try
    {
        $orderCallType = $effectConnectSDK->OrderCall();
        $orderCallType
            ->setResponseType(EffectConnectSDK\Core\Interfaces\CallTypeInterface::RESPONSE_TYPE_XML)
            ->setResponseLanguage('en')
        ;
    } catch (Exception $exception)
    {
        echo sprintf('Could not create call type. `%s`', $exception->getMessage());
        die();
    }
    /**
     * 3. Create an EffectConnectSDK\Core\Model\Order object containing the order number and tracking code.
     */
    $orderNumber  = '1323';
    $order        = (new EffectConnectSDK\Core\Model\Order())
        ->setNumber($orderNumber)
        ->setTrackingCode('TEST123456')
    ;
    /**
     * 4. Make the call
     */
    $apiCall = $orderCallType->update($order);
    $apiCall->call();

    echo $apiCall->getCurlResponse();