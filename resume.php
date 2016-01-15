<?php

/*
Plugin Name: I want to tell you a story
Plugin URI: meredithmatthews.net
Description: about being a coder, working with WordPress, and about myself.
Version: 1
Author: Meredith Matthews
Author URI: http://meredithmatthews.net
License: GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

// PEAR class to parse URLS, which is SO WEIRD, and call the class

include 'includes/net_URL2.php';

$url = new Net_URL2('?');

// set the title

$story = (isset($_GET['story']) ? $_GET['story'] : null);

switch($story)
	{
	    case 'I_want_to_tell_you_a_story':
	    	$story_title = 'I want to tell you a story';

	        break;

	    case '2':
	    	$story_title = 'the next part of the story';
	        break;

	    default: 
	    	$story_title = 'Prelude';
	}

// get rid of Screen Options and Help tags

add_filter( 'contextual_help', 'wpse_25034_remove_dashboard_help_tab', 999, 3 );
add_filter( 'screen_options_show_screen', 'wpse_25034_remove_help_tab' );

function wpse_25034_remove_dashboard_help_tab( $old_help, $screen_id, $screen )
{
    if( 'dashboard' != $screen->base )
        return $old_help;

    $screen->remove_help_tabs();
    return $old_help;
}

function wpse_25034_remove_help_tab( $visible )
{
    global $current_screen;
    if( 'dashboard' == $current_screen->base )
        return false;
    return $visible;
}

// enqueue the admin stylesheet!

function my_admin_theme_style() {
    wp_enqueue_style('my-admin-theme', plugins_url('styles/wp-admin.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'my_admin_theme_style');
add_action('login_enqueue_scripts', 'my_admin_theme_style');


// add dashboard widget

add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');

function my_custom_dashboard_widgets($story_title) {

	add_meta_box('custom_help_widget', $story_title, 'custom_dashboard_help', 'dashboard', 'normal','core');

}
 
function custom_dashboard_help() {

	global $story_title;
	global $story;
	global $url;

	if ($story_title == 'Prelude') {

		$url->setQueryVariable('story','I_want_to_tell_you_a_story');
		echo '
			<h2>
			Don\'t panic! 
			</h2>
			<p>
			This plugin manipulates the backend of your WordPress website, but don\'t worry! This plugin won\'t add anything to your
			database, it won\'t remove anything from your database, and it won\'t publish anything on the front end. 
			</p>
			<p>
			Additionally, this plugin will not read any of your information, upload anything, download anything, contact any external 
			website (with the exception of enqueueing some Google Fonts) or send any emails. Which is kind of a bummer, because I really 
			wanted to add a little script that emailed me every time this plugin is activated, but safe is better than sorry. There is absolutely 
			no obscured code in this plugin, and I invite you to check out the code for yourself.
			</p>
			<p>
			It\'s a little weird though, right? This is your WordPress dashboard. I\'ve basically come in and hijacked your personal private space. 
			It\'s sort of like I came into your house, sat on your bed and started a conversation while folding your laundry. As of this version (1.0), 
			I hope to get this plugin listed in the WordPress plugin directory to assuage any security concerns you may have, but let\'s be perfectly 
			honest: as of right this minute, you just trusted me enough to add this plugin to a site you own. That\'s pretty amazing. 
			Thank you for that. 
			</p>
			<p>
			I am not a hacker. I\'m not here to steal anything, compromise anything, or infect your computer. <a href="'.$url.'">I just want to tell you a story</a>.  
			</p>
			';
	}

	 if ( $story != NULL and $_GET['story'] == 'I_want_to_tell_you_a_story')  {
	 	
	 	$url->setQueryVariable('story','2');

        echo '<a href="'.$url.'">part 1</a>, and then there is <a href="?story=I_want_to_tell_you_a_story&netgirl=Prelude">netgirl</a>';
	}
	  if ( $story != NULL and $_GET['story'] == '2' ){
        echo 'part 2';
	}
	
	
}

// My life is more than one story and so is yours.

include 'secondstory.php';