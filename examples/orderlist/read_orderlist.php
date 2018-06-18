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
    $fromDateExampleFilter = new \EffectConnectSDK\Core\Model\Filter\FromDateFilter();
    /**
     * Example: Retrieve all orders placed AFTER 01-04-2018 at 04:00:00
     */
    $fromDateExampleFilter->setFilterValue(new DateTime('2018-04-01 04:00:00', new DateTimeZone('Europe/Amsterdam')));
    $toDateExampleFilter   = new \EffectConnectSDK\Core\Model\Filter\ToDateFilter();
    /**
     * Example: Retrieve all orders placed BEFORE today
     */
    $toDateExampleFilter->setFilterValue(new DateTime('now', new DateTimeZone('Europe/Amsterdam')));

    $statusExampleFilter   = new \EffectConnectSDK\Core\Model\Filter\HasStatusFilter();
    /**
     * Example: Retrieve all orders having either "Paid" or "Cancelled" status.
     */
    $statusExampleFilter->setFilterValue([
        \EffectConnectSDK\Core\Model\Filter\HasStatusFilter::STATUS_PAID,
        \EffectConnectSDK\Core\Model\Filter\HasStatusFilter::STATUS_CANCELLED
    ]);
    $tagExampleFilter      = new \EffectConnectSDK\Core\Model\Filter\HasTagFilter();
    /**
     * Example: Retrieve all orders NOT containing the "Test" tag.
     */
    $tagExampleFilter->setFilterValue([
        (new \EffectConnectSDK\Core\Model\Filter\TagFilterValue())
            ->setTagName('Test')
            ->setExclude(true)
    ]);
    /**
     * Example: Retrieve all orders containgin the "CustomTest" tag.
     */
    $tagExampleFilter->setFilterValue([
        (new \EffectConnectSDK\Core\Model\Filter\TagFilterValue())
            ->setTagName('CustomTest')
    ]);

    $orderList = (new \EffectConnectSDK\Core\Model\OrderList())
        ->addFilter($fromDateExampleFilter)
        ->addFilter($toDateExampleFilter)
        ->addFilter($statusExampleFilter)
        ->addFilter($tagExampleFilter)
    ;
    /**
     * 4. Make the call
     */
    $apiCall = $orderListCallType->read($orderList);
    $apiCall->call();
    echo $apiCall->getCurlResponse();