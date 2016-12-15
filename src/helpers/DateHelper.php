<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace yuncms\system\helpers;

use Yii;
use DateTime;
use DateTimeZone;
use yii\helpers\ArrayHelper;

/**
 * Class DateHelper
 * @package common\helpers
 */
class DateHelper
{
    /**
     * 获得时间戳
     *
     * @param int $dateTime 默认为空，则以当前时间戳返回
     * @return int
     */
    public static function getTimestamp($dateTime = null)
    {
        return $dateTime ? is_numeric($dateTime) ? $dateTime : strtotime($dateTime) : time();
    }

    /**
     * Get all of the time zones with the offsets sorted by their offset
     * @return array
     */
    public static function getTimeZoneAll()
    {
        $timezones = [];
        $identifiers = DateTimeZone::listIdentifiers();
        foreach ($identifiers as $identifier) {
            $date = new DateTime("now", new DateTimeZone($identifier));
            $offsetText = $date->format("P");
            $offsetInHours = $date->getOffset() / 60 / 60;
            $timezones[] = [
                "identifier" => $identifier,
                "name" => "(GMT{$offsetText}) $identifier",
                "offset" => $offsetInHours
            ];
        }
        ArrayHelper::multisort($timezones, "offset", SORT_ASC, SORT_NUMERIC);
        return $timezones;
    }

    /**
     * 获取星期
     *
     * @param int $week 星期，默认为当前时间获取
     * @return string
     */
    public static function getWeek($week = null)
    {
        $week = $week ? $week : date('w');
        $weekArr = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        return Yii::t('app', $weekArr [$week]);
    }

    /**
     * 判断是否为闰年
     *
     * @param int $year 年份，默认为当前年份
     * @return bool
     */
    public static function isLeapYear($year = null)
    {
        $year = $year ? $year : date('Y');
        return ($year % 4 == 0 && $year % 100 != 0 || $year % 400 == 0);
    }

    /**
     * 获取一年中有多少天
     *
     * @param int $year 年份，默认为当前年份
     * @return int
     */
    public static function getDaysInYear($year = null)
    {
        $year = $year ? $year : date('Y');
        return self::isLeapYear($year) ? 366 : 365;
    }

    /**
     * 获取一天中的时段
     *
     * @param int $hour 小时，默认为当前小时
     * @return string
     */
    public static function getPeriodOfTime($hour = null)
    {
        $hour = $hour ? $hour : date('G');
        $period = null;
        if ($hour >= 0 && $hour < 6) {
            $period = '凌晨';
        } elseif ($hour >= 6 && $hour < 8) {
            $period = 'Morning';
        } elseif ($hour >= 8 && $hour < 11) {
            $period = '上午';
        } elseif ($hour >= 11 && $hour < 13) {
            $period = '中午';
        } elseif ($hour >= 13 && $hour < 15) {
            $period = '响午';
        } elseif ($hour >= 15 && $hour < 18) {
            $period = '下午';
        } elseif ($hour >= 18 && $hour < 20) {
            $period = '傍晚';
        } elseif ($hour >= 20 && $hour < 22) {
            $period = '晚上';
        } elseif ($hour >= 22 && $hour <= 23) {
            $period = '深夜';
        }
        return Yii::t('app', $period);
    }

    /**
     * 日期数字转中文，适用于日、月、周
     *
     * @param int $number 日期数字，默认为当前日期
     * @return string
     */
    public static function numberToChinese($number)
    {
        $chineseArr = ['一', '二', '三', '四', '五', '六', '七', '八', '九', '十'];
        $chineseStr = null;
        if ($number < 10) {
            $chineseStr = $chineseArr [$number - 1];
        } elseif ($number < 20) {
            $chineseStr = '十' . $chineseArr [$number - 11];
        } elseif ($number < 30) {
            $chineseStr = '二十' . $chineseArr [$number - 21];
        } else {
            $chineseStr = '三十' . $chineseArr [$number - 31];
        }
        return $chineseStr;
    }

