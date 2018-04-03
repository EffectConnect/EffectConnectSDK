<?php
    // 1. Require the SDK base file.
    require_once(realpath(__DIR__.'/..').'/base.php');
    /**
     * @var \EffectConnectSDK\Core                        $effectConnectSDK
     * @var \EffectConnectSDK\Core\CallType\OrderListCall $orderListCallType
     *
     * 2. Get the OrderList call type.
     */
    try {
        $orderListCallType = $effectConnectSDK->OrderListCall();
    } catch (Exception $exception) {
        echo sprintf('Could not create call type. `%s`', $exception->getMessage());
        die();
    }
    /**
     * 3. Create an EffectConnectSDK\Core\Model\OrderList object and populate it with the type and values
     */

    try
    {
        $fromDateFilter = (new \EffectConnectSDK\Core\Model\Filter\FromDateFilter())
            ->setFilterValue(new DateTime('2018-01-01 12:00:00', new DateTimeZone('Europe/Amsterdam')))
        ;
        $hasStatusFilter = (new \EffectConnectSDK\Core\Model\Filter\HasStatusFilter())
            ->setFilterValue([
                \EffectConnectSDK\Core\Model\Filter\HasStatusFilter::STATUS_COMPLETED,
                \EffectConnectSDK\Core\Model\Filter\HasStatusFilter::STATUS_PARTIALLY_SHIPPED,
                \EffectConnectSDK\Core\Model\Filter\HasStatusFilter::STATUS_PAID,
            ])
        ;
        $orderList = (new \EffectConnectSDK\Core\Model\OrderList())
            ->addFilter($fromDateFilter)
            ->addFilter($hasStatusFilter)
        ;
    } catch (Exception $exception)
    {
        echo sprintf('Could not create object. `%s`', $exception->getMessage());
        die();
    }
    /**
     * 4. Make the call
     */
    $apiCall = $orderListCallType->read($orderList);
    $apiCall->call();
    echo $apiCall->getCurlResponse();