
<section class="register-login pt-5">
    <div class="container">
        <div class="checkout__form">
            <div class="row">
                <div class="col-md-6">
                    <h4>Register</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="checkout__input">
                                <p>Fist Name<span>*</span></p>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="checkout__input">
                                <p>Last Name<span>*</span></p>
                                <input type="text">
                            </div>
                        </div>
                    </div>
                    <div class="checkout__input">
                        <p>Email<span>*</span></p>
                        <input type="text">
                    </div>
                    <div class="checkout__input">
                        <p>Password<span>*</span></p>
                        <input type="text">
                    </div>
                    <div class="checkout__input">
                        <p>Repeat Password<span>*</span></p>
                        <input type="text">
                    </div>
                    <button type="submit" class="site-btn w-100">Register</button>
                </div>
                <div class="col-md-6 mb-0 mb-sm-5">
                    <h4>Login</h4>
                    {if !empty($errors)}
                        {include file=get_theme_path('views/inc/alert.tpl') message=$errors type='danger'}
                    {/if}
                    {form_open(uri_string())}
                        <div class="checkout__input">
                            <p>Email Address<span>*</span></p>
                            <input type="text" name="username" value="" id="username" placeholder="{lang('text_username')}" class="form-control form-control-lg" autocomplete="off">
                        </div>
                        <div class="checkout__input">
                            <p>Password<span>*</span></p>
                            <input type="password" name="password" value="" id="password" placeholder="{lang('text_password')}" class="form-control form-control-lg">
                        </div>
                        <div class="checkout__input__checkbox">

                            {form_checkbox('remember', '1', FALSE, 'id="remember" class="custom-control-input"')}
                            <label for="remember>
                                {lang('text_login_remember')}
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <button type="submit" class="site-btn w-100">Login</button>
                    {form_close()}
                    <div class="login-social my-3">
                        <a href="{$auth_url}" class="fb btn w-100">
                            <i class="fa fa-facebook fa-fw"></i> Login with Facebook
                        </a>
                        <a href="#" class="twitter btn w-100 my-3">
                            <i class="fa fa-twitter fa-fw"></i> Login with Twitter
                        </a>
                        <a href="#" class="google btn w-100">
                            <i class="fa fa-google fa-fw"></i> Login with Google+
                        </a>
                        <a href="{$zalo_auth_url}" class="zalo btn w-100 my-3">
                            <i class="fa fa-twitter fa-fw"></i> Login with Zalo
                        </a>
                    </div>
                    {if !empty($auth_url)}
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
            </div>
        </div>
    </div>
</section>
