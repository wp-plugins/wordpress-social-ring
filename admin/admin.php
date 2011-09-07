<?php

function wp_social_ring_setting_page() {
	
	?>
	
	<div class="wrap">
		<?php screen_icon('plugins'); ?>
		<h2><?php _e('WordPress Social Ring Settings',WP_SOCIAL_RING); ?></h2>
		<div id="wp-social-ring">
			<div class="postbox-container" style="width:70%;">
				<form action="options.php" method="post">
				
						<div class="postbox">
							<?php settings_fields(WP_SOCIAL_RING.'_options'); ?>
							<?php do_settings_sections(WP_SOCIAL_RING); ?>
						</div>
						<input name="submit" class="button-primary" type="submit" value="<?php _e('Save Changes',WP_SOCIAL_RING); ?>" />
				
				</form>
			</div>
			<div class="postbox-container" style="width:20%;">
				
				<div class="postbox" id="avbox-container"> 
					<div title="Click to toggle" class="handlediv"><br></div> 
					<h3 class="hndle"><span>AlterVista</span></h3> 
					<div class="inside" id="avbox"> <!-- #avbox --> 
						<p><?php _e('Your free WordPress blog, <b>without space and traffic limits</b>',WP_SOCIAL_RING); ?></p> 
						<p class="avlink"><a class="avbtn" target="_blank" href="<?php _e('http://en.altervista.org/create-free-blog.html',WP_SOCIAL_RING); ?>"><b><?php _e('Learn More',WP_SOCIAL_RING); ?> &raquo;</b></a></p>				
					</div> 
				</div>	
			</div>
		</div>
	</div>
	<?php

}

add_action('admin_print_styles', 'add_wp_social_ring_css');
function add_wp_social_ring_css() {
	wp_enqueue_style( WP_SOCIAL_RING.'-style', WP_SOCIAL_RING_URL.'admin/css/style.css');
}

// Register and define the settings
add_action('admin_init', 'wp_social_ring_admin_init');
function wp_social_ring_admin_init(){

	

	register_setting(
		WP_SOCIAL_RING.'_options',
		WP_SOCIAL_RING.'_options',
		WP_SOCIAL_RING.'_validate_options'
	);

	add_settings_section(
		WP_SOCIAL_RING.'_setting_section',
		__('General Settings',WP_SOCIAL_RING),
		'wp_social_ring_social_share_explain',
		WP_SOCIAL_RING
	);
	add_settings_field(
		'wp_social_ring_social_buttons',
		__('Buttons',WP_SOCIAL_RING),
		'print_social_ring_buttons_input',
		WP_SOCIAL_RING,
		WP_SOCIAL_RING.'_setting_section'
	);
	add_settings_field(
		'wp_social_ring_position',
		__('Position',WP_SOCIAL_RING),
		'print_social_ring_position_input',
		WP_SOCIAL_RING,
		WP_SOCIAL_RING.'_setting_section'
	);
	add_settings_field(
		'wp_social_ring_show_on',
		__('Show on',WP_SOCIAL_RING),
		'print_social_ring_show_on_input',
		WP_SOCIAL_RING,
		WP_SOCIAL_RING.'_setting_section'
	);
}

function wp_social_ring_social_share_explain() {
	?>
		<div class="explain"><?php _e('Choose Social Ring position and behavior',WP_SOCIAL_RING); ?></div>
	<?php
}


function print_social_ring_position_input() {
	
	global $wp_social_ring_options;
	// echo the field
	?>
		
		<ul>
			<li>
				<span><input id='social_before_content' name='wp_social_ring_options[social_before_content]' type='checkbox' value="1" <?php if($wp_social_ring_options['social_before_content'] == 1) echo "checked"; ?> /></span>
				<span><?php _e('Before content',WP_SOCIAL_RING) ?></span>
			</li>
			<li>
				<span><input id='social_after_content' name='wp_social_ring_options[social_after_content]' type='checkbox' value="1" <?php if($wp_social_ring_options['social_after_content'] == 1) echo "checked"; ?> /></span>
				<span><?php _e('After content',WP_SOCIAL_RING) ?></span>
			</li>
		</ul>

	<?php
}

