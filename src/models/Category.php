<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace yuncms\system\models;

use Yii;
use yii\db\Query;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use Overtrue\Pinyin\Pinyin;

/**
 * Class Category
 * @property int $id ID
 * @property integer $parent 父ID
 * @property string $name 标题
 * @property string $keywords 关键词
 * @property string $description 描述
 * @property string $pinyin 拼音
 * @property string $letter 首字母
 * @property int $frequency 热度
 * @package common\models
 */
class Category extends ActiveRecord
{
    /**
     * @var string 父栏目名称
     */
    public $parent_name;

    /**
     * @inheritdoc
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%categories}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['slug'], 'string', 'max' => 20],
            [['letter'], 'string', 'max' => 1],
            [['keywords', 'pinyin'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 1000],

            [['parent_name'], 'in',
                'range' => static::find()->select(['name'])->column(),
                'message' => 'Category "{value}" not found.'],
            [['parent', 'sort', 'slug'], 'default'],
            [['parent'], 'filterParent', 'when' => function () {
                return !$this->isNewRecord;
            }],
            [['sort', 'frequency'], 'integer'],
            ['sort', 'default', 'value' => 0]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('system', 'ID'),
            'name' => Yii::t('system', 'Category Name'),
            'parent' => Yii::t('system', 'Parent Category'),
            'slug' => Yii::t('system', 'Category Slug'),
            'keywords' => Yii::t('system', 'Category Keywords'),
            'description' => Yii::t('system', 'Category Description'),
            'pinyin' => Yii::t('system', 'Pinyin'),
            'letter' => Yii::t('system', 'Letter'),
            'frequency' => Yii::t('system', 'Frequency'),
            'sort' => Yii::t('system', 'Sort'),
            'allow_publish' => Yii::t('system', 'Allow Publish'),
            'parent_name' => Yii::t('system', 'Parent Category'),
            'created_at' => Yii::t('system', 'Created At'),
            'updated_at' => Yii::t('system', 'Updated At'),
        ];
    }

    /**
     * 获取父栏目
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent']);
    }

    /**
     * 获取子栏目
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(static::className(), ['parent' => 'id']);
    }

    /**
     * Use to loop detected.
     */
    public function filterParent()
    {
        $parent = $this->parent;
        $db = static::getDb();
        $query = (new Query)->select(['parent'])
            ->from(static::tableName())
            ->where('[[id]]=:id');
        while ($parent) {
            if ($this->id == $parent) {
                $this->addError('parent_name', Yii::t('system', 'Loop detected.'));
                return;
            }
            $parent = $query->params([':id' => $parent])->scalar($db);
        }
    }

    /** @inheritdoc */
    public function beforeSave($insert)
    {
        if (empty($this->pinyin)) {
            $py = new Pinyin();
            $this->pinyin = strtolower($py->permalink($this->name, ''));
        }
        if (empty($this->letter)) {
            $this->letter = strtoupper(substr($this->pinyin, 0, 1));
        }
        return parent::beforeSave($insert);
    }
}