<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace yuncms\system\validators;

use Yii;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\validators\Validator;
use yii\validators\ValidationAsset;

/**
 * Class MobileValidator
 * [ 'mobile', 'yuncms\system\validators\MobileValidator', 'message'=> '呀！手机号码格式不正确，请重试！' ],
 * @package yuncms\system\validators
 */
class MobileValidator extends Validator
{
    /**
     * @var string the regular expression for matching mobile.
     */
    public $mobilePattern = '/^13[\d]{9}$|^15[\d]{9}$|^17[\d]{9}$|^18[\d]{9}$/';

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
        if (!preg_match($this->mobilePattern, "$value")) {
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
        if (!preg_match($this->mobilePattern, "$value")) {
            return [$this->message, []];
        } else {
            return null;
        }
    }

    /**
     * @inheritdoc
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        $label = $model->getAttributeLabel($attribute);

        $options = [
            'pattern' => new JsExpression($this->mobilePattern),
            'message' => Yii::$app->getI18n()->format($this->message, [
                'attribute' => $label,
            ], Yii::$app->language),
        ];

        if ($this->skipOnEmpty) {
            $options['skipOnEmpty'] = 1;
        }

        ValidationAsset::register($view);

        return 'yii.validation.number(value, messages, ' . Json::htmlEncode($options) . ');';
    }
}