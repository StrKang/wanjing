<?php

namespace Wanjing\Utility;


class Encrypt
{
    /**
     * 字符串加密
     * @param string $key
     * @param string $str
     * @return string
     */
    static function encode(string $key, string $str): string
    {
        return self::_encrypt($str, 'E', $key);
    }

    /**
     * 字符串解密
     * @param string $key
     * @param string $str
     * @return string
     */
    static function decode(string $key, string $str): string
    {
        return self::_encrypt($str, 'D', $key);
    }

    /**
     * 加密
     * @param $string
     * @param $operation
     * @param string $key
     * @return array|false|string|string[]
     */
    private static function _encrypt($string, $operation, $key = '')
    {
        $key = md5($key);
        $key_length = strlen($key);
        $string = $operation == 'D' ? base64_decode($string) : substr(md5($string . $key), 0, 8) . $string;
        $string_length = strlen($string);
        $rndkey = $box = array();
        $result = '';
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($key[$i % $key_length]);
            $box[$i] = $i;
        }
        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        if ($operation == 'D') {
            if (substr($result, 0, 8) == substr(md5(substr($result, 8) . $key), 0, 8)) {
                return substr($result, 8);
            } else {
                return '';
            }
        } else {
            return str_replace('=', '', base64_encode($result));
        }
    }

    static function hzEncode($nums): string
    {
        $result = self::passkey();
        $rtn = "";
        $numslen = strlen($nums);
        //密文第一位标记数字的长度
        $begin = substr($result['codelen'], $numslen - 1, 1);
        //密文的扩展位
        $extlen = $result['length'] - $numslen - 1;
        $temp = str_replace('.', '', $nums / $result['key']);
        $temp = substr($temp, -$extlen);

        $arrextTemp = str_split($result['codeext']);
        $arrext = str_split($temp);
        foreach ($arrext as $v) {
            @$rtn .= $arrextTemp[$v];
        }

        $arrnumsTemp = str_split($result['codenums']);
        $arrnums = str_split($nums);
        foreach ($arrnums as $v) {
            $rtn .= $arrnumsTemp[$v];
        }
        return $begin . $rtn;
    }

    static function hzDecode($code): string
    {
        $result = self::passkey();
        $begin = substr($code, 0, 1);
        $rtn = '';
        $len = strpos($result['codelen'], $begin);
        if ($len !== false) {
            $len++;
            $arrnums = str_split(substr($code, -$len));
            foreach ($arrnums as $v) {
                $rtn .= strpos($result['codenums'], $v);
            }
        }
        return $rtn;
    }

    private static function passkey(): array
    {
        $strbase = "FeWUPXQxSyJizmNH6B1u3b8cAEKwTd54nRtZOMDhoG2YLrIlpvf70CsakVjqg";
        $key = 1314521;
        $length = 10;
        $codelen = substr($strbase, 0, $length);
        $codenums = substr($strbase, $length, 10);
        $codeext = substr($strbase, $length + 10);
        $result = array('strbase' => $strbase,
            'key' => $key,
            'length' => $length,
            'codenums' => $codenums,
            'codelen' => $codelen,
            'codeext' => $codeext,
        );
        return $result;
    }
}
