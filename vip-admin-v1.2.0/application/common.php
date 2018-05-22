<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/03/04
 * Time: 10:20
 */

/**
 * 根据ip获取地址信息
 * 接口
 * @param string $ip
 * @return array|bool|mixed
 */
function get_ip_location($ip = ''){
    $url = '';
    if ($ip == '' || $ip == '0.0.0.0') {
        $url = "http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json";
    } else {
        $url = "http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=" . $ip;
    }
    // 获得的地址信息
    $location = json_decode(file_get_contents($url), true);
    // 获取城市
    $data = $location['country'].'-'.$location['province'].'-'.$location['city'];
    // 返回信息
    return $data;
}


/**
 * 根据url获取title
 * @param $url
 * @return string
 */
function get_url_title($url){
    $content=file_get_contents($url);
    $pos = strpos($content,'utf-8');
    if($pos===false){$content = iconv("gbk","utf-8",$content);}
    $postb=strpos($content,'<title>')+7;
    $poste=strpos($content,'</title>');
    $length=$poste-$postb;
    return trim(substr($content,$postb,$length));
}

/**
 * 构建层级（树状）数组
 * @param array  $array          源数组
 * @param string $pid_name       父级ID的字段名
 * @param string $child_key_name 子元素键名
 * @return array|bool
 */
function treeArray($array, $pid_name = 'pid', $child_key_name = 'children'){
    $counter = array_children_count($array, $pid_name);
    if (!isset($counter[0]) || $counter[0] == 0) {
        return $array;
    }
    $tree = [];
    while (isset($counter[0]) && $counter[0] > 0) {
        $temp = array_shift($array);
        if (isset($counter[$temp['id']]) && $counter[$temp['id']] > 0) {
            array_push($array, $temp);
        } else {
            if ($temp[$pid_name] == 0) {
                $tree[] = $temp;
            } else {
                $array = array_child_append($array, $temp[$pid_name], $temp, $child_key_name);
            }
        }
        $counter = array_children_count($array, $pid_name);
    }
    return $tree;
}

/**
 * 统计子数组
 * @param $array
 * @param $pid
 * @return array
 */
function array_children_count($array, $pid){
    $counter = [];
    foreach ($array as $item) {
        $count = isset($counter[$item[$pid]]) ? $counter[$item[$pid]] : 0;
        $count++;
        $counter[$item[$pid]] = $count;
    }

    return $counter;
}

/**
 * 插入到对应的父元素$child_key_name字段
 * @param $parent
 * @param $pid
 * @param $child
 * @param $child_key_name
 * @return mixed
 */
function array_child_append($parent, $pid, $child, $child_key_name){
    foreach ($parent as &$item) {
        if ($item['id'] == $pid) {
            if (!isset($item[$child_key_name]))
                $item[$child_key_name] = [];
            $item[$child_key_name][] = $child;
        }
    }
    return $parent;
}


