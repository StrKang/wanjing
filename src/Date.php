<?php

namespace Wanjing\Utility;

/**
 * 处理时间相关
 */
class Date
{

    /**
     * 时间语义化转换
     * @param string|int $date 日期
     * @return string
     */
    static function humanDate(string|int $date): string
    {
        $timestamp = is_numeric($date) ? $date : (empty(strtotime($date)) ? time() : strtotime($date));
        $suffix = '前';
        $seconds = time() - $timestamp;
        if ($seconds < 0){
            $suffix = '后';
            $seconds = abs($seconds);
        }
        $data = match (true) {
            $seconds >= 31536000 => bcdiv("$seconds", '31536000') . '年',
            $seconds >= 2592000 => bcdiv("$seconds", '2592000') . '月',
            $seconds >= 604800 => bcdiv("$seconds", '604800') . '周',
            $seconds >= 86400 => bcdiv("$seconds", '86400') . '天',
            $seconds >= 3600 => bcdiv("$seconds", '3600') . '小时',
            $seconds >= 60 => bcdiv("$seconds", '60') . '分钟',
            default => $seconds . '秒',
        };
        return $data.$suffix;
    }

    /**
     * 获取一年多少天
     * @param int|null $year
     * @return int
     */
    static function calDaysInYear(?int $year): int
    {
        $days = 0;
        for($month = 1; $month <= 12; $month++){
            $days = $days + cal_days_in_month(CAL_GREGORIAN,$month,(int)$year);
        }
        return $days;
    }
}
