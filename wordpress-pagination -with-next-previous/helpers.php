<?php
/**
 * referralready helper functions
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @package referralready
 */
namespace App;

/**
 * @param string $numpages
 * @param string $pagerange
 * @param string $paged
 * http://callmenick.com/post/custom-wordpress-loop-with-pagination
 */
function custom_pagination($numpages = '', $pagerange = '', $paged='', $base = '', $type='') {

  if ($pagerange) {
    $pagerange = 2;
  }

  /**
   * This first part of our function is a fallback
   * for custom pagination inside a regular loop that
   * uses the global $paged and global $wp_query variables.
   *
   * It's good because we can now override default pagination
   * in our theme, and use this function in default quries
   * and custom queries.
   */
  global $paged;
  if (empty($paged)) {
    $paged = 1;
  }

  if ($numpages == '') {
    global $wp_query;
    $numpages = $wp_query->max_num_pages;
    if(!$numpages) {
      $numpages = 1;
    }
  }

  $base = ($base) ? : get_pagenum_link(1);

  /**
   * We construct the pagination arguments to enter into our paginate_links
   * function.
   */
  $pagination_args = array(
    'base'            => $base.'%_%',
    'format'          => 'page/%#%',
    'total'           => $numpages,
    'current'         => $paged,
    'show_all'        => False,
    'end_size'        => 2,
    'mid_size'        => $pagerange,
    'prev_next'       => True,
    'prev_text'       => __(''),
    'next_text'       => __(''),
    'type'      => 'list',
    'add_args'        => false,
    'add_fragment'    => '',
  );


  $paginate_links = paginate_links($pagination_args);


  $paginate_links = str_replace('<li><span aria-current="page" class="page-numbers current">','<li class="active"><span aria-current="page" class="page-numbers current">',$paginate_links);
  echo $paginate_links;
}
