<?php if (!defined('THINK_PATH')) exit(); if(count($job)): if(is_array($job)): foreach($job as $key=>$v): ?><div class="relation-item" data-type="<?php echo ($v['type']); ?>" data-kw="<?php echo ($v['name']); ?>"><span class="item-cont"><?php echo ($v['t_name']); ?></span><?php if(!empty($v['count'])): ?><span class="item-count">共<span><?php echo ($v['count']); ?></span>个职位</span><?php endif; ?></div><?php endforeach; endif; endif; ?>