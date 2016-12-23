<?php /* Smarty version Smarty-3.1.6, created on 2016-07-26 10:13:58
         compiled from "./Application/Home/View\Index\index.html" */ ?>
<?php /*%%SmartyHeaderCode:42445796c766287246-94625457%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8378b70862d866fede2c1372bd9cfe4821690da8' => 
    array (
      0 => './Application/Home/View\\Index\\index.html',
      1 => 1469498929,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '42445796c766287246-94625457',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5796c766430f3',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5796c766430f3')) {function content_5796c766430f3($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>财金鸟-学生主页</title>
    <link rel="stylesheet" type="text/css" href="/public/css/public.css">
    <link rel="stylesheet" type="text/css" href="/public/css/main.css">

    <script src="public/js/jquery.min.js"></script>
    <script src="public/js/style.js"></script>
</head>
<body>
    <div class="top">
        <div class="top-nav">
            <img src="/public/img/cjn_logo.png"/>
            <div class="menu">
                <a class="sub-menu active" href="index.html">首页</a>
                <a class="sub-menu" href="">大赛</a>
                <a class="sub-menu" href="">金融梦</a>
            </div>
        </div>
        <div class="other-nav">
            <div class="logon">
                <if res=1>
                <span>欢迎您！朱毅</span>
                <else>
                <a class="logon-item active" href="__MODULE__/user/login">登录</a>
                <span>|</span>
                <a class="logon-item" href="__MODULE__/user/signUp">注册</a>
                </if>
            </div>
            <a class="app-download" href=""><i></i>App下载</a>
            <a class="pr-login" href=""><i></i>企业登录</a>
        </div>
    </div>

    <div class="banner">
        <ul class="banner-img">
            <li class="img-list"><img src="/public/img/banner1.jpg"/></li>
            <li class="img-list"><img src="/public/img/banner2.jpg"/></li>
        </ul>
        <div class="banner-slider">
            <a class="banner-btn slider-pre" href="javascript:;"><i></i></a>
            <a class="banner-btn slider-next" href="javascript:;"><i></i></a>
        </div>
    </div>

    <div class="content">
        <div class="search">
            <div class="search-cont search-text">
                <div class="input-box">
                    <input id="search" type="search"/>
                    <label for="search">搜索职位、公司或地点</label>
                </div>
            </div>
            <div class="search-cont search-btn">
                <a href=""><i></i>搜索</a>
            </div>
        </div>

        <div class="company">
            <div class="classify">
                <div class="classify-item">
                    <a class="classify-title" href="">商业银行</a>
                    <div class="sub-classify">
                        <a href="">国有银行</a>
                        <a href="">股份制银行</a>
                        <a href="">外资银行</a>
                        <a href="">城商行/农商行</a>
                    </div>
                </div>
                <div class="classify-item">
                    <a class="classify-title" href="">证券投资</a>
                    <div class="sub-classify">
                        <a href="">券商（含投行）</a>
                        <a href="">期货</a>
                        <a href="">信托</a>
                        <a href="">基金</a>
                        <a href="">其他投资机构</a>
                    </div>
                </div>
                <div class="classify-item">
                    <a class="classify-title" href="">保险</a>
                    <div class="sub-classify">
                        <a href="">全部保险机构</a>
                    </div>
                </div>
                <div class="classify-item">
                    <a class="classify-title" href="">新兴金融行业</a>
                    <div class="sub-classify">
                        <a href="">第三方理财</a>
                        <a href="">互联网金融</a>
                    </div>
                </div>
                <div class="classify-item">
                    <a class="classify-title" href="">财务会计</a>
                    <div class="sub-classify">
                        <a href="">外资会计师事务所</a>
                        <a href="">企业财会</a>
                        <a href="">中资会计师事务所</a>
                    </div>
                </div>
                <div class="classify-item">
                    <a class="classify-title" href="">其他</a>
                    <div class="sub-classify">
                        <a href="">咨询</a>
                    </div>
                </div>
            </div>

            <div class="recommend">
                <p class="recommend-title">推荐公司</p>
                <div class="recommend-company">
                    <div class="recommend-item">
                        <a class="sub-recommend" href="">
                            <div class="recommend-img"><img src="/public/img/company_icon1.jpg"/></div>
                            <div class="recommend-info">
                                <div class="post-count">岗位数量：<span>234</span></div>
                                <div class="recommend-org">中信银行上海分行</div>
                            </div>
                        </a>
                        <a class="sub-recommend" href="">
                            <div class="recommend-img"> <img src="/public/img/company_icon2.jpg"/></div>
                            <div class="recommend-info">
                                <div class="post-count">岗位数量：<span>234</span></div>
                                <div class="recommend-org">中信银行上海分行</div>
                            </div>
                        </a>
                        <a class="sub-recommend" href="">
                            <div class="recommend-img"><img src="/public/img/company_icon1.jpg"/></div>
                            <div class="recommend-info">
                                <div class="post-count">岗位数量：<span>234</span></div>
                                <div class="recommend-org">中信银行上海分行</div>
                            </div>
                        </a>
                        <a class="sub-recommend" href="">
                            <div class="recommend-img"> <img src="/public/img/company_icon2.jpg"/></div>
                            <div class="recommend-info">
                                <div class="post-count">岗位数量：<span>234</span></div>
                                <div class="recommend-org">中信银行上海分行</div>
                            </div>
                        </a>
                        <a class="sub-recommend" href="">
                            <div class="recommend-img"><img src="/public/img/company_icon1.jpg"/></div>
                            <div class="recommend-info">
                                <div class="post-count">岗位数量：<span>234</span></div>
                                <div class="recommend-org">中信银行上海分行</div>
                            </div>
                        </a>
                        <a class="sub-recommend" href="">
                            <div class="recommend-img"> <img src="/public/img/company_icon2.jpg"/></div>
                            <div class="recommend-info">
                                <div class="post-count">岗位数量：<span>234</span></div>
                                <div class="recommend-org">中信银行上海分行</div>
                            </div>
                        </a>
                    </div>
                    <div class="img-lab">
                        <span class="sub-lab active"><i></i></span>
                        <span class="sub-lab"><i></i></span>
                        <span class="sub-lab"><i></i></span>
                        <span class="sub-lab"><i></i></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="post-recommend">
            <div class="post-type">
                <a class="type-item" href="javascript:;">兼职实习<span></span></a>
                <a class="type-item active" href="javascript:;">暑假实习<span></span></a>
            </div>
            <div class="post-list">
                <div class="post-box">
                    <a class="post-item" href="">
                        <div class="item-row">
                            <span class="row-left post-name">投资助理</span>
                            <span class="row-right company-name">中信银行股份有限公司上海分公司</span>
                        </div>
                        <div class="item-row">
                            <div class="row-left post-demand addr-degree">
                                <span class="sub-demand post-addr"><i></i>上海</span>
                                <span class="sub-demand degree"><i></i>本科</span>
                            </div>
                            <span class="row-right company-nature">商业银行/股份制银行</span>
                        </div>
                        <div class="item-row">
                            <div class="row-left post-demand time">
                                <span class="sub-demand post-time"><i></i>暑假实习</span>
                                <span class="sub-demand demand-time"><i></i>每周至少实习5天</span>
                            </div>
                            <span class="row-right publish-date">发布于2天前</span>
                        </div>
                    </a>
                    <a class="post-item" href="">
                        <div class="item-row">
                            <span class="row-left post-name">投资助理</span>
                            <span class="row-right company-name">中信银行股份有限公司上海分公司</span>
                        </div>
                        <div class="item-row">
                            <div class="row-left post-demand addr-degree">
                                <span class="sub-demand post-addr"><i></i>上海</span>
                                <span class="sub-demand degree"><i></i>本科</span>
                            </div>
                            <span class="row-right company-nature">商业银行/股份制银行</span>
                        </div>
                        <div class="item-row">
                            <div class="row-left post-demand time">
                                <span class="sub-demand post-time"><i></i>暑假实习</span>
                                <span class="sub-demand demand-time"><i></i>每周至少实习5天</span>
                            </div>
                            <span class="row-right publish-date">发布于2天前</span>
                        </div>
                    </a>
                </div>
                <div class="post-box">
                    <a class="post-item" href="">
                        <div class="item-row">
                            <span class="row-left post-name">投资助理</span>
                            <span class="row-right company-name">中信银行股份有限公司上海分公司</span>
                        </div>
                        <div class="item-row">
                            <div class="row-left post-demand addr-degree">
                                <span class="sub-demand post-addr"><i></i>上海</span>
                                <span class="sub-demand degree"><i></i>本科</span>
                            </div>
                            <span class="row-right company-nature">商业银行/股份制银行</span>
                        </div>
                        <div class="item-row">
                            <div class="row-left post-demand time">
                                <span class="sub-demand post-time"><i></i>暑假实习</span>
                                <span class="sub-demand demand-time"><i></i>每周至少实习5天</span>
                            </div>
                            <span class="row-right publish-date">发布于2天前</span>
                        </div>
                    </a>
                    <a class="post-item" href="">
                        <div class="item-row">
                            <span class="row-left post-name">投资助理</span>
                            <span class="row-right company-name">中信银行股份有限公司上海分公司</span>
                        </div>
                        <div class="item-row">
                            <div class="row-left post-demand addr-degree">
                                <span class="sub-demand post-addr"><i></i>上海</span>
                                <span class="sub-demand degree"><i></i>本科</span>
                            </div>
                            <span class="row-right company-nature">商业银行/股份制银行</span>
                        </div>
                        <div class="item-row">
                            <div class="row-left post-demand time">
                                <span class="sub-demand post-time"><i></i>暑假实习</span>
                                <span class="sub-demand demand-time"><i></i>每周至少实习5天</span>
                            </div>
                            <span class="row-right publish-date">发布于2天前</span>
                        </div>
                    </a>
                </div>
                <div class="post-box">
                    <a class="post-item" href="">
                        <div class="item-row">
                            <span class="row-left post-name">投资助理</span>
                            <span class="row-right company-name">中信银行股份有限公司上海分公司</span>
                        </div>
                        <div class="item-row">
                            <div class="row-left post-demand addr-degree">
                                <span class="sub-demand post-addr"><i></i>上海</span>
                                <span class="sub-demand degree"><i></i>本科</span>
                            </div>
                            <span class="row-right company-nature">商业银行/股份制银行</span>
                        </div>
                        <div class="item-row">
                            <div class="row-left post-demand time">
                                <span class="sub-demand post-time"><i></i>暑假实习</span>
                                <span class="sub-demand demand-time"><i></i>每周至少实习5天</span>
                            </div>
                            <span class="row-right publish-date">发布于2天前</span>
                        </div>
                    </a>
                    <a class="post-item" href="">
                        <div class="item-row">
                            <span class="row-left post-name">投资助理</span>
                            <span class="row-right company-name">中信银行股份有限公司上海分公司</span>
                        </div>
                        <div class="item-row">
                            <div class="row-left post-demand addr-degree">
                                <span class="sub-demand post-addr"><i></i>上海</span>
                                <span class="sub-demand degree"><i></i>本科</span>
                            </div>
                            <span class="row-right company-nature">商业银行/股份制银行</span>
                        </div>
                        <div class="item-row">
                            <div class="row-left post-demand time">
                                <span class="sub-demand post-time"><i></i>暑假实习</span>
                                <span class="sub-demand demand-time"><i></i>每周至少实习5天</span>
                            </div>
                            <span class="row-right publish-date">发布于2天前</span>
                        </div>
                    </a>
                </div>
                <div class="post-box">
                    <a class="post-item" href="">
                        <div class="item-row">
                            <span class="row-left post-name">投资助理</span>
                            <span class="row-right company-name">中信银行股份有限公司上海分公司</span>
                        </div>
                        <div class="item-row">
                            <div class="row-left post-demand addr-degree">
                                <span class="sub-demand post-addr"><i></i>上海</span>
                                <span class="sub-demand degree"><i></i>本科</span>
                            </div>
                            <span class="row-right company-nature">商业银行/股份制银行</span>
                        </div>
                        <div class="item-row">
                            <div class="row-left post-demand time">
                                <span class="sub-demand post-time"><i></i>暑假实习</span>
                                <span class="sub-demand demand-time"><i></i>每周至少实习5天</span>
                            </div>
                            <span class="row-right publish-date">发布于2天前</span>
                        </div>
                    </a>
                    <a class="post-item" href="">
                        <div class="item-row">
                            <span class="row-left post-name">投资助理</span>
                            <span class="row-right company-name">中信银行股份有限公司上海分公司</span>
                        </div>
                        <div class="item-row">
                            <div class="row-left post-demand addr-degree">
                                <span class="sub-demand post-addr"><i></i>上海</span>
                                <span class="sub-demand degree"><i></i>本科</span>
                            </div>
                            <span class="row-right company-nature">商业银行/股份制银行</span>
                        </div>
                        <div class="item-row">
                            <div class="row-left post-demand time">
                                <span class="sub-demand post-time"><i></i>暑假实习</span>
                                <span class="sub-demand demand-time"><i></i>每周至少实习5天</span>
                            </div>
                            <span class="row-right publish-date">发布于2天前</span>
                        </div>
                    </a>
                </div>
                <div class="post-box">
                    <a class="post-item" href="">
                        <div class="item-row">
                            <span class="row-left post-name">投资助理</span>
                            <span class="row-right company-name">中信银行股份有限公司上海分公司</span>
                        </div>
                        <div class="item-row">
                            <div class="row-left post-demand addr-degree">
                                <span class="sub-demand post-addr"><i></i>上海</span>
                                <span class="sub-demand degree"><i></i>本科</span>
                            </div>
                            <span class="row-right company-nature">商业银行/股份制银行</span>
                        </div>
                        <div class="item-row">
                            <div class="row-left post-demand time">
                                <span class="sub-demand post-time"><i></i>暑假实习</span>
                                <span class="sub-demand demand-time"><i></i>每周至少实习5天</span>
                            </div>
                            <span class="row-right publish-date">发布于2天前</span>
                        </div>
                    </a>
                    <a class="post-item" href="">
                        <div class="item-row">
                            <span class="row-left post-name">投资助理</span>
                            <span class="row-right company-name">中信银行股份有限公司上海分公司</span>
                        </div>
                        <div class="item-row">
                            <div class="row-left post-demand addr-degree">
                                <span class="sub-demand post-addr"><i></i>上海</span>
                                <span class="sub-demand degree"><i></i>本科</span>
                            </div>
                            <span class="row-right company-nature">商业银行/股份制银行</span>
                        </div>
                        <div class="item-row">
                            <div class="row-left post-demand time">
                                <span class="sub-demand post-time"><i></i>暑假实习</span>
                                <span class="sub-demand demand-time"><i></i>每周至少实习5天</span>
                            </div>
                            <span class="row-right publish-date">发布于2天前</span>
                        </div>
                    </a>
                </div>
                <div class="post-box">
                    <a class="post-item" href="">
                        <div class="item-row">
                            <span class="row-left post-name">投资助理</span>
                            <span class="row-right company-name">中信银行股份有限公司上海分公司</span>
                        </div>
                        <div class="item-row">
                            <div class="row-left post-demand addr-degree">
                                <span class="sub-demand post-addr"><i></i>上海</span>
                                <span class="sub-demand degree"><i></i>本科</span>
                            </div>
                            <span class="row-right company-nature">商业银行/股份制银行</span>
                        </div>
                        <div class="item-row">
                            <div class="row-left post-demand time">
                                <span class="sub-demand post-time"><i></i>暑假实习</span>
                                <span class="sub-demand demand-time"><i></i>每周至少实习5天</span>
                            </div>
                            <span class="row-right publish-date">发布于2天前</span>
                        </div>
                    </a>
                    <a class="post-item" href="">
                        <div class="item-row">
                            <span class="row-left post-name">投资助理</span>
                            <span class="row-right company-name">中信银行股份有限公司上海分公司</span>
                        </div>
                        <div class="item-row">
                            <div class="row-left post-demand addr-degree">
                                <span class="sub-demand post-addr"><i></i>上海</span>
                                <span class="sub-demand degree"><i></i>本科</span>
                            </div>
                            <span class="row-right company-nature">商业银行/股份制银行</span>
                        </div>
                        <div class="item-row">
                            <div class="row-left post-demand time">
                                <span class="sub-demand post-time"><i></i>暑假实习</span>
                                <span class="sub-demand demand-time"><i></i>每周至少实习5天</span>
                            </div>
                            <span class="row-right publish-date">发布于2天前</span>
                        </div>
                    </a>
                </div>
                <a class="more-post" href="">查看更多职位</a>
            </div>
        </div>
    </div>

    <a class="my-advice" href=""><i></i><span>我的建议</span></a>

    <div class="footer">
        <img src="/public/img/cjn_logo_bottom2.png"/>
        <div class="bottom-nav">
            <a class="sub-bottom-nav" href="">关于我们</a>
            <a class="sub-bottom-nav" href="">管理团队</a>
            <a class="sub-bottom-nav" href="">招贤纳士</a>
            <a class="sub-bottom-nav" href="">联系我们</a>
            <p class="icp">沪ICP备11028366号-2 @2016 cjbird.cn All rights reserved</p>
        </div>
        <div class="code">
            <img src="/public/img/cjn_code.jpg"/>
        </div>
    </div>
</body>
</html><?php }} ?>