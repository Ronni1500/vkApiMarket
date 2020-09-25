<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit301830b7749e1cbfdd5e91a668ff1f15
{
    public static $prefixLengthsPsr4 = array (
        'V' => 
        array (
            'VK\\' => 3,
        ),
        'A' => 
        array (
            'Asil\\VkMarket\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'VK\\' => 
        array (
            0 => __DIR__ . '/..' . '/vkcom/vk-php-sdk/src/VK',
        ),
        'Asil\\VkMarket\\' => 
        array (
            0 => __DIR__ . '/..' . '/asil/vkmarket/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit301830b7749e1cbfdd5e91a668ff1f15::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit301830b7749e1cbfdd5e91a668ff1f15::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
