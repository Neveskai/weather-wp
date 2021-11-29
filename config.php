<?php class NLExt {
	private $options;

	public function __construct(){
		add_action('admin_menu', array($this, 'leftmenu_init'));
		add_action('admin_init', array($this, 'configpage_hooks'));
	}

	public function leftmenu_init(){
		add_menu_page(
			'Contas Nomeadas',
			'Contas Nomeadas',
			'manage_options',
			'NAcc',
			array($this, 'config_page'),
			'dashicons-screenoptions',
			65
		);
	}
	
	public function configpage_hooks(){
		wp_enqueue_script('lodash.js'				, '/wp-content/plugins/NamedAcc/dist/lodash/lodash.js'	 , array(), null, false);
		wp_enqueue_script('vue.js'	  				, '/wp-content/plugins/NamedAcc/dist/vue/vue.js'			 , array(), null, false);
		wp_enqueue_script('vue-router.js'	 	, '/wp-content/plugins/NamedAcc/dist/vue/vue-router.js'	 , array(), null, false);
		wp_enqueue_script('vue-http-loader.js' , '/wp-content/plugins/NamedAcc/dist/vue/httpVueLoader.js', array(), null, false);
		wp_enqueue_script('dirs.js'				, '/wp-content/plugins/NamedAcc/src/dirs.js'					 , array(), null, false);
		
		wp_enqueue_script('jquery.js' 			, '/wp-content/plugins/NamedAcc/dist/bootstrap4/jquery3.js'				, array(), null, false);
		wp_enqueue_script('bootstrap4.js'		, '/wp-content/plugins/NamedAcc/dist/bootstrap4/js/bootstrap.js'		, array(), null, false);
		wp_enqueue_style('bootstrap4.css'		, '/wp-content/plugins/NamedAcc/dist/bootstrap4/css/bootstrap.css'	, array(), null, false);
		wp_enqueue_script('general.js' 			, '/wp-content/plugins/NamedAcc/dist/self-repository/js/general.js'	, array(), null, false);
		wp_enqueue_style('general.css'			, '/wp-content/plugins/NamedAcc/dist/self-repository/css/general.css', array(), null, false);
	}
	
	public function config_page(){
		?><div class="wrap" style="padding: 0; margin: 0 2px 0 -16px;">
			<script language="javascript" type="module" src="/wp-content/plugins/NamedAcc/src/routes.js"></script>
			<div id="app"></div>
		</div><?php 
	}

}
if (is_admin()) { $nlext = new NLExt(); }

?>