<?php
/*
Plugin-Name: Attentive Ads (CaptchMe) admin options
Plugin-URI: http://www.attentiveads.com
Version-du-document: 2.0.1
Author: Attentive Ads
Email: sos@attentiveads.com
Author URI: http://www.attentiveads.com/
Created: 20180326_124200

Copyright (c) 2011-2018 by Attentive Ads
*/

/* ----------------------------------------------------------------------------------------
* Registering settings methods
* --------------------------------------------------------------------------------------*/

// Add options page in settings menu
function captchme_add_options_menu() {
	add_options_page('Attentive Ads (CaptchMe) | Options', 'Attentive Ads (CaptchMe)', 'manage_options', 'captchme_options_menu', 'captchme_build_options_panel');
}

// Build options page
function captchme_build_options_panel () {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.','captchme') );
	}
	?>
	<script type="text/javascript">
		var uvOptions = {};
		(function() {
			var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
			uv.src = '<?php echo plugins_url("js/4XedFoWFflCyNL7vcgyaew.js", __FILE__); ?>';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
		})();

		var compteur_gegene = 0;

		document.addEventListener('DOMContentLoaded',function() {
			var inputs = document.querySelectorAll('input[name^=captchme_options]');
			for (i = 0; i < inputs.length; i++) {
				inputs[i].onchange=changeEventHandler;
			}
			inputs = document.querySelectorAll('select[name^=captchme_options]');
			for (i = 0; i < inputs.length; i++) {
				inputs[i].onchange=changeEventHandler;
			}
		},false);
		function changeEventHandler(event) {
			compteur_gegene++;
		}
		window.onbeforeunload = function (e) {
			if (compteur_gegene > 0) return confirm("You have unsaved modifiations - Vous avez des modifications non sauvegardées");
		}
	</script>
	<style>
		.form-table th {
			padding: 15px 10px 15px 0;
		}
		.form-table td {
			padding: 10px 10px;
		}
		input[type='checkbox'] {
			margin-left:2px;
		}
		select {
			box-sizing:border-box;
		}
		h1.captchme_format {
			width:100%;
			box-sizing:border-box;
			padding:8px 8px 10px 15px;
			margin:48px 0 12px 0;
			background-color:#35a3ba;
			color:#fff;
			border-radius: 2px;
			box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
		}
		.goto_format { display:inline-block;width:22%; }
		.nav-tab-wrapper img { width:120px;height:66px; }
		.nav-tab-wrapper img.aapanel { width:42px;height:34px;margin:6px 39px; }
		.goto_format_row { width:90%;margin:0 auto;text-align:center;padding-top:12px; }
		.goto_format_row2 { padding-top:24px; }
	</style>

	<div class="wrap">
		<style type="text/css">.form-table th { width: 205px; } /* evite le retour à la ligne avant les : */</style>
		<div id="captchme_header" style="width:100%;padding:5px 0 0 0;margin:20px 0;background-color:#35a3ba;border-radius: 2px;box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);">
			<img src='<?php echo plugins_url( 'images/attentiveads.png', __FILE__ ); ?>' width="auto" height="80" alt="Attentive Ads"/>
		</div>
		<div id="icon-plugins" class="icon32"></div>
		<h2><?php _e("Attentive Ads (CaptchMe) Options","captchme") ?></h2>
		<p><?php _e("CaptchMe by Attentive Ads offers a monetized spam blocking solution.",'captchme') ?></p>
		<p><?php _e("But Attentive Ads is not only a captcha solution. It's 8 different monetization formats, all compatible with Wordpress. Optimize the monetization of your audience with our respectful advertising formats: monetize & secure comments and registrations with CaptchMe publicaptchas, monetize access to content you want to enhance with the AccessMe format, monetize all your pages with our classic formats.",'captchme') ?> <a href="//www.attentiveads.com/demos/" target="_blank"><?php _e("Discover our other formats.",'captchme') ?></a></p>
		<p style="margin-bottom:36px;"><?php _e("For details, visit the ",'captchme') ?><a href="//www.attentiveads.com/" target="_blank"><?php _e("Attentive Ads website",'captchme') ?></a>.</p>
		<p style="margin-bottom:36px;"><?php _e("Manage your formats:",'captchme') ?></p>

		<?php
		if( isset( $_GET[ 'tab' ] ) ) {
			$active_tab = $_GET[ 'tab' ];
		}
		?>

		<form method="post" action="options.php<?php if (isset($active_tab)) { echo "?tab=".$active_tab; }; ?>" onsubmit="compteur_gegene=0;">

			<h2 class="nav-tab-wrapper">
				<a href="?page=captchme_options_menu&tab=captchme" class="nav-tab <?php echo $active_tab == 'captchme' ? 'nav-tab-active' : ''; ?>">CAPTCH ME<br><img src="//api.captchme.net/images/wordpress/captchme.gif" /></a>
				<a href="?page=captchme_options_menu&tab=accessme" class="nav-tab <?php echo $active_tab == 'accessme' ? 'nav-tab-active' : ''; ?>">ACCESS ME<br><img src="//api.captchme.net/images/wordpress/accessme.gif" /></a>
				<a href="?page=captchme_options_menu&tab=showme" class="nav-tab <?php echo $active_tab == 'showme' ? 'nav-tab-active' : ''; ?>">SHOW ME<br><img src="//api.captchme.net/images/wordpress/showme.gif" /></a>
				<a href="?page=captchme_options_menu&tab=leaveme" class="nav-tab <?php echo $active_tab == 'leaveme' ? 'nav-tab-active' : ''; ?>">LEAVE ME<br><img src="//api.captchme.net/images/wordpress/leaveme.gif" /></a>
				<a href="?page=captchme_options_menu&tab=cskin" class="nav-tab <?php echo $active_tab == 'cskin' ? 'nav-tab-active' : ''; ?>">C-SKIN<br><img src="//api.captchme.net/images/wordpress/skin.gif" /></a>
				<a href="?page=captchme_options_menu&tab=cfloorad" class="nav-tab <?php echo $active_tab == 'cfloorad' ? 'nav-tab-active' : ''; ?>">C-FLOORAD<br><img src="//api.captchme.net/images/wordpress/floorad.gif" /></a>
				<a href="?page=captchme_options_menu&tab=cbillboard" class="nav-tab <?php echo $active_tab == 'cbillboard' ? 'nav-tab-active' : ''; ?>">C-BILLBOARD<br><img src="//api.captchme.net/images/wordpress/billboard.gif" /></a>
				<a href="?page=captchme_options_menu&tab=cbanner" class="nav-tab <?php echo $active_tab == 'cbanner' ? 'nav-tab-active' : ''; ?>">C-BANNER<br><img src="//api.captchme.net/images/wordpress/banner.gif" /></a>
				<a href="http://portal.captchme.net/publisher/" target="_blank" class="nav-tab <?php echo $active_tab == 'formats' ? 'nav-tab-active' : ''; ?>"><?php _e("My account",'captchme') ?><br><img src="//api.captchme.net/images/wordpress/panel.jpg" /></a>
			</h2>

			<?php if ($active_tab == "") : ?>
			<div>
				<p>&nbsp;</p>
				<p><?php _e("(please choose the format to setup)",'captchme') ?></p>
			</div>
			<?php endif ?>

			<?php settings_fields('captchme_options'); ?>
			<?php do_settings_sections(__FILE__); ?>

			<?php if ( ($active_tab == 'captchme') || ($active_tab == 'showme') || ($active_tab == 'leaveme') || ($active_tab == 'accessme') || ($active_tab == 'cskin') || ($active_tab == 'cfloorad') || ($active_tab == 'cbillboard') || ($active_tab == 'cbanner') ) : ?>
			<div class="submit" style="margin-top:24px;">
				<input type="submit" class="button-primary" value="<?php _e("Save changes","captchme"); ?>" />
			</div>
			<?php endif ?>
		</form>
		<p class="copyright" style="margin-top:72px;">&copy; Copyright 2011-<?php echo date('Y'); ?>&nbsp;&nbsp;<a href="//www.attentiveads.com" target="_blank">Attentive Ads SAS</a>.</p>
	</div>
	<?php
}

