{assign var="class_colum_label" value="col-12 col-sm-3 col-form-label text-sm-right"}
{assign var="class_colum_input" value="col-12 col-sm-8 col-lg-6"}
{form_hidden('manage', $manage_name)}
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">{lang('add_heading')}</h2>
                <p class="pageheader-text">{lang('add_subheading')}</p>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        {$this->breadcrumb->render()}
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">{lang('add_subheading')}</h5>
                <div class="card-body">
                    {if !empty(validation_errors())}
                        <ul class="text-danger">{validation_errors('<li>', '</li>')}</ul>
                    {/if}
                    {form_open(uri_string(), ['id' => 'add_validationform'])}
                        {if $identity_column !== 'email'}
                            <div class="form-group row">
                                {lang('username_label', 'username_label', ['class' => $class_colum_label])}
                                <div class="{$class_colum_input}">
                                    {form_input($identity)}
                                </div>
                            </div>
                        {/if}
                        <div class="form-group row">
                            {lang('create_user_password_label', 'create_user_password_label', ['class' => $class_colum_label])}
                            <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                                {form_input($password)}
                            </div>
                            <div class="col-sm-4 col-lg-3">
                                {form_input($password_confirm)}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('full_name_label', 'full_name_label', ['class' => $class_colum_label])}
                            <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                                {form_input($first_name)}
                            </div>
                            <div class="col-sm-4 col-lg-3">
                                {form_input($last_name)}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('image_label', 'image_label', ['class' => $class_colum_label])}
                            <div class="{$class_colum_input}">
                                <!-- Drag and Drop container-->
                                <div class="drop-drap-file" data-module="article" data-is-multi="false">
                                    <input type="file" name="file" id="file" size="20" />
                                    <div class="upload-area dropzone dz-clickable"  id="uploadfile">
                                        <h5 class="dz-message"">{lang('image_upload')}</h5>
                                    </div>
                                    <div id="image_thumb"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('dob_label', 'dob_label', ['class' => $class_colum_label])}
                            <div class="col-sm-4 col-lg-3 mb-3 mb-sm-0">
                                <div class="input-group date" id="show-date-picker" data-target-input="nearest">
                                    <input type="text" name="dob" id="dob" class="form-control datetimepicker-input" placeholder="01/01/1990" data-target="#show-datet-picker" />
                                    <div class="input-group-append" data-target="#show-date-picker" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 col-lg-3">
                                <div class="float-right">
                                    {lang('gender_label', 'gender_label', ['class' => 'ml-2 mr-3'])}
                                    <label class="custom-control custom-radio mt-1 custom-control-inline">
                                        {form_radio('gender', GENDER_MALE, set_value('gender', GENDER_MALE), ['id' => 'male', 'class' => 'custom-control-input'])}
                                        <span class="custom-control-label">{lang('gender_male')}</span>
                                    </label>
                                    <label class="custom-control custom-radio mt-1 custom-control-inline">
                                        {form_radio('gender', GENDER_FEMALE, set_value('gender'), ['id' => 'female', 'class' => 'custom-control-input'])}
                                        <span class="custom-control-label">{lang('gender_female')}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('create_user_email_label', 'create_user_email_label', ['class' => $class_colum_label])}
                            <div class="{$class_colum_input}">
                                {form_input($email)}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('create_user_phone_label', 'create_user_phone_label', ['class' => $class_colum_label])}
                            <div class="{$class_colum_input}">
                                {form_input($phone)}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('create_user_company_label', 'create_user_company_label', ['class' => $class_colum_label])}
                            <div class="{$class_colum_input}">
                                {form_input($company)}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('address_label', 'address_label', ['class' => $class_colum_label])}
                            <div class="{$class_colum_input}">
                                {form_input($address)}
                            </div>
                        </div>
                        <div class="form-group row">
                            {lang('group_label', 'group_label', ['class' => $class_colum_label])}
                            <div class="{$class_colum_input}">
                                {if !empty($groups)}
                                    <div id="list_category" class="list_checkbox">
                                        {foreach $groups as $group}
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" name="groups[]" id="group_{$group.id}" value="{$group.id}" class="custom-control-input">
                                                <span class="custom-control-label">{$group.name}</span>
                                            </label>
                                        {/foreach}
                                    </div>
                                {/if}
                            </div>
                        </div>
                        {if $this->ion_auth->is_super_admin()}
                            <div class="form-group row">
                                {lang('super_admin_label', 'super_admin_label', ['class' => $class_colum_label])}
                                <div class="{$class_colum_input}">
                                    <div class="switch-button switch-button-sm mt-2">
                                        {form_checkbox($super_admin)}
                                        <span><label for="super_admin"></label></span>
                                    </div>
                                </div>
                            </div>
                        {/if}
                        <div class="form-group row">
                            {lang('permission_label', 'permission_label', ['class' => $class_colum_label])}
                            <div class="{$class_colum_input}">
                                {if !empty($permissions)}
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" name="cb_permission_all" id="cb_permission_all" value="all" class="custom-control-input">
                                        <span class="custom-control-label">{lang('check_all')}</span>
                                    </label>
                                    <div id="list_permission" class="list_checkbox">
                                        {foreach $permissions as $permission}
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" name="permissions[]" id="permission_{$permission.id}" value="{$permission.id}" class="custom-control-input">
                                                <span class="custom-control-label">{$permission.name}</span>
                                            </label>
                                        {/foreach}
                                    </div>
                                {/if}
                            </div>
                        </div>
                        <div class="form-group row text-center">
                            <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0">
                                <button type="submit" class="btn btn-sm btn-space btn-primary"><i class="fas fa-plus mr-1"></i>{lang('add_submit_btn')}</button>
                                {anchor("`$manage_url`", '<i class="fas fa-undo-alt mr-1"></i>'|cat:lang('btn_cancel'), ['class' => 'btn btn-sm btn-space btn-secondary'])}
                            </div>
                        </div>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>
</div>
