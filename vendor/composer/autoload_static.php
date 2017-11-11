<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit854a27bf493294b29ece2f1aa67d9804
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'Dotenv\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Dotenv\\' => 
        array (
            0 => __DIR__ . '/..' . '/vlucas/phpdotenv/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit854a27bf493294b29ece2f1aa67d9804::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit854a27bf493294b29ece2f1aa67d9804::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
