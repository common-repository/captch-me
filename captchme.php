<?php
/*
Plugin Name: Attentive Ads (CaptchMe)
Plugin URI: http://www.attentiveads.com
Description: Optimisez la r&eacute;mun&eacute;ration de votre site ! Attentive Ads est la meilleure fa&ccedil;on de mon&eacute;tiser votre audience avec nos formats publicitaires respectueux des internautes : mon&eacute;tisez & s&eacute;curisez commentaires et inscriptions avec les publicaptchas CaptchMe, mon&eacute;tisez l'acc&egrave;s aux contenus que vous souhaitez valoriser avec le format Access Me, mon&eacute;tisez toutes vos pages avec nos formats classiques.
Version: 2.1.0
Author: Attentive Ads
Author URI: http://www.attentiveads.com/
Email: sos@attentiveads.com
Created: 20180326_124200

Copyright (c) 2011-2018 by Attentive Ads
*/

 /* ----------------------------------------------------------------------------------------
 * Internationalization
 * --------------------------------------------------------------------------------------*/
 add_action('init', 'captchme_load_translation');
 function captchme_load_translation() {
    load_plugin_textdomain('captchme', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

/* ----------------------------------------------------------------------------------------
 * Handle plugin options
 * --------------------------------------------------------------------------------------*/
 include("captchme-options.php");
 register_activation_hook(__FILE__, 'create_captchme_options');
 //register_deactivation_hook(__FILE__, '');
 register_uninstall_hook(__FILE__, 'delete_captchme_options');

/* ----------------------------------------------------------------------------------------
 * Load Captchme PHP plugin
 * --------------------------------------------------------------------------------------*/
 require_once(dirname(__FILE__) . '/captchme-lib.php');

/* ----------------------------------------------------------------------------------------
 * Load options
 * --------------------------------------------------------------------------------------*/
 $captchme_options = get_option('captchme_options');

/* ----------------------------------------------------------------------------------------
 * Captchme comment protection
 * --------------------------------------------------------------------------------------*/
 $captchme_error = '';

 // Hook for comment form
 add_action('comment_form', 'comment_form_add_captchme');

 // Add CaptchMe captcha into comment forms
 function comment_form_add_captchme() {
    global $captchme_options;

    if( $captchme_options['comment_enable'] == true ) {

        // Add captchme options
        echo "
            <script type='text/javascript'>
                var CaptchmeOptions = {
                    lang: '{$captchme_options['lang']}',
                    showtitle: '{$captchme_options['title']}',
                    showinstruction: '{$captchme_options['instruction']}',
                    testadb: '{$captchme_options['adb']}',
                    tabindex: '{$captchme_options['comment_tabindex']}'
                    };
            </script>";

        // Add CaptchMe captcha
        echo captchme_generate_html($captchme_options['captchme_public_key'], $_GET['error_code'], $captchme_options['ssl']);

        // Move form submit button under the captcha
        echo "<p><div id='captchme_submit'></div></p>
            
            <script type='text/javascript'>
                   
                var button = document.getElementById('submit');
                //var class = $('#submit').className;
                button.remove(); //removes from its current place
                //document.write(button);
                document.getElementById('captchme_submit').appendChild(button);
                //$('#captchme_submit').append('<br /><p>'+button.html()); //places the button after CaptchMe
                
            </script>";

    }
 }

 // Hook for captcha validation on comment post
 add_filter('preprocess_comment', 'comment_form_check_captchme', 0);

 // Check captcha value
 function comment_form_check_captchme($comment_data) {
    global $captchme_options, $captchme_error;

    if( $captchme_options['comment_enable'] == true ) {
        // Avoid check on trackbacks/pingbacks
        if ( $comment_data['comment_type'] == '' ) {
            $captchme_response = captchme_verify ($captchme_options['captchme_private_key'],
                                                  sanitize_text_field($_POST["captchme_challenge_field"]),
                                                  sanitize_text_field($_POST["captchme_response_field"]),
                                                  $_SERVER['REMOTE_ADDR'],
                                                  $captchme_options['captchme_authent_key']);
            if ($captchme_response->is_valid)
                return $comment_data;
            else {
                $captchme_error = $captchme_response->error;
                add_filter('pre_comment_approved', create_function('', 'return \'spam\';'));
                return $comment_data;
            }
        }
    }

    return $comment_data;
 }

 // Redirect to the post if validation failed
 add_filter('comment_post_redirect', 'captchme_comment_form_redirect',0,2);

 // Redirect to the post
 function captchme_comment_form_redirect($location, $comment) {
    global $captchme_options, $captchme_error;

    if( $captchme_options['comment_enable'] == true ) {
        // If an error as occured
        if($captchme_error != '') {
            // Redirect to the post page and the commentform anchor, adding the error code to the url
            #$page = substr($location, strrpos($location, '?')+1);
            #$page = substr($page, 0,strrpos($page, '#')) . '#commentform';
            #$location =  substr($location, 0,strrpos($location, '?')) .
            #            '?commentform=' . $comment->comment_ID .
            #            '&error_code='.$captchme_error .
            #            '&' . $page;
             $location = substr($location, 0, strpos($location, '#')) .
                    ((strpos($location, "?") === false) ? "?" : "&") .
                    'comment=' . $comment->comment_ID .
                    '&error_code='.$captchme_error .
                    '#commentform';
        }
    }

       #return preg_replace("/#comment-([\d]+)/", "#comments", $location);
       return $location;
       #wp_redirect($location);
       #exit;
 }
 // Hook to put back comment data if validation failed
 add_filter('wp_head', 'captchme_comment_form_failed',0);

 // Put back comment data
 function captchme_comment_form_failed() {
    global $captchme_options;

    if( $captchme_options['comment_enable'] == true ) {
        // Only for single post pages
        if ((is_single() || is_page()) && $_GET['comment']) {

            $comment = get_comment($_GET['comment']);
            if( $comment->comment_approved == 'spam') {

                if( $captchme_options['comment_spam_delete'] == true ) {
                    // Delete spam comment
                    wp_delete_comment($comment->comment_ID);
                } else {
                    // Remove potential captchme tag
                    $comment->comment_content = preg_replace('/^\[[0-9]+\]/', '', $comment->comment_content);
                    wp_update_comment(array('comment_ID'=> $comment->comment_ID,
                                            'comment_content'=> '['.time().']' . $comment->comment_content));
                }

				$text = preg_replace_callback('/([\\/\(\)\+\;\'])/',function ($matches){ return '\'%\'.dechex(ord(\'$matches[1]\'))';}, $comment->comment_content);
                $text = preg_replace('/\\r\\n/m', '\\\n', $text);

                echo "
                <script type='text/javascript'>
                     var captchme_comment = unescape('{$text}');
                </script>";
            }
        }
    }
  }

/* ----------------------------------------------------------------------------------------
 * Captchme registration protection
 * --------------------------------------------------------------------------------------*/
 // Hook for registration form
 add_action('register_form', 'registration_form_add_captchme');

 // Add CaptchMe captcha into registration forms
 function registration_form_add_captchme() {
    global $captchme_options, $captchme_error;

    if( $captchme_options['registration_enable'] == true ) {

        // Add a line
        echo "<hr id='cm_line'/>";
        // Add css stylin
        echo "
            <style type='text/css'>
                #login {
                    width: 370px !important;
                }

                #login a {
                    text-align: center;
                }

                #nav {
                    text-align: center;
                }

                #reg_passmail {
                    margin-top:10px;
                }

                #cm_line {
                    clear: both;
                    margin-bottom: 1.5em;
                    border: 0;
                    border-top: 1px solid #E5E5E5;
                    height: 1px;
                }

                body form .input {
                    width: 98%;
                }
            </style>
            <script type='text/javascript'>
                var CaptchmeOptions = {
                    lang: '{$captchme_options['lang']}',
                    showtitle: '{$captchme_options['title']}',
                    showinstruction: '{$captchme_options['instruction']}',
                    testadb: '{$captchme_options['adb']}',
                    tabindex: '{$captchme_options['registration_tabindex']}'
                    };
            </script>";
        echo captchme_generate_html($captchme_options['captchme_public_key'], $captchme_error, $captchme_options['ssl']);
        // Move form submit button under the captcha
        echo "<p><div id='captchme_submit'></div></p>
            
            <script type='text/javascript'>
                   
                var button = document.getElementById('submit');
                //var class = $('#submit').className;
                button.remove(); //removes from its current place
                //document.write(button);
                document.getElementById('captchme_submit').appendChild(button);
                //$('#captchme_submit').append('<br /><p>'+button.html()); //places the button after CaptchMe
                
            </script>";

    }
 }

 // Hook for registration check
 add_filter('registration_errors', 'registration_form_check_captchme');

 // Check CaptchMe captcha
 function registration_form_check_captchme($errors) {
    global $captchme_options, $captchme_error;

    if( $captchme_options['registration_enable'] == true ) {

        // no captcha answer return an error
        if (empty($_POST['captchme_response_field']) || $_POST['captchme_response_field'] == '') {
            $captchme_error = "missing-mandatory-parameter";
            $errors->add('cm_empty_answer', '<strong>'.__('ERROR','captchme').'</strong>: '.__('Please fill in the CaptchMe form.','captchme'));
            return $errors;
        }

        $captchme_response = captchme_verify ($captchme_options['captchme_private_key'],
                                              sanitize_text_field($_POST["captchme_challenge_field"]),
                                              sanitize_text_field($_POST["captchme_response_field"]),
                                              $_SERVER['REMOTE_ADDR'],
                                              $captchme_options['captchme_authent_key']);
        if (!$captchme_response->is_valid){ // && $captchme_response->error == 'invalid-response') {
            $captchme_error = $captchme_response->error;
            $errors->add('cm_wrong_answer', '<strong>'.__('ERROR','captchme').'</strong>: '.__('CaptchMe captcha response was incorrect.','captchme'));
        }

        return $errors;
    }
 }
