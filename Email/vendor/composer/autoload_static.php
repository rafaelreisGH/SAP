<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit736c02ff9dacf5c89781d31cbea5c873
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit736c02ff9dacf5c89781d31cbea5c873::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit736c02ff9dacf5c89781d31cbea5c873::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