// Register settings
function register_captchme_settings() {
	if( isset( $_GET[ 'tab' ] ) ) {
		$active_tab = $_GET[ 'tab' ];
	} // end if
	register_setting('captchme_options', 'captchme_options', 'captchme_validate_settings');
	if( $active_tab == 'captchme' ) {
		// captchme format title
		add_settings_section('captchme-titlecaptchme-section', '', 'captchme_titlecaptchme_section', __FILE__);
		// captchme settings section
		add_settings_section('captchme-section-captchme-misc', __('General Settings','captchme'), 'captchme_captchme_general_section', __FILE__);
		// Comment settings section
		add_settings_section('captchme-section-captchme-comment', __('Comments Activation','captchme'), 'captchme_captchme_comment_section', __FILE__);
		// Registration settings section
		add_settings_section('captchme-section-captchme-registration', __('Registration Activation','captchme'), 'captchme_captchme_registration_section', __FILE__);
		// Login settings section
		add_settings_section('captchme-section-captchme-login', __('Login Activation','captchme'), 'captchme_captchme_login_section', __FILE__);
		// captchme contact form 7
		add_settings_section('captchme-form7captchme-section', '', 'captchme_contact_form_7_settings', __FILE__);
	}
	if( $active_tab == 'showme' ) {
		// showme format title
		add_settings_section('captchme-titleshowme-section', '', 'captchme_titleshowme_section', __FILE__);
		// ShowMe settings section
		add_settings_section('captchme-section-showme', __('General Settings & Activation','captchme'), 'captchme_showme_section', __FILE__);
	}
	if( $active_tab == 'leaveme' ) {
		// leaveme format title
		add_settings_section('captchme-titleleaveme-section', '', 'captchme_titleleaveme_section', __FILE__);
		// LeaveMe settings section
		add_settings_section('captchme-section-leaveme', __('General Settings & Activation','captchme'), 'captchme_leaveme_section', __FILE__);
	}
	if( $active_tab == 'accessme' ) {
		// AccessMe format title
		add_settings_section('captchme-titleaccessme-section', '', 'captchme_titleaccessme_section', __FILE__);
		// AccessMe settings section
		add_settings_section('captchme-section-accessme', __('General Settings & Activation','captchme'), 'captchme_accessme_section', __FILE__);
		// AccessMe code generator
		add_settings_section('captchme-section-accessmegen', '', 'captchme_accessme_settings', __FILE__);
	}
	if( $active_tab == 'cskin' ) {
		// C-Skin format title
		add_settings_section('captchme-titlecskin-section', '', 'captchme_titlecskin_section', __FILE__);
		// C-Skin settings section
		add_settings_section('captchme-section-skin', __('General Settings & Activation','captchme'), 'captchme_skin_section', __FILE__);
	}
	if( $active_tab == 'cfloorad' ) {
		// C-Floorad format title
		add_settings_section('captchme-titlecfloorad-section', '', 'captchme_titlecfloorad_section', __FILE__);
		// C-Floorad settings section
		add_settings_section('captchme-section-floorad', __('General Settings & Activation','captchme'), 'captchme_floorad_section', __FILE__);
	}
	if($active_tab == 'cbanner' ) {
		// C-Banner format title
		add_settings_section('captchme-titlecbanner-section', '', 'captchme_titlecbanner_section', __FILE__);
		// C-Banner settings section
		add_settings_section('captchme-section-banner', __('General Settings & Activation','captchme'), 'captchme_banner_section', __FILE__);
	}
	if($active_tab == 'cbillboard' ) {
		// C-billboard format title
		add_settings_section('captchme-titlecbillboard-section', '', 'captchme_titlecbillboard_section', __FILE__);
		// C-billboard settings section
		add_settings_section('captchme-section-billboard', __('General Settings & Activation','captchme'), 'captchme_billboard_section', __FILE__);
	}
}

// sections for add title
function captchme_titlecaptchme_section() {
	echo '<h1 class="captchme_format" id="captchme">';
	_e("CaptchMe Format","captchme");
	echo '</h1>';
	echo "<div style='margin:0 0 34px 1px;'><a href='//www.attentiveads.com/demos/format-captchme.html' target='_blank'>Demo CaptchMe</a>";
	echo " / ";
	echo "<a href='//portal.captchme.net/publisher' target='_blank'>" . __('Get your keys', 'captchme') . "</a></div>";
}
function captchme_titleshowme_section() {
	echo '<h1 class="captchme_format" id="showme">';
	_e("ShowMe Format","captchme");
	echo '</h1>';
	echo "<div style='margin:0 0 34px 1px;'><a href='//www.attentiveads.com/demos/format-showme.html' target='_blank'>Demo ShowMe</a>";
	echo " / ";
	echo "<a href='//portal.captchme.net/publisher' target='_blank'>" . __('Get your keys', 'captchme') . "</a></div>";
}
function captchme_titleleaveme_section() {
	echo '<h1 class="captchme_format" id="leaveme">';
	_e("LeaveMe Format","captchme");
	echo '</h1>';
	echo "<div style='margin:0 0 34px 1px;'><a href='//www.attentiveads.com/demos/format-leaveme.html' target='_blank'>Demo LeaveMe</a>";
	echo " / ";
	echo "<a href='//portal.captchme.net/publisher' target='_blank'>" . __('Get your keys', 'captchme') . "</a></div>";
}
function captchme_titleaccessme_section() {
	echo '<h1 class="captchme_format" id="accessme">';
	_e("AccessMe Format","captchme");
	echo '</h1>';
	echo "<div style='margin:0 0 34px 1px;'><a href='//www.attentiveads.com/demos/format-accessme.html' target='_blank'>Demo AccessMe</a>";
	echo " / ";
	echo "<a href='//portal.captchme.net/publisher' target='_blank'>" . __('Get your keys', 'captchme') . "</a></div>";
}
function captchme_titlecskin_section() {
	echo '<h1 class="captchme_format" id="cskin">';
	_e("C-Skin Format","captchme");
	echo '</h1>';
	echo "<div style='margin:0 0 34px 1px;'><a href='//www.attentiveads.com/demos/format-c-skin.html' target='_blank'>Demo C-Skin</a>";
	echo " / ";
	echo "<a href='//portal.captchme.net/publisher' target='_blank'>" . __('Get your keys', 'captchme') . "</a> ";
	_e("(you need a special public key for C-Skin, please create a new universe in your Publisher Selfcare)","captchme");
	echo "</div>";
}
function captchme_titlecfloorad_section() {
	echo '<h1 class="captchme_format" id="cfloorad">';
	_e("C-Floorad Format","captchme");
	echo '</h1>';
	echo "<div style='margin:0 0 34px 1px;'><a href='//www.attentiveads.com/demos/format-c-floorad.html' target='_blank'>Demo C-Floorad</a>";
	echo " / ";
	echo "<a href='//portal.captchme.net/publisher' target='_blank'>" . __('Get your keys', 'captchme') . "</a> ";
	_e("(you need a special public key for C-Floorad, please create a new universe in your Publisher Selfcare)","captchme");
	echo "</div>";
}
function captchme_titlecbanner_section() {
	echo '<h1 class="captchme_format" id="cbanner">';
	_e("C-Banner Format","captchme");
	echo '</h1>';
	echo "<div style='margin:0 0 34px 1px;'><a href='//www.attentiveads.com/demos/format-c-banner.html' target='_blank'>Demo C-Banner</a>";
	echo " / ";
	echo "<a href='//portal.captchme.net/publisher' target='_blank'>" . __('Get your keys', 'captchme') . "</a> ";
	_e("(you need a special public key for C-Banner, please create a new universe in your Publisher Selfcare)","captchme");
	echo "</div>";
}
function captchme_titlecbillboard_section() {
	echo '<h1 class="captchme_format" id="cbillboard">';
	_e("C-Billboard Format","captchme");
	echo '</h1>';
	echo "<div style='margin:0 0 34px 1px;'><a href='//www.attentiveads.com/demos/format-c-billboard.html' target='_blank'>Demo C-Billboard</a>";
	echo " / ";
	echo "<a href='//portal.captchme.net/publisher' target='_blank'>" . __('Get your keys', 'captchme') . "</a> ";
	_e("(you need a special public key for C-Billboard, please create a new universe in your Publisher Selfcare)","captchme");
	echo "</div>";
}

// Register general settings section
function captchme_captchme_general_section() {
	add_settings_field('captchme_public_key', __('Public Key:','captchme'), 'captchme_add_captchme_public_key', __FILE__, 'captchme-section-captchme-misc');
	add_settings_field('captchme_private_key', __('Private Key:','captchme'), 'captchme_add_captchme_private_key', __FILE__, 'captchme-section-captchme-misc');
	add_settings_field('captchme_authent_key', __('Authentication Key:','captchme'), 'captchme_add_captchme_authent_key', __FILE__, 'captchme-section-captchme-misc');
	add_settings_field('lang', __('Language:','captchme'), 'captchme_add_language', __FILE__, 'captchme-section-captchme-misc');
	add_settings_field('title', __('Title:','captchme'), 'captchme_add_title', __FILE__, 'captchme-section-captchme-misc');
	add_settings_field('instruction', __('Instruction:','captchme'), 'captchme_add_instruction', __FILE__, 'captchme-section-captchme-misc');
	add_settings_field('ssl', __('SSL:','captchme'), 'captchme_add_ssl', __FILE__, 'captchme-section-captchme-misc');
	add_settings_field('adb', __('Adblock Detection:','captchme'), 'captchme_add_adb', __FILE__, 'captchme-section-captchme-misc');
}

