<?php if (!defined('THINK_PATH')) exit(); if(is_array($res["posts"])): foreach($res["posts"] as $k=>$v): ?><a class="post-item" href="/mpost/<?php echo (smartBase64($v["id"])); ?>.html"><div class="post-avatar"><img src="<?php echo ((isset($v["org"]["b_logo_url"]) && ($v["org"]["b_logo_url"] !== ""))?($v["org"]["b_logo_url"]):'/Public/img/wap/company_icon.jpg'); ?>"/></div><div class="post-info"><div class="info-line"><span class="line-block post-name"><?php echo ($v["name"]); ?></span><?php if(($v['esalary']) >= "1"): ?><span class="line-block post-pay"><?php echo ($v['ssalary']); ?>-<?php echo ($v['esalary']); if($v['salary_unit'] == 0): ?>元/天<?php else: ?>元/月<?php endif; ?></span><?php else: ?><span class="line-block post-pay"><?php if($v['ssalary'] <= 0): ?>面议<?php else: if($v['salary_unit'] == 0): echo ($v["ssalary"]); ?>元/天<?php else: echo ($v["ssalary"]); ?>元/月<?php endif; endif; ?></span><?php endif; ?><!-- <span class="line-block post-pay">3500-8000元/月</span> --></div><div class="info-line"><span class="line-block post-org"><?php echo ($v["org"]["abbrname"]); ?></span><span class="line-block post-addr"><i></i><?php echo ($v["city_name"]); ?>-<?php if(!empty($v["zone_name"])): echo ($v["zone_name"]); else: ?>全市<?php endif; ?></span></div><div class="info-line"><div class="line-block post-others"><span class="sub-attr"><?php echo (smartDegree($v["degree"])); ?></span><?php if(!empty($v["work_days"])): ?><span class="sub-attr"><?php echo ($v["work_days"]); ?>天/周</span><?php endif; if(!empty($v["work_duration"])): ?><span class="sub-attr">至少<?php echo ($v['work_duration']/30); ?>个月</span><?php endif; ?></div><span class="line-block post-time"><?php echo (smartJobStrTime($v["last_time"])); ?></span></div></div></a><?php endforeach; endif; ?>