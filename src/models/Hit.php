<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace yuncms\system\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * 点击计数器
 * @property int $id
 * @property int $model_id
 * @property string $model
 * @property int $views
 * @property int $day_views
 * @property int $week_views
 * @property int $month_views
 * @property int $yesterday_views
 * @property int $created_at
 * @property int $updated_at
 * @package yuncms\system\models
 */
class Hit extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%hits}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [TimestampBehavior::className()];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['views', 'default', 'value' => 0],
            ['yesterday_views', 'default', 'value' => 0],
            ['day_views', 'default', 'value' => 0],
            ['week_views', 'default', 'value' => 0],
            ['month_views', 'default', 'value' => 0]
        ];
    }

    /**
     * 记录并获取项目点击数
     * @param string $model 模型名称
     * @param string $model_id 模型ID
     * @param int $increasing 递增数量，默认是1
     * @return static
     */
    public static function hit($model, $model_id, $increasing = 1)
    {
        if (($model = static::findOne(['model' => $model, 'model_id' => $model_id])) == null) {
            $model = new static();
        }
        $model->views = $model->views + $increasing;
        //昨日显示次数
        $model->yesterday_views = (date('Ymd', $model->updated_at) == date('Ymd', strtotime('-1 day'))) ? $model->day_views : $model->yesterday_views;
        $model->day_views = (date('Ymd', $model->updated_at) == date('Ymd', time())) ? ($model->day_views + $increasing) : 1;
        $model->week_views = (date('YW', $model->updated_at) == date('YW', time())) ? ($model->week_views + $increasing) : 1;
        $model->month_views = (date('Ym', $model->updated_at) == date('Ym', time())) ? ($model->month_views + $increasing) : 1;
        $model->save();
        return $model;
    }
}