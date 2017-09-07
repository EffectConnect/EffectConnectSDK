<?php
    use EffectConnectSDK\Core;
    use EffectConnectSDK\Core\Model\Order;
    use EffectConnectSDK\Core\CallType\OrderCall;
    use EffectConnectSDK\Core\Interfaces\CallTypeInterface;

    /**
     * Include the base
     */
    require_once(realpath(__DIR__.'/..').'/base.php');

    /**
     * @var Core $effectConnectSDK
     * @var OrderCall $orderCallType
     *
     * The core as instantiated in base.php
     * Creates the appropriate calltype, in this case, the Order call
     */
    $orderCallType = $effectConnectSDK->OrderCall();
    $orderCallType
        ->setResponseType(CallTypeInterface::RESPONSE_TYPE_XML)
        ->setResponseLanguage('en')
    ;

    $orderNumber  = '1234';
    $order = (new Order())->setNumber($orderNumber);
    $apiCall = $orderCallType->read($order);
    $apiCall->call();
    echo $apiCall->getResponse();