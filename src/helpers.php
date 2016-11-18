<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
/**
 * 将时间戳格式化
 */
if (!function_exists('timestamp_format')) {
    function timestamp_format($timestamp)
    {
        return Yii::$app->formatter->asRelativeTime($timestamp);
    }
}

if (!function_exists('participle')) {
    /**
     * 分词
     * @param string $string
     * @return array 分词结果
     */
    function participle($string)
    {
        if (!function_exists('scws_new')) {
            return [];
        }
        $matches = null;
        if (preg_match_all('/^[a-zA-Z0-9\x7f-\xff\.@]+$/', $string, $matches)) {
            if (isset($matches[0])) {
                $string = '';
                foreach ($matches[0] as $match) {
                    $string .= $match;
                }
                $so = scws_new();
                $so->set_charset('utf8');
                $so->send_text($string);
                $words = [];
                while ($tmp = $so->get_result()) {
                    foreach ($tmp as $k => $v) {
                        $words = $v['word'];
                    }
                }
                $so->close();
                if (!$words) {//分词结果空
                    return [];
                }
                $words = array_unique($words);
                foreach ($words as $key => $value) {
                    if (is_null($value) || empty($value) || $value == "的" || $value == "了" || $value == "吗") {
                        unset ($words[$key]);
                    }
                }
                if (count($words) <= 0) {
                    return [];
                }

                return $words;
            }
        }
        return [];
    }
}