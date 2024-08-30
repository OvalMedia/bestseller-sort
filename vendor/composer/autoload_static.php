<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9f9f14ac59cf723515d663c9baa1e265
{
    public static $prefixLengthsPsr4 = array (
        'O' => 
        array (
            'Ovalmedia\\BestsellerSort\\' => 25,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Ovalmedia\\BestsellerSort\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9f9f14ac59cf723515d663c9baa1e265::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9f9f14ac59cf723515d663c9baa1e265::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9f9f14ac59cf723515d663c9baa1e265::$classMap;

        }, null, ClassLoader::class);
    }
}