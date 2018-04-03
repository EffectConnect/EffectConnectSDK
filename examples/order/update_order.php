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
     * 3. Create an EffectConnectSDK\Core\Model\Order object containing all orderlines you're trying to update.
     */

    try
    {
        $firstUpdatableOrderline = (new \EffectConnectSDK\Core\Model\OrderLineUpdate())
            ->setIdentifierType(\EffectConnectSDK\Core\Model\OrderLineUpdate::TYPE_CHANNEL_LINE_ID)
            ->setIdentifier('test_order_1.2')
            ->setTrackingNumber('TEST-TRACK-1234')
            ->setTrackingUrl('https://test-update.test')
            ->setCarrier('NOT A CARRIER')
        ;
        $secondUpdatableOrderline = (new \EffectConnectSDK\Core\Model\OrderLineUpdate())
            ->setIdentifierType(\EffectConnectSDK\Core\Model\OrderLineUpdate::TYPE_CHANNEL_LINE_ID)
            ->setIdentifier('test_order_1.1')
            ->setTrackingNumber('TEST-TRACK-1234')
            ->setTrackingUrl('https://test-update.test')
            ->setCarrier('NOT A CARRIER')
        ;
        $orderUpdate             = (new EffectConnectSDK\Core\Model\OrderUpdateRequest())
            ->addLineUpdate($firstUpdatableOrderline)
            ->addLineUpdate($secondUpdatableOrderline)
        ;
    } catch (Exception $exception)
    {
        echo sprintf('Could not create object. `%s`', $exception->getMessage());
        die();
    }
    /**
     * 4. Make the call
     */
    $apiCall = $orderCallType->update($orderUpdate);
    $apiCall->call();

    echo $apiCall->getCurlResponse();