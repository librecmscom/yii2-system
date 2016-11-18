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

if (!function_exists('key_extra')) {
    /**
     * 从文本中提取关键词
     * @param string $string
     * @param int $limit 获取词的数量
     * @return array
     */
    function key_extra($string, $limit = 10)
    {
        if (function_exists('scws_new')) {
            $matches = null;
            if (preg_match_all("/[a-zA-Z0-9\x{4e00}-\x{9fa5}]+/u", $string, $matches)) {
                if (isset($matches[0])) {
                    $string = '';
                    foreach ($matches[0] as $match) {
                        $string .= $match;
                    }
                    $so = scws_new();
                    $so->set_charset('utf8');
                    $so->send_text($string);
                    $tmp = $so->get_tops($limit);
                    $so->close();
                    $words = [];
                    foreach ($tmp as $key => $value) {
                        $words[] = $value['word'];
                    }
                    return $words;
                }
            }
        }
        return [];
    }
}
if (!function_exists('pullword')) {
    /**
     * 分词
     * @param string $string
     * @return array 分词结果
     */
    function pullword($string)
    {
        if (function_exists('scws_new')) {
            $matches = null;
            if (preg_match_all("/[a-zA-Z0-9\x{4e00}-\x{9fa5}]+/u", $string, $matches)) {
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
                        $words = array_merge($words,$tmp);
                    }
                    $so->close();
                    return $words;
                }
            }
        }
        return [];
    }
}