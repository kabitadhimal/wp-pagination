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
    if (!$numpages) {
      $numpages = 1;
    }
  }

  $big = 999999999; // need an unlikely integer
  /**
   * We construct the pagination arguments to enter into our paginate_links
   * function.
   */
  $pagination_args = [
    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),

    'format' => '?paged=%#%',
    'total' => $numpages,
    'current' => $paged,
    'show_all' => False,
    'end_size' => 1,
    'type' => 'array', // output as an array
    'mid_size' => $pagerange,
    'prev_next' => false, // remove previous and next buttons
  ];
  $pages = paginate_links($pagination_args);
  if( $pages ) {
    ?>
      <ul class="page-numbers">
         <?php if ( get_query_var('paged') > 1 ) { ?>
            <li><?php previous_posts_link('')?></li>
         <?php } else {
            echo '<li><span class="prev page-numbers inactive"></span></li>';
          }
          foreach ( $pages as $page ) {
            $page = str_replace('<a','<li><a ',$page);
            $page = str_replace('</a>',' </a></li>',$page);
            $page = str_replace('<span','<li><span',$page);
            $page = str_replace('</span>',' </span></li>',$page);
            echo $page;
          }
          if ( get_query_var('paged') < $numpages ) {
            ?>
             <li><?php next_posts_link('', $numpages ); ?></li>
         <?php } else {
            echo '<li><span class="next page-numbers inactive "></span></li>';
          }
    ?>
      </ul>
  <?php }
}

/*
 * add class to next and previous link in pagination
 */
add_filter('next_posts_link_attributes', 'next_posts_link_attributes');
add_filter('previous_posts_link_attributes', 'previous_posts_link_attributes');

function previous_posts_link_attributes() {
  return 'class="prev page-numbers"';
}
function next_posts_link_attributes() {
  return 'class="next page-numbers"';
}
