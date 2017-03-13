<?php
namespace yuncms\system\behaviors;

use yii\base\Behavior;
use yii\db\BaseActiveRecord;

/**
 * Class SerializedAttributes
 * @package baibaratsky\yii\behaviors\model
 *
 * @property BaseActiveRecord $owner
 * @link https://github.com/baibaratsky/yii2-serialized-attributes-behavior
 *
 *  public function behaviors()
 * {
 *      return [
 *          'serializedAttributes' => [
 *              'class' => SerializedAttributes::className(),
 *
 *              // Define the attributes you want to be serialized
 *              'attributes' => ['serializedData', 'moreSerializedData'],
 *
 *              // Enable this option if your DB is not in UTF-8
 *              // (more info at http://www.jackreichert.com/2014/02/02/handling-a-php-unserialize-offset-error/)
 *              // 'encode' => true,
 *          ],
 *      ];
 * }
 */
class SerializedAttributes extends Behavior
{
    /**
     * 将要被序列化的字段
     * @var string[] Attributes you want to be serialized
     */
    public $attributes = [];

    /**
     * @var bool Encode serialized data to protect them from corruption (when your DB is not in UTF-8)
     * @see http://www.jackreichert.com/2014/02/02/handling-a-php-unserialize-offset-error/
     */
    public $encode = false;

    /**
     * @var array
     */
    private $oldAttributes = [];

    /**
     * 定义关注的事件列表
     * @return array
     */
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'serializeAttributes',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'serializeAttributes',
            BaseActiveRecord::EVENT_AFTER_INSERT => 'deserializeAttributes',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'deserializeAttributes',
            BaseActiveRecord::EVENT_AFTER_FIND => 'deserializeAttributes',
            BaseActiveRecord::EVENT_AFTER_REFRESH => 'deserializeAttributes',
        ];
    }

    /**
     * 序列化属性
     * @throws \Exception
     */
    public function serializeAttributes()
    {
        foreach ($this->attributes as $attribute) {
            if (isset($this->oldAttributes[$attribute])) {
                $this->owner->setOldAttribute($attribute, $this->oldAttributes[$attribute]);
            }
            if (is_array($this->owner->{$attribute}) && count($this->owner->{$attribute}) > 0) {
                $this->owner->$attribute = serialize($this->owner->{$attribute});
                if ($this->encode) {
                    $this->owner->{$attribute} = base64_encode($this->owner->{$attribute});
                }
            } elseif (empty($this->owner->{$attribute})) {
                $this->owner->{$attribute} = null;
            } else {
                throw new \Exception('Can’t serialize attribute "' . $attribute . '" of "' . $this->owner->className() . '".');
            }
        }
    }

    /**
     * 反序列化属性
     * @throws \Exception
     */
    public function deserializeAttributes()
    {
        foreach ($this->attributes as $attribute) {
            $this->oldAttributes[$attribute] = $this->owner->getOldAttribute($attribute);
            if (empty($this->owner->{$attribute})) {
                $this->owner->setAttribute($attribute, []);
                $this->owner->setOldAttribute($attribute, []);
            } elseif (is_scalar($this->owner->{$attribute})) {
                if ($this->encode) {
                    $this->owner->{$attribute} = base64_decode($this->owner->{$attribute});
                }
                $value = @unserialize($this->owner->$attribute);
                if ($value !== false) {
                    $this->owner->setAttribute($attribute, $value);
                    $this->owner->setOldAttribute($attribute, $value);
                } else {
                    throw new \Exception('Can’t deserialize attribute "' . $attribute . '" of "' . $this->owner->className() . '".');
                }
            }
        }
    }
}