<?php
namespace yuncms\system\models;

use Yii;
use yii\helpers\Json;
use yii\base\DynamicModel;
use yii\base\InvalidParamException;

/**
 * This is the model class for table "settings".
 *
 * @author Aris Karageorgos <aris@phe.me>
 */
class Setting extends BaseSetting
{
    /**
     * @param bool $forDropDown if false - return array or validators, true - key=>value for dropDown
     * @return array
     */
    public function getTypes($forDropDown = true)
    {
        $values = [
            'string' => ['value', 'string'],
            'integer' => ['value', 'integer'],
            'boolean' => ['value', 'boolean', 'trueValue' => "1", 'falseValue' => "0", 'strict' => true],
            'float' => ['value', 'number'],
            'email' => ['value', 'email'],
            'ip' => ['value', 'ip'],
            'url' => ['value', 'url'],
            'object' => [
                'value',
                function ($attribute, $params) {
                    $object = null;
                    try {
                        Json::decode($this->$attribute);
                    } catch (InvalidParamException $e) {
                        $this->addError($attribute, Yii::t('system', '"{attribute}" must be a valid JSON object', [
                            'attribute' => $attribute,
                        ]));
                    }
                }
            ],
        ];

        if (!$forDropDown) {
            return $values;
        }

        $return = [];
        foreach ($values as $key => $value) {
            $return[$key] = Yii::t('system', $key);
        }

        return $return;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'string'],
            [['section', 'key'], 'string', 'max' => 255],
            [
                ['key'],
                'unique',
                'targetAttribute' => ['section', 'key'],
                'message' =>
                    Yii::t('system', '{attribute} "{value}" already exists for this section.')
            ],
            ['type', 'in', 'range' => array_keys($this->getTypes(false))],
            [['type', 'created', 'modified'], 'safe'],
            [['active'], 'boolean'],
        ];
    }

    public function beforeSave($insert)
    {
        $validators = $this->getTypes(false);
        if (!array_key_exists($this->type, $validators)) {
            $this->addError('type', Yii::t('system', 'Please select correct type'));
            return false;
        }

        $model = DynamicModel::validateData([
            'value' => $this->value
        ], [
            $validators[$this->type],
        ]);

        if ($model->hasErrors()) {
            $this->addError('value', $model->getFirstError('value'));
            return false;
        }

        if ($this->hasErrors()) {
            return false;
        }

        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('system', 'ID'),
            'type' => Yii::t('system', 'Type'),
            'section' => Yii::t('system', 'Section'),
            'key' => Yii::t('system', 'Key'),
            'value' => Yii::t('system', 'Value'),
            'active' => Yii::t('system', 'Active'),
            'created' => Yii::t('system', 'Created'),
            'modified' => Yii::t('system', 'Modified'),
        ];
    }
}
