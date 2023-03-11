<?php

namespace Wanjing\Utility;

/**
 * 处理字符串相关
 */
class Str
{
    /**
     * 获取随机订单号（根据日期生成）
     * @param string $prefix 前缀
     * @param int $size 长度
     * @return string
     */
    static function orderNo(string $prefix = '',int $size = 18): string
    {
        if ($size < 14) $size = 14;
        $code = $prefix . date('Ymd') . bcadd(date('H') , date('i')) . date('s');
        while (strlen($code) < $size) $code .= rand(0, 9);
        return $code;
    }

    /**
     * 判断是否是特殊字符 eg：emoji表情
     * @param $str string 待判断字符串
     * @return bool
     */
    static function hasSpecialChar(string $str): bool
    {
        $len   = mb_strlen($str);
        $array = [];
        for ($i = 0; $i < $len; $i++) {
            $array[] = mb_substr($str, $i, 1, 'utf-8');
            if (strlen($array[$i]) >= 4) return true;
        }
        return false;
    }

    /**
     * 获取服务器ip
     * @return string
     */
    static function serverIp(): string
    {
        if (!empty($_SERVER['SERVER_ADDR'])) {
            $ip = $_SERVER['SERVER_ADDR'];
        } elseif (!empty($_SERVER['SERVER_NAME'])) {
            $ip = gethostbyname($_SERVER['SERVER_NAME']);
        } else {
            $ip = defined('PHPUNIT_RUNNING') ? '127.0.0.1' : gethostbyname(gethostname());
        }

        return filter_var($ip, FILTER_VALIDATE_IP) ?: '127.0.0.1';
    }
}
