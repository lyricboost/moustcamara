<?php
/**
 * Template Name: Home Page (Full Width)
 * Description: Full-width layout for the home page with no container constraints
 */

get_header(); ?>

<div class="page-home">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            the_content();
        endwhile;
    endif;
    ?>
</div>

<?php get_footer(); ?>
