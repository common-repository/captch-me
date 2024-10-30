<?php
/*
Plugin-Name: Attentive Ads (CaptchMe) C-Banner & C-Billboard widgets
Plugin-URI: http://www.attentiveads.com
Version-du-document: 2.0.1
Author: Attentive Ads
Email: sos@attentiveads.com
Author URI: http://www.attentiveads.com/
Created: 20180326_124200

Copyright (c) 2011-2018 by Attentive Ads
*/
 
class CaptchMe_Cbanner_Widget extends WP_Widget {

	function __construct() {
		load_plugin_textdomain( 'captchme' );
		
		parent::__construct(
			'CaptchMe_Cbanner_Widget',
			__( 'Attentive Ads C-Banner Widget' , 'captchme'),
			array( 'description' => __( 'Display C-Banner ads' , 'captchme') )
		);

		if ( is_active_widget( false, false, $this->id_base ) ) {
			add_action( 'wp_head', array( $this, 'css' ) );
		}
	}

	function css() {
?>

<style type="text/css">
.cbanner {
	width: 300px;
	min-height: 250px;
	max-height: 600px;
	border:0;
	padding:0;
	margin:0;
}
.cbanner.error {
	background: #fff7f7;
	box-sizing:border-box;
	border:1px solid #F92942;
	padding:10px;
}
.cbanner_error {
	width:280px;
	height:230px;
	color: #F92942;
	text-align:center;
	display: table-cell;
  vertical-align: middle;
}
</style>

<?php
	}
	
	function form( $instance ) {
		if ( $instance && isset( $instance['callback_url'] ) ) {
			$callback_url = $instance['callback_url'];
		}
		else {
			$callback_url = __( 'http://api.captchme.net/autopromo/attentiveads-300x250.html' , 'captchme' );
		}
?>

		<p>
		<label for="<?php echo $this->get_field_id( 'callback_url' ); ?>"><?php esc_html_e( 'Callback url:' , 'captchme'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'callback_url' ); ?>" name="<?php echo $this->get_field_name( 'callback_url' ); ?>" type="text" value="<?php echo esc_attr( $callback_url ); ?>" />
		</p>

<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance['callback_url'] = strip_tags( $new_instance['callback_url'] );
		return $instance;
	}
	
	function widget( $args, $instance ) {
		global $captchme_options; 
		
		echo $args['before_widget'];
		
		if ($captchme_options['banner_key'] != "") :
?>

		<div class="cbanner">
			<!-- cbanner -->
			<script type="text/javascript" 
				src="//api.captchme.net/api/script?key=<?php echo $captchme_options['banner_key']; ?>&style=banner">
			</script>
			<script type="text/javascript">
			var BannerOptions = {
			urlCallBack : "<?php echo $instance['callback_url']; ?>", <!-- url de callback -->
			}
			</script>
		</div>

<?php
		endif;
		
		if ($captchme_options['banner_key'] == "") :
?>

		<div class="cbanner error">
			<div class="cbanner_error">
				<?php _e("Please setup your C-Banner key in Wordpress admin panel","captchme"); ?>
			</div>
		</div>

<?php
		endif;
		
		echo $args['after_widget'];
	}
}

class CaptchMe_Cbillboard_Widget extends WP_Widget {

	function __construct() {
		load_plugin_textdomain( 'captchme' );
		
		parent::__construct(
			'CaptchMe_Cbillboard_Widget',
			__( 'Attentive Ads C-Billboard Widget' , 'captchme'),
			array( 'description' => __( 'Display C-Billboard ads' , 'captchme') )
		);

		if ( is_active_widget( false, false, $this->id_base ) ) {
			add_action( 'wp_head', array( $this, 'css' ) );
		}
	}

	function css() {
?>

<style type="text/css">
.cbillboard {
	width: 970px;
	min-height: 90px;
	max-height: 250px;
	border:0;
	padding:0;
	margin:0;
}
.cbillboard.error {
	background: #fff7f7;
	box-sizing:border-box;
	border:1px solid #F92942;
	padding:10px;
}
.cbillboard_error {
	width:950px;
	height:70px;
	color: #F92942;
	text-align:center;
	display: table-cell;
  vertical-align: middle;
}
</style>

<?php
	}

	function form( $instance ) {
		if ( $instance && isset( $instance['callback_url'] ) ) {
			$callback_url = $instance['callback_url'];
		}
		else {
			$callback_url = __( 'http://api.captchme.net/autopromo/attentiveads-970x250.html' , 'captchme' );
		}
?>

		<p>
		<label for="<?php echo $this->get_field_id( 'callback_url' ); ?>"><?php esc_html_e( 'Callback url:' , 'captchme'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'callback_url' ); ?>" name="<?php echo $this->get_field_name( 'callback_url' ); ?>" type="text" value="<?php echo esc_attr( $callback_url ); ?>" />
		</p>

<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance['callback_url'] = strip_tags( $new_instance['callback_url'] );
		return $instance;
	}

	function widget( $args, $instance ) {
		global $captchme_options; 
		
		if ($captchme_options['billboard_key'] != "") :
?>

		<div class="cbillboard">
			<!-- cbillboard -->
			<script type="text/javascript" 
				src="//api.captchme.net/api/script?key=<?php echo $captchme_options['billboard_key']; ?>&style=billboard">
			</script>
			<script type="text/javascript">
			var BillboardOptions = {
			urlCallBack : "<?php echo $instance['callback_url']; ?>", <!-- url de callback -->
			}
			</script>
		</div>

<?php
		endif;
		
		if ($captchme_options['billboard_key'] == "") :
?>

		<div class="cbillboard error">
			<div class="cbillboard_error">
				<?php _e("Please setup your C-Billboard key in Wordpress admin panel","captchme"); ?>
			</div>
		</div>

<?php
		endif;
	}
}

function captchme_register_widgets() {
	register_widget( 'CaptchMe_Cbanner_Widget' );
	register_widget( 'CaptchMe_Cbillboard_Widget' );
}

add_action( 'widgets_init', 'captchme_register_widgets' );