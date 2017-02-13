<?php

namespace yuncms\system\models;

use Yii;

/**
 * This is the model class for table "{{%type}}".
 *
 * @property integer $id
 * @property string $name 类别名称
 * @property integer $parent 父类别
 * @property string $module 所属模块
 *
 * @property Type $parent0
 * @property Type[] $types
 */
class Type extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent'], 'integer'],
            [['name', 'module'], 'string', 'max' => 255],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => Type::className(), 'targetAttribute' => ['parent' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('system', 'ID'),
            'name' => Yii::t('system', 'Type Name'),
            'parent' => Yii::t('system', 'Parent Type'),
            'module' => Yii::t('system', 'Module'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Type::className(), ['id' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypes()
    {
        return $this->hasMany(Type::className(), ['parent' => 'id']);
    }

    /**
     * @inheritdoc
     * @return TypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TypeQuery(get_called_class());
    }
}
