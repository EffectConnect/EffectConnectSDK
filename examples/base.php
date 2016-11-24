<?php
    use EffectConnectSDK\Core\Helper\Keychain;
    use EffectConnectSDK\Core;
    require_once(realpath(__DIR__.'/..').'/autoload/effectConnectSdk.php');

    $publicKey = 'PutYourSuppliedPublicKey';
    $secretKey = 'FillInYourOwnSecretKeyAsSupplied';

    $keychain  = new Keychain();
    $keychain
        ->setPublicKey($publicKey)
        ->setSecretKey($secretKey)
    ;
    $effectConnectSDK   = new Core($keychain);