<?php
// 1. Require the SDK base file.
require_once(realpath(__DIR__.'/..').'/base.php');

/**
 * @var \EffectConnectSDK\Core $effectConnectSDK
 * @var \EffectConnectSDK\Core\CallType\OrderListCall $orderListCallType
 *
 * 2. Get the OrderList call type.
 */

try
{
    $orderListCallType = $effectConnectSDK->OrderListCall();
} catch (Exception $exception)
{
    echo sprintf('Could not create call type. `%s`', $exception->getMessage());
    die();
}
/**
 * 3. Create an EffectConnectSDK\Core\Model\OrderList object and populate it with the type and values
 */
$listType       = \EffectConnectSDK\Core\Model\OrderList::TYPE_STATUS;
$orderList = (new \EffectConnectSDK\Core\Model\OrderList())
    ->setType($listType)
    ->addValue('new')
    ->addValue('paid')
;
/**
 * 4. Make the call
 */
$apiCall     = $orderListCallType->read($orderList);
$apiCall->call();

echo $apiCall->getCurlResponse();