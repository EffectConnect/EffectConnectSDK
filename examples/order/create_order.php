<?php
    // 1. Require the SDK base file.
    require_once(realpath(__DIR__.'/..').'/base.php');

    /**
     * @var \EffectConnectSDK\Core $effectConnectSDK
     * @var \EffectConnectSDK\Core\CallType\OrderCall $orderCallType
     *
     * 2. Get the Order call type.
     */
    try
    {
        $orderCallType = $effectConnectSDK->OrderCall();
    } catch (Exception $exception)
    {
        echo sprintf('Could not create call type. `%s`', $exception->getMessage());
        die();
    }
    /**
     * 3. Create an EffectConnectSDK\Core\Model\Order object and populate it with all required information
     */
    $orderNumber  = '1323';
    $orderStatus  = \EffectConnectSDK\Core\Model\Order::STATUS_NEW;
    $currency     = 'EUR';
    $date         = new \DateTime('now', new \DateTimeZone('Europe/Amsterdam'));
    $shippingCost = 0;
    $handlingCost = 0;
    try
    {
        $order = (new \EffectConnectSDK\Core\Model\Order())
            ->setNumber($orderNumber)
            ->setStatus($orderStatus)
            ->setCurrency($currency)
            ->setDate($date)
            ->setShippingCost($shippingCost)
            ->setHandlingCost($handlingCost)
        ;
        $shippingAddress = (new \EffectConnectSDK\Core\Model\OrderAddress())
            ->setType(\EffectConnectSDK\Core\Model\OrderAddress::TYPE_SHIPPING)
            ->setSalutation(\EffectConnectSDK\Core\Model\OrderAddress::SALUTATION_MALE)
            ->setFirstName('Stefan')
            ->setLastName('Van den Heuvel')
            ->setCompany('Koek & Peer')
            ->setStreet('Tolhuisweg')
            ->setHouseNumber('5')
            ->setHouseNumberExtension('a')
            ->setAddressNote('Kantoor')
            ->setZipCode('6071RG')
            ->setCity('Swalmen')
            ->setState('Limburg')
            ->setCountry('NL')
            ->setPhone('0123456789')
            ->setEmail('stefan@koekenpeer.nl')
        ;
        $billingAddress = (new \EffectConnectSDK\Core\Model\OrderAddress())
            ->setType(\EffectConnectSDK\Core\Model\OrderAddress::TYPE_BILLING)
            ->setSalutation(\EffectConnectSDK\Core\Model\OrderAddress::SALUTATION_MALE)
            ->setFirstName('Stefan')
            ->setLastName('Van den Heuvel')
            ->setCompany('EffectConnect')
            ->setStreet('Eenanderadres')
            ->setHouseNumber('12')
            ->setAddressNote('Thuis?')
            ->setZipCode('1234AB')
            ->setCity('ABCStad')
            ->setState('Ergens')
            ->setCountry('NL')
            ->setPhone('9876543210')
            ->setEmail('stefan+1@koekenpeer.n')
        ;

        $firstOrderLine = (new \EffectConnectSDK\Core\Model\OrderLine())
            ->setId('1232456-1')
            ->setOptionId(902)
            ->setAmount(1)
            ->setPrice(16000)
            ->setTransactionFee(230)
        ;
        $secondOrderLine = (new \EffectConnectSDK\Core\Model\OrderLine())
            ->setId('1232456-2')
            ->setOptionId(357)
            ->setAmount(3)
            ->setPrice(41000)
            ->setTransactionFee(230)
        ;
        $order
            ->setBillingAddress($billingAddress)
            ->setShippingAddress($shippingAddress)
            ->addOrderLine($firstOrderLine)
            ->addOrderLine($secondOrderLine)
        ;
    } catch (Exception $exception)
    {
        echo sprintf('Could not create Order object. `%s`', $exception->getMessage());
        die();
    }
    /**
     * 4. Make the call
     */
    $apiCall = $orderCallType->create($order);
    $apiCall->call();

    echo $apiCall->getCurlResponse();