// Register comment settings section
function captchme_captchme_comment_section() {
	add_settings_field('comment_enable', __('Activate CaptchMe on comments:','captchme'), 'captchme_add_comment_enable', __FILE__, 'captchme-section-captchme-comment');
	add_settings_field('comment_spam_delete', __('Automatically delete spam comments:','captchme'), 'captchme_add_comment_spam_delete', __FILE__, 'captchme-section-captchme-comment');
	add_settings_field('comment_tabindex', __('Tabindex:','captchme'), 'captchme_add_comment_tabindex', __FILE__, 'captchme-section-captchme-comment');
}

// Register registration settings section
function captchme_captchme_registration_section() {
	add_settings_field('registration_enable', __('Activate CaptchMe on registration form:','captchme'), 'captchme_add_registration_enable', __FILE__, 'captchme-section-captchme-registration');
	add_settings_field('registration_spam_delete', __('Automatically delete spam registration:','captchme'), 'captchme_add_registration_spam_delete', __FILE__, 'captchme-section-captchme-registration');
	add_settings_field('registration_tabindex', __('Tabindex:','captchme'), 'captchme_add_registration_tabindex', __FILE__, 'captchme-section-captchme-registration');
}

// Register login settings section
function captchme_captchme_login_section() {
	add_settings_field('login_enable', __('Activate CaptchMe on login form:','captchme'), 'captchme_add_login_enable', __FILE__, 'captchme-section-captchme-login');
	add_settings_field('login_tabindex', __('Tabindex:','captchme'), 'captchme_add_login_tabindex', __FILE__, 'captchme-section-captchme-login');
}

// Register accessme settings section
function captchme_accessme_section() {
	add_settings_field('accessme_key', __('Public key for AccessMe:','captchme'), 'captchme_add_accessme_key', __FILE__, 'captchme-section-accessme');
	add_settings_field('accessme_enable', __('Activate AccessMe:','captchme'), 'captchme_add_accessme_enable', __FILE__, 'captchme-section-accessme');
}

// Register showme settings section
function captchme_showme_section() {
	add_settings_field('showme_key', __('Public Key for ShowMe:','captchme'), 'captchme_add_showme_key', __FILE__, 'captchme-section-showme');
	add_settings_field('showme_enable', __('Activate ShowMe:','captchme'), 'captchme_add_showme_enable', __FILE__, 'captchme-section-showme');
	add_settings_field('showme_position', __('Position:','captchme'), 'captchme_add_showme_position', __FILE__, 'captchme-section-showme');
}

// Register leave settings section
function captchme_leaveme_section() {
	add_settings_field('leaveme_key', __('Public Key for LeaveMe:','captchme'), 'captchme_add_leaveme_key', __FILE__, 'captchme-section-leaveme');
	add_settings_field('leaveme_enable', __('Activate LeaveMe:','captchme'), 'captchme_add_leaveme_enable', __FILE__, 'captchme-section-leaveme');
	add_settings_field('leaveme_message', __('Message:','captchme'), 'captchme_add_leaveme_message', __FILE__, 'captchme-section-leaveme');
}

// Register C-Skin settings section
function captchme_skin_section() {
	add_settings_field('skin_key', __('Public key for C-Skin:','captchme'), 'captchme_add_skin_key', __FILE__, 'captchme-section-skin');
	add_settings_field('skin_enable', __('Activate C-Skin:','captchme'), 'captchme_add_skin_enable', __FILE__, 'captchme-section-skin');
}

// Register C-Floorad settings section
function captchme_floorad_section() {
	add_settings_field('floorad_key', __('Public key for C-Floorad:','captchme'), 'captchme_add_floorad_key', __FILE__, 'captchme-section-floorad');
	add_settings_field('floorad_enable', __('Activate C-Floorad:','captchme'), 'captchme_add_floorad_enable', __FILE__, 'captchme-section-floorad');
}

// Register C-Banner settings section
function captchme_banner_section() {
	add_settings_field('banner_key', __('Public key for C-Banner:','captchme'), 'captchme_add_banner_key', __FILE__, 'captchme-section-banner');
	add_settings_field('banner_enable', __('Activate C-Banner:','captchme'), 'captchme_add_banner_enable', __FILE__, 'captchme-section-banner');
}

// Register C-Billboard settings section
function captchme_billboard_section() {
	add_settings_field('billboard_key', __('Public key for C-Billboard:','captchme'), 'captchme_add_billboard_key', __FILE__, 'captchme-section-billboard');
	add_settings_field('billboard_enable', __('Activate C-Billboard:','captchme'), 'captchme_add_billboard_enable', __FILE__, 'captchme-section-billboard');
}


