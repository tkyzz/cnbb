<?php if (!defined('THINK_PATH')) exit();?><div class="detail-item-title level-title"><p class="title"><span>社会实践经验（非实习）</span></p><div class="action-box"><div class="sub-action add js_practice_add"><i></i>添加</div></div></div><div class="show-level"><?php if(is_array($rjp["practice"])): foreach($rjp["practice"] as $key=>$v): ?><div class="sub-info education-info"><div class="sub-edit edit js_practice_edit" data-resumeid="<?php echo ($rjp["resume_id"]); ?>" data-id="<?php echo ($v["id"]); ?>"><i></i>编辑</div><div class="college-info"><span><?php echo ($v["name"]); ?></span><span class="from-to"><span><?php echo (substr_replace($v["sdate"],'.',4,0)); ?></span>—<span><?php if($v["edate"] == 0): ?>至今<?php else: echo (substr_replace($v["edate"],'.',4,0)); endif; ?></span></span></div><div class="harvest"><p class="harvest-title">实践描述</p><div class="harvest-info"><div class="sub-harvest"><?php echo (smartTextarea($v["remark"])); ?></div></div></div></div><?php endforeach; endif; ?></div>