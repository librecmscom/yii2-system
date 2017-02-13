<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace yuncms\system\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Class UrlRule
 * @property int $id
 * @property string $slug
 */
class UrlRule extends ActiveRecord
{
    const STATUS_ACTIVE = 1;

    const STATUS_PASSIVE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%url_rule}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'route'], 'required'],
            [['redirect_code', 'redirect'], 'integer'],
            [['slug', 'route', 'params'], 'string', 'max' => 255],
            ['redirect_code', 'default', 'value' => 301],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_PASSIVE]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('system', 'ID'),
            'slug' => Yii::t('system', 'Slug'),
            'route' => Yii::t('system', 'Route'),
            'params' => Yii::t('system', 'Params'),
            'redirect' => Yii::t('system', 'Redirect'),
            'redirect_code' => Yii::t('system', 'Redirect Code'),
            'status' => Yii::t('system', 'Status'),
        ];
    }

    /** @inheritdoc */
    public function beforeSave($insert)
    {
        $this->slug = '/' . ltrim($this->slug, '/');
        return parent::beforeSave($insert);
    }


    /**
     * 通过路由和参数获取反解的URL
     * @param string $slug
     * @param array $params
     * @param int $status
     * @return null|static
     */
    public static function getRoute($slug, $params = [], $status = self::STATUS_ACTIVE)
    {
        return UrlRule::findOne(['slug' => $slug, 'params' => http_build_query($params), 'status' => $status]);
    }

    public static function getRouteBySlugWithParams($slug, $params = [], $status = self::STATUS_ACTIVE)
    {
        return self::findOne(['slug' => $slug, 'params' => http_build_query($params), 'status' => $status]);
    }

    /**
     * 获取通过重写后的URL获取路由
     * @param string $slug
     * @param int $status
     * @return null|static
     */
    public static function getRouteBySlug($slug, $status = self::STATUS_ACTIVE)
    {
        return self::findOne(['slug' => $slug, 'status' => $status]);
    }
}