function captchme_validate_settings($options) {
	if( isset( $_GET[ 'tab' ] ) ) {
		$active_tab = $_GET[ 'tab' ];
	} // end if
	$new_options = default_captchme_options();

	//$old_options = get_option('captchme_options');

	/*if isset($options['captchme_public_key']) {
	echo $options['showme_key'];
	} else if isset() {
	echo "old if exists";
	} else {
	echo "default";
	} */

	if( $active_tab == 'captchme' ) {
		$new_options['captchme_public_key'] = sanitize_text_field(trim($options['captchme_public_key']));
		$new_options['captchme_private_key'] = sanitize_text_field(trim($options['captchme_private_key']));
		$new_options['captchme_authent_key'] = sanitize_text_field(trim($options['captchme_authent_key']));
		$new_options['lang'] = sanitize_text_field(trim($options['lang']));
		$new_options['title'] = sanitize_text_field(trim($options['title']));
		$new_options['instruction'] = sanitize_text_field(trim($options['instruction']));
		$new_options['ssl'] = sanitize_text_field(trim($options['ssl']));
		$new_options['adb'] = sanitize_text_field(trim($options['adb']));
		$new_options['comment_enable'] = sanitize_text_field(trim($options['comment_enable']));
		$new_options['comment_spam_delete'] = sanitize_text_field(trim($options['comment_spam_delete']));
		$new_options['comment_tabindex'] = sanitize_text_field(trim($options['comment_tabindex']));
		$new_options['registration_enable'] = sanitize_text_field(trim($options['registration_enable']));
		$new_options['registration_spam_delete'] = sanitize_text_field(trim($options['registration_spam_delete']));
		$new_options['registration_tabindex'] = sanitize_text_field(trim($options['registration_tabindex']));
		$new_options['login_enable'] = sanitize_text_field(trim($options['login_enable']));
		$new_options['login_tabindex'] = sanitize_text_field(trim($options['login_tabindex']));

		$old_options = get_option('captchme_options');

		$new_options['accessme_key'] = $old_options['accessme_key'];
		$new_options['accessme_enable'] = $old_options['accessme_enable'];
		$new_options['showme_key'] = $old_options['showme_key'];
		$new_options['showme_enable'] = $old_options['showme_enable'];
		$new_options['showme_position'] = $old_options['showme_position'];
		$new_options['leaveme_key'] = $old_options['leaveme_key'];
		$new_options['leaveme_enable'] = $old_options['leaveme_enable'];
		$new_options['leaveme_message'] = $old_options['leaveme_message'];
		$new_options['skin_key'] = $old_options['skin_key'];
		$new_options['skin_enable'] = $old_options['skin_enable'];
		$new_options['floorad_key'] = $old_options['floorad_key'];
		$new_options['floorad_enable'] = $old_options['floorad_enable'];
		$new_options['banner_key'] = $old_options['banner_key'];
		$new_options['banner_enable'] = $old_options['banner_enable'];
		$new_options['billboard_key'] = $old_options['billboard_key'];
		$new_options['billboard_enable'] = $old_options['billboard_enable'];

		// Check keys format
		if(($new_options['comment_enable'] || $new_options['registration_enable'] || $new_options['login_enable']) && (!preg_match('/^[a-zA-Z0-9_-]{64}$/', $new_options['captchme_public_key']))) {
			$new_options['captchme_public_key'] = '';
			add_settings_error('captchme_public_key', 'captchme_public_key_invalid', __('Invalid CaptchMe public key. It should be 64 alphanumeric characters long.','captchme'), 'error');
		}
		if(($new_options['comment_enable'] || $new_options['registration_enable'] || $new_options['login_enable']) && (!preg_match('/[A-Za-z0-9-_]{64}/', $new_options['captchme_private_key']))) {
			$new_options['captchme_private_key'] = '';
			add_settings_error('captchme_private_key', 'captchme_private_key_invalid', __('Invalid CaptchMe private key. It should be 64 alphanumeric characters long.','captchme'), 'error');
		}
		if(($new_options['comment_enable'] || $new_options['registration_enable'] || $new_options['login_enable']) && (!preg_match('/[A-Za-z0-9-_]{64}/', $new_options['captchme_authent_key']))) {
			$new_options['captchme_authent_key'] = '';
			add_settings_error('captchme_authent_key', 'captchme_authent_key_invalid', __('Invalid CaptchMe authentication key. It should be 64 alphanumeric characters long.','captchme'), 'error');
		}

		// Default language to french if not provided
		if ( $new_options['lang'] == FALSE || $new_options['lang'] == ''){
			$new_options['lang']='fr';
		}

		// Default title if not provided
		if ( $new_options['title'] == FALSE || $new_options['title'] == ''){
			$new_options['title']='0';
		}

		// Default instruction if not provided
		if ( $new_options['instruction'] == FALSE || $new_options['instruction'] == ''){
			$new_options['instruction']='0';
		}

		// Default ssl if not provided
		if ( $new_options['ssl'] == FALSE || $new_options['ssl'] == ''){
			$new_options['ssl']='0';
		}

		// Default adb if not provided
		if ( $new_options['adb'] == FALSE || $new_options['adb'] == ''){
			$new_options['adb']='1';
		}

		if(($new_options['comment_enable']) && (!preg_match('/[0-9]+/', $new_options['comment_tabindex']))) {
			$new_options['comment_tabindex'] = '';
			add_settings_error('comment_tabindex', 'tabindex_invalid', __('Invalid tabindex. It should be a numerical value.','captchme'), 'error');
		}

		if(($new_options['registration_enable']) && (!preg_match('/[0-9]+/', $new_options['registration_tabindex']))) {
			$new_options['registration_tabindex'] = '';
			add_settings_error('registration_tabindex', 'tabindex_invalid', __('Invalid tabindex. It should be a numerical value.','captchme'), 'error');
		}

		if(($new_options['login_enable']) && (!preg_match('/[0-9]+/', $new_options['login_tabindex']))) {
			$new_options['login_tabindex'] = '';
			add_settings_error('login_tabindex', 'tabindex_invalid', __('Invalid tabindex. It should be a numerical value.','captchme'), 'error');
		}
	}
	if( $active_tab == 'accessme' ) {
		$new_options['accessme_key'] = sanitize_text_field(trim($options['accessme_key']));
		$new_options['accessme_enable'] = sanitize_text_field(trim($options['accessme_enable']));

		$old_options = get_option('captchme_options');

		$new_options['captchme_public_key'] = $old_options['captchme_public_key'];
		$new_options['captchme_private_key'] = $old_options['captchme_private_key'];
		$new_options['captchme_authent_key'] = $old_options['captchme_authent_key'];
		$new_options['lang'] = $old_options['lang'];
		$new_options['title'] = $old_options['title'];
		$new_options['instruction'] = $old_options['instruction'];
		$new_options['ssl'] = $old_options['ssl'];
		$new_options['adb'] = $old_options['adb'];
		$new_options['comment_enable'] = $old_options['comment_enable'];
		$new_options['comment_spam_delete'] = $old_options['comment_spam_delete'];
		$new_options['comment_tabindex'] = $old_options['comment_tabindex'];
		$new_options['registration_enable'] = $old_options['registration_enable'];
		$new_options['registration_spam_delete'] = $old_options['registration_spam_delete'];
		$new_options['registration_tabindex'] = $old_options['registration_tabindex'];
		$new_options['login_enable'] = $old_options['login_enable'];
		$new_options['login_tabindex'] = $old_options['login_tabindex'];
		$new_options['showme_key'] = $old_options['showme_key'];
		$new_options['showme_enable'] = $old_options['showme_enable'];
		$new_options['showme_position'] = $old_options['showme_position'];
		$new_options['leaveme_key'] = $old_options['leaveme_key'];
		$new_options['leaveme_enable'] = $old_options['leaveme_enable'];
		$new_options['leaveme_message'] = $old_options['leaveme_message'];
		$new_options['skin_key'] = $old_options['skin_key'];
		$new_options['skin_enable'] = $old_options['skin_enable'];
		$new_options['floorad_key'] = $old_options['floorad_key'];
		$new_options['floorad_enable'] = $old_options['floorad_enable'];
		$new_options['banner_key'] = $old_options['banner_key'];
		$new_options['banner_enable'] = $old_options['banner_enable'];
		$new_options['billboard_key'] = $old_options['billboard_key'];
		$new_options['billboard_enable'] = $old_options['billboard_enable'];

		if($new_options['accessme_enable'] && (!preg_match('/^[a-zA-Z0-9_-]{64}$/', $new_options['accessme_key']))) {
			$new_options['accessme_key'] = '';
			add_settings_error('accessme_key', 'accessme_key_invalid', __('Invalid AccessMe public key. It should be 64 alphanumeric characters long.','captchme'), 'error');
		}
	}
	if( $active_tab == 'showme' ) {
		$new_options['showme_key'] = sanitize_text_field(trim($options['showme_key']));
		$new_options['showme_enable'] = sanitize_text_field(trim($options['showme_enable']));
		$new_options['showme_position'] = sanitize_text_field(trim($options['showme_position']));

		$old_options = get_option('captchme_options');

		$new_options['captchme_public_key'] = $old_options['captchme_public_key'];
		$new_options['captchme_private_key'] = $old_options['captchme_private_key'];
		$new_options['captchme_authent_key'] = $old_options['captchme_authent_key'];
		$new_options['lang'] = $old_options['lang'];
		$new_options['title'] = $old_options['title'];
		$new_options['instruction'] = $old_options['instruction'];
		$new_options['ssl'] = $old_options['ssl'];
		$new_options['adb'] = $old_options['adb'];
		$new_options['comment_enable'] = $old_options['comment_enable'];
		$new_options['comment_spam_delete'] = $old_options['comment_spam_delete'];
		$new_options['comment_tabindex'] = $old_options['comment_tabindex'];
		$new_options['registration_enable'] = $old_options['registration_enable'];
		$new_options['registration_spam_delete'] = $old_options['registration_spam_delete'];
		$new_options['registration_tabindex'] = $old_options['registration_tabindex'];
		$new_options['login_enable'] = $old_options['login_enable'];
		$new_options['login_tabindex'] = $old_options['login_tabindex'];
		$new_options['accessme_key'] = $old_options['accessme_key'];
		$new_options['accessme_enable'] = $old_options['accessme_enable'];
		$new_options['leaveme_key'] = $old_options['leaveme_key'];
		$new_options['leaveme_enable'] = $old_options['leaveme_enable'];
		$new_options['leaveme_message'] = $old_options['leaveme_message'];
		$new_options['skin_key'] = $old_options['skin_key'];
		$new_options['skin_enable'] = $old_options['skin_enable'];
		$new_options['floorad_key'] = $old_options['floorad_key'];
		$new_options['floorad_enable'] = $old_options['floorad_enable'];
		$new_options['banner_key'] = $old_options['banner_key'];
		$new_options['banner_enable'] = $old_options['banner_enable'];
		$new_options['billboard_key'] = $old_options['billboard_key'];
		$new_options['billboard_enable'] = $old_options['billboard_enable'];

		if($new_options['showme_enable'] && (!preg_match('/^[a-zA-Z0-9_-]{64}$/', $new_options['showme_key']))) {
			$new_options['showme_key'] = '';
			add_settings_error('showme_key', 'showme_key_invalid', __('Invalid ShowMe public key. It should be 64 alphanumeric characters long.','captchme'), 'error');
		}

		// Default showme position if not provided
		if ( $new_options['showme_position'] == FALSE || $new_options['showme_position'] == ''){
			$new_options['showme_position']='left';
		}

	}
	if( $active_tab == 'leaveme' ) {
		$new_options['leaveme_key'] = sanitize_text_field(trim($options['leaveme_key']));
		$new_options['leaveme_enable'] = sanitize_text_field(trim($options['leaveme_enable']));
		$new_options['leaveme_message'] = sanitize_text_field(trim(addslashes($options['leaveme_message'])));

		$old_options = get_option('captchme_options');

		$new_options['captchme_public_key'] = $old_options['captchme_public_key'];
		$new_options['captchme_private_key'] = $old_options['captchme_private_key'];
		$new_options['captchme_authent_key'] = $old_options['captchme_authent_key'];
		$new_options['lang'] = $old_options['lang'];
		$new_options['title'] = $old_options['title'];
		$new_options['instruction'] = $old_options['instruction'];
		$new_options['ssl'] = $old_options['ssl'];
		$new_options['adb'] = $old_options['adb'];
		$new_options['comment_enable'] = $old_options['comment_enable'];
		$new_options['comment_spam_delete'] = $old_options['comment_spam_delete'];
		$new_options['comment_tabindex'] = $old_options['comment_tabindex'];
		$new_options['registration_enable'] = $old_options['registration_enable'];
		$new_options['registration_spam_delete'] = $old_options['registration_spam_delete'];
		$new_options['registration_tabindex'] = $old_options['registration_tabindex'];
		$new_options['login_enable'] = $old_options['login_enable'];
		$new_options['login_tabindex'] = $old_options['login_tabindex'];
		$new_options['accessme_key'] = $old_options['accessme_key'];
		$new_options['accessme_enable'] = $old_options['accessme_enable'];
		$new_options['showme_key'] = $old_options['showme_key'];
		$new_options['showme_enable'] = $old_options['showme_enable'];
		$new_options['showme_position'] = $old_options['showme_position'];
		$new_options['skin_key'] = $old_options['skin_key'];
		$new_options['skin_enable'] = $old_options['skin_enable'];
		$new_options['floorad_key'] = $old_options['floorad_key'];
		$new_options['floorad_enable'] = $old_options['floorad_enable'];
		$new_options['banner_key'] = $old_options['banner_key'];
		$new_options['banner_enable'] = $old_options['banner_enable'];
		$new_options['billboard_key'] = $old_options['billboard_key'];
		$new_options['billboard_enable'] = $old_options['billboard_enable'];

		if($new_options['leaveme_enable'] && (!preg_match('/^[a-zA-Z0-9_-]{64}$/', $new_options['leaveme_key']))) {
			$new_options['leaveme_key'] = '';
			add_settings_error('leaveme_key', 'leaveme_key_invalid', __('Invalid LeaveMe public key. It should be 64 alphanumeric characters long.','captchme'), 'error');
		}
	}
	if( $active_tab == 'cskin' ) {
		$new_options['skin_key'] = sanitize_text_field(trim($options['skin_key']));
		$new_options['skin_enable'] = sanitize_text_field(trim($options['skin_enable']));

		$old_options = get_option('captchme_options');

		$new_options['captchme_public_key'] = $old_options['captchme_public_key'];
		$new_options['captchme_private_key'] = $old_options['captchme_private_key'];
		$new_options['captchme_authent_key'] = $old_options['captchme_authent_key'];
		$new_options['lang'] = $old_options['lang'];
		$new_options['title'] = $old_options['title'];
		$new_options['instruction'] = $old_options['instruction'];
		$new_options['ssl'] = $old_options['ssl'];
		$new_options['adb'] = $old_options['adb'];
		$new_options['comment_enable'] = $old_options['comment_enable'];
		$new_options['comment_spam_delete'] = $old_options['comment_spam_delete'];
		$new_options['comment_tabindex'] = $old_options['comment_tabindex'];
		$new_options['registration_enable'] = $old_options['registration_enable'];
		$new_options['registration_spam_delete'] = $old_options['registration_spam_delete'];
		$new_options['registration_tabindex'] = $old_options['registration_tabindex'];
		$new_options['login_enable'] = $old_options['login_enable'];
		$new_options['login_tabindex'] = $old_options['login_tabindex'];
		$new_options['accessme_key'] = $old_options['accessme_key'];
		$new_options['accessme_enable'] = $old_options['accessme_enable'];
		$new_options['showme_key'] = $old_options['showme_key'];
		$new_options['showme_enable'] = $old_options['showme_enable'];
		$new_options['showme_position'] = $old_options['showme_position'];
		$new_options['leaveme_key'] = $old_options['leaveme_key'];
		$new_options['leaveme_enable'] = $old_options['leaveme_enable'];
		$new_options['leaveme_message'] = $old_options['leaveme_message'];
		$new_options['floorad_key'] = $old_options['floorad_key'];
		$new_options['floorad_enable'] = $old_options['floorad_enable'];
		$new_options['banner_key'] = $old_options['banner_key'];
		$new_options['banner_enable'] = $old_options['banner_enable'];
		$new_options['billboard_key'] = $old_options['billboard_key'];
		$new_options['billboard_enable'] = $old_options['billboard_enable'];

		if($new_options['skin_enable'] && !preg_match('/[A-Za-z0-9-_]{64}/', $new_options['skin_key'])) {
			$new_options['skin_key'] = '';
			$new_options['skin_enable'] = 0;
			add_settings_error('skin_key', 'skin_key_invalid', __('Invalid public key for C-Skin. It should be 64 alphanumeric characters long.','captchme'), 'error');
		}

	}
	if( $active_tab == 'cfloorad' ) {
		$new_options['floorad_key'] = sanitize_text_field(trim($options['floorad_key']));
		$new_options['floorad_enable'] = sanitize_text_field(trim($options['floorad_enable']));

		$old_options = get_option('captchme_options');

		$new_options['captchme_public_key'] = $old_options['captchme_public_key'];
		$new_options['captchme_private_key'] = $old_options['captchme_private_key'];
		$new_options['captchme_authent_key'] = $old_options['captchme_authent_key'];
		$new_options['lang'] = $old_options['lang'];
		$new_options['title'] = $old_options['title'];
		$new_options['instruction'] = $old_options['instruction'];
		$new_options['ssl'] = $old_options['ssl'];
		$new_options['adb'] = $old_options['adb'];
		$new_options['comment_enable'] = $old_options['comment_enable'];
		$new_options['comment_spam_delete'] = $old_options['comment_spam_delete'];
		$new_options['comment_tabindex'] = $old_options['comment_tabindex'];
		$new_options['registration_enable'] = $old_options['registration_enable'];
		$new_options['registration_spam_delete'] = $old_options['registration_spam_delete'];
		$new_options['registration_tabindex'] = $old_options['registration_tabindex'];
		$new_options['login_enable'] = $old_options['login_enable'];
		$new_options['login_tabindex'] = $old_options['login_tabindex'];
		$new_options['accessme_key'] = $old_options['accessme_key'];
		$new_options['accessme_enable'] = $old_options['accessme_enable'];
		$new_options['showme_key'] = $old_options['showme_key'];
		$new_options['showme_enable'] = $old_options['showme_enable'];
		$new_options['showme_position'] = $old_options['showme_position'];
		$new_options['leaveme_key'] = $old_options['leaveme_key'];
		$new_options['leaveme_enable'] = $old_options['leaveme_enable'];
		$new_options['leaveme_message'] = $old_options['leaveme_message'];
		$new_options['skin_key'] = $old_options['skin_key'];
		$new_options['skin_enable'] = $old_options['skin_enable'];
		$new_options['banner_key'] = $old_options['banner_key'];
		$new_options['banner_enable'] = $old_options['banner_enable'];
		$new_options['billboard_key'] = $old_options['billboard_key'];
		$new_options['billboard_enable'] = $old_options['billboard_enable'];

		if($new_options['floorad_enable'] && !preg_match('/[A-Za-z0-9-_]{64}/', $new_options['floorad_key'])) {
			$new_options['floorad_key'] = '';
			$new_options['floorad_enable'] = 0;
			add_settings_error('floorad_key', 'floorad_key_invalid', __('Invalid public key for C-Floorad. It should be 64 alphanumeric characters long.','captchme'), 'error');
		}
	}
	if( $active_tab == 'cbanner' ) {
		$new_options['banner_key'] = sanitize_text_field(trim($options['banner_key']));
		$new_options['banner_enable'] = sanitize_text_field(trim($options['banner_enable']));

		$old_options = get_option('captchme_options');

		$new_options['captchme_public_key'] = $old_options['captchme_public_key'];
		$new_options['captchme_private_key'] = $old_options['captchme_private_key'];
		$new_options['captchme_authent_key'] = $old_options['captchme_authent_key'];
		$new_options['lang'] = $old_options['lang'];
		$new_options['title'] = $old_options['title'];
		$new_options['instruction'] = $old_options['instruction'];
		$new_options['ssl'] = $old_options['ssl'];
		$new_options['adb'] = $old_options['adb'];
		$new_options['comment_enable'] = $old_options['comment_enable'];
		$new_options['comment_spam_delete'] = $old_options['comment_spam_delete'];
		$new_options['comment_tabindex'] = $old_options['comment_tabindex'];
		$new_options['registration_enable'] = $old_options['registration_enable'];
		$new_options['registration_spam_delete'] = $old_options['registration_spam_delete'];
		$new_options['registration_tabindex'] = $old_options['registration_tabindex'];
		$new_options['login_enable'] = $old_options['login_enable'];
		$new_options['login_tabindex'] = $old_options['login_tabindex'];
		$new_options['accessme_key'] = $old_options['accessme_key'];
		$new_options['accessme_enable'] = $old_options['accessme_enable'];
		$new_options['showme_key'] = $old_options['showme_key'];
		$new_options['showme_enable'] = $old_options['showme_enable'];
		$new_options['showme_position'] = $old_options['showme_position'];
		$new_options['leaveme_key'] = $old_options['leaveme_key'];
		$new_options['leaveme_enable'] = $old_options['leaveme_enable'];
		$new_options['leaveme_message'] = $old_options['leaveme_message'];
		$new_options['skin_key'] = $old_options['skin_key'];
		$new_options['skin_enable'] = $old_options['skin_enable'];
		$new_options['floorad_key'] = $old_options['floorad_key'];
		$new_options['floorad_enable'] = $old_options['floorad_enable'];
		$new_options['billboard_key'] = $old_options['billboard_key'];
		$new_options['billboard_enable'] = $old_options['billboard_enable'];

		if($new_options['banner_enable'] && !preg_match('/[A-Za-z0-9-_]{64}/', $new_options['banner_key'])) {
			$new_options['banner_key'] = '';
			$new_options['banner_enable'] = 0;
			add_settings_error('banner_key', 'banner_key_invalid', __('Invalid public key for C-Banner. It should be 64 alphanumeric characters long.','captchme'), 'error');
		}
	}
	if( $active_tab == 'cbillboard' ) {
		$new_options['billboard_key'] = sanitize_text_field(trim($options['billboard_key']));
		$new_options['billboard_enable'] = sanitize_text_field(trim($options['billboard_enable']));

		$old_options = get_option('captchme_options');

		$new_options['captchme_public_key'] = $old_options['captchme_public_key'];
		$new_options['captchme_private_key'] = $old_options['captchme_private_key'];
		$new_options['captchme_authent_key'] = $old_options['captchme_authent_key'];
		$new_options['lang'] = $old_options['lang'];
		$new_options['title'] = $old_options['title'];
		$new_options['instruction'] = $old_options['instruction'];
		$new_options['ssl'] = $old_options['ssl'];
		$new_options['adb'] = $old_options['adb'];
		$new_options['comment_enable'] = $old_options['comment_enable'];
		$new_options['comment_spam_delete'] = $old_options['comment_spam_delete'];
		$new_options['comment_tabindex'] = $old_options['comment_tabindex'];
		$new_options['registration_enable'] = $old_options['registration_enable'];
		$new_options['registration_spam_delete'] = $old_options['registration_spam_delete'];
		$new_options['registration_tabindex'] = $old_options['registration_tabindex'];
		$new_options['login_enable'] = $old_options['login_enable'];
		$new_options['login_tabindex'] = $old_options['login_tabindex'];
		$new_options['accessme_key'] = $old_options['accessme_key'];
		$new_options['accessme_enable'] = $old_options['accessme_enable'];
		$new_options['showme_key'] = $old_options['showme_key'];
		$new_options['showme_enable'] = $old_options['showme_enable'];
		$new_options['showme_position'] = $old_options['showme_position'];
		$new_options['leaveme_key'] = $old_options['leaveme_key'];
		$new_options['leaveme_enable'] = $old_options['leaveme_enable'];
		$new_options['leaveme_message'] = $old_options['leaveme_message'];
		$new_options['skin_key'] = $old_options['skin_key'];
		$new_options['skin_enable'] = $old_options['skin_enable'];
		$new_options['floorad_key'] = $old_options['floorad_key'];
		$new_options['floorad_enable'] = $old_options['floorad_enable'];
		$new_options['banner_key'] = $old_options['banner_key'];
		$new_options['banner_enable'] = $old_options['banner_enable'];
		
		if($new_options['billboard_enable'] && !preg_match('/[A-Za-z0-9-_]{64}/', $new_options['billboard_key'])) {
			$new_options['billboard_key'] = '';
			$new_options['billboard_enable'] = 0;
			add_settings_error('billboard_key', 'billboard_key_invalid', __('Invalid public key for C-Billboard. It should be 64 alphanumeric characters long.','captchme'), 'error');
		}
	}

	return $new_options;
}

