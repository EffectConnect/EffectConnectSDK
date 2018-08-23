<?php
    // 1. Require the SDK base file.
    require_once(realpath(__DIR__.'/..').'/base.php');

    /**
     * @var EffectConnect\PHPSdk\Core\CallType\OrderCall $orderCallType
     *
     * 2. Get the Order call type.
     */
    try
    {
        $orderCallType = $effectConnectSDK->OrderCall();
        $orderCallType
            ->setResponseType(EffectConnect\PHPSdk\Core\Interfaces\CallTypeInterface::RESPONSE_TYPE_XML)
            ->setResponseLanguage('en')
        ;
    } catch (Exception $exception)
    {
        echo sprintf('Could not create call type. `%s`', $exception->getMessage());
        die();
    }
    /**
     * 3. Create an EffectConnect\PHPSdk\Core\Model\Order object containing all orderlines you're trying to update.
     */

    try
    {
        $orderAddTag             = (new \EffectConnect\PHPSdk\Core\Model\OrderUpdate())
            ->setOrderIdentifierType(\EffectConnect\PHPSdk\Core\Model\OrderUpdate::TYPE_CHANNEL_NUMBER)
            ->setOrderIdentifier('TEST-ORDER-1')
            ->addTag('CustomTag')
            ->addTag('Test')
            ->removeTag('RemovableTag')
        ;
        $firstUpdatableOrderline = (new \EffectConnect\PHPSdk\Core\Model\OrderLineUpdate())
            ->setOrderlineIdentifierType(\EffectConnect\PHPSdk\Core\Model\OrderLineUpdate::TYPE_CHANNEL_LINE_ID)
            ->setOrderlineIdentifier('test_order3_1.2')
            ->setTrackingNumber('TEST-TRACK-1234')
            ->setTrackingUrl('https://test-update.test')
            ->setCarrier('NOT A CARRIER')
        ;
        $secondUpdatableOrderline = (new \EffectConnect\PHPSdk\Core\Model\OrderLineUpdate())
            ->setOrderlineIdentifierType(\EffectConnect\PHPSdk\Core\Model\OrderLineUpdate::TYPE_CHANNEL_LINE_ID)
            ->setOrderlineIdentifier('test_order3_1.1')
            ->setTrackingNumber('TEST-TRACK-1234')
            ->setTrackingUrl('https://test-update.test')
            ->setCarrier('NOT A CARRIER')
        ;
        $orderUpdate             = (new EffectConnect\PHPSdk\Core\Model\OrderUpdateRequest())
            ->addLineUpdate($firstUpdatableOrderline)
            ->addLineUpdate($secondUpdatableOrderline)
            ->addOrderUpdate($orderAddTag)
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