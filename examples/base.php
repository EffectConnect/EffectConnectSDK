<?php
    use EffectConnectSDK\Core\Helper\Keychain;
    use EffectConnectSDK\Core;
    require_once(realpath(__DIR__.'/..').'/autoload/effectConnectSdk.php');

    /**
     * Set your public and secret keys as supplied by EffectConnect
     */
    $publicKey = 'PutYourSuppliedPublicKey';
    $secretKey = 'FillInYourOwnSecretKeyAsSupplied';
    /**
     * Create the keychain
     */
    $keychain  = new Keychain();
    $keychain
        ->setPublicKey($publicKey)
        ->setSecretKey($secretKey)
    ;
    /**
     * Instantiate the Core
     */
    $effectConnectSDK   = new Core($keychain);