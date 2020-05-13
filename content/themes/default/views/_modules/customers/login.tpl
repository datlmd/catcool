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
                    Bằng cách tạo một tài khoản, tôi đồng ý với Pngtree's Điều khoản dịch vụ, Chính sách riêng tư Và Quyền sở hữu trí tuệ
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
                            <label for="remember>
                                {lang('text_login_remember')}
                                {form_checkbox('remember', '1', FALSE, 'id="remember" class="custom-control-input"')}
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <button type="submit" class="site-btn w-100">Login</button>
                    {form_close()}
                    <div class="text-center-line mt-4">Hoặc</div>
                    <div class="text-center">Với mạng xã hội của bạn.</div>
                    <div class="social-list text-center">
                        <a href="javascript:;" rel="nofollow" data-type="fb" class="social-item fb btn">
                            <i class="fa fa-facebook fa-fw"></i> Facebook
                        </a>
                        {*<a href="#" rel="nofollow" data-type="tt" class="social-item twitter btn my-3">*}
                            {*<i class="fa fa-twitter fa-fw"></i> Twitter*}
                        {*</a>*}
                        <a href="javascript:;" rel="nofollow" data-type="gg" class="social-item google btn">
                            <i class="fa fa-google fa-fw"></i> Google
                        </a>
                        <a href="javascript:;" rel="nofollow" data-type="zalo" class="social-item zalo btn my-3">Zalo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
