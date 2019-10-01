<div id="view_albums">
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
        {form_open_multipart(uri_string(), ['id' => 'add_album'])}
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">{lang('add_subheading')}</h5>
                    <div class="card-body">
                        {if !empty(validation_errors())}
                            <ul class="text-danger">{validation_errors('<li>', '</li>')}</ul>
                        {/if}
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                            <button type="button" onclick="Photo.submitAlbum('add_album');" class="btn btn-sm btn-space btn-primary">{lang('add_album')}</button>
                            <button type="button" onclick="Photo.loadView('{get_last_url($manage_url)}');" class="btn btn-sm btn-space btn-secondary">{lang('btn_cancel')}</button>
                            {*{anchor("`$manage_url`", lang('btn_cancel'), ['class' => 'btn btn-sm btn-space btn-secondary'])}*}
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('title_label')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_input($title)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                                {lang('description_label')}
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                {form_textarea($description)}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-3 col-form-label text-sm-right">
                            </label>
                            <div class="col-12 col-sm-8 col-lg-6">
                                <div class="switch-button switch-button-sm">
                                    {form_checkbox($published)}
                                    <span><label for="published"></label></span>
                                </div>
                            </div>
                        </div>

                        <!-- Drag and Drop container-->
                        {lang('select_photos')}
                        <div class="drop-drap-file" data-module="user" data-is-multi="false">
                            <input type="file" name="file" id="file" multiple accept="audio/*,video/*,image/*" /> {*multiple*}
                            <div class="upload-area dropzone dz-clickable"  id="uploadfile">
                                <h5 class="dz-message"">{lang('image_upload')}</h5>
                            </div>
                        </div>
                        <ul id="image_thumb" class="list_album_photos row mt-2"></ul>
                    </div>
                </div>
            </div>
        </div>
        {form_close()}
    </div>
</div>
<input type="hidden" name="confirm_title" value="{lang("confirm_title")}">
<input type="hidden" name="confirm_content" value="{lang("confirm_delete")}">
<input type="hidden" name="confirm_btn_ok" value="{lang("btn_delete")}">
<input type="hidden" name="confirm_btn_close" value="{lang("btn_close")}">