    /**
     * 年份数字转中文
     *
     * @param int $year 年份数字，默认为当前年份
     * @param bool $flag 是否增加公元
     * @return string
     */
    public static function yearToChinese($year = null, $flag = false)
    {
        $year = $year ? intval($year) : date('Y');
        $data = ['零', '一', '二', '三', '四', '五', '六', '七', '八', '九'];
        $chinese_str = null;
        for ($i = 0; $i < 4; $i++) {
            $chinese_str .= $data [substr($year, $i, 1)];
        }
        return $flag ? '公元' . $chinese_str : $chinese_str;
    }

    /**
     * 获取日期所属的星座、干支、生肖
     *
     * @param string $type 获取信息类型（SX：生肖、GZ：干支、XZ：星座）
     * @param int $date
     * @return string
     */
    public static function dateInfo($type, $date = null)
    {
        $year = date('Y', $date);
        $month = date('m', $date);
        $day = date('d', $date);
        $result = null;
        switch ($type) {
            case 'SX' :
                $data = ['鼠', '牛', '虎', '兔', '龙', '蛇', '马', '羊', '猴', '鸡', '狗', '猪'];
                $result = $data [($year - 4) % 12];
                break;
            case 'GZ' :
                $data = [['甲', '乙', '丙', '丁', '戊', '己', '庚', '辛', '壬', '癸'], ['子', '丑', '寅', '卯', '辰', '巳', '午', '未', '申', '酉', '戌', '亥']];
                $num = $year - 1900 + 36;
                $result = $data [0] [$num % 10] . $data [1] [$num % 12];
                break;
            case 'XZ' :
                $data = ['摩羯', '宝瓶', '双鱼', '白羊', '金牛', '双子', '巨蟹', '狮子', '处女', '天秤', '天蝎', '射手'];
                $zone = [1222, 122, 222, 321, 421, 522, 622, 722, 822, 922, 1022, 1122, 1222];
                if ((100 * $month + $day) >= $zone [0] || (100 * $month + $day) < $zone [1]) {
                    $i = 0;
                } else {
                    for ($i = 1; $i < 12; $i++) {
                        if ((100 * $month + $day) >= $zone [$i] && (100 * $month + $day) < $zone [$i + 1]) break;
                    }
                }
                $result = $data [$i] . '座';
                break;
        }
        return $result;
    }

    /**
     * 获取两个日期的差
     *
     * @param string $interval 日期差的间隔类型，（Y：年、M：月、W：星期、D：日期、H：时、N：分、S：秒）
     * @param int $startDateTime 开始日期
     * @param int $endDateTime 结束日期
     * @return int
     */
    public static function dateDiff($interval, $startDateTime, $endDateTime)
    {
        $diff = static::getTimestamp($endDateTime) - static::getTimestamp($startDateTime);
        switch ($interval) {
            case 'Y' : // 年
                $result = bcdiv($diff, 60 * 60 * 24 * 365);
                break;
            case 'M' : // 月
                $result = bcdiv($diff, 60 * 60 * 24 * 30);
                break;
            case 'W' : // 星期
                $result = bcdiv($diff, 60 * 60 * 24 * 7);
                break;
            case 'D' : // 日
                $result = bcdiv($diff, 60 * 60 * 24);
                break;
            case 'H' : // 时
                $result = bcdiv($diff, 60 * 60);
                break;
            case 'N' : // 分
                $result = bcdiv($diff, 60);
                break;
            case 'S' : // 秒
            default :
                $result = $diff;
                break;
        }
        return $result;
    }

