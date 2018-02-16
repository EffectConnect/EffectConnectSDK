<?php
    spl_autoload_register(function ($class) {
        $sdkRoot       = realpath(__DIR__.'/..').'/';
        $namespaceFile = str_replace('\\', '/', $class).'.php';
        $fileLocation  = $sdkRoot.$namespaceFile;
        if (file_exists($fileLocation))
        {
            require_once($fileLocation);
            return true;
        }
        throw new Exception(vsprintf('File `%s` for class `%s` not found', [$fileLocation, $class]));
    }, true);