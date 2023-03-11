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

    /**
     * 生成密码
     * @param int $length 长度
     * @param bool $isSymbol 是否需要符号
     * @param array $other 自定义内容
     * @return string
     */
    static function makePassword(int $length = 8, bool $isSymbol = false, array $other = []): string
    {
        // 密码字符集，可任意添加你需要的字符
        $chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
            'i', 'j', 'k', 'l','m', 'n', 'o', 'p', 'q', 'r', 's',
            't', 'u', 'v', 'w', 'x', 'y','z', 'A', 'B', 'C', 'D',
            'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L','M', 'N', 'O',
            'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y','Z',
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
        );

        //符号
        $symbol = ['!','@','#', '$', '%', '^', '&', '*', '(', ')', '-', '_',
            '[', ']', '{', '}', '<', '>', '~', '`', '+', '=', ',',
            '.', ';', ':', '/', '?', '|'];
        if ($isSymbol) $chars =  array_merge($chars,$symbol);
        if(!empty($other)) $chars =  array_merge($chars,$other);

        // 在 $chars 中随机取 $length 个数组元素键名
        $keys = array_rand($chars, $length);

        $password = '';
        // 将 $length 个数组元素连接成字符串
        for($i = 0; $i < $length; $i++) $password .= $chars[$keys[$i]];
        return $password;
    }

    /**
     * 从一个明文值生产哈希
     * @param string $value 需要生产哈希的原文
     * @param integer $cost  递归的层数 可根据机器配置调整以增加哈希的强度
     * @return false|string 返回60位哈希字符串 生成失败返回false
     *@author : evalor <master@evalor.cn>
     */
    static function makeHash(string $value, int $cost = 10): bool|string
    {
        return password_hash($value, PASSWORD_BCRYPT, [ 'cost' => $cost ]);
    }
}
