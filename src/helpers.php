<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
/**
 * 将时间戳格式化
 */
if(! function_exists('timestamp_format')){
    function timestamp_format($timestamp){
        return Yii::$app->formatter->asRelativeTime($timestamp);
    }
}