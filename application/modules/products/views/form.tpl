{* thong tin ve san pham *}
{capture name=product_info}
    <div class="tab-regular">
        <ul class="nav nav-tabs border-bottom pl-3" id="tab_multi_language" role="tablist">
            {if count($list_lang) > 1}
                {foreach $list_lang as $language}
                    <li class="nav-item">
                        {if !empty($id_content_tab)}
                            <a class="nav-link p-2 pl-3 pr-3 {if $language.active}active{/if}" id="{$id_content_tab}_tab_{$language.id}" data-toggle="tab" href="#{$id_content_tab}_{$language.id}" role="tab" aria-controls="{$id_content_tab}_{$language.id}" aria-selected="{if $language.active}true{else}false{/if}">{$language.icon}{$language.name}</a>
                        {else}
                            <a class="nav-link p-2 pl-3 pr-3 {if $language.active}active{/if}" id="language_tab_{$language.id}" data-toggle="tab" href="#lanuage_content_{$language.id}" role="tab" aria-controls="lanuage_content_{$language.id}" aria-selected="{if $language.active}true{else}false{/if}">{$language.icon}{$language.name}</a>
                        {/if}
                    </li>
                {/foreach}
            {/if}
        </ul>
        <div class="tab-content border-0 p-3" id="dummy_tab_content">
            {foreach $list_lang as $language}
                <div class="tab-pane fade {if $language.active}show active{/if}" role="tabpanel" id="lanuage_content_{$language.id}"  aria-labelledby="language_tab_{$language.id}">
                    <div class="form-group row required has-error">
                        <label class="col-12 col-sm-2 col-form-label required-label text-sm-right">
                            {lang('text_name')}
                        </label>
                        <div class="col-12 col-sm-8 col-lg-8">
                            <input type="text" name="manager_description[{$language.id}][name]" value='{set_value("manager_description[`$language.id`][name]", $edit_data.details[$language.id].name)}' id="input-name[{$language.id}]" class="form-control {if !empty(form_error("manager_description[`$language.id`][name]"))}is-invalid{/if}">
                            {if !empty(form_error("manager_description[`$language.id`][name]"))}
                                <div class="invalid-feedback">{form_error("manager_description[`$language.id`][name]")}</div>
                            {/if}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-2 col-form-label text-sm-right">
                            {lang('text_description')}
                        </label>
                        <div class="col-12 col-sm-8 col-lg-8">
                            <textarea name="manager_description[{$language.id}][description]" cols="40" rows="2" id="input-description[{$language.id}]" type="textarea" class="form-control">{set_value("manager_description[`$language.id`][description]", $edit_data.details[$language.id].description)}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-2 col-form-label text-sm-right">
                            {lang('text_tags')}
                        </label>
                        <div class="col-12 col-sm-8 col-lg-8">
                            <input type="text" name="manager_description[{$language.id}][tag]" value='{set_value("manager_description[`$language.id`][tag]", $edit_data.details[$language.id].tag)}' id="input_tag[{$language.id}]" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-sm-2 col-form-label text-sm-right">
                            {lang('tab_seo')}
                        </label>
                        <div class="col-12 col-sm-8 col-lg-8">
                            {include file=get_theme_path('views/inc/seo_form.tpl') name_seo_url='product/'}
                        </div>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
{/capture}
{* end thong tin ve san pham *}

