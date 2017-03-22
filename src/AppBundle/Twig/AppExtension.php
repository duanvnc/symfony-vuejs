<?php

namespace AppBundle\Twig;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Twig_SimpleFunction;

/**
 * Created by PhpStorm.
 * User: quentinrillet
 * Date: 01/12/2016
 * Time: 16:54
 */
class AppExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
      new Twig_SimpleFunction('assetsWebpack', array($this, 'assetsWebpack')),
    );
    }

    public function assetsWebpack($type)
    {
        try {
            $array = json_decode(file_get_contents('dist/assets.json'), true);
        } catch (FileException $exception) {
            return $exception;
        }

        if ($type != 'js' && $type != 'css') {
            $type = 'js';
        }

        return '/dist'.$array['app'][$type];
    }

    public function getName()
    {
        return 'app_extension';
    }
}
