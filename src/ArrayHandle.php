<?php

namespace YxTools;

class ArrayHandle
{
    /**
     * 按类型通用二位数组快速排序
     *
     * @param array $data
     * @param string $key
     * @param string $type
     * @return void
     */
    public static function sortt($data = [], $key = 'score', $type = 'asc')
    {
        if (count($data) <= 1) {
            return $data;
        }
        $tem = $data[0][$key];
        $leftarray = array();
        $rightarray = array();
        for ($i = 1; $i < count($data); $i++) {
            if ($type == 'asc') {
                if ($data [$i][$key] >= $tem) {
                    $rightarray[] = $data[$i];
                } else {
                    $leftarray[] = $data[$i];
                }
            } else {
                if ($data [$i][$key] <= $tem) {
                    $rightarray[] = $data[$i];
                } else {
                    $leftarray[] = $data[$i];
                }
            }

        }
        $rightarray = self::sortt($rightarray, $key);
        $leftarray = self::sortt($leftarray, $key);
        $sortarray = array_merge($leftarray, array($data[0]), $rightarray);
        return $sortarray;
    }


    /**
     * 一维数据数组生成数据树
     * @param array $list 数据列表
     * @param string $id 父ID Key
     * @param string $pid ID Key
     * @param string $son 定义子数据Key
     * @return array
     */
    public static function arr2tree($list, $id = 'id', $pid = 'pid', $son = 'sub')
    {
        list($tree, $map) = [[], []];
        foreach ($list as $item) $map[$item[$id]] = $item;
        foreach ($list as $item) if (isset($item[$pid]) && isset($map[$item[$pid]])) {
            $map[$item[$pid]][$son][] = &$map[$item[$id]];
        } else $tree[] = &$map[$item[$id]];
        unset($map);
        return $tree;
    }

    /**
     * 一维数据数组生成数据树
     * @param array $list 数据列表
     * @param string $id ID Key
     * @param string $pid 父ID Key
     * @param string $path
     * @param string $ppath
     * @return array
     */
    public static function arr2table(array $list, $id = 'id', $pid = 'pid', $path = 'path', $ppath = '')
    {
        $tree = [];
        foreach (self::arr2tree($list, $id, $pid) as $attr) {
            $attr[$path] = "{$ppath}-{$attr[$id]}";
            $attr['sub'] = isset($attr['sub']) ? $attr['sub'] : [];
            $attr['spt'] = substr_count($ppath, '-');
            $attr['spl'] = str_repeat("　├　", $attr['spt']);
            $sub = $attr['sub'];
            unset($attr['sub']);
            $tree[] = $attr;
            if (!empty($sub)) $tree = array_merge($tree, self::arr2table($sub, $id, $pid, $path, $attr[$path]));
        }
        return $tree;
    }
}
