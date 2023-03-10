<?php

namespace Wanjing\Utility;


class Arr
{

    /**
     * @param array $highlight
     * @return array
     */
    static function searchHighlight(array $highlight): array
    {
        $data = [];
        if (empty($highlight)) return $data;

        foreach ($highlight as $key => $value) $data[$key] = $value[0];
        return $data;
    }

    /**
     * 获取数组的树形结构
     * @param array $list
     * @param string $pk
     * @param string $pid
     * @param string $child
     * @return array
     */
    static function tree(array $list, string $pk = 'id', string $pid = 'parentId', string $child = 'children'): array
    {
        $items = self::index_by($list, $pk);
        $tree = [];
        foreach ($items as $key => $item) {
            if (isset($items[$item[$pid] ?? 0])) {
                $items[$item[$pid] ?? 0][$child][] = &$items[$key];  // 此处不能动
            } else {
                $tree[] = &$items[$key];  // 此处不能动
            }
        }
        return $tree;
    }

    static function index_by(array $arr, string $index): array
    {
        $newArr = [];
        foreach ($arr as $item) {
            if (!is_array($item)) $item = (array)$item;
            $newArr[$item[$index]] = $item;
        }
        return $newArr;
    }
}
