<?php

namespace Henanwanjing\Framework\Utility;

class HHashid
{
    private static function passkey()
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

    //加密
    static function encryption($nums)
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

    //解密
    static function deciphering($code)
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
}
