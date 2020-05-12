<!DOCTYPE html>
<html class="{Events::trigger('html_class', 'no-js', 'string')}" lang="{if $lang_abbr}{$lang_abbr}{else}vi{/if}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<base href="{base_url()}">
	<title>{Events::trigger('the_title', $title, 'string')}</title>
	<link rel="icon" href="{base_url('favicon.ico')}">
	{$metadata}

	<!-- StyleSheets -->
	<link rel="stylesheet" href="{css_url('vendor/bootstrap/css/bootstrap.min', 'common')}" type="text/css">
	{$css_files}

</head>
<body class="{Events::trigger('body_class', '', 'string')}">

	{$layout}

	<script src="{js_url('vendor/jquery/jquery-3.4.1.min', 'common')}" type="text/javascript"></script>
	<script src="{js_url('vendor/bootstrap/js/bootstrap.min', 'common')}" type="text/javascript"></script>
	<!-- JavaScripts -->
	{$js_files}

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
