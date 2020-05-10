<style>
    body {
        background: url({img_url('assets/images/auth-bg.jpg')}) no-repeat center center;
    }
</style>
<div class="splash-container">
    <div class="card">
        <div class="card-header text-center">
            <a href="{site_url()}" title="{lang('login_heading')}"><img src="{img_url(config_item('image_logo_url'), 'common')}" alt="logo" class="logo-img"></a>
        </div>
        <div class="card-body pt-4">
            {if !empty($errors)}
                {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
            {/if}
            {form_open(uri_string())}
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="input_group_username"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" name="username" value="" id="username" placeholder="{lang('text_username')}" class="form-control form-control-lg" describedby="input_group_username" autocomplete="off">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="input_group_password"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" name="password" value="" id="password" placeholder="{lang('text_password')}" describedby="input_group_password" class="form-control form-control-lg">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="input_group_captcha"><i class="fas fa-shield-alt"></i></span>
                    </div>
                    <input type="number" name="captcha" value="" id="captcha" placeholder="{lang('text_captcha')}" describedby="input_group_captcha" class="form-control form-control-lg" autocomplete="off">
                </div>
                <div class="form-group text-center">
                    {$image_captcha}
                </div>
                <div class="form-group mt-3">
                  <label class="custom-control custom-checkbox">
                      {form_checkbox('remember', '1', FALSE, 'id="remember" class="custom-control-input"')}
                      <span class="custom-control-label"> {lang('text_login_remember')}</span>
                  </label>
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block mt-2">{lang('button_login')}</button>
            {form_close()}

            {if !empty($auth_url)}
            <h2>CodeIgniter Facebook Login</h2>
            <a href="{$auth_url}"><img src="{img_url('images/facebook.png', 'common')}"></a>
            {else}
            <h2>Facebook Profile Details</h2>
            <div class="ac-data">
                <img src="{$user_data.picture}"/>
                <p><b>Facebook ID:</b> {$user_data.oauth_uid}</p>
                <p><b>Name:</b> {$user_data.first_name} - {$user_data.last_name}</p>
                <p><b>Email:</b> {$user_data.email}</p>
                <p><b>Phone:</b> {$user_data.phone}</p>
                <p><b>Gender:</b> {$user_data.gender}</p>
                <p><b>Logged in with:</b> Facebook</p>
                <p><b>Profile Link:</b> <a href="{$user_data.link}" target="_blank">Click to visit Facebook page</a></p>
                <p><b>Logout from <a href="{$logout_url}">Facebook</a></p>
            </div>
            {/if}

            {if !empty($zalo_auth_url)}
            <h2>CodeIgniter Zalo Login</h2>
            <a href="{$zalo_auth_url}"><img src="{img_url('images/facebook.png', 'common')}"></a>
            {else}
                <img src="{$user_zalo.picture.data.url}"/>
                <p><b>Zalo ID:</b> {$user_zalo.id}</p>
                <p><b>Name:</b> {$user_zalo.name}</p>
                <p><b>DOB:</b> {$user_zalo.birthday}</p>
                <p><b>Gender:</b> {$user_zalo.gender}</p>
                <p><b>Logout from <a href="{$zalo_logout_url}">Zalo</a></p>
            {/if}
        </div>
        <div class="card-footer bg-white text-center p-0">
          <div class="card-footer-item card-footer-item-bordered">
              {anchor("users/manage/forgot_password", lang('text_forgot_password'), 'class="footer-link"')}
          </div>
        </div>
    </div>
</div>
