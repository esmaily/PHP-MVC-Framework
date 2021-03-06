<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit86e5045484ae52d69082edc9ae4c46a9
{
    public static $files = array (
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        '7b6da17ee52fc1de63821b4ffee602db' => __DIR__ . '/../..' . '/config/app.php',
        'e320f53bb3364b7ed572ecc5ef33c5cf' => __DIR__ . '/../..' . '/app/helpers.php',
        'c1d952ed5c3af6ebf32482823b87babf' => __DIR__ . '/../..' . '/app/routes.php',
    );

    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Twig\\' => 5,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Twig\\' => 
        array (
            0 => __DIR__ . '/..' . '/twig/twig/src',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $prefixesPsr0 = array (
        'T' => 
        array (
            'Twig_' => 
            array (
                0 => __DIR__ . '/..' . '/twig/twig/lib',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit86e5045484ae52d69082edc9ae4c46a9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit86e5045484ae52d69082edc9ae4c46a9::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit86e5045484ae52d69082edc9ae4c46a9::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