/* ----------------------------------------------------------------------------------------
 * Captchme login protection
 * --------------------------------------------------------------------------------------*/
 // Hook for login form
 add_action('login_form', 'login_form_add_captchme');

 // Add CaptchMe captcha into registration forms
 function login_form_add_captchme() {
    global $captchme_options, $captchme_error;

    if( $captchme_options['login_enable'] == true ) {

        // Add a line
        echo "<hr id='cm_line'/>";
        // Add css stylin
        echo "
            <style type='text/css'>
                #login {
                    width: 370px !important;
                }

                #login a {
                    text-align: center;
                }

                #nav {
                    text-align: center;
                }

                #reg_passmail {
                    margin-top:10px;
                }

                #cm_line {
                    clear: both;
                    margin-bottom: 1.5em;
                    border: 0;
                    border-top: 1px solid #E5E5E5;
                    height: 1px;
                }

                body form .input {
                    width: 98%;
                }
            </style>
            <script type='text/javascript'>
                var CaptchmeOptions = {
                    lang: '{$captchme_options['lang']}',
                    showtitle: '{$captchme_options['title']}',
                    showinstruction: '{$captchme_options['instruction']}',
                    testadb: '{$captchme_options['adb']}',
                    tabindex: '{$captchme_options['login_tabindex']}'
                    };
            </script>";
        echo captchme_generate_html($captchme_options['captchme_public_key'],  $captchme_error, $captchme_options['ssl']);
        // Move form submit button under the captcha
        echo "<p><br><div id='captchme_submit'></div></p>
            
            <script type='text/javascript'>
                   
                var button = document.getElementById('submit');
                //var class = $('#submit').className;
                button.remove(); //removes from its current place
                //document.write(button);
                document.getElementById('captchme_submit').appendChild(button);
                //$('#captchme_submit').append('<br /><p>'+button.html()); //places the button after CaptchMe
                
            </script>";

    }
 }

