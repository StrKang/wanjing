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
    static function isImageMineType(string $mineType): bool
    {
        $images = ['image/png', 'image/gif', 'image/jpeg', 'image/jpeg'];
        return in_array($mineType, $images);
    }
}
