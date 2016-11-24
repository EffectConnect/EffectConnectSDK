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
    $orderStatus  = Order::STATUS_NEW;
    $currency     = 'EUR';
    $date         = new \DateTime('now', new \DateTimeZone('Europe/Amsterdam'));
    $shippingCost = 0;
    $handlingCost = 0;

    $order = (new Order())
        ->setNumber($orderNumber)
        ->setStatus($orderStatus)
        ->setCurrency($currency)
        ->setDate($date)
        ->setShippingCost($shippingCost)
        ->setHandlingCost($handlingCost)
    ;
    $shippingAddress = (new OrderAddress())
        ->setType(OrderAddress::TYPE_SHIPPING)
        ->setSalutation(OrderAddress::SALUTATION_MALE)
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
    $billingAddress = (new OrderAddress())
        ->setType(OrderAddress::TYPE_BILLING)
        ->setSalutation(OrderAddress::SALUTATION_MALE)
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

    $firstOrderLine = (new OrderLine())
        ->setId('1232456-1')
        ->setOptionId(902)
        ->setAmount(1)
        ->setPrice(16000)
        ->setTransactionFee(230)
    ;
    $secondOrderLine = (new OrderLine())
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

    $apiCall = $orderCallType->create($order);
    $apiCall->call();
    echo $apiCall->getResponse();