// Hook for login check
add_action('wp_authenticate_user', 'login_form_check_captchme', 10, 2);

// Check CaptchMe captcha
 function login_form_check_captchme( $user, $password ) {
    global $captchme_options, $captchme_error;

    if( $captchme_options['login_enable'] == true ) {

        // no captcha answer return an error
        if (empty($_POST['captchme_response_field']) || $_POST['captchme_response_field'] == '') {            
            $captchme_error = "missing-mandatory-parameter";
            return new WP_Error('cm_empty_answer', '<strong>'.__('ERROR','captchme').'</strong>: '.__('Please fill in the CaptchMe form.','captchme'));
        }

        $captchme_response = captchme_verify ($captchme_options['captchme_private_key'],
                                              sanitize_text_field($_POST["captchme_challenge_field"]),
                                              sanitize_text_field($_POST["captchme_response_field"]),
                                              $_SERVER['REMOTE_ADDR'],
                                              $captchme_options['captchme_authent_key']);
        if (!$captchme_response->is_valid){ // && $captchme_response->error == 'invalid-response') {
            $captchme_error = $captchme_response->error;
            return new WP_Error('cm_wrong_answer',  '<strong>'.__('ERROR','captchme').'</strong>: '.__('CaptchMe captcha response was incorrect.','captchme'));
        }
    }
    return $user;
 }

