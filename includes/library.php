<?php

function social_ring_add_opengraph_namespace( $output ) {
	return $output.' xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml"';
}
		
function social_ring_add_opengraph_meta() {
	
	global $post;
	
	if (is_singular()) {
		echo "\n\n<!-- Social Ring: Facebook Open Graph Meta Start -->\n";
		echo "<meta property=\"og:url\" content=\"".esc_attr(get_permalink($post->ID))."\" />\n";
		echo "<meta property=\"og:title\" content=\"".esc_attr( strip_tags( stripslashes($post->post_title)))."\" />\n";
		echo "<meta property=\"og:type\" content=\"article\" />\n";
		echo "<meta property=\"og:site_name\" content=\"".esc_attr(get_bloginfo('name'))."\" />\n";
		echo "<meta property=\"og:description\" content=\"".esc_attr(social_ring_make_excerpt($post))."\" />\n";
		if ( empty( $image ) && function_exists('has_post_thumbnail') && has_post_thumbnail( $post->ID ) ) {
			$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumbnail' );
			if ( $thumbnail )
				$image = $thumbnail[0];
		// If that's not there, grab the first attached image
		} else {
			$files = get_children( 
						array( 
						'post_parent' => $post->ID,
						'post_type' => 'attachment',
						'post_mime_type' => 'image',
						) 
					);
			if ( $files ) {
				$keys = array_reverse( array_keys( $files ) );
				$image = image_downsize( $keys[0], 'thumbnail' );
				$image = $image[0];
			//if there's no attached image, try to grab first image in content
			} else {
				$image = social_ring_get_first_image();
			}
		}	
		if ( $image != '' ) {
			echo "<meta property=\"og:image\" content=\"".esc_attr( $image )."\" />\n";
		}
		echo "<!-- Social Ring: Facebook Open Graph Meta End -->\n\n";
	}
	
}

function social_ring_get_first_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();

  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i',
       $post->post_content, $matches);
  $first_img = $matches [1] [0];

  return $first_img;
}

function social_ring_add_css() {

	global $wp_social_ring_options;
	if(social_ring_print_check() == 1) {
?> 

		<style type="text/css">
			.social-ring {
				margin: 0 !important;
				padding: 0 !important;
				line-height: 20px !important;
				height: 30px !important;
				font-size: 11px;
				
			}
			
			.social-ring-button {
				float: left !important;
				margin: 0 !important;
				padding: 0 !important;
			}
			
		</style>

<?php
	}
}

function social_ring_add_sharing($content) {

	global $wp_social_ring_options;

	if(social_ring_print_check() == 1 && ($wp_social_ring_options['social_before_content'] == 1 || $wp_social_ring_options['social_after_content'] == 1)) {
	
		$url = get_permalink(get_the_ID());
		$title = get_the_title(get_the_ID());
		$html = '<div class="social-ring">';
	
		if($wp_social_ring_options['social_twitter_button'] == 1) {
			$html .= '<div class="social-ring-button"><a href="http://twitter.com/share" data-url="'.$url.'" data-text="'.$title.'" data-count="horizontal" class="sr-twitter-button twitter-share-button"></a></div>';
		}
		
		if($wp_social_ring_options['social_google_button'] == 1) {
			$html .= '<div class="social-ring-button"><g:plusone size="medium" callback="plusone_vote"></g:plusone></div>';
		}
		
		if($wp_social_ring_options['social_facebook_share_button'] == 1) {
			$html .= '<div class="social-ring-button"><iframe allowtransparency="true" frameborder="0" hspace="0" marginheight="0" marginwidth="0" scrolling="no" style="width: 70px; height: 21px; position: static; left: 0px; top: 0px; visibility: visible; " tabindex="-1" vspace="0" width="100%" src="'.WP_SOCIAL_RING_URL.'/includes/share.php?url='.urlencode($url).'"></iframe></div>';	
		}
		if($wp_social_ring_options['social_facebook_like_button'] == 1) {
			if(!preg_match("/MSIE 8.0/", $_SERVER['HTTP_USER_AGENT']) ) {
				if($wp_social_ring_options['social_facebook_send_button'] == 1) {
					$send = 'true';
					$width = 180;
				} else {
					$send = 'false';
					$width = 140;
				}
				$html .= '<div class="social-ring-button"><fb:like href="'.$url.'" send="'.$send.'" showfaces="false" width="'.$width.'" layout="button_count" action="like"/></fb:like></div>';
			} else {
				$html .= '<div class="social-ring-button"><iframe src="http://www.facebook.com/plugins/like.php?app_id=131347983616840&amp;href='.urlencode($url).'&amp;send=false&amp;layout=button_count&amp;width=75&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:110px; height:21px;" allowTransparency="true"></iframe></div>';
			}
		}
	
		$html .= '</div>';
		$html .= '<div style="clear:both;">&nbsp;</div>';
		
		if($wp_social_ring_options['social_before_content'] == 1) {
			$content = $html.$content;
		} 
		if($wp_social_ring_options['social_after_content'] == 1) {
			$content = $content.$html;
		}
		
	}
	
	return $content;
}