    /**
     * 返回指定日期在一段时间间隔时间后的日期
     *
     * @param string $interval 时间间隔类型，（Y：年、Q：季度、M：月、W：星期、D：日期、H：时、N：分、S：秒）
     * @param int $value 时间间隔数值，数值为正数获取未来的时间，数值为负数获取过去的时间
     * @param string $dateTime 日期
     * @param string $format 返回的日期转换格式
     * @return string 返回追加后的日期
     */
    public static function dateAdd($interval, $value, $dateTime = null, $format = null)
    {
        $dateTime = $dateTime ? $dateTime : date('Y-m-d H:i:s');
        $date = getdate(self::getTimestamp($dateTime));
        switch ($interval) {
            case 'Y' : // 年
                $date ['year'] += $value;
                break;
            case 'Q' : // 季度
                $date ['mon'] += ($value * 3);
                break;
            case 'M' : // 月
                $date ['mon'] += $value;
                break;
            case 'W' : // 星期
                $date ['mday'] += ($value * 7);
                break;
            case 'D' : // 日
                $date ['mday'] += $value;
                break;
            case 'H' : // 时
                $date ['hours'] += $value;
                break;
            case 'N' : // 分
                $date ['minutes'] += $value;
                break;
            case 'S' : // 秒
            default :
                $date ['seconds'] += $value;
                break;
        }
        return date($format, mktime($date ['hours'], $date ['minutes'], $date ['seconds'], $date ['mon'], $date ['mday'], $date ['year']));
    }

    /**
     * 根据年份获取每个月的天数
     *
     * @param int $year 年份
     * @return array 月份天数数组
     */
    public static function getDaysByMonthsOfYear($year = null)
    {
        $year = $year ? $year : date('Y');
        $months = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        if (self::isLeapYear($year)) $months [1] = 29;
        return $months;
    }

    /**
     * 返回某年的某个月有多少天
     *
     * @param int $month 月份
     * @param int $year 年份
     * @return int 月份天数
     */
    public static function getDaysByMonth($month, $year)
    {
        $months = self::getDaysByMonthsOfYear($year);
        $value = $months [$month - 1];
        return !$value ? 0 : $value;
    }

    /**
     * 获取两个日期之间范围
     *
     * @param string $startDateTime
     * @param string $endDateTime
     * @param bool $sort
     * @param string $format
     * @return array 返回日期数组
     */
    public static function getDayRangeInBetweenDate($startDateTime, $endDateTime, $sort = false, $format = 'Y-m-d')
    {
        $startDateTime = self::getTimestamp($startDateTime);
        $endDateTime = self::getTimestamp($endDateTime);
        $num = ($endDateTime - $startDateTime) / 86400;
        $arr = [];
        for ($i = 0; $i <= $num; $i++) {
            $arr [] = date($format, $startDateTime + 86400 * $i);
        }
        return $sort ? array_reverse($arr) : $arr;
    }
    
    /**
     * 获取年份的第一天
     *
     * @param int $year 年份
     * @param string $format 返回的日期格式
     * @return string 返回的日期
     */
    public static function firstDayOfYear($year = null, $format = 'Y-m-d')
    {
        $year = $year ? $year : date('Y');
        return date($format, mktime(0, 0, 0, 1, 1, $year));
    }

    /**
     * 获取年份最后一天
     *
     * @param int $year 年份
     * @param string $format 返回的日期格式
     * @return string 返回的日期
     */
    public static function lastDayOfYear($year = null, $format = 'Y-m-d')
    {
        $year = $year ? $year : date('Y');
        return date($format, mktime(0, 0, 0, 1, 0, $year + 1));
    }

    /**
     * 获取月份的第一天
     *
     * @param int $month 月份
     * @param int $year 年份
     * @param string $format 返回的日期格式
     * @return string 返回的日期
     */
    public static function firstDayOfMonth($month = null, $year = null, $format = 'Y-m-d')
    {
        $year = $year ? $year : date('Y');
        $month = $month ? $month : date('m');
        return date($format, mktime(0, 0, 0, $month, 1, $year));
    }

    /**
     * 获取月份最后一天
     *
     * @param int $month 月份
     * @param int $year 年份
     * @param string $format 返回的日期格式
     * @return string 返回的日期
     */
    public static function lastDayOfMonth($month = null, $year = null, $format = 'Y-m-d')
    {
        $year = $year ? $year : date('Y');
        $month = $month ? $month : date('m');
        return date($format, mktime(0, 0, 0, $month + 1, 0, $year));
    }

    /**
     * 获取今天开始时间戳
     * @return int
     */
    public static function todayFirstSecond()
    {
        return mktime(0, 0, 0, date("m", time()), date("d", time()), date("Y", time()));
    }