/* ----------------------------------------------------------------------------------------
* Builds input fields methods
* --------------------------------------------------------------------------------------*/
function captchme_add_captchme_public_key() {
	$options = get_option('captchme_options');
	echo "<input name='captchme_options[captchme_public_key]' type='text' value='{$options['captchme_public_key']}' maxlength=64 size=85/>";
}

function captchme_add_captchme_private_key() {
	$options = get_option('captchme_options');
	echo "<input name='captchme_options[captchme_private_key]' type='text' value='{$options['captchme_private_key']}' maxlength=64 size=85/>";
}

function captchme_add_captchme_authent_key() {
	$options = get_option('captchme_options');
	echo "<input name='captchme_options[captchme_authent_key]' type='text' value='{$options['captchme_authent_key']}' maxlength=64 size=85/>";
}

function captchme_add_accessme_key() {
	$options = get_option('captchme_options');
	echo "<input name='captchme_options[accessme_key]' type='text' value='{$options['accessme_key']}' maxlength=64 size=85/>";
}

function captchme_add_showme_key() {
	$options = get_option('captchme_options');
	echo "<input name='captchme_options[showme_key]' type='text' value='{$options['showme_key']}' maxlength=64 size=85/>";
}

function captchme_add_leaveme_key() {
	$options = get_option('captchme_options');
	echo "<input name='captchme_options[leaveme_key]' type='text' value='{$options['leaveme_key']}' maxlength=64 size=85/>";
}