/* ----------------------------------------------------------------------------------------
 * Captchme Contact Form 7 protection
 * --------------------------------------------------------------------------------------*/
// Add custom shortcode to Contact Form 7
add_action( 'wpcf7_init', 'add_shortcode_captchme_cf7' );
function add_shortcode_captchme_cf7() {
    wpcf7_add_shortcode('captchme', 'contact_form_7_add_captchme', true);
}

// Add CaptchMe captcha into Contact form 7
function contact_form_7_add_captchme($tag) {
    global $captchme_options, $captchme_error;

    $tag = new WPCF7_Shortcode($tag);

    // Add captchme options
    $output = "
        <script type='text/javascript'>
            var CaptchmeOptions = {
                lang: '{$captchme_options['lang']}',
                showtitle: '{$captchme_options['title']}',
                showinstruction: '{$captchme_options['instruction']}',
                testadb: '{$captchme_options['adb']}'
                };
        </script>";

    $output .= "<style type='text/css'> #captchmerefresh_btn { padding-bottom: 10px !important; } .captchmelogo { margin-bottom: 3px !important; } .captchmelogo a { padding-bottom: 1px !important; }</style>";


    // Add CaptchMe captcha
    $output .= captchme_generate_html($captchme_options['captchme_public_key'], $captchme_error, $captchme_options['ssl']);

    return '<span class="wpcf7-form-control-wrap captchme">' . $output . '</span>';
 
}

add_filter('wpcf7_validate_captchme*','contact_form_7_check_captchme', 10, 2);
add_filter('wpcf7_validate_captchme','contact_form_7_check_captchme', 10, 2);

// Check captcha value
 function contact_form_7_check_captchme($comment_data, $tag) {
    global $captchme_options, $captchme_error;

    $tag = new WPCF7_Shortcode( $tag );

    // no captcha answer return an error
    if (empty($_POST['captchme_response_field']) || $_POST['captchme_response_field'] == '') {
        $captchme_error = "missing-mandatory-parameter";
        $tag->name = "captchme";
        $comment_data->invalidate($tag, __('Please fill in the CaptchMe form.','captchme') . ' ' . __('If CaptchMe captcha is not visible, thanks to deactivate your ad blocker and to refresh the page.','captchme'));
        return $comment_data;
    }

    $captchme_response = captchme_verify ($captchme_options['captchme_private_key'],
                                          sanitize_text_field($_POST["captchme_challenge_field"]),
                                          sanitize_text_field($_POST["captchme_response_field"]),
                                          $_SERVER['REMOTE_ADDR'],
                                          $captchme_options['captchme_authent_key']);
    if (!$captchme_response->is_valid){
        $captchme_error = $captchme_response->error;
        $tag->name = "captchme";
        $comment_data->invalidate($tag, __('CaptchMe captcha response was incorrect.','captchme') . ' ' . __('If CaptchMe captcha is not visible, thanks to deactivate your ad blocker and to refresh the page.','captchme'));
        return $comment_data;
    }
    return $comment_data;
 }

