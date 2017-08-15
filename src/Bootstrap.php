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
    /**
     * 初始化
     * @param \yii\base\Application $app
     * @throws \yii\base\InvalidConfigException
     */
    public function bootstrap($app)
    {
        /** @var Module $module */
        /** @var \yii\db\ActiveRecord $modelName */
        if ($app->hasModule('system') && ($module = $app->getModule('system')) instanceof Module) {
            if ($app instanceof \yii\console\Application) {

            } else if (class_exists('\yuncms\admin\Application') && $app instanceof \yuncms\admin\Application) {

            } elseif ($module instanceof Module) {//前台判断放最后
                $app->urlManager->addRules([
                    'page' => 'system/page/view',
                ]);
                //注册Url管理
                $app->urlManager->addRules([
                    [
                        'class' => 'yuncms\system\components\SlugUrlRule',
                    ]
                ], true);
            }
        }
//        $app->set('settings', [
//            'class' => 'yuncms\system\components\Settings',
//        ]);

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
