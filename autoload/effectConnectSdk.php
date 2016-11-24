<?php
    spl_autoload_register(function ($class) {
        $sdkRoot       = realpath(__DIR__.DIRECTORY_SEPARATOR.'..').DIRECTORY_SEPARATOR;
        $namespaceFile = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
        $fileLocation  = $sdkRoot.$namespaceFile;
        if (file_exists($fileLocation))
        {
            require_once($fileLocation);
            return true;
        }

        throw new Exception('File `'.$fileLocation.'` for class `'.$class.'` not found');
    }, true);