<?php
    // 1. Include the autoloader.
    require_once(realpath(__DIR__.'/..').'/autoload/effectConnectSdk.php');
    // 2. Set your public and secret API keys.
    $publicKey = 'PutYourSuppliedPublicKey';
    $secretKey = 'FillInYourOwnSecretKeyAsSupplied';
    // 3. Create a Keychain object.
    $keychain  = new EffectConnect\PHPSdk\Core\Helper\Keychain();
    try
    {
        // 4. Add your keys to the keychain.
        $keychain
            ->setPublicKey($publicKey)
            ->setSecretKey($secretKey)
        ;
    } catch (\Exception $exception)
    {
        echo sprintf('Could not set API keys. `%s`.', $exception->getMessage());
        die();
    }
    // 5. Instantiate the SDK
    try
    {
        $effectConnectSDK   = new EffectConnect\PHPSdk\Core($keychain);
    } catch (Exception $exception)
    {
        echo sprintf('Could not create SDK. `%s`', $exception->getMessage());
        die();
    }
    // All set! We can now make calls to the EffectConnect API!