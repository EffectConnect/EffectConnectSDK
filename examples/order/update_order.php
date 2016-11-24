<?php
    use EffectConnectSDK\Core\Model\Order;
    use EffectConnectSDK\Core\Model\OrderLine;
    use EffectConnectSDK\Core\Model\OrderAddress;
    use EffectConnectSDK\Core\CallType\OrderCall;
    use EffectConnectSDK\Core\Interfaces\CallTypeInterface;
    require_once(realpath(__DIR__.'/..').'/base.php');

    $orderCallType = $effectConnectSDK->OrderCall();
    /** @var OrderCall $orderCallType */
    $orderCallType
        ->setResponseType(CallTypeInterface::RESPONSE_TYPE_XML)
        ->setResponseLanguage('en')
    ;
    $orderNumber  = '1323';
    $order = (new Order())
        ->setNumber($orderNumber)
        ->setTrackingCode('TEST123456')
    ;

    $apiCall = $orderCallType->update($order);
    $apiCall->call();
    echo $apiCall->getResponse();