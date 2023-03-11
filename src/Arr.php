<?php

namespace Wanjing\Utility;

/**
 * 处理数组相关
 */
class Arr
{

    /**
     * es高亮字段处理
     * @param array $highlight 结果数组
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
     * @param string $pk 主键
     * @param string $pid 父id
     * @param string $child 下级分组字段名
     * @return array
     */
    static function tree(array $list, string $pk = 'id', string $pid = 'parentId', string $child = 'children'): array
    {
        $items = self::indexBy($list, $pk);
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

    /**
     * @param array $arr
     * @param string $index
     * @return array
     */
    static function indexBy(array $arr, string $index): array
    {
        $newArr = [];
        foreach ($arr as $item) {
            if (!is_array($item)) $item = (array)$item;
            $newArr[$item[$index]] = $item;
        }
        return $newArr;
    }
}
