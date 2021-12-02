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
				<h5 class="ml-2">Weather Widgets </h5>
				<table class="table">
					<thead>
						<tr>
							<th>Shortcode	</th>
							<th>City			</th>
							<th>Unit			</th>
							<th>Retorno		</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>[weatherCP city="{city}" unit="{unit}"]</td>
							<td>aracaju</td>
							<td>temp	</td>
							<td><?php echo do_shortcode('[weatherCP]'); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<style scoped>
			#app {
				font-size: 12px;
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