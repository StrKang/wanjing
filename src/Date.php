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

    /**
     * 获取指定日期是星期几.
     * @param $date
     * @param int $type
     * @return int|string
     */
    static function week($date, int $type = 0): int|string
    {
        //强制转换日期格式
        $date_str = date('Y-m-d', $date);
        //封装成数组
        $arr = explode('-', $date_str);
        //参数赋值
        //年
        $year = $arr[0];
        //月，输出2位整型，不够2位右对齐
        $month = sprintf('%02d', $arr[1]);
        //日，输出2位整型，不够2位右对齐
        $day = sprintf('%02d', $arr[2]);
        //时分秒默认赋值为0；
        $hour = $minute = $second = 0;
        //转换成时间戳
        $strap = mktime($hour, $minute, $second, (int)$month, (int)$day, (int)$year);
        //获取数字型星期几
        $numberWk = date('w', $strap);
        if ($type) {
            $weekArr = [0, 1, 2, 3, 4, 5, 6];
        } else {
            //自定义星期数组
            $weekArr = ['日', '一', '二', '三', '四', '五', '六'];
        }
        //获取数字对应的星期
        return $weekArr[$numberWk];
    }

    /**
     * 获取今天周几.
     * @param string $date
     * @return int
     */
    public static function today(string $date = ''): int
    {
        if (!$date) {
            $date = date('w');
        } else {
            $date = date('w', $date);
        }
        return mb_substr('0123456', $date, 1);
    }
}
