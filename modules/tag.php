<?php
/**
 * 侧边栏组件: 标签
 */
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>

<h5 class="light teal-text text-darken-2 center padding-horizontal">
    <?php echo $widgets_exist['tag']['title'];?>
</h5>
<div id="blogtags" class="padding-bottom padding-horizontal">
<?php $i=0; foreach($tag_cache as $value): ?>
    <?php $i++; if($i < 16):?>
    <span style="font-size:<?php echo $value['fontsize']; ?>pt; line-height:30px;">
        <a class="light red-text text-lighten-2 padding-horizontal-xs" href="<?php echo Url::tag($value['tagurl']); ?>" title="<?php echo $value['usenum']; ?> 篇文章">
            <?php echo $value['tagname']; ?>
        </a>
    </span>
    <?php endif;?>
<?php endforeach; ?>
</div>