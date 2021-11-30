<?php class _WeatherCP {
	private $options;

	public function __construct(){
		add_action('admin_menu', array($this, 'leftmenu_init'));
		add_action('admin_init', array($this, 'configpage_hooks'));
	}

	public function leftmenu_init(){
		add_menu_page(
			'WeatherCP',
			'WeatherCP',
			'manage_options',
			'WeatherCP',
			array($this, 'config_page'),
			'dashicons-cloud',
			65
		);
	}
	
	public function configpage_hooks(){
		echo '';
	}
	
	public function config_page(){ ?>
		<div class="wrap">
			<div id="app">
				<h5 class="ml-2">Weather Widgets
					<button class="float-right btn">Novo <i class="fa fa-plus"></i></button>
				</h5>
				<table class="table">
					<thead>
						<tr>
							<th>Name			</th>
							<th>Shortcode	</th>
							<th>Type			</th>
							<th>Demo			</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>My Widget</td>
							<td>[WeatherCP city="{city}"]</td>
							<td>Temperature</td>
							<td><?php echo do_shortcode('[weatherCP-temp]'); ?></td>
						</tr>
					</tbody>
				</table>
				<div style="font-size: 200% !important;">
					<i class="fa fa-sun"></i>
					<i class="fa fa-moon"></i>
					<i class="fa fa-cloud"></i>
					<i class="fa fa-cloud-moon"></i>
					<i class="fa fa-cloud-showers-heavy"></i>
					<i class="fa fa-cloud-sun"></i>
					<i class="fa fa-cloud-rain"></i>
					<i class="fa fa-cloud-moon-rain"></i>
					<i class="fa fa-cloud-sun-rain"></i>
				</div>
			</div>
		</div>
		<style scoped>
			#app {
				font-size: 13px;
			}
			.btn.float-right {
				padding: 5px 14px;
				border-radius: 2px;
				border: 1px solid #999;
				font-size: 13px;
			}
			.wrap {
				padding: 10px;
				margin: 0 2px 0 -15px;
			}
		</style>
	<?php }
}
if (is_admin()) { $_WeatherCP = new _WeatherCP(); }

?>