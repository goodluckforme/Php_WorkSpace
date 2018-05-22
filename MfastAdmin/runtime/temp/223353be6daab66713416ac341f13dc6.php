<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:92:"D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin\public/../application/index\view\user\index.html";i:1525672326;s:86:"D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin\application\index\view\layout\default.html";i:1525672326;s:83:"D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin\application\index\view\common\meta.html";i:1525672326;s:86:"D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin\application\index\view\common\sidenav.html";i:1525672326;s:85:"D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin\application\index\view\common\script.html";i:1525672326;}*/ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?> – <?php echo __('The fastest framework based on ThinkPHP5 and Bootstrap'); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<?php if(isset($keywords)): ?>
<meta name="keywords" content="<?php echo $keywords; ?>">
<?php endif; if(isset($description)): ?>
<meta name="description" content="<?php echo $description; ?>">
<?php endif; ?>
<meta name="author" content="FastAdmin">

<link rel="shortcut icon" href="/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/assets/css/frontend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config: <?php echo json_encode($config); ?>
    };
</script>
        <link href="/assets/css/user.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">
    </head>

    <body>

        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#header-navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo url('/'); ?>" style="padding:6px 15px;"><img src="/assets/img/logo.png" style="height:40px;" alt=""></a>
                </div>
                <div class="collapse navbar-collapse" id="header-navbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="https://www.fastadmin.net" target="_blank"><?php echo __('Home'); ?></a></li>
                        <li><a href="https://www.fastadmin.net/store.html" target="_blank"><?php echo __('Store'); ?></a></li>
                        <li><a href="https://www.fastadmin.net/service.html" target="_blank"><?php echo __('Services'); ?></a></li>
                        <li><a href="https://www.fastadmin.net/download.html" target="_blank"><?php echo __('Download'); ?></a></li>
                        <li><a href="https://www.fastadmin.net/demo.html" target="_blank"><?php echo __('Demo'); ?></a></li>
                        <li><a href="https://www.fastadmin.net/donate.html" target="_blank"><?php echo __('Donation'); ?></a></li>
                        <li><a href="https://forum.fastadmin.net" target="_blank"><?php echo __('Forum'); ?></a></li>
                        <li><a href="https://doc.fastadmin.net" target="_blank"><?php echo __('Docs'); ?></a></li>
                        <li class="dropdown">
                            <?php if($user): ?>
                            <a href="<?php echo url('user/index'); ?>" class="dropdown-toggle" data-toggle="dropdown" style="padding-top: 10px;height: 50px;">
                                <span class="avatar-img"><img src="<?php echo $user['avatar']; ?>" alt=""></span>
                            </a>
                            <?php else: ?>
                            <a href="<?php echo url('user/index'); ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('User center'); ?> <b class="caret"></b></a>
                            <?php endif; ?>
                            <ul class="dropdown-menu">
                                <?php if($user): ?>
                                <li><a href="<?php echo url('user/index'); ?>"><i class="fa fa-user-circle"></i><?php echo __('User center'); ?></a></li>
                                <li><a href="<?php echo url('user/profile'); ?>"><i class="fa fa-user-o"></i><?php echo __('Profile'); ?></a></li>
                                <li><a href="<?php echo url('user/changepwd'); ?>"><i class="fa fa-key"></i><?php echo __('Change password'); ?></a></li>
                                <li><a href="<?php echo url('user/logout'); ?>"><i class="fa fa-sign-out"></i><?php echo __('Sign out'); ?></a></li>
                                <?php else: ?>
                                <li><a href="<?php echo url('user/login'); ?>"><i class="fa fa-sign-in"></i> <?php echo __('Sign in'); ?></a></li>
                                <li><a href="<?php echo url('user/register'); ?>"><i class="fa fa-user-o"></i> <?php echo __('Sign up'); ?></a></li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="content">
            <div id="content-container" class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="sidenav">
    <ul class="list-group">
        <li class="list-group-heading"><?php echo __('User center'); ?></li>
        <li class="list-group-item <?php echo $config['actionname']=='index'?'active':''; ?>"> <a href="<?php echo url('user/index'); ?>"><i class="fa fa-user-circle"></i> <?php echo __('User center'); ?></a> </li>
        <li class="list-group-item <?php echo $config['actionname']=='profile'?'active':''; ?>"> <a href="<?php echo url('user/profile'); ?>"><i class="fa fa-user-o"></i> <?php echo __('Profile'); ?></a> </li>
        <li class="list-group-item <?php echo $config['actionname']=='changepwd'?'active':''; ?>"> <a href="<?php echo url('user/changepwd'); ?>"><i class="fa fa-key"></i> <?php echo __('Change password'); ?></a> </li>
        <li class="list-group-item <?php echo $config['actionname']=='logout'?'active':''; ?>"> <a href="<?php echo url('user/logout'); ?>"><i class="fa fa-sign-out"></i> <?php echo __('Sign out'); ?></a> </li>
    </ul>
</div>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default ">
                <div class="panel-body">
                    <h2 class="page-header"><?php echo __('User center'); ?></h2>
                    <div class="row user-baseinfo">
                        <div class="col-md-3 col-sm-3 col-xs-2 text-center user-center">
                            <a href="<?php echo url('user/profile'); ?>" title="<?php echo __('Click to edit'); ?>">
                                <span class="avatar-img"><img src="<?php echo $user['avatar']; ?>" alt=""></span>
                            </a>
                        </div>
                        <div class="col-md-7 col-sm-7 col-xs-10">
                            <!-- Content -->
                            <div class="ui-content">
                                <!-- Heading -->
                                <h4><a href="<?php echo url('user/profile'); ?>"><?php echo $user['username']; ?></a></h4>
                                <!-- Paragraph -->
                                <p><a href="<?php echo url('user/profile'); ?>"><?php echo (isset($user['bio']) && ($user['bio'] !== '')?$user['bio']:__("This guy hasn't written anything yet")); ?></a></p>
                                <!-- Success -->
                                <div style="margin-top:15px;">
                                    <table class="table">	
                                        <tbody><tr>
                                                <th><?php echo __('Lv'); ?></th>
                                                <td><a href="javascript:;" class="viewlv"><?php echo $user['level']; ?></a></td>
                                                <th><?php echo __('Score'); ?></th>
                                                <td><a href="javascript:;" class="viewscore"><?php echo $user['score']; ?></a></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo __('Successions'); ?></th>
                                                <td><?php echo $user['successions']; ?> <?php echo __('Day'); ?></td>
                                                <th><?php echo __('Maxsuccessions'); ?></th>
                                                <td><?php echo $user['maxsuccessions']; ?> <?php echo __('Day'); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo __('Logintime'); ?></th>
                                                <td><?php echo date("Y-m-d H:i:s",$user['logintime']); ?></td>
                                                <th><?php echo __('Prevtime'); ?></th>
                                                <td><?php echo date("Y-m-d H:i:s",$user['prevtime']); ?></td>
                                            </tr>
                                        </tbody></table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-0 col-pad">
                            <a href="<?php echo url('user/profile'); ?>" class="btn btn-success hidden-xs"><i class="fa fa-pencil"></i> <?php echo __('Profile'); ?></a>	
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        </main>

        <footer class="footer" style="clear:both">
            <p class="copyright">Copyright&nbsp;©&nbsp;2017-2018 fastadmin.net All Rights Reserved <?php echo $site['name']; ?> <?php echo __('Copyrights'); ?> <a href="https://www.miibeian.gov.cn" target="_blank"><?php echo $site['beian']; ?></a></p>
        </footer>

        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-frontend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>

    </body>

</html>