function captchme_add_language() {
	$options = get_option('captchme_options');
	$languages = array('fr' => __('French','captchme'),
	'en' => __('English','captchme'),
	'es' => __('Spanish','captchme'),
	'\'\''   => __('Web User','captchme'));
	echo '<select name="captchme_options[lang]" id="lang">';
	foreach ($languages as $key => $lang ) {
		$selected='';
		if ($options['lang'] == $key) {
			$selected = 'selected=\"selected\"';
		}
		echo "<option value=\"$key\" $selected>$lang</option>";
	}
	echo '</select>';
}

function captchme_add_title() {
	$options = get_option('captchme_options');
	$title = array('1' => __('Show','captchme'),
	'0' => __('Hide','captchme'));
	echo '<select name="captchme_options[title]" id="title">';
	foreach ($title as $key => $value ) {
		$selected='';
		if ($options['title'] == $key) {
			$selected = 'selected=\"selected\"';
		}
		echo "<option value=\"$key\" $selected>$value</option>";
	}
	echo '</select>';
}

function captchme_add_instruction() {
	$options = get_option('captchme_options');
	$instruction = array('1' => __('Show','captchme'),
	'0' => __('Hide','captchme'));
	echo '<select name="captchme_options[instruction]" id="instruction">';
	foreach ($instruction as $key => $value ) {
		$selected='';
		if ($options['instruction'] == $key) {
			$selected = 'selected=\"selected\"';
		}
		echo "<option value=\"$key\" $selected>$value</option>";
	}
	echo '</select>';
}

function captchme_add_ssl() {
	$options = get_option('captchme_options');
	$ssl = array('1' => __('Activated','captchme'),
	'0' => __('Deactivated','captchme'));
	echo '<select name="captchme_options[ssl]" id="ssl">';
	foreach ($ssl as $key => $value ) {
		$selected='';
		if ($options['ssl'] == $key) {
			$selected = 'selected=\"selected\"';
		}
		echo "<option value=\"$key\" $selected>$value</option>";
	}
	echo '</select>';
}

function captchme_add_adb() {
	$options = get_option('captchme_options');
	$adb = array('1' => __('Activated','captchme'),
	'0' => __('Deactivated','captchme'));
	echo '<select name="captchme_options[adb]" id="adb">';
	foreach ($adb as $key => $value ) {
		$selected='';
		if ($options['adb'] == $key) {
			$selected = 'selected=\"selected\"';
		}
		echo "<option value=\"$key\" $selected>$value</option>";
	}
	echo '</select>';
}

function captchme_add_comment_enable() {
	captchme_add_enable('comment');
}

function captchme_add_registration_enable() {
	captchme_add_enable('registration');
}

function captchme_add_login_enable() {
	captchme_add_enable('login');
}

function captchme_add_showme_enable() {
	captchme_add_enable('showme');
}

function captchme_add_leaveme_enable() {
	captchme_add_enable('leaveme');
}

function captchme_add_accessme_enable() {
	captchme_add_enable('accessme');
}

function captchme_add_skin_enable() {
	captchme_add_enable('skin');
}

function captchme_add_floorad_enable() {
	captchme_add_enable('floorad');
}

function captchme_add_banner_enable() {
	captchme_add_enable('banner');
}

function captchme_add_billboard_enable() {
	captchme_add_enable('billboard');
}

