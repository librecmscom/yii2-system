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
 * Class IdCardValidator
 * @package yuncms\system\validators
 */
class IdCardValidator extends Validator
{
    /**
     * 每位加权因子
     */
    public $power = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];

    /**
     * 第18位校检码
     */
    public $verifyCode = ["1", "0", "X", "9", "8", "7", "6", "5", "4", "3", "2"];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = Yii::t('system', '{attribute} Do not meet the rules.');
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
        if (!$this->validateIdCard($value)) {
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
        if (!$this->validateIdCard($value)) {
            return [$this->message, []];
        } else {
            return null;
        }
    }

    /**
     * 验证18位身份编码是否合法
     *
     * @param int $idCard 身份编码
     * @return boolean 是否合法
     */
    public function validateIdCard($idCard)
    {
        if (strlen($idCard) == 18) {
            // 前17位
            $code17 = substr($idCard, 0, 17);
            // 第18位
            $code18 = substr($idCard, 17, 1);
            if (is_numeric($code17)) {
                $iArr = str_split($code17);
                if ($iArr != null) {
                    $iSum17 = $this->getPowerSum($iArr);
                    // 获取校验位
                    $val = $this->getCheckCode18($iSum17);
                    if (strlen($val) > 0 && $val == $code18) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * 将power和值与11取模获得余数进行校验码判断
     *
     * @param int $iSum
     * @return string 校验位
     */
    private function getCheckCode18($iSum) {
        $sCode = "";
        switch ($iSum % 11) {
            case 10 :
                $sCode = "2";
                break;
            case 9 :
                $sCode = "3";
                break;
            case 8 :
                $sCode = "4";
                break;
            case 7 :
                $sCode = "5";
                break;
            case 6 :
                $sCode = "6";
                break;
            case 5 :
                $sCode = "7";
                break;
            case 4 :
                $sCode = "8";
                break;
            case 3 :
                $sCode = "9";
                break;
            case 2 :
                $sCode = "x";
                break;
            case 1 :
                $sCode = "0";
                break;
            case 0 :
                $sCode = "1";
                break;
        }
        return $sCode;
    }

    /**
     * 将身份证的每位和对应位的加权因子相乘之后，再得到和值
     *
     * @param array $iArr
     * @return int 身份证编码。
     */
    private function getPowerSum($iArr) {
        $iSum = 0;
        $powerLen = count ( $this->power );
        $arrLen = count ( $iArr );
        if ($powerLen == $arrLen) {
            for($i = 0; $i < $arrLen; $i ++) {
                for($j = 0; $j < $powerLen; $j ++) {
                    if ($i == $j) {
                        $iSum = $iSum + $iArr [$i] * $this->power [$j];
                    }
                }
            }
        }
        return $iSum;
    }
}