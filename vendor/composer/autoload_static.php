<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit58ec4795c639b9b1d1e865b9e3133604
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit58ec4795c639b9b1d1e865b9e3133604::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit58ec4795c639b9b1d1e865b9e3133604::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit58ec4795c639b9b1d1e865b9e3133604::$classMap;

        }, null, ClassLoader::class);
    }
}