<?php 

/**
 * Add options page
 */
add_action('acf/init', 'my_acf_op_init');
function my_acf_op_init()
{
  // Check function exists.
  if (function_exists('acf_add_options_page')) {
    // Register options page.
    $option_page = acf_add_options_page(array(
      'page_title'    => 'הגדרות תבנית',
      'menu_title'    => 'הגדרות תבנית',
      'menu_slug'     => 'acf-theme-settings',
      'capability'    => 'edit_posts',
      'redirect'      => false
    ));
  }
}

/** 
 * Links
 */

// Print ACF Links
function printLink($link, $class = '')
{
  if ($link) :
    $link_target = $link['target'] ? $link['target'] : '_self';
    $class = ($class != '') ? 'class="' . $class . '"' : '';
    return '<a href="' . $link['url'] . '" ' . $class . ' target="' . $link_target . '">' . $link['title'] . '</a>';
  endif;
}

// Print Social Links
function printSocialLink($link_url, $icon_class, $link_name)
{
  if ($link_url && $icon_class && $link_name) {
    return '<li><a rel="external" href="' . $link_url . '"><i aria-hidden="true" class="' . $icon_class . '"></i> <span>' . $link_name . '</span></a></li>';
  }
}

/**
 * _s Customize ACF oEmbed
 */
function _s_custom_oembed($iframe)
{
	preg_match('/src="(.+?)"/', $iframe, $matches);
	$src = $matches[1];

	$params = array(
		'hd'   => 1,
		'rel'  => 0
	);
	$new_src = add_query_arg($params, $src);
	$iframe = str_replace($src, $new_src, $iframe);

	// Add extra attributes to iframe HTML.
	$attributes = 'frameborder="0"';
	$iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);

	// Display customized HTML.
	return $iframe;
}