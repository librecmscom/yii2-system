<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace yuncms\system\behaviors;

use yii\helpers\Json;
use yii\base\Behavior;
use yii\db\BaseActiveRecord;
use yii\base\InvalidConfigException;

/**
 * ActiveRecord字段 数组 <=> 字符串 转换
 * ```php
 * public function behaviors(){
 *     return [
 *         'event' => [
 *             'class' => ArrayBehavior::className(),
 *             'attributes' => ['attribute1', 'attribute2'],
 *          ]
 *      ];
 *  }
 * ```
 */
class ArrayBehavior extends Behavior
{

    /**
     * 需要转换的attribute
     *
     * @var
     */
    public $attributes;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (empty ($this->attributes)) {
            throw new InvalidConfigException ('The "attributes" property must be set.');
        }
    }

    /**
     * @inheritdoc
     */
    public function events()
    {
        return array_fill_keys([
            BaseActiveRecord::EVENT_BEFORE_INSERT,
            BaseActiveRecord::EVENT_BEFORE_UPDATE,
            BaseActiveRecord::EVENT_AFTER_FIND
        ], 'evaluateAttributes');
    }

    /**
     * 计算属性值，并将其分配给当前属性。
     *
     * @param \yii\base\Event $event
     */
    public function evaluateAttributes($event)
    {
        if (in_array($event->name, $this->events)) {
            foreach ($this->attributes as $attribute) {
                $this->owner->$attribute = $this->getValue($this->owner->$attribute, $event->name);
            }
        }
    }

    /**
     * 获取json转换后的值
     *
     * @param $value
     * @param $event
     * @return mixed|string
     */
    protected function getValue($value, $event)
    {
        switch ($event) {
            case BaseActiveRecord::EVENT_BEFORE_INSERT :
            case BaseActiveRecord::EVENT_BEFORE_UPDATE :
                if (is_array($value)) {
                    $value = Json::encode($value);
                }
                break;
            case BaseActiveRecord::EVENT_AFTER_FIND :
                $value = Json::decode($value);
                break;
        }
        return $value;
    }
}