// Add Contact Form Tag Generator Button
add_action('wpcf7_admin_init', 'captchme_cf7_add_tag_generator', 55);

function captchme_cf7_add_tag_generator() {
    $tag_generator = WPCF7_TagGenerator::get_instance();
    $tag_generator->add( 'captchme', 'CaptchMe by Attentive Ads', 'captchme_cf7_tag_generator', array( 'nameless' => 1 ) );
}

function captchme_cf7_tag_generator( $contact_form, $args = '' ) {
    $args = wp_parse_args( $args, array() ); ?>
    <div class="control-box">
        <fieldset>
            <legend><?php _e("Add tag", 'captchme') ?> <code>[captchme]</code> <?php _e("before tag", 'captchme') ?> <code>[submit]</code></legend>
        </fieldset>
    </div>
    <div class="insert-box">
        <input type="text" name="captchme" class="tag code" readonly="readonly" onfocus="this.select()" />
        <div class="submitbox">
            <input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'contact-form-7' ) ); ?>" />
        </div>
    </div>
<?php
}

/* ----------------------------------------------------------------------------------------
 * Show Me, Leave Me, C-Skin, C-Floorad
 * --------------------------------------------------------------------------------------*/

add_action( 'wp_head', 'captchme_add_head' );

function captchme_add_head() {
    global $captchme_options;

    if( $captchme_options['showme_enable'] == true ) {
        echo "<script type='text/javascript'>
                    var ShowMeOptions = {
                        position : '{$captchme_options['showme_position']}'
                    }
            </script>
            <script type='text/javascript'
                    src='//api.captchme.net/api/script?key={$captchme_options['showme_key']}&style=light'>
            </script>";
    }
    
    if( $captchme_options['leaveme_enable'] == true ) {
        echo "<script type='text/javascript'>
                    var LeaveMeOptions = {
                        lang : '{$captchme_options['lang']}',
                        message : '{$captchme_options['leaveme_message']}'
                    }
            </script>
            <script type='text/javascript'
                    src='//api.captchme.net/api/script?key={$captchme_options['leaveme_key']}&style=leaver'>
            </script>";
    }
    
    if( $captchme_options['skin_enable'] == true ) {
        echo "<script type='text/javascript'
                    src='//api.captchme.net/api/script?key={$captchme_options['skin_key']}&style=skin'>
            </script>";
    }

    if( $captchme_options['floorad_enable'] == true ) {
        echo "<script type='text/javascript'
                    src='//api.captchme.net/api/script?key={$captchme_options['floorad_key']}&style=floorad'>
            </script>";
    }
    
}

/* ----------------------------------------------------------------------------------------
 * Access Me protection
 * --------------------------------------------------------------------------------------*/

add_shortcode('accessme', 'captchme_add_accessme');

function captchme_add_accessme($atts, $content = "") {
    if($content == "")
        return captchme_add_accessme_protect($atts);
    return captchme_add_accessme_content($atts, $content);
}

