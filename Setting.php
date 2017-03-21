<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace yuncms\system;

use Yii;
use yii\base\Component;

/**
 * Class Setting
 * @package yuncms\system
 * @see https://github.com/funson86/yii2-setting/
 */
class Setting extends Component
{
    /**
     * @param $code
     * @return mixed|void
     */
    public function get($code)
    {
        if (!$code) return;
        $setting = \yuncms\system\models\Setting::find()->where(['code' => $code])->one();
        if ($setting)
            return $setting->value;
        else
            return;
    }
}