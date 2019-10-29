<?php /* Smarty version 3.1.28-dev/21, created on 2019-10-29 16:21:57
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/content/themes/admin/views/_modules/articles/categories/form.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:13639428655db804b546f7c5_80601834%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '138bd46217afcc9b4ee195e8c280b1c929b93728' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/dev/catcool/content/themes/admin/views/_modules/articles/categories/form.tpl',
      1 => 1572340609,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13639428655db804b546f7c5_80601834',
  'variables' => 
  array (
    'manage_name' => 0,
    'edit_data' => 0,
    'csrf' => 0,
    'text_form' => 0,
    'text_submit' => 0,
    'button_cancel' => 0,
    'text_cancel' => 0,
    'errors' => 0,
    'list_lang' => 0,
    'language' => 0,
    'list_patent' => 0,
    'output_html' => 0,
    'indent_symbol' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.28-dev/21',
  'unifunc' => 'content_5db804b56d7ce5_45571003',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5db804b56d7ce5_45571003')) {
function content_5db804b56d7ce5_45571003 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '13639428655db804b546f7c5_80601834';
echo form_hidden('manage',$_smarty_tpl->tpl_vars['manage_name']->value);?>

<div class="container-fluid  dashboard-content">
    <?php echo $_smarty_tpl->getSubTemplate (get_theme_path('views/inc/breadcrumb.inc.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

    <?php echo form_open(uri_string(),array('id'=>'validationform'));?>

        <?php if (!empty($_smarty_tpl->tpl_vars['edit_data']->value['category_id'])) {?>
            <?php echo form_hidden('category_id',$_smarty_tpl->tpl_vars['edit_data']->value['category_id']);?>

            <?php echo create_input_token($_smarty_tpl->tpl_vars['csrf']->value);?>

        <?php }?>
        <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h5 class="mb-0 mt-1 ml-1"><i class="fas <?php if (!empty($_smarty_tpl->tpl_vars['edit_data']->value['category_id'])) {?>fa-edit<?php } else { ?>fa-plus<?php }?> mr-2"></i><?php echo $_smarty_tpl->tpl_vars['text_form']->value;?>
</h5>
                            </div>
                            <div class="col-4 text-right">
                                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $_smarty_tpl->tpl_vars['text_submit']->value;?>
"><i class="fas fa-save"></i></button>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['button_cancel']->value;?>
" class="btn btn-sm btn-space btn-secondary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $_smarty_tpl->tpl_vars['text_cancel']->value;?>
"><i class="fas fa-reply"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <?php if (!empty($_smarty_tpl->tpl_vars['errors']->value)) {?>
                            <?php echo $_smarty_tpl->getSubTemplate (get_theme_path('views/inc/alert.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('message'=>$_smarty_tpl->tpl_vars['errors']->value,'type'=>'danger'), 0);
?>

                        <?php }
echo BASEPATH;?>

                        <div class="tab-regular">
                            <?php if (count($_smarty_tpl->tpl_vars['list_lang']->value) > 1) {?>
                                <ul class="nav nav-tabs border-bottom" id="myTab" role="tablist">
                                    <?php
$foreach_0_language_sav['s_item'] = isset($_smarty_tpl->tpl_vars['language']) ? $_smarty_tpl->tpl_vars['language'] : false;
$_from = $_smarty_tpl->tpl_vars['list_lang']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['language'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['language']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->_loop = true;
$foreach_0_language_sav['item'] = $_smarty_tpl->tpl_vars['language'];
?>
                                        <li class="nav-item">
                                            <a class="nav-link p-2 pl-3 pr-3 <?php if ($_smarty_tpl->tpl_vars['language']->value['active']) {?>active<?php }?>" id="language-tab-<?php echo $_smarty_tpl->tpl_vars['language']->value['id'];?>
" data-toggle="tab" href="#lanuage-<?php echo $_smarty_tpl->tpl_vars['language']->value['id'];?>
" role="tab" aria-controls="lanuage-<?php echo $_smarty_tpl->tpl_vars['language']->value['id'];?>
" aria-selected="<?php if ($_smarty_tpl->tpl_vars['language']->value['active']) {?>true<?php } else { ?>false<?php }?>"><?php echo $_smarty_tpl->tpl_vars['language']->value['icon'];
echo $_smarty_tpl->tpl_vars['language']->value['name'];?>
</a>
                                        </li>
                                    <?php
$_smarty_tpl->tpl_vars['language'] = $foreach_0_language_sav['item'];
}
if ($foreach_0_language_sav['s_item']) {
$_smarty_tpl->tpl_vars['language'] = $foreach_0_language_sav['s_item'];
}
?>
                                </ul>
                            <?php }?>
                            <div class="tab-content border-0 p-3" id="myTabContent">
                                <?php
$foreach_1_language_sav['s_item'] = isset($_smarty_tpl->tpl_vars['language']) ? $_smarty_tpl->tpl_vars['language'] : false;
$_from = $_smarty_tpl->tpl_vars['list_lang']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['language'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['language']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['language']->value) {
$_smarty_tpl->tpl_vars['language']->_loop = true;
$foreach_1_language_sav['item'] = $_smarty_tpl->tpl_vars['language'];
?>
                                    <div class="tab-pane fade <?php if ($_smarty_tpl->tpl_vars['language']->value['active']) {?>show active<?php }?>" role="tabpanel" id="lanuage-<?php echo $_smarty_tpl->tpl_vars['language']->value['id'];?>
"  aria-labelledby="language-tab-<?php echo $_smarty_tpl->tpl_vars['language']->value['id'];?>
">
                                        <div class="form-group row required has-error">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                                <?php echo lang('title_label');?>

                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-8">
                                                <input type="text" name="article_category_description[<?php echo $_smarty_tpl->tpl_vars['language']->value['id'];?>
][title]" value='<?php echo set_value("article_category_description[".((string)$_smarty_tpl->tpl_vars['language']->value['id'])."][title]",$_smarty_tpl->tpl_vars['edit_data']->value['details'][$_smarty_tpl->tpl_vars['language']->value['id']]['title']);?>
' id="input-title[<?php echo $_smarty_tpl->tpl_vars['language']->value['id'];?>
]" data-slug-id="input-slug-<?php echo $_smarty_tpl->tpl_vars['language']->value['id'];?>
" class="form-control <?php if (!empty(form_error("article_category_description[".((string)$_smarty_tpl->tpl_vars['language']->value['id'])."][title]"))) {?>is-invalid<?php }?> <?php if (empty($_smarty_tpl->tpl_vars['edit_data']->value['category_id'])) {?>make_slug<?php }?>">
                                                <?php if (!empty(form_error("article_category_description[".((string)$_smarty_tpl->tpl_vars['language']->value['id'])."][title]"))) {?>
                                                    <div class="invalid-feedback"><?php echo form_error("article_category_description[".((string)$_smarty_tpl->tpl_vars['language']->value['id'])."][title]");?>
</div>
                                                <?php }?>
                                            </div>
                                        </div>
                                        <div class="form-group row required">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                                <?php echo lang('slug_label');?>

                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-8">
                                                <input type="text" name="article_category_description[<?php echo $_smarty_tpl->tpl_vars['language']->value['id'];?>
][slug]" value='<?php echo set_value("article_category_description[".((string)$_smarty_tpl->tpl_vars['language']->value['id'])."][slug]",$_smarty_tpl->tpl_vars['edit_data']->value['details'][$_smarty_tpl->tpl_vars['language']->value['id']]['slug']);?>
' id="input-slug-<?php echo $_smarty_tpl->tpl_vars['language']->value['id'];?>
" class="form-control">
                                                <div class="invalid-feedback">fgdgadgf<?php echo form_error("article_category_description[".((string)$_smarty_tpl->tpl_vars['language']->value['id'])."][slug]");?>
</div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                                <?php echo lang('description_label');?>

                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-8">
                                                <textarea name="article_category_description[<?php echo $_smarty_tpl->tpl_vars['language']->value['id'];?>
][description]" cols="40" rows="5" id="input-description[<?php echo $_smarty_tpl->tpl_vars['language']->value['id'];?>
]" type="textarea" class="form-control"><?php echo set_value("article_category_description[".((string)$_smarty_tpl->tpl_vars['language']->value['id'])."][description]",$_smarty_tpl->tpl_vars['edit_data']->value['details'][$_smarty_tpl->tpl_vars['language']->value['id']]['description']);?>
</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                                <?php echo lang("seo_title_label");?>

                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-8">
                                                <input type="text" name="article_category_description[<?php echo $_smarty_tpl->tpl_vars['language']->value['id'];?>
][meta_title]" value='<?php echo set_value("article_category_description[".((string)$_smarty_tpl->tpl_vars['language']->value['id'])."][meta_title]",$_smarty_tpl->tpl_vars['edit_data']->value['details'][$_smarty_tpl->tpl_vars['language']->value['id']]['meta_title']);?>
' id="input-meta-title[<?php echo $_smarty_tpl->tpl_vars['language']->value['id'];?>
]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                                <?php echo lang("seo_description_label");?>

                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-8">
                                                <textarea name="article_category_description[<?php echo $_smarty_tpl->tpl_vars['language']->value['id'];?>
][meta_description]" cols="40" rows="5" id="input-meta-description[<?php echo $_smarty_tpl->tpl_vars['language']->value['id'];?>
]" type="textarea" class="form-control"><?php echo set_value("article_category_description[".((string)$_smarty_tpl->tpl_vars['language']->value['id'])."][meta_description]",$_smarty_tpl->tpl_vars['edit_data']->value['details'][$_smarty_tpl->tpl_vars['language']->value['id']]['meta_description']);?>
</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                                <?php echo lang("seo_keyword_label");?>

                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-8">
                                                <input type="text" name="article_category_description[<?php echo $_smarty_tpl->tpl_vars['language']->value['id'];?>
][meta_keyword]" value='<?php echo set_value("article_category_description[".((string)$_smarty_tpl->tpl_vars['language']->value['id'])."][meta_keyword]",$_smarty_tpl->tpl_vars['edit_data']->value['details'][$_smarty_tpl->tpl_vars['language']->value['id']]['meta_keyword']);?>
' id="input-meta-keyword[<?php echo $_smarty_tpl->tpl_vars['language']->value['id'];?>
]" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                <?php
$_smarty_tpl->tpl_vars['language'] = $foreach_1_language_sav['item'];
}
if ($foreach_1_language_sav['s_item']) {
$_smarty_tpl->tpl_vars['language'] = $foreach_1_language_sav['s_item'];
}
?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header"><?php echo lang('manage_more_label');?>
</h5>
                    <div class="card-body">
                        <div class="form-group">
                            <?php echo lang('published_label');?>

                            <div class="switch-button switch-button-xs float-right mt-1">
                                <input type="checkbox" name="published" value="<?php echo STATUS_ON;?>
" <?php if ($_smarty_tpl->tpl_vars['edit_data']->value['published']) {?>checked="checked"<?php }?> id="published">
                                <span><label for="published"></label></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo lang("images_label");?>

                            <!-- Drag and Drop container-->
                            <a href="javascript:void(0);" id="thumb-image" data-target="input-image" data-thumb="thumb-image" data-toggle="image">
                                <img src="<?php echo image_thumb_url($_smarty_tpl->tpl_vars['edit_data']->value['image']);?>
" class="img-thumbnail mr-1 img-fluid" alt="" title="" id="thumb-image" data-placeholder="https://demo.opencart.com/image/cache/no_image-100x100.png"/>
                            </a>
                            <input type="hidden" name="image" value="<?php echo $_smarty_tpl->tpl_vars['edit_data']->value['image'];?>
" id="input-image" />
                        </div>
                        <div class="form-group">
                            <?php echo lang('sort_order_label');?>

                            <input type="number" name="sort_order" value="<?php echo set_value('sort_order',$_smarty_tpl->tpl_vars['edit_data']->value['sort_order']);?>
" id="sort_order" min="0" class="form-control">
                        </div>
                        <div class="form-group">
                            <?php echo lang('parent_label');?>

                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value=""><?php echo lang('select_dropdown_label');?>
</option>
                                <?php $_smarty_tpl->tpl_vars['output_html'] = new Smarty_Variable('<option ##SELECTED## value="##VALUE##">##INDENT_SYMBOL####NAME##</option>', null, 0);?>
                                <?php $_smarty_tpl->tpl_vars['indent_symbol'] = new Smarty_Variable('-&nbsp;-&nbsp;', null, 0);?>
                                <?php echo draw_tree_output(array('data'=>$_smarty_tpl->tpl_vars['list_patent']->value,'key_id'=>'category_id'),$_smarty_tpl->tpl_vars['output_html']->value,0,$_smarty_tpl->tpl_vars['edit_data']->value['parent_id'],$_smarty_tpl->tpl_vars['indent_symbol']->value);?>

                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php echo form_close();?>

</div>
<?php }
}
?>