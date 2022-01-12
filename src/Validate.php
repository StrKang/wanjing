<?php
/**
 * Created by : PhpStorm
 * User: tyd
 * Date: 2021/12/4
 * Time: 10:06 上午
 */

namespace Henanwanjing\Utility;


class Validate
{
    /**
     * 是否是图片
     * @param string $mineType
     * @return bool
     */
    static function isImageMineType(string $mineType): bool
    {
        $images = ['image/png', 'image/gif', 'image/jpeg', 'image/jpeg'];
        return in_array($mineType, $images);
    }

    /**
     * 是否含有中文
     * @param string $str
     * @return bool
     */
    static function isChs(string $str): bool
    {
        if (preg_match('/[\x{4e00}-\x{9fa5}]/u', $str) > 0) {
            return true;
        }
        return false;
    }
}
