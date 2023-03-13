<?php
/*
 * Template Name: Test Pagination Template
 */

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args = [ 'post_type' => 'post', 'paged' => $paged, 'post_status'=> 'publish'];

$blockTitle ="Test Block Title";
$className = 'blog mb-18';
$id ="";
?>

<style>
  ul.page-numbers {
    display: -webkit-box;
    display: -moz-flex;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -webkit-box-align: center;
    -ms-flex-align: center;
    -moz-align-items: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    margin: 4.25rem 0;
    list-style: none;
  }
  ul.page-numbers li {
    cursor: pointer;
    border: 1px solid #FFFFFF;
    border-radius: 0.5rem;
    text-align: center;
    margin: 0 0.5rem;
  }
  ul.page-numbers li a {
    text-decoration: none;
  }
  ul.page-numbers li.active {
    background-color: #2BABA9;
    border-color: #2BABA9;
  }
  ul.page-numbers li.active span, ul.page-numbers li.active a {
    color: #FFFFFF;
  }
  ul.page-numbers li:hover {
    background-color: #2BABA9;
    border-color: #2BABA9;
  }
  ul.page-numbers li:hover span, ul.page-numbers li:hover a {
    color: #FFFFFF;
  }
  ul.page-numbers li:hover .next:after, ul.page-numbers li:hover .prev:after {
    background-image: url("data:image/svg+xml,%3Csvg width='8' height='16' viewBox='0 0 8 14' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.5 13L6.5 7L1.5 1' stroke='%23FFFFFF' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E%0A");
  }
  ul.page-numbers li span, ul.page-numbers li a {
    font-size: 0.875rem;
    line-height: 1.3125rem;
    font-weight: 400;
    color: #828282;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
    padding: 0.28125rem 1rem;
    display: inline-block;
  }
  ul.page-numbers li .next:after, ul.page-numbers li .prev:after {
    content: "";
    display: inline-block;
    background-repeat: no-repeat;
    background-image: url("data:image/svg+xml,%3Csvg width='8' height='16' viewBox='0 0 8 14' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.5 13L6.5 7L1.5 1' stroke='%23828282' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E%0A");
    font-size: 14px;
    width: 8px;
    height: 16px;

  }
  ul.page-numbers li a.prev:after {
    -webkit-transform: rotate(180deg);
    transform: rotate(180deg);
  }
</style>
<?php get_header(); ?>

  <section class="is-layout-constrained group wp-block-group ">
    <div class="container alignfull ">
        <div class="<?=$className?>" id="<?=$id?>">
          <?php if($blockTitle) echo '<h1 class="h1 text-center">'.$blockTitle.'</h1>'; ?>

          <div class="w-100 mb-4 d-flex align-items-end flex-column">
            <form class="search" action="<?php the_permalink(); ?>" >
              <input type="text" placeholder="Search.." name="search" onfocus="this.placeholder = ''"
                     onblur="this.placeholder = 'Search..'"><button type="submit"><img src="<?=get_template_directory_uri()?>/dist/images/searchicon.svg"> </button>
            </form>
          </div>

          <div class="articles" >
            <div class="row gx-4 gy-4 row-gap-4 ">
              <?php

              //build query
              $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
              $args = [ 'post_type' => 'post', 'paged' => $paged, 'posts_per_page'=>2, 'post_status'=> 'publish'];


              if(isset($_GET['search']) && !empty($_GET['search'])) {
                $args['s'] = esc_html($_GET['search']);
              }

              $wp_query = new WP_Query( $args );
              // the query
               if ( $wp_query->have_posts() ) : ?>
                <!-- the loop -->
                <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
                       <div class="col-12 col-lg-4 col-md-6">
                           <article class="position-relative">
                               <?php
                               $img = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'medium' )[0];
                               if($img) {
                                   ?>
                                   <div class="article_img"><img src="<?=$img?>" alt="<?=get_the_title()?>" ></div>
                               <?php } ?>
                               <div class="article_info d-flex mb-2">
                                   <?php
                                   $categories = get_the_category();
                                   if($categories) echo '<div class="article-cat">'.esc_html( $categories[0]->name ).'</div>';
                                   ?>
                                   <!--Category 123 --><?php


                                   /*if ( ! empty( $categories ) ) {
                                       echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
                                   } */?>
                                   <div class="article-date"><?=get_the_date( 'j F Y' )?></div>
                               </div>
                               <div class="article_summary">
                                   <?php the_title("<h4>","</h4>"); ?>
                                   <?php the_excerpt(); ?>
                               </div>
                               <a href="<?php the_permalink(); ?>" class="link"></a>
                           </article>
                       </div>

                   <?php endwhile; ?>
                <!-- end of the loop -->
                 <?php App\custom_pagination($wp_query->max_num_pages,2,$paged); ?>
                 <!-- pagination here -->
                 <?php wp_reset_postdata(); ?>
               <?php else : ?>
                 <p><?php _e( 'Sorry, no articles matched your criteria.' ); ?></p>
               <?php endif; ?>

            </div>
          </div>
        </div>
    </div>
  </section>
<?php get_footer();