function print_social_ring_buttons_input() {
	
	global $wp_social_ring_options;
	// echo the field
	?>

		<ul>
			<li>
				<span><input id='social_facebook_like_button' name='wp_social_ring_options[social_facebook_like_button]' type='checkbox' value="1" <?php if($wp_social_ring_options['social_facebook_like_button'] == 1) echo "checked"; ?> /></span>
				<span><?php _e('Facebook Like',WP_SOCIAL_RING) ?></span>
			</li>
			<li>
				<span><input id='social_facebook_send_button' name='wp_social_ring_options[social_facebook_send_button]' type='checkbox' value="1" <?php if($wp_social_ring_options['social_facebook_send_button'] == 1) echo "checked"; ?> /></span>
				<span><?php _e('Facebook Send',WP_SOCIAL_RING) ?></span>
			</li>
			<li>
				<span><input id='social_facebook_share_button' name='wp_social_ring_options[social_facebook_share_button]' type='checkbox' value="1" <?php if($wp_social_ring_options['social_facebook_share_button'] == 1) echo "checked"; ?> /></span>
				<span><?php _e('Facebook Share',WP_SOCIAL_RING) ?></span>
			</li>
			<li>
				<span><input id='social_twitter_button' name='wp_social_ring_options[social_twitter_button]' type='checkbox' value="1" <?php if($wp_social_ring_options['social_twitter_button'] == 1) echo "checked"; ?> /></span>
				<span><?php _e('Twitter',WP_SOCIAL_RING) ?></span>
			</li>
			<li>
				<span><input id='social_google_button' name='wp_social_ring_options[social_google_button]' type='checkbox' value="1" <?php if($wp_social_ring_options['social_google_button'] == 1) echo "checked"; ?> /></span>
				<span><?php _e('Google +1',WP_SOCIAL_RING) ?></span>
			</li>
		</ul>

	<?php
}

function print_social_ring_show_on_input() {
	
	global $wp_social_ring_options;
	// echo the field

	?>

		<ul>
			<li>
				<span><input id='social_on_home' name='wp_social_ring_options[social_on_home]' type='checkbox' value="1" <?php if($wp_social_ring_options['social_on_home'] == 1) echo "checked"; ?> /></span>
				<span><?php _e('Home',WP_SOCIAL_RING) ?></span>
			</li>
			<li>
				<span><input id='social_on_pages' name='wp_social_ring_options[social_on_pages]' type='checkbox' value="1" <?php if($wp_social_ring_options['social_on_pages'] == 1) echo "checked"; ?> /></span>
				<span><?php _e('Pages',WP_SOCIAL_RING) ?></span>
			</li>
			<li>
				<span><input id='social_on_posts' name='wp_social_ring_options[social_on_posts]' type='checkbox' value="1" <?php if($wp_social_ring_options['social_on_posts'] == 1) echo "checked"; ?> /></span>
				<span><?php _e('Posts',WP_SOCIAL_RING) ?></span>
			</li>
			<li>
				<span><input id='social_on_category' name='wp_social_ring_options[social_on_category]' type='checkbox' value="1" <?php if($wp_social_ring_options['social_on_category'] == 1) echo "checked"; ?> /></span>
				<span><?php _e('Categories',WP_SOCIAL_RING) ?></span>
			</li>
			<li>
				<span><input id='social_on_archive' name='wp_social_ring_options[social_on_archive]' type='checkbox' value="1" <?php if($wp_social_ring_options['social_on_archive'] == 1) echo "checked"; ?> /></span>
				<span><?php _e('Archive',WP_SOCIAL_RING) ?></span>
			</li>
		</ul>

	<?php
}


// Validate user input (we want text only)
function wp_social_ring_validate_options( $input ) {
	
	global $wp_social_ring_options;
	
	//social
	$valid['social_facebook_like_button'] = (isset( $input['social_facebook_like_button'])) ? 1 : 0;
	$valid['social_facebook_send_button'] = (isset( $input['social_facebook_send_button'])) ? 1 : 0;
	if($valid['social_facebook_send_button'] == 1) {
		$valid['social_facebook_like_button'] = 1;
	}
	$valid['social_facebook_share_button'] = (isset( $input['social_facebook_share_button'])) ? 1 : 0;
	$valid['social_twitter_button'] = (isset( $input['social_twitter_button'])) ? 1 : 0;
	$valid['social_google_button'] = (isset( $input['social_google_button'])) ? 1 : 0;
	$valid['social_on_home'] = (isset( $input['social_on_home'])) ? 1 : 0;
	$valid['social_on_pages'] = (isset( $input['social_on_pages'])) ? 1 : 0;
	$valid['social_on_posts'] = (isset( $input['social_on_posts'])) ? 1 : 0;
	$valid['social_on_category'] = (isset( $input['social_on_category'])) ? 1 : 0;
	$valid['social_on_archive'] = (isset( $input['social_on_archive'])) ? 1 : 0;
	$valid['social_before_content'] = (isset( $input['social_before_content'])) ? 1 : 0;
	$valid['social_after_content'] = (isset( $input['social_after_content'])) ? 1 : 0;
	
	return $valid;
}

add_action('admin_menu', 'register_social_ring_admin_menu');
function register_social_ring_admin_menu() {

	add_menu_page(__('Social Ring settings',WP_SOCIAL_RING),__('Social Ring',WP_SOCIAL_RING),'manage_options',WP_SOCIAL_RING,WP_SOCIAL_RING.'_setting_page',plugins_url('/images/av-16x16.png',__FILE__));

}

?>