<?php

namespace yuncms\system\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "{{%area}}".
 *
 * @property integer $id 地区id(autoincrement)
 * @property string $name 地区名称
 * @property integer $parent 父地区
 * @property integer $sort 地区排序
 * @property Area $areaParent 父地区
 * @property Area[] $areas 子地区
 */
class Area extends \yii\db\ActiveRecord
{
    public $parent_name;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%area}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_name'], 'filterParent'],
            [['parent_name'], 'in',
                'range' => static::find()->select(['name'])->column(),
                'message' => Yii::t('system', 'Area "{value}" not found.')],
            [['parent', 'sort'], 'integer'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('system', 'Area ID'),
            'name' => Yii::t('system', 'Area Name'),
            'area_code' => Yii::t('system', 'Area Code'),
            'post_code' => Yii::t('system', 'Post Code'),
            'parent' => Yii::t('system', 'Parent Area'),
            'parent_name' => Yii::t('system', 'Parent Area Name'),
            'sort' => Yii::t('system', 'Area Sort'),
        ];
    }

    public function filterParent()
    {
        $value = $this->parent_name;
        $parent = self::findOne(['name' => $value]);
        if ($parent) {
            $id = $this->id;
            $parent_id = $parent->id;
            while ($parent) {
                if ($parent->id == $id) {
                    $this->addError('parent_name', Yii::t('system','Loop detected.'));
                    return;
                }
                $parent = $parent->areaParent;
            }
            $this->parent = $parent_id;
        }
    }

    /**
     *
     * @return mixed
     */
    public static function getAreaSource()
    {
        $tableName = static::tableName();
        return (new Query())
            ->select(['m.id', 'm.name', 'parent_name' => 'p.name'])
            ->from(['m' => $tableName])
            ->leftJoin(['p' => $tableName], '[[m.parent]]=[[p.id]]')
            ->all(static::getDb());
    }

    /**
     * 返回父地区
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAreaParent()
    {
        return $this->hasOne(Area::className(), ['id' => 'parent']);
    }

    /**
     * 返回子地区
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAreas()
    {
        return $this->hasMany(Area::className(), ['parent' => 'id']);
    }

    /**
     * @inheritdoc
     * @return AreaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AreaQuery(get_called_class());
    }
}