function captchme_add_accessme_protect($atts) {
    global $captchme_options;
    
    $a = shortcode_atts( array(
        'type' => 'button',
        'position' => 'center',
        'url' => '',
        'urltext' => '',
        'message' => '',
        'mandatory' => '',
        'opacity' => '',
        'extra_css' => ''
    ), $atts );

    $return = "<script type='text/javascript'>
    var CaptchmeInterstitielOptions = {
        publicKey: '{$captchme_options['accessme_key']}',
        urlcallback: 'none',
        lang: '{$captchme_options['lang']}',
        showtitle: '{$captchme_options['title']}',
        showinstruction: '{$captchme_options['instruction']}',";
        if($a['message'] != '') {
            $m = addslashes($a["message"]);
            $return .= "message: '{$m}',";
        }
        if($a['mandatory'] != '' && ($a['mandatory'] == 0 || $a['mandatory'] == 1))
            $return .= "mandatory: '{$a['mandatory']}',";
        if($a['opacity'] != '' && $a['opacity'] >= 0 && $a['opacity'] <= 1)
            $return .= "opacity: '{$a['opacity']}',";
        if($a['extra_css'] != '')
            $return .= "extra_css: '{$a['extra_css']}',";
    $return .= "};
    </script>
    <script type='text/javascript'
            src='//api.captchme.net/js/captchme-interstitial-min.js'>
    </script>";

    if($a['type'] == 'link') {
        $tag = 'a';
    } else {
        $tag = 'button';
    }
    
    switch($a['position']) {
        case 'left':
            $position = 'left';
            break;
        case 'right':
            $position = 'right';
            break;
        default:
            $position = 'center';
    }

    if($a['url'] == "")
        return '<p style="color:red">' . __('ERROR', 'captchme') . ' : ' . __('No url found, use "url" attribute in [accessme] tag', 'captchme') . '</p>';
    if($a['urltext'] == "")
        return '<p style="color:red">' . __('ERROR', 'captchme') . ' : ' . __('No urltext found, use "urltext" attribute in [accessme] tag', 'captchme') . '</p>';
    $urls = explode(',', $a['url']);
    $texts = explode(',', $a['urltext']);
    if(count($urls) != count($texts))
        return '<p style="color:red">' . __('ERROR', 'captchme') . ' : ' . __('Number of urls and texts do not match', 'captchme') . '</p>';
    $links = array_combine($texts, $urls);
    foreach ($links as $key => $value) {
        $key = trim($key);
        $value = trim($value);
        $return .= "<div style='margin-bottom:5px; text-align: {$position};'><{$tag} onclick='captchme_interstitialBox.initialize(\"{$value}\");'>{$key}</{$tag}></div>";
    }

    return $return;
}

function captchme_add_accessme_content($atts, $content) {
    global $captchme_options;
    
    $a = shortcode_atts( array(
        'type' => 'button',
        'position' => 'center',
        'button_title' => __('Read more', 'captchme'),
        'message' => '',
        'mandatory' => '',
        'opacity' => '',
        'extra_css' => ''
    ), $atts );

    $return = "<script src='https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>
    <script>
        function captchme_show_content() {
            $('#accessme_btn').slideUp('slow');
            $('#accessme_content').fadeIn('slow');
        }
    </script>
    <script type='text/javascript'>
    var CaptchmeInterstitielOptions = {
        publicKey: '{$captchme_options['accessme_key']}',
        callback: captchme_show_content,
        lang: '{$captchme_options['lang']}',
        showtitle: '{$captchme_options['title']}',
        showinstruction: '{$captchme_options['instruction']}',";
        if($a['message'] != '') {
            $m = addslashes($a["message"]);
            $return .= "message: '{$m}',";
        }
        if($a['mandatory'] != '' && ($a['mandatory'] == 0 || $a['mandatory'] == 1))
            $return .= "mandatory: '{$a['mandatory']}',";
        if($a['opacity'] != '' && $a['opacity'] >= 0 && $a['opacity'] <= 1)
            $return .= "opacity: '{$a['opacity']}',";
        if($a['extra_css'] != '')
            $return .= "extra_css: '{$a['extra_css']}',";
    $return .= "};
    </script>
    <script type='text/javascript'
            src='//api.captchme.net/js/captchme-interstitial-min.js'>
    </script>";
    
    if($a['type'] == 'link') {
        $tag = 'a';
    } else {
        $tag = 'button';
    }
    
    switch($a['position']) {
        case 'left':
            $position = 'left';
            break;
        case 'right':
            $position = 'right';
            break;
        default:
            $position = 'center';
    }

    $return .= "<div id='accessme_btn' style='text-align: {$position};'><{$tag} onclick='captchme_interstitialBox.initialize();'>{$a['button_title']}</{$tag}></div>";
    $return .= "<span id='accessme_content' style='display:none'>{$content}</span>";

    return $return;
}

/* ----------------------------------------------------------------------------------------
 * C-Banner & C-Billboard widgets
 * --------------------------------------------------------------------------------------*/
require_once(dirname(__FILE__) . '/captchme-widget.php');
?>
