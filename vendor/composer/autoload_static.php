<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit019cc1a87c692cb9baeba8212a40febe
{
    public static $files = array (
        '72033b16ae40bd4e52712b8d2bd804b8' => __DIR__ . '/../..' . '/DB_Details.php',
    );

    public static $classMap = array (
        'CRUD' => __DIR__ . '/../..' . '/class/CRUD.php',
        'DB' => __DIR__ . '/../..' . '/class/DB_Connect.php',
        'Router' => __DIR__ . '/../..' . '/class/Router.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit019cc1a87c692cb9baeba8212a40febe::$classMap;

        }, null, ClassLoader::class);
    }
}