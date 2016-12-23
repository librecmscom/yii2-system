<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace yuncms\system\validators;

use Yii;
use yii\validators\Validator;
use yuncms\admin\helpers\BanHelper;

/**
 * Class BanValidator
 * @package yuncms\system\validators
 */
class BanValidator extends Validator
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = Yii::t('yii', '{attribute} must be an integer.');
        }
    }

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        if (is_array($value)) {
            $this->addError($model, $attribute, $this->message);
            return;
        }
        if (!BanHelper::checkWord("$value")) {
            $this->addError($model, $attribute, $this->message);
        }

    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        if (is_array($value)) {
            return [Yii::t('yii', '{attribute} is invalid.'), []];
        }
        if (!BanHelper::checkWord("$value")) {
            return [$this->message, []];
        } else {
            return null;
        }
    }
}