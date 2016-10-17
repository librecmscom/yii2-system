<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace yuncms\system;

use Yii;
use yii\web\GroupUrlRule;
use yii\i18n\PhpMessageSource;
use yii\base\BootstrapInterface;

/**
 * Class Bootstrap
 * @package yuncms/user
 */
class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        if (($app->get('fs', false)) == null) {
            $app->set('authManager', [
                'fs' => 'creocoder\flysystem\LocalFilesystem',
                'path' => '@uploads',
            ]);
        }

        /**
         * 注册语言包
         */
        if (!isset($app->get('i18n')->translations['system*'])) {
            $app->get('i18n')->translations['system*'] = [
                'class' => PhpMessageSource::className(),
                'sourceLanguage' => 'en-US',
                'basePath' => __DIR__ . '/messages',
            ];
        }
    }
}