<?php if (!defined('THINK_PATH')) exit();?><div class="show-block"><div class="profile-show edu_profile_show" data-id="<?php echo ((isset($edus[0]['major']) && ($edus[0]['major'] !== ""))?($edus[0]['major']):0); ?>"><div class="detail-item-title"><p class="title"><span>教育经历</span><b class="must-lab">必填</b></p><div class="action-box"><div class="sub-action add js_edu_add"><i></i>添加</div></div></div><?php if(is_array($edus)): foreach($edus as $key=>$v): ?><div class="sub-info" data-id="<?php echo ($v["id"]); ?>"><div class="sub-edit edit js_edu_edit" data-id="<?php echo ($v["id"]); ?>"><i></i>编辑</div><div class="college-info"><span class="major must-field"><?php echo ($v["school_name"]); echo (is_edu_read($v["edate"])); ?></span><?php if(!empty($v["faculty"])): ?><span class="others must-field"><?php echo ($v["faculty"]); ?></span><?php endif; ?><span class="major must-field"><?php echo ($v["major"]); ?></span><span class="degree"><?php echo (smartDegree($v["degree"])); ?></span><!--<?php if(!empty($v["bp"])): ?>--><!--<span class="others bp">绩点<?php echo ($v["bp"]); ?></span>--><!--<?php endif; ?>--><!--<?php if(!empty($v["rank"])): ?>--><!--<span class="others rank">排名<?php echo ($v["rank"]); ?></span>--><!--<?php endif; ?>--><span class="from-to"><span class="sdate"><?php echo (smartEduGrade($v["sdate"])); ?></span></span></div></div><?php endforeach; endif; ?></div>