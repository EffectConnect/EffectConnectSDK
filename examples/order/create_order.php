<?php
    // 1. Require the SDK base file.
    require_once(realpath(__DIR__.'/..').'/base.php');

    /**
     * @var \EffectConnectSDK\Core $effectConnectSDK
     * @var \EffectConnectSDK\Core\CallType\OrderCall $orderCallType
     *
     * 2. Get the Order call type.
     */
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
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
    $currency     = 'EUR';
    $date         = new \DateTime('now', new \DateTimeZone('Europe/Amsterdam'));
    try
    {
        $shippingAddress = (new \EffectConnectSDK\Core\Model\OrderAddress())
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
            ->setEmail('stefan+1@koekenpeer.nl')
        ;

        $firstOrderLine = (new \EffectConnectSDK\Core\Model\OrderLine())
            ->setId('1232456-1')
            ->addProductIdentifier((new \EffectConnectSDK\Core\Model\OrderLineProductIdentifier())
                ->setType(\EffectConnectSDK\Core\Model\OrderLineProductIdentifier::TYPE_ID)
                ->setValue(1)
            )
            ->setProductTitle('Optie 1')
            ->setIndividualProductPrice(12.50)
            ->addFee((new \EffectConnectSDK\Core\Model\OrderFee())
                ->setType(\EffectConnectSDK\Core\Model\OrderFee::FEE_TYPE_COMMISSION)
                ->setAmount(1.25)
            )
        ;
        $secondOrderLine = (new \EffectConnectSDK\Core\Model\OrderLine())
            ->setId('1232456-2')
            ->addProductIdentifier((new \EffectConnectSDK\Core\Model\OrderLineProductIdentifier())
                ->setType(\EffectConnectSDK\Core\Model\OrderLineProductIdentifier::TYPE_ID)
                ->setValue(6)
            )
            ->setQuantity(3)
            ->setProductTitle('Optie 1')
            ->setIndividualProductPrice(12.50)
            ->addFee((new \EffectConnectSDK\Core\Model\OrderFee())
                ->setType(\EffectConnectSDK\Core\Model\OrderFee::FEE_TYPE_COMMISSION)
                ->setAmount(3.75)
            )
        ;
        $order = (new \EffectConnectSDK\Core\Model\Order())
            ->setNumber($orderNumber)
            ->setCurrency($currency)
            ->setDate($date)
            ->setBillingAddress($billingAddress)
            ->setShippingAddress($shippingAddress)
            ->addLine($firstOrderLine)
            ->addLine($secondOrderLine)
            ->addFee((new \EffectConnectSDK\Core\Model\OrderFee())
                ->setType(\EffectConnectSDK\Core\Model\OrderFee::FEE_TYPE_SHIPPING)
                ->setAmount(6.50)
            )
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