function captchme_add_enable($prefix) {
	$options = get_option('captchme_options');
	$checked = '';
	if( $options[$prefix.'_enable'] == true ) {
		$checked='checked';
	}
	echo "<input name='captchme_options[{$prefix}_enable]' type='checkbox' value='1' $checked/>";
}

function captchme_add_comment_spam_delete() {
	captchme_add_spam_delete('comment');
}

function captchme_add_registration_spam_delete() {
	captchme_add_spam_delete('registration');
}

function captchme_add_spam_delete($prefix) {
	$options = get_option('captchme_options');
	$checked = '';
	if( $options[$prefix.'_spam_delete'] == true ) {
		$checked='checked';
	}
	echo "<input name='captchme_options[{$prefix}_spam_delete]' type='checkbox' value='1' $checked/>";
}

function captchme_add_comment_tabindex() {
	captchme_add_tabindex('comment');
}

function captchme_add_registration_tabindex() {
	captchme_add_tabindex('registration');
}

function captchme_add_login_tabindex() {
	captchme_add_tabindex('login');
}

function captchme_add_tabindex($prefix) {
	$options = get_option('captchme_options');
	echo "<input name='captchme_options[{$prefix}_tabindex]' type='text' value='{$options[$prefix.'_tabindex']}'/>";
}

function captchme_add_showme_position() {
	$options = get_option('captchme_options');
	$showme_positions = array('left'  => __('Left','captchme'),
	'right' => __('Right','captchme'));
	echo '<select name="captchme_options[showme_position]" id="showme_position">';
	foreach ($showme_positions as $key => $showme_position ) {
		$selected='';
		if ($options['showme_position'] == $key) {
			$selected = 'selected=\"selected\"';
		}
		echo "<option value=\"$key\" $selected>$showme_position</option>";
	}
	echo '</select>';
}

function captchme_add_leaveme_message() {
	$options = get_option('captchme_options');
	echo "<input name='captchme_options[leaveme_message]' type='text' value='" . htmlentities(stripcslashes("{$options['leaveme_message']}"), ENT_QUOTES) . "' maxlength=85 size=85/>";
}

function captchme_add_skin_key() {
	$options = get_option('captchme_options');
	echo "<input name='captchme_options[skin_key]' type='text' value='{$options['skin_key']}' maxlength=64 size=85/>";
}

function captchme_add_floorad_key() {
	$options = get_option('captchme_options');
	echo "<input name='captchme_options[floorad_key]' type='text' value='{$options['floorad_key']}' maxlength=64 size=85/>";
}

function captchme_add_banner_key() {
	$options = get_option('captchme_options');
	echo "<input name='captchme_options[banner_key]' type='text' value='{$options['banner_key']}' maxlength=64 size=85/>";
}

function captchme_add_billboard_key() {
	$options = get_option('captchme_options');
	echo "<input name='captchme_options[billboard_key]' type='text' value='{$options['billboard_key']}' maxlength=64 size=85/>";
}


/* ----------------------------------------------------------------------------------------
* Handle plugin options persistence
* --------------------------------------------------------------------------------------*/

function create_captchme_options() {
	add_option('captchme_options',default_captchme_options());
}

function delete_captchme_options() {
	delete_option('captchme_options');
}

function default_captchme_options() {
	$options = array(
	'version' => '2.0.1',
	'captchme_public_key' => '',
	'captchme_private_key' => '',
	'captchme_authent_key' => '',
	'theme' => 'white',
	'lang' => 'fr',
	'showtitle' => 1,
	'showinstruction' => 1,
	'ssl' => 0,
	'adb' => 1,
	'comment_enable' => 1,
	'comment_spam_delete' => 0,
	'comment_tabindex' => 0,
	'registration_enable' => 0,
	'registration_spam_delete' => 0,
	'registration_tabindex' => 30,
	'login_enable' => 0,
	'login_tabindex' => 30,
	'showme_key' => '',
	'showme_enable' => 0,
	'showme_position' => 'left',
	'leaveme_key' => '',
	'leaveme_enable' => 0,
	'leaveme_message' => '',
	'accessme_key' => '',
	'accessme_enable' => 0,
	'skin_enable' => 0,
	'skin_key' => '',
	'floorad_enable' => 0,
	'floorad_key' => '',
	'banner_enable' => 0,
	'banner_key' => '',
	'billboard_enable' => 0,
	'billboard_key' => ''
	);

	return $options;
}

/* ----------------------------------------------------------------------------------------
* Add settings link in plugin page
* --------------------------------------------------------------------------------------*/
function captchme_add_settings_link($links, $file) {
	if ($file == plugin_basename('captch-me/captchme.php')) {
		$settings_title = __('CaptchMe settings', 'captchme');
		$settings = __('Settings', 'captchme');
		$settings_link = '<a href="options-general.php?page=captchme_options_menu" title="' . $settings_title . '">' . $settings . '</a>';
		array_unshift($links, $settings_link);
	}

	return $links;
}

/* ----------------------------------------------------------------------------------------
* Add options menu
* --------------------------------------------------------------------------------------*/
add_action('admin_init', 'register_captchme_settings');
add_action('admin_menu', 'captchme_add_options_menu');
add_filter("plugin_action_links", 'captchme_add_settings_link', 10, 2);


