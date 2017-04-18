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
 * Class Language
 * @package yuncms\system\models
 */
class Language extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%languages}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'iso_639_1', 'iso_639_2', 'iso_639_3'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['iso_639_1'], 'string', 'max' => 2],
            [['iso_639_2', 'iso_639_3'], 'string', 'max' => 10],
            ['name', 'unique', 'message' => Yii::t('system', 'This name has already been taken')],
            ['iso_639_1', 'unique', 'message' => Yii::t('system', 'This iso_639_1 has already been taken')],
            ['iso_639_2', 'unique', 'message' => Yii::t('system', 'This iso_639_2 has already been taken')],
            ['iso_639_3', 'unique', 'message' => Yii::t('system', 'This iso_639_3 has already been taken')],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('system', 'ID'),
            'name' => Yii::t('system', 'Language Name'),
            'iso_639_1' => Yii::t('system', 'ISO 639 1'),
            'iso_639_2' => Yii::t('system', 'ISO 639 2'),
            'iso_639_3' => Yii::t('system', 'ISO 639 3'),
        ];
    }
}