{* data san pham *}
{capture name=product_data}
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">
            {lang('text_published')}
        </label>
        <div class="col-12 col-sm-8 col-lg-8">
            <div class="switch-button switch-button-xs mt-1">
                <input type="checkbox" name="published" value="{STATUS_ON}" {if $edit_data.product_id}{if $edit_data.published eq true}checked="checked"{/if}{else}checked="checked"{/if} id="published">
                <span><label for="published"></label></span>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_master_id')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="master_id" value="{set_value('master_id', $edit_data.master_id)}" id="master_id" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_model')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="model" value="{set_value('model', $edit_data.model)}" id="model" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_sku')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="sku" value="{set_value('sku', $edit_data.sku)}" id="sku" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_upc')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="upc" value="{set_value('upc', $edit_data.upc)}" id="upc" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_ean')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="ean" value="{set_value('ean', $edit_data.ean)}" id="ean" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_jan')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="jan" value="{set_value('jan', $edit_data.jan)}" id="jan" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_isbn')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="isbn" value="{set_value('isbn', $edit_data.isbn)}" id="isbn" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_mpn')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="mpn" value="{set_value('mpn', $edit_data.mpn)}" id="mpn" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_location')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="location" value="{set_value('location', $edit_data.location)}" id="location" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_variant')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="variant" value="{set_value('variant', $edit_data.variant)}" id="variant" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_override')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="override" value="{set_value('override', $edit_data.override)}" id="override" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_quantity')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="quantity" value="{set_value('quantity', $edit_data.quantity)}" id="quantity" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_stock_status_id')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="stock_status_id" value="{set_value('stock_status_id', $edit_data.stock_status_id)}" id="stock_status_id" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_image')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="image" value="{set_value('image', $edit_data.image)}" id="image" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_manufacturer_id')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="manufacturer_id" value="{set_value('manufacturer_id', $edit_data.manufacturer_id)}" id="manufacturer_id" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_shipping')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="shipping" value="{set_value('shipping', $edit_data.shipping)}" id="shipping" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_price')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="price" value="{set_value('price', $edit_data.price)}" id="price" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_points')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="points" value="{set_value('points', $edit_data.points)}" id="points" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_tax_class_id')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="tax_class_id" value="{set_value('tax_class_id', $edit_data.tax_class_id)}" id="tax_class_id" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_date_available')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="date_available" value="{set_value('date_available', $edit_data.date_available)}" id="date_available" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_weight')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="weight" value="{set_value('weight', $edit_data.weight)}" id="weight" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_weight_class_id')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="weight_class_id" value="{set_value('weight_class_id', $edit_data.weight_class_id)}" id="weight_class_id" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_length')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="length" value="{set_value('length', $edit_data.length)}" id="length" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_length_class_id')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="length_class_id" value="{set_value('length_class_id', $edit_data.length_class_id)}" id="length_class_id" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_width')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="width" value="{set_value('width', $edit_data.width)}" id="width" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_height')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="height" value="{set_value('height', $edit_data.height)}" id="height" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_subtract')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="subtract" value="{set_value('subtract', $edit_data.subtract)}" id="subtract" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_minimum')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="minimum" value="{set_value('minimum', $edit_data.minimum)}" id="minimum" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_status')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="status" value="{set_value('status', $edit_data.status)}" id="status" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_viewed')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="text" name="viewed" value="{set_value('viewed', $edit_data.viewed)}" id="viewed" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label text-sm-right">{lang('text_sort_order')}</label>
        <div class="col-12 col-sm-8 col-lg-8">
            <input type="number" name="sort_order" value="{if $edit_data.product_id}{set_value('sort_order', $edit_data.sort_order)}{else}0{/if}" id="sort_order" min="0" class="form-control">
        </div>
    </div>
{/capture}