/* ----------------------------------------------------------------------------------------
* AccessMe instructions
* --------------------------------------------------------------------------------------*/
function captchme_accessme_settings() {
	echo "
	<div>
	<h2 style='margin-top:24px;margin-bottom:28px;'>" . __('How to monetize and protect a content with Access Me', 'captchme') . "</h2>
	<h4>" . __('You can use AccessMe to protect links or to hide a part of the page until the captcha is validated', 'captchme') . "</h4>
	<p>" . __('Use <code>[accessme]</code> tag (with required and optional attributes) to protect links.', 'captchme') . "</p>
	<p>" . __('Use <code>[accessme] YOUR CONTENT TO HIDE [/accessme]</code> tag (with optional attributes) to hide a part of your page.', 'captchme') . "</p>
	<a id='see_attributs' onclick='see_attributs_table();'>" . __('See attributes', 'captchme') . " &darr;</a>
	<a id='hide_attributs' style='display:none;' onclick='hide_attributs_table();'>" . __('Hide attributes', 'captchme') . " &uarr;</a>
	<script>
	function see_attributs_table() {
	document.getElementById('attributs_table').style.display = 'block';
	document.getElementById('see_attributs').style.display = 'none';
	document.getElementById('hide_attributs').style.display = 'block';
	}
	function hide_attributs_table() {
	document.getElementById('attributs_table').style.display = 'none';
	document.getElementById('see_attributs').style.display = 'block';
	document.getElementById('hide_attributs').style.display = 'none';
	}
	function use_protect() {
	document.getElementById('use_hide').style.display = 'none';
	document.getElementById('use_protect').style.display = 'block';
	}
	function use_hide() {
	document.getElementById('use_protect').style.display = 'none';
	document.getElementById('use_hide').style.display = 'block';
	}
	</script>
	<style>
	#attributs_table table {
	border-collapse: collapse;
	width: 1110px;
	}
	#attributs_table th, #attributs_table td {
	border: 1px solid #333;
	}
	#attributs_table td {
	padding: 2px 5px;
	}
	</style>
	<div id='attributs_table' style='display:none;'>
	<h4>" . __('Protect link attributes', 'captchme') . "</h4>
	<table>
	<tr>
	<th style='width: 75px;'>" . __('Attribute', 'captchme') . "</th>
	<th style='width: 405px;'>Description</th>
	<th>" . __('Value', 'captchme') . "</th>
	</tr>
	<tr>
	<td>url</td>
	<td>" . __('List of URL (separated by commas) to protect with AccessMe', 'captchme') . "</td>
	<td><code>http://www.link.com</code> " . __('or', 'captchme') . " <code>http://www.link1.com, www.link2.com, ...</code><br><i>(" . __('required', 'captchme') . ")</i></td>
	</tr>
	<tr>
	<td>urltext</td>
	<td>" . __('Text for each link', 'captchme') . "</td>
	<td><code>Link</code> " . __('or', 'captchme') . " <code>Link 1, Link 2, ...</code><br><i>(" . __('required', 'captchme') . ", " . __('same number as url', 'captchme') . ")</i></td>
	</tr>
	</table>

	<h4>" . __('Hide page attributes', 'captchme') . "</h4>
	<table>
	<tr>
	<th style='width: 75px;'>" . __('Attribute', 'captchme') . "</th>
	<th style='width: 405px;'>Description</th>
	<th>" . __('Value', 'captchme') . "</th>
	</tr>
	<tr>
	<td>button_title</td>
	<td>" . __('Button (or link) title', 'captchme') . "</td>
	<td><i>(" . __('optional', 'captchme') . ", " . __('default', 'captchme') . " : <code>" . __('Read more', 'captchme') . "</code>)</i></td>
	</tr>
	</table>

	<h4>" . __('Shared attributes', 'captchme') . "</h4>
	<table>
	<tr>
	<th style='width: 75px;'>" . __('Attribute', 'captchme') . "</th>
	<th>Description</th>
	<th>" . __('Value', 'captchme') . "</th>
	</tr>
	<tr>
	<td>type</td>
	<td>" . __('Type of element (button or link)', 'captchme') . "</td>
	<td><code>button</code>, <code>link</code><br><i>(" . __('optional', 'captchme') . ", " . __('default', 'captchme') . " : <code>button</code>)</i></td>
	</tr>
	<tr>
	<td>position</td>
	<td>" . __('Element position (center, left or right) in the page', 'captchme') . "</td>
	<td><code>center</code>, <code>left</code>, <code>right</code><br><i>(" . __('optional', 'captchme') . ", " . __('default', 'captchme') . " : <code>center</code>)</i></td>
	</tr>
	<tr>
	<td>message</td>
	<td>" . __('Message to be displayed above the AccessMe module', 'captchme') . "</td>
	<td><i>(" . __('optional', 'captchme') . ", " . __('default', 'captchme') . " : " . __('none', 'captchme') . ")</i></td>
	</tr>
	<tr>
	<td>mandatory</td>
	<td>" . __('Makes AccessMe mandatory. Possible values are:', 'captchme') . "<br>
	&bull; " . __('Non-blocking (value to be used "0"). AccessMe can be closed by the user by clicking on a cross in the top right of the screen', 'captchme') . "<br>
	&bull; " . __('Blocking (value to be used "1"). AccessMe can not be closed. The user must validate the captcha to continue', 'captchme') . "</td>
	<td><code>0</code>, <code>1</code><br><i>(" . __('optional', 'captchme') . ", " . __('default', 'captchme') . " : <code>0</code>)</i></td>
	</tr>
	<tr>
	<td>opacity</td>
	<td>" . __('This value determines the opacity of the background image used', 'captchme') . "</td>
	<td>" . __('from', 'captchme') . " <code>0.1</code> " . __('to', 'captchme') . " <code>1</code> (" . __('step', 'captchme') . " : 0.1)<br><i>(" . __('optional', 'captchme') . ", " . __('default', 'captchme') . " : <code>0.8</code>)</i></td>
	</tr>
	<tr>
	<td>extra_css</td>
	<td>" . __('URL of a style sheet to define the background image used for AccesMe. This sheet should follow the template below:', 'captchme') . "<br>
	<pre>#captchme_interVeil{
	background: url(//mondomain.com/bureau.jpg) !important;
	position: fixed !important;
	filter:progid:DXImageTransform.Microsoft.alpha(opacity=100) !important;
	background-size: cover !important;
	background-repeat : no-repeat !important;
	background-height : 100% !important;
	background-width : auto !important;
	}</pre></td>
	<td><i>(" . __('optional', 'captchme') . ", " . __('default', 'captchme') . " : " . __('none', 'captchme') . ")</i></td>
	</tr>
	</table>
	</div>
	<h4>" . __('AccessMe tag generator', 'captchme') . "</h4>
	<div>
	<input type='radio' id='accessme_use_protect' name='accessme_use' onclick='use_protect();' value='protect' checked>" . __('Protect link', 'captchme') . "<br>
	<input type='radio' id='accessme_use_hide' name='accessme_use' onclick='use_hide();' value='hide'>" . __('Hide page', 'captchme') . "<br>
	<div id='use_protect' style='margin-top:10px;'>
	url* : <input id='accessme_url' type='text'>
	urltext* : <input id='accessme_urltext' type='text'>
	</div>
	<div id='use_hide' style='display:none; margin-top:10px;'>
	button_title : <input id='accessme_button_title'type='text'>
	</div>
	<div>
	type : <select id='accessme_type'><option value=''></option><option value='button'>" . __('button', 'captchme') . "</option><option value='link'>" . __('link', 'captchme') . "</option></select>
	position : <select id='accessme_position'><option value=''></option><option value='center'>" . __('center', 'captchme') . "</option><option value='left'>" . __('left', 'captchme') . "</option><option value='right'>" . __('right', 'captchme') . "</option></select>
	message : <input id='accessme_message' type='text'>
	mandatory : <select id='accessme_mandatory'><option value=''></option><option value='0'>" . __('non-blocking', 'captchme') . "</option><option value='1'>" . __('blocking', 'captchme') . "</option></select>
	opacity : <input id='accessme_opacity' type='number' min='0' max='1' step='0.1'>
	extra_css : <input id='accessme_extra_css' type='text'>
	</div>
	<button style='margin-top:10px;' class='button-secondary' onclick='generate_accessme(); return false;'>" . __('Generate AccessMe tag', 'captchme') . "</button>
	<script>
	function generate_accessme() {
	var accessme_use = document.querySelector('input[name=accessme_use]:checked').value;

	var accessme_type = document.getElementById('accessme_type').value;
	var accessme_position = document.getElementById('accessme_position').value;
	var accessme_message = document.getElementById('accessme_message').value.trim();
	var accessme_mandatory = document.getElementById('accessme_mandatory').value;
	var accessme_opacity = document.getElementById('accessme_opacity').value;
	var accessme_extra_css = document.getElementById('accessme_extra_css').value.trim();

	var options = '';
	if(accessme_type != '' && (accessme_type == 'button' || accessme_type == 'link'))
	options += ' type=\"' + accessme_type + '\"';
	if(accessme_position != '' && (accessme_position == 'center' || accessme_position == 'left' || accessme_position == 'right'))
	options += ' position=\"' + accessme_position + '\"';
	if(accessme_message != '')
	options += ' message=\"' + accessme_message + '\"';
	if(accessme_mandatory != '' && (accessme_mandatory == '0' || accessme_mandatory == '1'))
	options += ' mandatory=\"' + accessme_mandatory + '\"';
	if(accessme_opacity != '' && accessme_opacity >= '0' && accessme_opacity <= '1')
	options += ' opacity=\"' + accessme_opacity + '\"';
	if(accessme_extra_css != '')
	options += ' extra_css=\"' + accessme_extra_css + '\"';

	var result = '';
	if(accessme_use == 'protect') {
	var accessme_url = document.getElementById('accessme_url').value.trim();
	var accessme_urltext = document.getElementById('accessme_urltext').value.trim();
	if(accessme_url == '' || accessme_urltext == '') {
	result = '" . __('Error url and urltext are required', 'captchme') . "';
	} else {
	var urls = accessme_url.split(',');
	var urlstexts = accessme_urltext.split(',');
	if(urls.length != urlstexts.length)
	result = '" . __('Number of urls and texts do not match', 'captchme') . "';
	else
	result = '[accessme url=\"' + accessme_url + '\" urltext=\"' + accessme_urltext + '\"' + options + ']';
	}
	} else if(accessme_use == 'hide') {
	var accessme_button_title = document.getElementById('accessme_button_title').value.trim();
	result = '[accessme';
	if(accessme_button_title != '')
	result += ' button_title=\"' + accessme_button_title + '\"';
	result += options + '] " . __('YOUR CONTENT TO HIDE', 'captchme') . " [/accessme]';
	}


	document.getElementById('accessme_result').value = result;
	}
	</script>
	<div style='margin-top:10px;'>
	<label for='accessme_result'>" . __('Add this tag in your page:', 'captchme') . "</label><br>
	<input id='accessme_result' type='text' size='140' readonly onclick='this.select();'>
	</div>
	</div>

	</div>
	<div>&nbsp;</div>
	";
}


/* ----------------------------------------------------------------------------------------
* Contact Form 7 instructions
* --------------------------------------------------------------------------------------*/
function captchme_contact_form_7_settings() {
	echo "<div>
	<h2>Contact Form 7</h2>
	<h4>" . __("CaptchMe is compatible with the plugin Contact Form 7", 'captchme') . "</h4>
	<ul>
	<li>&bull; " . __("Install and activate the plugin", 'captchme') . " <a href='https://wordpress.org/plugins/contact-form-7/'><strong>Contact Form 7</strong></a></li>
	<li>&bull; " . __("Create your form", 'captchme') . " (menu &laquo;<a href='admin.php?page=wpcf7-new'><strong>Contact</strong></a>&raquo;)</li>
	<li>&bull; " . __("Add tag", 'captchme') . " <code>[captchme]</code> " . __("before tag", 'captchme') . " <code>[submit]</code></li>
	<li>&bull; " . __("Add this form to your page", 'captchme') . "</li>
	</ul>
	</div>";
}

?>