function social_ring_add_js() {

	global $wp_social_ring_options;
	if(social_ring_print_check() == 1) {
		?>
		<!-- Social Ring JS Start-->
		<?php
		if($wp_social_ring_options['social_facebook_like_button'] == 1) {
			if(defined(WPLANG)) {
?>
<div id="fb-root"></div><script src="http://connect.facebook.net/<?php echo WPLANG; ?>/all.js#xfbml=1"></script>
<?php
			 } else {
?>
<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
<?php			 
			 }
		}
		if($wp_social_ring_options['social_google_button'] == 1) {
?>
<script type='text/javascript' src='https://apis.google.com/js/plusone.js'></script>
<?php
		}
		if($wp_social_ring_options['social_twitter_button'] == 1) {
?>
<script type='text/javascript'>
function insertTweetText(element, index, array) {
	element.innerHTML = 'Twitter';
}
var className = 'sr-twitter-button';
var hasClassName = new RegExp("(?:^|\\s)" + className + "(?:$|\\s)");
var allElements = document.getElementsByTagName("a");
var twitterLinks = [];
for (var i = 0; (element = allElements[i]) != null; i++) {
	var elementClass = element.className;
	if (elementClass && elementClass.indexOf(className) != -1 && hasClassName.test(elementClass))
		twitterLinks.push(element);
}

twitterLinks.forEach(insertTweetText);
</script>
<script type='text/javascript' src='http://platform.twitter.com/widgets.js'></script>
<?php
		}
		?>
		<!-- Social Ring JS End-->
		<?php
	}
}

function social_ring_print_check() {

	global $wp_social_ring_options;
	
	if(is_single()) {
		return $wp_social_ring_options['social_on_posts'];
	}
	if(is_page()) {
		return $wp_social_ring_options['social_on_pages'];
	}
	if(is_home()) {
		return $wp_social_ring_options['social_on_home'];
	}
	if(is_category()) {
		return $wp_social_ring_options['social_on_category'];
	}
	if(is_archive()) {
		return $wp_social_ring_options['social_on_archive'];
	}
	return 0;

}

/* Code from Simple Facebook Connect by Otto (http://ottopress.com) */
function social_ring_make_excerpt($post) { 
	
	if (!empty($post->post_excerpt)) $text = $post->post_excerpt;
	else $text = $post->post_content;
	
	$text = strip_shortcodes( $text );

	remove_filter( 'the_content', 'wptexturize' );
	$text = apply_filters('the_content', $text);
	add_filter( 'the_content', 'wptexturize' );

	$text = str_replace(']]>', ']]&gt;', $text);
	$text = wp_strip_all_tags($text);
	$text = str_replace(array("\r\n","\r","\n"),' ',$text);

	$excerpt_more = apply_filters('excerpt_more', '[...]');
	$excerpt_more = html_entity_decode($excerpt_more, ENT_QUOTES, 'UTF-8');
	$text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');

	$max = min(1000,apply_filters('sfc_excerpt_length',1000));
	$max -= strlen ($excerpt_more) + 1;
	$max -= strlen ('</fb:intl>') * 2 - 1;

	if ($max<1) return ''; // nothing to send
	
	if (strlen($text) >= $max) {
		$text = substr($text, 0, $max);
		$words = explode(' ', $text);
		array_pop ($words);
		array_push ($words, $excerpt_more);
		$text = implode(' ', $words);
	}

	return $text;
}

?>