{*layout*}
{form_hidden('manage_url', $manage_url)}
<div class="container-fluid  dashboard-content">
    {form_open(uri_string(), ['id' => 'validationform'])}
        <div class="row">
            <div class="col-sm-7 col-12">
                {include file=get_theme_path('views/inc/breadcrumb.inc.tpl')}
            </div>
            <div class="col-sm-5 col-12 mb-2 mb-sm-0 text-right">
                <button type="submit" class="btn btn-sm btn-space btn-primary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_submit}"><i class="fas fa-save"></i></button>
                <a href="{$button_cancel}" class="btn btn-sm btn-space btn-secondary mb-0"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{$text_cancel}"><i class="fas fa-reply"></i></a>
            </div>
        </div>
        {if !empty($edit_data.product_id)}
            {form_hidden('product_id', $edit_data.product_id)}
            {create_input_token($csrf)}
        {/if}
        <div class="row">
            {if !empty($errors)}
                <div class="col-12">
                    {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                </div>
            {/if}
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header"><i class="fas {if !empty($edit_data.product_id)}fa-edit{else}fa-plus{/if} mr-2"></i>{$text_form}</h5>
                    <div class="card-body p-0 pt-3 bg-light">
                        <div class="tab-regular">
                            <ul class="nav nav-tabs pl-3" id="tab_product" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link p-2 pl-3 pr-3 active" id="product_tab_info" data-toggle="tab" href="#product_info" role="tab" aria-controls="info" aria-selected="true">{lang('tab_general')}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 pl-3 pr-3" id="product_tab_data" data-toggle="tab" href="#product_data" role="tab" aria-controls="data" aria-selected="false">{lang('tab_data')}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 pl-3 pr-3" id="product_tab_links" data-toggle="tab" href="#product_links" role="tab" aria-controls="links" aria-selected="false">{lang('tab_links')}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 pl-3 pr-3" id="product_tab_attribute" data-toggle="tab" href="#product_attribute" role="tab" aria-controls="attribute" aria-selected="false">{lang('tab_attribute')}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 pl-3 pr-3" id="product_tab_option" data-toggle="tab" href="#product_option" role="tab" aria-controls="option" aria-selected="false">{lang('tab_option')}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 pl-3 pr-3" id="product_tab_recurring" data-toggle="tab" href="#product_recurring" role="tab" aria-controls="recurring" aria-selected="false">{lang('tab_recurring')}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 pl-3 pr-3" id="product_tab_discount" data-toggle="tab" href="#product_discount" role="tab" aria-controls="discount" aria-selected="false">{lang('tab_discount')}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 pl-3 pr-3" id="product_tab_special" data-toggle="tab" href="#product_special" role="tab" aria-controls="special" aria-selected="false">{lang('tab_special')}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 pl-3 pr-3" id="product_tab_image" data-toggle="tab" href="#product_image" role="tab" aria-controls="image" aria-selected="false">{lang('tab_image')}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 pl-3 pr-3" id="product_tab_reward" data-toggle="tab" href="#product_reward" role="tab" aria-controls="reward" aria-selected="false">{lang('tab_reward')}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 pl-3 pr-3" id="product_tab_seo" data-toggle="tab" href="#product_seo" role="tab" aria-controls="seo" aria-selected="false">{lang('tab_seo')}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-2 pl-3 pr-3" id="product_tab_design" data-toggle="tab" href="#product_design" role="tab" aria-controls="design" aria-selected="false">{lang('tab_design')}</a>
                                </li>
                            </ul>
                            <div class="tab-content pl-1 pr-1" id="product_tab_content">
                                <div class="tab-pane fade show active" id="product_info" role="tabpanel" aria-labelledby="product_tab_info">
                                    {$smarty.capture.product_info}
                                </div>
                                <div class="tab-pane fade p-3" id="product_data" role="tabpanel" aria-labelledby="product_tab_data">
                                    {$smarty.capture.product_data}
                                </div>
                                <div class="tab-pane fade p-3" id="product_links" role="tabpanel" aria-labelledby="product_tab_links">
                                    {$smarty.capture.product_links}
                                </div>
                                <div class="tab-pane fade p-3" id="product_attribute" role="tabpanel" aria-labelledby="product_tab_attribute">
                                    {$smarty.capture.product_attribute}
                                </div>
                                <div class="tab-pane fade p-3" id="product_option" role="tabpanel" aria-labelledby="product_tab_option">
                                    {$smarty.capture.product_option}
                                </div>
                                <div class="tab-pane fade p-3" id="product_recurring" role="tabpanel" aria-labelledby="product_tab_recurring">
                                    {$smarty.capture.product_recurring}
                                </div>
                                <div class="tab-pane fade p-3" id="product_discount" role="tabpanel" aria-labelledby="product_tab_discount">
                                    {$smarty.capture.product_discount}
                                </div>
                                <div class="tab-pane fade p-3" id="product_special" role="tabpanel" aria-labelledby="product_tab_special">
                                    {$smarty.capture.product_special}
                                </div>
                                <div class="tab-pane fade p-3" id="product_reward" role="tabpanel" aria-labelledby="product_tab_reward">
                                    {$smarty.capture.product_reward}
                                </div>
                                <div class="tab-pane fade p-3" id="product_seo" role="tabpanel" aria-labelledby="product_tab_seo">
                                    {$smarty.capture.product_seo}
                                </div>
                                <div class="tab-pane fade p-3" id="product_design" role="tabpanel" aria-labelledby="product_tab_design">
                                    {$smarty.capture.product_design}
                                </div>
                            </div>
                        </div>
                    </div>{*end card-body*}
                </div>
            </div>
        </div>
    {form_close()}
</div>

