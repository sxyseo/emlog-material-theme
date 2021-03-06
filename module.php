<?php
/**
 * 侧边栏组件、页面模块
 */
if(!defined('EMLOG_ROOT')) {exit('error!');}

global $CACHE;
$navi_cache = $CACHE->readCache('navi');
$link_cache = $CACHE->readCache('link');
$user_cache = $CACHE->readCache('user');
$tag_cache = $CACHE->readCache('tags');
$sort_cache = $CACHE->readCache('sort');
$newtws_cache = $CACHE->readCache('newtw');
$com_cache = $CACHE->readCache('comment');
$newLogs_cache = $CACHE->readCache('newlog');
$record_cache = $CACHE->readCache('record');
// 文章所属分类
$log_cache_sort = $CACHE->readCache('logsort');
// 文章标签
$log_cache_tags = $CACHE->readCache('logtags');

$istwitter = Option::get('istwitter');

// 热门文章 && 随机文章
$index_hotlognum = Option::get('index_hotlognum');
$index_randlognum = Option::get('index_randlognum');
$Log_Model = new Log_Model();
$hotLogs = $Log_Model->getHotLog($index_hotlognum);
$randLogs = $Log_Model->getRandLog($index_randlognum);

global $widgets_exist;
global $widgets_num;
global $widgets_arr;
$widgets_exist = array();
$widgets_num = 0;
$widgets_arr = array('home');

// 个人资料
function widget_blogger($title, $exists=true){
    global $widgets_exist;
    $widgets_exist['blogger']['title'] = $title;
    $widgets_exist['blogger']['exists'] = $exists;
}

// 日历
function widget_calendar($title, $exists=true){
    global $widgets_exist, $widgets_num, $widgets_arr;
    $widgets_exist['calendar']['title'] = $title;
    $widgets_exist['calendar']['exists'] = $exists;
    $widgets_num += 1;
    array_push($widgets_arr, 'calendar');
}

// 标签
function widget_tag($title, $exists=true){
    global $widgets_exist, $widgets_num, $widgets_arr;
    $widgets_exist['tag']['title'] = $title;
    $widgets_exist['tag']['exists'] = $exists;
    $widgets_num += 1;
    array_push($widgets_arr, 'tag');
}

// 分类
function widget_sort($title, $exists=true){
    global $widgets_exist, $widgets_num, $widgets_arr;
    $widgets_exist['sort']['title'] = $title;
    $widgets_exist['sort']['exists'] = $exists;
    $widgets_num += 1;
    array_push($widgets_arr, 'sort');
}

// 最新微语
function widget_twitter($title, $exists=true){
    global $widgets_exist, $widgets_num, $widgets_arr;
    $widgets_exist['twitter']['title'] = $title;
    $widgets_exist['twitter']['exists'] = $exists;
    $widgets_num += 1;
    array_push($widgets_arr, 'twitter');
}

// 最新评论
function widget_newcomm($title, $exists=true){
    global $widgets_exist, $widgets_num, $widgets_arr;
    $widgets_exist['newcomm']['title'] = $title;
    $widgets_exist['newcomm']['exists'] = $exists;
    $widgets_num += 1;
    array_push($widgets_arr, 'newcomm');
}

// 最新文章
function widget_newlog($title, $exists=true){
    global $widgets_exist, $widgets_num, $widgets_arr;
    $widgets_exist['newlog']['title'] = $title;
    $widgets_exist['newlog']['exists'] = $exists;
    $widgets_num += 1;
    array_push($widgets_arr, 'newlog');
}

// 热门文章
function widget_hotlog($title, $exists=true){
    global $widgets_exist, $widgets_num, $widgets_arr;
    $widgets_exist['hotlog']['title'] = $title;
    $widgets_exist['hotlog']['exists'] = $exists;
    $widgets_num += 1;
    array_push($widgets_arr, 'hotlog');
}

// 随机文章
function widget_random_log($title, $exists=true){
    global $widgets_exist, $widgets_num, $widgets_arr;
    $widgets_exist['randlog']['title'] = $title;
    $widgets_exist['randlog']['exists'] = $exists;
    $widgets_num += 1;
    array_push($widgets_arr, 'randlog');
}

// 搜索
function widget_search($title, $exists=true){
    global $widgets_exist, $widgets_num;
    $widgets_exist['search']['title'] = $title;
    $widgets_exist['search']['exists'] = $exists;
}

// 归档
function widget_archive($title, $exists=true){
    global $widgets_exist, $widgets_num, $widgets_arr;
    $widgets_exist['archive']['title'] = $title;
    $widgets_exist['archive']['exists'] = $exists;
    $widgets_num += 1;
    array_push($widgets_arr, 'archive');
}

// 自定义组件
function widget_custom_text($title, $content, $exists=true){
    global $widgets_exist, $widgets_num, $widgets_arr;
    $widgets_exist['custom']['title'] = $title;
    $widgets_exist['custom']['content'] = $content;
    $widgets_exist['custom']['exists'] = $exists;
    $widgets_num += 1;
    array_push($widgets_arr, 'custom');
}

// 友情链接
function widget_link($title, $exists=true){
    global $widgets_exist;
    $widgets_exist['link']['title'] = $title;
    $widgets_exist['link']['exists'] = $exists;
}

//blog：置顶
function topflg($top, $sortop='n', $sortid=null){
    if(blog_tool_ishome() && $top == 'y') {
       return true;
    } elseif($sortid && $sortop == 'y'){
       return true;
    }
    return false;
}

//blog-tool:判断是否是首页
function blog_tool_ishome(){
    if (BLOG_URL . trim(Dispatcher::setPath(), '/') == BLOG_URL){
        return true;
    } else {
        return FALSE;
    }
}

$widgets = !empty($options_cache['widgets1']) ? unserialize($options_cache['widgets1']) : array();
foreach ($widgets as $val)
{
    $widget_title = @unserialize($options_cache['widget_title']);
    $custom_widget = @unserialize($options_cache['custom_widget']);
    if(strpos($val, 'custom_wg_') === 0){
        $callback = 'widget_custom_text';
        if(function_exists($callback)){
            call_user_func($callback, htmlspecialchars($custom_widget[$val]['title']), $custom_widget[$val]['content']);
        }
    }else{
        $callback = 'widget_'.$val;
        if(function_exists($callback)){
            preg_match("/^.*\s\((.*)\)/", $widget_title[$val], $matchs);
            $wgTitle = isset($matchs[1]) ? $matchs[1] : $widget_title[$val];
            call_user_func($callback, htmlspecialchars($wgTitle));
        }
    }
}

?>
