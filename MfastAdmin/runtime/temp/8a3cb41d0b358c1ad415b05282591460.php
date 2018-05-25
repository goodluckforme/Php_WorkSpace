<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:105:"D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin\public/../application/admin\view\general\attachment\edit.html";i:1525672326;s:86:"D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin\application\admin\view\layout\default.html";i:1525672326;s:83:"D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin\application\admin\view\common\meta.html";i:1525672326;s:85:"D:\Apache24\htdocs\Php_WorkSpace\MfastAdmin\application\admin\view\common\script.html";i:1525672326;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<link rel="shortcut icon" href="/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>
    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <form id="edit-form" class="form-horizontal form-ajax" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label for="c-url" class="control-label col-xs-12 col-sm-2"><?php echo __('Url'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="text" name="row[url]" value="<?php echo $row['url']; ?>"  id="c-url" class="form-control" required />
        </div>
    </div>
    <div class="form-group">
        <label for="c-imagewidth" class="control-label col-xs-12 col-sm-2"><?php echo __('Imagewidth'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="text" name="row[imagewidth]" value="<?php echo $row['imagewidth']; ?>"  id="c-imagewidth" class="form-control" required />
        </div>
    </div>
    <div class="form-group">
        <label for="c-imageheight" class="control-label col-xs-12 col-sm-2"><?php echo __('Imageheight'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="text" name="row[imageheight]" value="<?php echo $row['imageheight']; ?>"  id="c-imageheight" class="form-control" required />
        </div>
    </div>
    <div class="form-group">
        <label for="c-imagetype" class="control-label col-xs-12 col-sm-2"><?php echo __('Imagetype'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="text" name="row[imagetype]" value="<?php echo $row['imagetype']; ?>"  id="c-imagetype" class="form-control" required />
        </div>
    </div>
    <div class="form-group">
        <label for="c-imageframes" class="control-label col-xs-12 col-sm-2"><?php echo __('Imageframes'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="number" name="row[imageframes]" value="<?php echo $row['imageframes']; ?>"  id="c-imageframes" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <label for="c-filesize" class="control-label col-xs-12 col-sm-2"><?php echo __('Filesize'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="number" name="row[filesize]" value="<?php echo $row['filesize']; ?>"  id="c-filesize" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <label for="c-mimetype" class="control-label col-xs-12 col-sm-2"><?php echo __('Mimetype'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="text" name="row[mimetype]" value="<?php echo $row['mimetype']; ?>"  id="c-mimetype" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <label for="c-extparam" class="control-label col-xs-12 col-sm-2"><?php echo __('Extparam'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="text" name="row[extparam]" value="<?php echo $row['extparam']; ?>"  id="c-extparam" class="form-control" />
        </div>
    </div>
    <div class="form-group">
        <label for="c-uploadtime" class="control-label col-xs-12 col-sm-2"><?php echo __('Uploadtime'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="datetime" name="row[uploadtime]" value="<?php echo datetime($row['uploadtime']); ?>"  id="c-uploadtime" class="form-control datetimepicker" />
        </div>
    </div>
    <div class="form-group">
        <label for="c-storage" class="control-label col-xs-12 col-sm-2"><?php echo __('Storage'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input type="text" name="row[storage]" value="<?php echo $row['storage']; ?>"  id="c-storage" class="form-control" />
        </div>
    </div>
    <div class="form-group hide layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo $site['version']; ?>"></script>
    </body>
</html>