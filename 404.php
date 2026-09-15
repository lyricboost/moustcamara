<?php
/**
 * 404 Not Found Template
 *
 * Loads one of two layouts from template-parts/:
 *  - '404-hero'   : hero-alt style with background photo (current)
 *  - '404-simple' : original minimal centered layout
 * Swap the template part name below to switch versions.
 */

get_header();

get_template_part('template-parts/404-hero');

get_footer();
