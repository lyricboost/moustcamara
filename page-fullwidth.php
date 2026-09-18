<?php
/**
 * Template Name: Full Width
 * Description: Full-width page layout with no container constraints
 */

get_header(); ?>

<div class="page-fullwidth">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            the_content();
        endwhile;
    endif;
    ?>
</div>

<?php get_footer(); ?>
