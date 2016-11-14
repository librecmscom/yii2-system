<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace yuncms\system\helpers;

/**
 * Class StringHelper
 * @package yuncms\system
 */
class StringHelper extends \yii\helpers\StringHelper
{
    /**
     * 截取字符串,无视编码
     *
     * @param string $string 要截取的字符串编码
     * @param int $start 开始截取
     * @param int $length 截取的长度
     * @param boolean $dot 是否显示省略号,默认为false
     * @return string 截取后的字串
     */
    public static function substr($string, $start = 0, $length, $dot = null)
    {
        $string = self::byteSubstr($string, $start, $length);
        return $dot ? $string . $dot : $string;
    }

    /**
     * 提取两个字符串之间的值，不包括分隔符
     *
     * @param string $string 待提取的只付出
     * @param string $start 开始字符串
     * @param string|null $end 结束字符串，省略将返回所有的。
     * @return bool string substring between $start and $end or false if either string is not found
     */
    public static function betweenSubstr($string, $start, $end = null)
    {
        if (($start_pos = strpos($string, $start)) !== false) {
            if ($end) {
                if (($end_pos = strpos($string, $end, $start_pos + strlen($start))) !== false) {
                    return substr($string, $start_pos + strlen($start), $end_pos - ($start_pos + strlen($start)));
                }
            } else {
                return substr($string, $start_pos);
            }
        }
        return false;
    }
}