<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite7494b97ea224c537c59fa2a6a2c27a4
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Plasticbrain\\FlashMessages\\' => 27,
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Plasticbrain\\FlashMessages\\' => 
        array (
            0 => __DIR__ . '/..' . '/plasticbrain/php-flash-messages/src',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite7494b97ea224c537c59fa2a6a2c27a4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite7494b97ea224c537c59fa2a6a2c27a4::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite7494b97ea224c537c59fa2a6a2c27a4::$classMap;

        }, null, ClassLoader::class);
    }
}