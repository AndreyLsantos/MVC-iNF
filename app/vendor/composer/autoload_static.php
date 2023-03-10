<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4343cf2fd6981efb451b2fff5a916c07
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'InfluenceDigital\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'InfluenceDigital\\' => 
        array (
            0 => __DIR__ . '/../..' . '/aplicacao',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4343cf2fd6981efb451b2fff5a916c07::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4343cf2fd6981efb451b2fff5a916c07::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit4343cf2fd6981efb451b2fff5a916c07::$classMap;

        }, null, ClassLoader::class);
    }
}
