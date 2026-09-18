<?php
/**
 * Front Page Template
 * This template is automatically used for the site's homepage
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
