<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This class is here to demonstrate the use of 
 * Events library with Theme library.
 */
class Theme_class
{
	public function __construct()
	{
		/**
		 * With this event registered, theme can independently enqueue
		 * all needed StyleSheets without adding them in controllers.
		 */
		Events::register('enqueue_styles', array($this, 'styles'));

		/**
		 * With this event registered, theme can independently enqueue
		 * all needed JS files without adding them in controllers.
		 */
		Events::register('enqueue_scripts', array($this, 'scripts'));

		/**
		 * With this event registered, theme can independently enqueue
		 * all needed meta tags without adding them in controllers.
		 */
		Events::register('enqueue_metadata', array($this, 'metadata'));

		// Manipulating <html> class.
		Events::register('html_class', array($this, 'html_class'));

		// Manipulating <body> class.
		Events::register('body_class', array($this, 'body_class'));
	}


    public function styles()
    {

        add_style('assets/css/font-awesome.min');
        add_style('assets/css/elegant-icons');
        add_style('assets/css/nice-select');
        add_style('assets/css/jquery-ui.min');
        add_style('assets/css/owl.carousel.min');
        add_style('assets/css/slicknav.min');
        add_style('assets/css/style');

    }


    public function scripts()
    {
        prepend_script('assets/js/main');
        prepend_script('assets/js/owl.carousel.min');
        prepend_script('assets/js/mixitup.min');
        prepend_script('assets/js/jquery.slicknav');
        prepend_script('assets/js/jquery-ui.min');
        prepend_script('assets/js/jquery.nice-select.min');
	}


	public function metadata()
	{
		add_meta('generator', 'Cat Cool CMS');
		add_meta('author', 'Dat Le');
		add_meta('author', 'https://github.com/bkader', 'rel');

		// Let's add some extra tags.
		add_meta('twitter:card', 'summary');
		add_meta('twitter:site', '@KaderBouyakoub');
		add_meta('twitter:creator', '@KaderBouyakoub');
		add_meta('og:url', current_url());
		add_meta('og:title', 'Cat Cool CMS');
		add_meta('og:description', 'Thiet ke web');
		add_meta('og:image', get_theme_url('screenshot.png'));

		// And why not more!
		//add_meta('manifest', base_url('site.webmanifest'), 'rel');
		add_meta('apple-touch-icon', base_url('icon.png'), 'rel');
	}

	// ------------------------------------------------------------------------


	public function html_class($class)
	{
		// You can add class for a specific module!
		// if (is_module('module_name')) {}
		// if (is_module('mod_1, mod_2'))

		// Or set class for a specific controller.
		if (is_controller('example'))
		{
			return '';
		}

		if (is_controller('admin'))
		{
			return '';
		}

		// You can as well set if for a specific method.
		// if (is_method(...)) {}

		// And you can chain all.
		// if (is_controller('example') && is_method('index')) {}

		return $class;
	}

	// ------------------------------------------------------------------------

	/**
	 * Manipulating <body> class.
	 * @access 	public
	 * @param 	string 	$class
	 * @return 	string
	 */
	public function body_class($class)
	{
		return '';
	}

}

// Always instantiate the class so trigger get registered.
$theme_class = new Theme_class;

// ------------------------------------------------------------------------

if ( ! function_exists('bs_alert'))
{
	function bs_alert($message = '', $type = 'info')
	{
		if (empty($message))
		{
			return;
		}

		// Turn 'error' into 'danger' because it does not exist on bootstrap.
		$type == 'error' && $type = 'danger';

		$alert =<<<END
<div class="alert alert-{type}">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	{message}
</div>
END;
		return str_replace(
			array('{type}', '{message}'),
			array($type, $message),
			$alert
		);
	}
}
