<?php

// get rid of all the other dashboard widgets except for the ones we want. 

$netgirl = (isset($_GET['netgirl']) ? $_GET['netgirl'] : null);

switch($netgirl)
	{
	    case 'I_want_to_tell_you_a_netgirl':
	    	$netgirl_title = 'I want to tell you a netgirl';

	        break;

	    case '2':
	    	$netgirl_title = 'the next part of the netgirl';
	        break;

	    default: 
	    	$netgirl_title = 'Prelude';
	}

add_action('wp_dashboard_setup', 'wpse_73561_remove_all_dashboard_meta_boxes', 9999 );

function wpse_73561_remove_all_dashboard_meta_boxes() {
    global $story_title;
    global $netgirl_title;
    global $wp_meta_boxes;
    global $netgirl;

    if (!$netgirl) {
    $wp_meta_boxes['dashboard'] = 
    Array ( 
    	'normal' => Array ( 
    		'core' => Array ( 
    			'custom_help_widget' => Array ( 
    				'id' => 'custom_help_widget', 
    				'title' => $story_title, 
    				'callback' => 'custom_dashboard_help', 
    				'args' => '' )
    				 ) ,
    		'sorted' => Array()
    		), 
    	'side' => Array ( 
    		'core' => Array ( )
    	)

    );
	} else {
		$wp_meta_boxes['dashboard'] = 
	    Array ( 
	    	'normal' => Array ( 
	    		'core' => Array ( 
	    			'custom_help_widget' => Array ( 
	    				'id' => 'custom_help_widget', 
	    				'title' => $story_title, 
	    				'callback' => 'custom_dashboard_help', 
	    				'args' => '' ),
	    			'netgirl_widget' => Array ( 
	    				'id' => 'netgirl_widget', 
	    				'title' => $netgirl_title, 
	    				'callback' => 'netgirl_dashboard_widget', 
	    				'args' => '' )    			
	    				 ) ,
	    		'sorted' => Array()
	    		), 
	    	'side' => Array ( 
	    		'core' => Array ( )
	    	)

		);
    
	}
}


// add dashboard widget

if ($netgirl) {

add_action('wp_dashboard_setup', 'netgirl_dashboard_widgets');

	function netgirl_dashboard_widgets($netgirl_title) {

		add_meta_box('netgirl_widget', $netgirl_title, 'netgirl_dashboard_widget', 'dashboard', 'normal','core');

	}
	 
	function netgirl_dashboard_widget() {

		global $netgirl_title;
		global $netgirl;
		global $url;

		if ($netgirl_title == 'Prelude') {
			$url->setQueryVariable('netgirl','I_want_to_tell_you_a_netgirl');
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
				I am not a hacker. I\'m not here to steal anything, compromise anything, or infect your computer. <a href="'.$url.'">I just want to tell you a netgirl</a>.  
				</p>
				';
		}

		 if ( $netgirl != NULL and $_GET['netgirl'] == 'I_want_to_tell_you_a_netgirl')  {
	        echo '<a href="?netgirl=2">part 1</a>';
		}
		  if ( $netgirl != NULL and $_GET['netgirl'] == '2' ){
	        echo 'part 2';
		}
		
		
	}
}