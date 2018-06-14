<?php
    // 1. Require the SDK base file.
    require_once(realpath(__DIR__.'/..').'/base.php');
    /**
     * @var \EffectConnectSDK\Core                        $effectConnectSDK
     * @var \EffectConnectSDK\Core\CallType\ProcessCall   $processCallType
     *
     * 2. Get the Process call type.
     */
    try
    {
        $processCallType = $effectConnectSDK->ProcessCall();
    } catch (Exception $exception)
    {
        echo sprintf('Could not create call type. `%s`', $exception->getMessage());
        die();
    }
    /**
     * 3. Create an EffectConnectSDK\Core\Model\ProcessReadRequest object and populate it with the process ID you want to retrieve
     */

    try
    {
        $processReadRequest = (new \EffectConnectSDK\Core\Model\ProcessReadRequest())
            ->setID('Vqs2PqP985p4r1rG')
        ;
    } catch (Exception $exception)
    {
        echo sprintf('Could not create object. `%s`', $exception->getMessage());
        die();
    }
    /**
     * 4. Make the call
     */
    $apiCall = $processCallType->read($processReadRequest);
    $apiCall->call();
    echo $apiCall->getCurlResponse();