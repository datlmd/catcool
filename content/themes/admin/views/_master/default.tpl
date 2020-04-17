<!doctype html>
<html class="{Events::trigger('html_class', 'no-js', 'string')}" dir="{lang('direction')}" lang="{lang('code')}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <base href="{base_url()}">
        <title>{Events::trigger('the_title', $title, 'string')}</title>

        {$metadata}

        <!-- StyleSheets -->
        {$css_files}

        <!--[if lt IE 9]>
        {js('html5shiv-3.7.3.min', 'https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js', null, 'common')}
        {js('respond-1.4.2.min', 'https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js', null, 'common')}
        <![endif]-->

        <script>{script_global()}</script>
    </head>
    <body class="{Events::trigger('body_class', '', 'string')}">
        <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

        {$layout}

        <script src="{js_url('vendor/jquery/jquery-3.4.1.min', 'common')}" type="text/javascript"></script>
        <script src="{js_url('vendor/bootstrap/js/popper.min', 'common')}" type="text/javascript"></script>
        <script src="{js_url('vendor/bootstrap/js/bootstrap.min', 'common')}" type="text/javascript"></script>
        {*<script src="{js_url('vendor/bootstrap/js/bootstrap.bundle', 'common')}" type="text/javascript"></script>*}
        {$js_files}
        <script src="{{js_url('alert.min', 'common')}}"></script>

        {if (config_item('ga_enabled') && (! empty(config_item('ga_siteid')) && config_item('ga_siteid') != 'UA-XXXXX-Y'))}
            {literal}
            <!-- Google Analytics-->
            <script>
                window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
                ga('create','{{config_item('ga_siteid')}}','auto');ga('send','pageview')
            </script>
            <script src="https://www.google-analytics.com/analytics.js" async defer></script>
            {/literal}
        {/if}

    </body>
</html>