    /**
     * 获取今天结束时间戳
     * @return int
     */
    public static function todayLastSecond()
    {
        return mktime(23, 59, 59, date("m", time()), date("d", time()), date("Y", time()));
    }

    /**
     * 获取本周开始时间戳
     * @return int
     */
    public static function weekFirstSecond()
    {
        return strtotime(date('Y-m-d', time() - ((date('w') == 0 ? 7 : date('w')) - 1) * 24 * 3600));
    }

    /**
     * 获取本周结束时间戳
     *
     * @return int
     */
    public static function weekLastSecond()
    {
        return strtotime(date('Y-m-d', time() + (7 - (date('w') == 0 ? 7 : date('w'))) * 24 * 3600) . ' 23:59:59');
    }

    /**
     * 获取上周开始时间戳
     * @return int
     */
    public static function lastWeekFirstSecond()
    {
        return strtotime('-1 monday', time());
    }

    /**
     * 获取上周结束时间戳
     * @return
     */
    public static function lastWeekLastSecond()
    {
        return strtotime('-1 sunday', time()) + 86399;
    }

    /**
     * 获取上月开始时间戳
     * @return mixed
     */
    public static function lastMonthFirstSecond()
    {
        return strtotime(date('Y-m', strtotime('-1 month', time())) . '-01 00:00:00');
    }

    /**
     * 获取上月结束时间戳
     * @return mixed
     */
    public static function lastMonthLastSecond()
    {
        return strtotime(date('Y-m', strtotime('-1 month', time())) . '-' . date('t', strtotime('-1 month', time())) . ' 23:59:59');
    }

    /**
     * 获取本月1日0点时间戳
     *
     * @return int
     */
    public static function monthFirstSecond()
    {
        return strtotime(date('Y-m', time()) . '-01 00:00:00');
    }

    /**
     * 获取本月最后一日结束时间戳
     * @return int
     */
    public static function monthLastSecond()
    {
        return strtotime(date('Y-m', time()) . '-' . date('t', time()) . ' 23:59:59');
    }

    /**
     * 获取下月1日开始时间戳
     *
     * @return int
     */
    public static function nextMonthFirstSecond()
    {
        return static::monthLastSecond() + 86400;
    }

    /**
     * 获取下月最后一日结束时间戳
     *
     * @return int
     */
    public static function nextMonthLastSecond()
    {
        return strtotime(date('Y-m', static::nextMonthFirstSecond()) . '-' . date('t', static::nextMonthFirstSecond()) . ' 23:59:59');
    }

    /**
     * 获取上季度开始
     *
     * @return int
     */
    public static function lastQuarterFirstSecond()
    {
        $season = ceil((date('n')) / 3) - 1;
        return mktime(0, 0, 0, $season * 3 - 3 + 1, 1, date('Y'));
    }

    /**
     * 获取上季度结束
     *
     * @return int
     */
    public static function lastQuarterLastSecond()
    {
        $season = ceil((date('n')) / 3) - 1;
        return mktime(23, 59, 59, $season * 3, date('t', mktime(0, 0, 0, $season * 3, 1, date("Y"))), date('Y'));
    }

    /**
     * 获取本季度开始
     *
     * @return int
     */
    public static function QuarterFirstSecond()
    {
        $season = ceil((date('n')) / 3);
        return mktime(0, 0, 0, $season * 3 - 3 + 1, 1, date('Y'));
    }

    /**
     * 获取本季度结束
     * @return int
     */
    public static function QuarterLastSecond()
    {
        $season = ceil((date('n')) / 3);
        return mktime(23, 59, 59, $season * 3, date('t', mktime(0, 0, 0, $season * 3, 1, date("Y"))), date('Y'));
    }

    /**
     * 获取本年开始时间戳
     * @return int
     */
    public static function yearFirstSecond()
    {
        return strtotime(date('Y') . '-01-01 00:00:00');
    }

    /**
     * 获取本年结束时间戳
     * @return int
     */
    public static function yearLastSecond()
    {
        return strtotime(date('Y') . '-12-31 23:59:59');
    }


}