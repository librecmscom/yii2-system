<?php

namespace yuncms\system\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%page}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $route
 * @property string $content
 * @property string $view
 * @property integer $views
 * @property integer $status
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property \yuncms\user\models\User $user
 */
class Page extends ActiveRecord
{
    const STATUS_ACTIVE = 1;

    const STATUS_DELETE = 0;

    /**
     * @inheritdoc
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => 'yii\behaviors\BlameableBehavior',
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => 'user_id',
                ]
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'route'], 'required'],
            [['content'], 'string'],
            [['views', 'status'], 'integer'],
            [['title', 'keywords', 'description', 'route', 'view'], 'string', 'max' => 255],
            ['view', 'default', 'value' => 'view.php'],
            ['views', 'default', 'value' => 0],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETE]],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->user->identityClass, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('system', 'ID'),
            'title' => Yii::t('system', 'Title'),
            'keywords' => Yii::t('system', 'Keywords'),
            'description' => Yii::t('system', 'Description'),
            'route' => Yii::t('system', 'Route'),
            'content' => Yii::t('system', 'Content'),
            'view' => Yii::t('system', 'View'),
            'views' => Yii::t('system', 'Views'),
            'status' => Yii::t('system', 'Status'),
            'user_id' => Yii::t('system', 'User Id'),
            'created_at' => Yii::t('system', 'Created At'),
            'updated_at' => Yii::t('system', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return PageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PageQuery(get_called_class());
    }

    /**
     * 保存后执行
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        $params = 'id=' . $this->id;
        if (($url = UrlRule::findOne(['route' => '/system/page/view', 'params' => $params])) != null) {
            $url->updateAttributes(['slug' => $this->route]);
        } else {
            $url = new UrlRule([
                'slug' => $this->route,
                'route' => '/page/view',
                'params' => $params,
            ]);
            $url->save();
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * 删除时同步删除对应的Url规则
     * @throws \Exception
     */
    public function beforeDelete()
    {
        if (($url = UrlRule::findOne(['route' => '/system/page/view', 'params' => 'id=' . $this->id])) != null) {
            $url->delete();
        }
        parent::beforeDelete();
    }
}
