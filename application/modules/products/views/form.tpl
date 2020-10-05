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
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header"><i class="fas {if !empty($edit_data.product_id)}fa-edit{else}fa-plus{/if} mr-2"></i>{$text_form}</h5>
                    <div class="card-body p-0 pt-3 bg-light">
                        <div class="tab-regular">
                            {include file=get_theme_path('views/inc/tab_language.inc.tpl') languages=$list_lang}
                            <div class="tab-content border-0 p-3" id="dummy_tab_content">
                                {foreach $list_lang as $language}
                                    <div class="tab-pane fade {if $language.active}show active{/if}" role="tabpanel" id="lanuage_content_{$language.id}"  aria-labelledby="language_tab_{$language.id}">
                                        <div class="form-group row required has-error">
                                            <label class="col-12 col-sm-3 col-form-label required-label text-sm-right">
                                                {lang('text_name')}
                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-7">
                                                <input type="text" name="manager_description[{$language.id}][name]" value='{set_value("manager_description[`$language.id`][name]", $edit_data.details[$language.id].name)}' id="input-name[{$language.id}]" class="form-control {if !empty(form_error("manager_description[`$language.id`][name]"))}is-invalid{/if}">
                                                {if !empty(form_error("manager_description[`$language.id`][name]"))}
                                                    <div class="invalid-feedback">{form_error("manager_description[`$language.id`][name]")}</div>
                                                {/if}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                                {lang('text_description')}
                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-7">
                                                <textarea name="manager_description[{$language.id}][description]" cols="40" rows="2" id="input-description[{$language.id}]" type="textarea" class="form-control">{set_value("manager_description[`$language.id`][description]", $edit_data.details[$language.id].description)}</textarea>
                                            </div>
                                        </div>
                                        
                <div class="form-group row">
                    <label class="col-12 col-sm-3 col-form-label text-sm-right">
                        {lang('text_tag')}
                    </label>
                    <div class="col-12 col-sm-8 col-lg-7">
                        <input type="text" name="manager_description[{$language.id}][tag]" value='{set_value("manager_description[`$language.id`][tag]", $edit_data.details[$language.id].tag)}' id="input_tag[{$language.id}]" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-12 col-sm-3 col-form-label text-sm-right">
                        {lang('text_meta_title')}
                    </label>
                    <div class="col-12 col-sm-8 col-lg-7">
                        <input type="text" name="manager_description[{$language.id}][meta_title]" value='{set_value("manager_description[`$language.id`][meta_title]", $edit_data.details[$language.id].meta_title)}' id="input_meta_title[{$language.id}]" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-12 col-sm-3 col-form-label text-sm-right">
                        {lang('text_meta_description')}
                    </label>
                    <div class="col-12 col-sm-8 col-lg-7">
                        <input type="text" name="manager_description[{$language.id}][meta_description]" value='{set_value("manager_description[`$language.id`][meta_description]", $edit_data.details[$language.id].meta_description)}' id="input_meta_description[{$language.id}]" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-12 col-sm-3 col-form-label text-sm-right">
                        {lang('text_meta_keyword')}
                    </label>
                    <div class="col-12 col-sm-8 col-lg-7">
                        <input type="text" name="manager_description[{$language.id}][meta_keyword]" value='{set_value("manager_description[`$language.id`][meta_keyword]", $edit_data.details[$language.id].meta_keyword)}' id="input_meta_keyword[{$language.id}]" class="form-control">
                    </div>
                </div>
                                    </div>
                                {/foreach}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">{lang('text_manage_more')}</h5>
                    <div class="card-body">
                        <div class="form-group">
                            {lang('text_published')}
                            <div class="switch-button switch-button-xs float-right mt-1">
                                <input type="checkbox" name="published" value="{STATUS_ON}" {if $edit_data.product_id}{if $edit_data.published eq true}checked="checked"{/if}{else}checked="checked"{/if} id="published">
                                <span><label for="published"></label></span>
                            </div>
                        </div>
                        
                <div class="form-group">
                    {lang('text_master_id')}
                    <input type="text" name="master_id" value="{set_value('master_id', $edit_data.master_id)}" id="master_id" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_model')}
                    <input type="text" name="model" value="{set_value('model', $edit_data.model)}" id="model" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_sku')}
                    <input type="text" name="sku" value="{set_value('sku', $edit_data.sku)}" id="sku" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_upc')}
                    <input type="text" name="upc" value="{set_value('upc', $edit_data.upc)}" id="upc" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_ean')}
                    <input type="text" name="ean" value="{set_value('ean', $edit_data.ean)}" id="ean" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_jan')}
                    <input type="text" name="jan" value="{set_value('jan', $edit_data.jan)}" id="jan" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_isbn')}
                    <input type="text" name="isbn" value="{set_value('isbn', $edit_data.isbn)}" id="isbn" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_mpn')}
                    <input type="text" name="mpn" value="{set_value('mpn', $edit_data.mpn)}" id="mpn" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_location')}
                    <input type="text" name="location" value="{set_value('location', $edit_data.location)}" id="location" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_variant')}
                    <input type="text" name="variant" value="{set_value('variant', $edit_data.variant)}" id="variant" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_override')}
                    <input type="text" name="override" value="{set_value('override', $edit_data.override)}" id="override" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_quantity')}
                    <input type="text" name="quantity" value="{set_value('quantity', $edit_data.quantity)}" id="quantity" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_stock_status_id')}
                    <input type="text" name="stock_status_id" value="{set_value('stock_status_id', $edit_data.stock_status_id)}" id="stock_status_id" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_image')}
                    <input type="text" name="image" value="{set_value('image', $edit_data.image)}" id="image" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_manufacturer_id')}
                    <input type="text" name="manufacturer_id" value="{set_value('manufacturer_id', $edit_data.manufacturer_id)}" id="manufacturer_id" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_shipping')}
                    <input type="text" name="shipping" value="{set_value('shipping', $edit_data.shipping)}" id="shipping" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_price')}
                    <input type="text" name="price" value="{set_value('price', $edit_data.price)}" id="price" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_points')}
                    <input type="text" name="points" value="{set_value('points', $edit_data.points)}" id="points" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_tax_class_id')}
                    <input type="text" name="tax_class_id" value="{set_value('tax_class_id', $edit_data.tax_class_id)}" id="tax_class_id" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_date_available')}
                    <input type="text" name="date_available" value="{set_value('date_available', $edit_data.date_available)}" id="date_available" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_weight')}
                    <input type="text" name="weight" value="{set_value('weight', $edit_data.weight)}" id="weight" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_weight_class_id')}
                    <input type="text" name="weight_class_id" value="{set_value('weight_class_id', $edit_data.weight_class_id)}" id="weight_class_id" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_length')}
                    <input type="text" name="length" value="{set_value('length', $edit_data.length)}" id="length" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_length_class_id')}
                    <input type="text" name="length_class_id" value="{set_value('length_class_id', $edit_data.length_class_id)}" id="length_class_id" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_width')}
                    <input type="text" name="width" value="{set_value('width', $edit_data.width)}" id="width" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_height')}
                    <input type="text" name="height" value="{set_value('height', $edit_data.height)}" id="height" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_subtract')}
                    <input type="text" name="subtract" value="{set_value('subtract', $edit_data.subtract)}" id="subtract" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_minimum')}
                    <input type="text" name="minimum" value="{set_value('minimum', $edit_data.minimum)}" id="minimum" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_status')}
                    <input type="text" name="status" value="{set_value('status', $edit_data.status)}" id="status" class="form-control">
                </div>
                <div class="form-group">
                    {lang('text_viewed')}
                    <input type="text" name="viewed" value="{set_value('viewed', $edit_data.viewed)}" id="viewed" class="form-control">
                </div>
                        <div class="form-group">
                            {lang('text_sort_order')}
                            <input type="number" name="sort_order" value="{if $edit_data.product_id}{set_value('sort_order', $edit_data.sort_order)}{else}0{/if}" id="sort_order" min="0" class="form-control">
                        </div>
                    </div>
                </div>
                {if $edit_data.product_id}
                    {include file=get_theme_path('views/inc/status_form.inc.tpl')}
                {/if}
            </div>
        </div>
    {form_close()}
</div>
