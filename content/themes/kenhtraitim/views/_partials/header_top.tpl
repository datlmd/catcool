{literal}
<header id="header" data-plugin-options="{'stickyEnabled': true, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': true, 'stickyStartAt': 122, 'stickySetTop': '-122px', 'stickyChangeLogo': false}">
{/literal}
    <div class="header-body border-color-primary border-top-0 box-shadow-none">
        <div class="header-container container z-index-2" style="min-height: 122px;">
            <div class="header-row">
                <div class="header-column">
                    <div class="header-row">
                        <h1 class="header-logo">
                            <a href="index.html">
                                <img alt="Porto" width="255" height="48" src="{img_url('assets/img/logo.png')}">
                                <span class="hide-text">Porto - Demo Blog 5</span>
                            </a>
                        </h1>
                    </div>
                </div>
                <div class="header-column justify-content-end">
                    <div class="header-row h-100">
                        <a href="http://themeforest.net/item/porto-responsive-html5-template/4106987" target="_blank" class="py-3 d-block">
                            <img alt="Porto" class="img-fluid pl-3" src="{img_url('assets/img/blog/blog-ad-2.jpg')}" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-nav-bar bg-primary">
            <div class="container">
                <div class="header-row p-relative">
                    <div class="header-column">
                        <div class="header-row">
                            <div class="header-colum order-2 order-lg-1">
                                <div class="header-row">
                                    <div class="header-nav header-nav-stripe header-nav-divisor header-nav-force-light-text justify-content-start">
                                        <div class="header-nav-main header-nav-main-square header-nav-main-effect-1 header-nav-main-sub-effect-1">
                                            <nav class="collapse">
                                                {assign var="menu_main" value=get_menu_by_position()}
                                                <ul class="nav nav-pills" id="mainNav">
                                                    {if !empty($menu_main)}
                                                        {foreach $menu_main as $key => $item}
                                                            <li class="dropdown">
                                                                <a class="dropdown-item dropdown-toggle" href="{base_url({$item.detail.slug})}">
                                                                    {$item.detail.name}
                                                                </a>
                                                                {if $item.subs}
                                                                    <ul class="dropdown-menu">
                                                                        {foreach $item.subs as $sub}
                                                                            <li>
                                                                                <a class="dropdown-item" href="{base_url({$sub.detail.slug})}">
                                                                                    {$sub.detail.name}
                                                                                </a>
                                                                            </li>
                                                                        {/foreach}
                                                                    </ul>
                                                                {/if}
                                                            </li>
                                                        {/foreach}
                                                    {/if}
                                                </ul>
                                            </nav>
                                        </div>
                                        <button class="btn header-btn-collapse-nav" data-toggle="collapse" data-target=".header-nav-main nav">
                                            <i class="fas fa-bars"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="header-column order-1 order-lg-2">
                                <div class="header-row justify-content-end">
                                    <div class="header-nav-features header-nav-features-no-border w-75 w-auto-mobile d-none d-sm-flex">
                                        <form role="search" class="d-flex w-100" action="page-search-results.html" method="get">
                                            <div class="simple-search input-group w-100">
                                                <input class="form-control border-0 text-1" id="headerSearch" name="q" type="search" value="" placeholder="Search...">
                                                <span class="input-group-append bg-light border-0">
                                                    <button class="btn" type="submit">
                                                        <i class="fa fa-search header-nav-top-icon"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
