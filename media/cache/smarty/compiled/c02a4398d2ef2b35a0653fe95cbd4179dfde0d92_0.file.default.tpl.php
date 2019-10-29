<?php /* Smarty version 3.1.28-dev/21, created on 2019-10-29 16:21:57
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/content/themes/admin/views/_master/default.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:4435258145db804b5dc9411_83589342%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c02a4398d2ef2b35a0653fe95cbd4179dfde0d92' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/content/themes/admin/views/_master/default.tpl',
      1 => 1572227767,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4435258145db804b5dc9411_83589342',
  'variables' => 
  array (
    'title' => 0,
    'metadata' => 0,
    'css_files' => 0,
    'layout' => 0,
    'js_files' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.28-dev/21',
  'unifunc' => 'content_5db804b5e8f866_90936262',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5db804b5e8f866_90936262')) {
function content_5db804b5e8f866_90936262 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '4435258145db804b5dc9411_83589342';
?>
<!DOCTYPE html>
<html class="<?php echo Events::trigger('html_class','no-js','string');?>
" dir="<?php echo lang('direction');?>
" lang="<?php echo lang('code');?>
">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <base href="<?php echo base_url();?>
">
        <title><?php echo Events::trigger('the_title',$_smarty_tpl->tpl_vars['title']->value,'string');?>
</title>
        <link rel="icon" href="<?php echo base_url('favicon.ico');?>
">
        <?php echo $_smarty_tpl->tpl_vars['metadata']->value;?>


        <!-- StyleSheets -->
        <?php echo $_smarty_tpl->tpl_vars['css_files']->value;?>


        <!--[if lt IE 9]>
        <?php echo js('html5shiv-3.7.3.min','https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js',null,'common');?>

        <?php echo js('respond-1.4.2.min','https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js',null,'common');?>

        <![endif]-->

        <?php echo '<script'; ?>
><?php echo script_global();?>
<?php echo '</script'; ?>
>
    </head>
    <body class="<?php echo Events::trigger('body_class','','string');?>
">
        <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

        <?php echo $_smarty_tpl->tpl_vars['layout']->value;?>


        <?php echo $_smarty_tpl->tpl_vars['js_files']->value;?>

        <?php echo '<script'; ?>
 src="<?php ob_start();
echo js_url('alert.min','common');
$_tmp1=ob_get_clean();
echo $_tmp1;?>
"><?php echo '</script'; ?>
>

        <?php if ((config_item('ga_enabled') && (!empty(config_item('ga_siteid')) && config_item('ga_siteid') != 'UA-XXXXX-Y'))) {?>
            
            <!-- Google Analytics-->
            <?php echo '<script'; ?>
>
                window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
                ga('create','{{config_item('ga_siteid')}}','auto');ga('send','pageview')
            <?php echo '</script'; ?>
>
            <?php echo '<script'; ?>
 src="https://www.google-analytics.com/analytics.js" async defer><?php echo '</script'; ?>
>
            
        <?php }?>

    </body>
</html>
<?php }
}
?>