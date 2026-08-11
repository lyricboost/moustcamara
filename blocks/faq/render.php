<?php
/**
 * FAQ Block
 * 
 * @package MoustCamara
 */

$heading = get_field('heading') ?: '';
$subheading = get_field('subheading') ?: '';
$heading_size = get_field('heading_size') ?: 'large';
$heading_class = $heading_size === 'medium' ? ' faq-heading--medium' : '';
$image = get_field('image');
$background = get_field('background_color') ?: 'none';
$show_numbering = get_field('show_numbering');
$items = get_field('items') ?: [];

// Build CSS classes
$classes = ['faq-section'];

if ($background !== 'none') {
    $classes[] = 'faq-section--bg-' . $background;
    
    // Add text-light class for dark backgrounds
    if (in_array($background, ['navy', 'dark-gray', 'black'])) {
        $classes[] = 'text-light';
    }
}

if (!$image) {
    $classes[] = 'faq-section--no-image';
}

if ($show_numbering) {
    $classes[] = 'faq-section--numbered';
}

$section_class = implode(' ', $classes);
?>

<section class="<?php echo esc_attr($section_class); ?>">
    <div class="container">
        <div class="faq-wrapper">
            <?php if ($image): ?>
                <div class="faq-image" style="background-image: url('<?php echo esc_url($image['url']); ?>');">
                </div>
            <?php endif; ?>
            
            <div class="faq-content">
                <?php if ($heading || $subheading): ?>
                    <div class="faq-header<?php echo esc_attr($heading_class); ?>">
                        <?php if ($heading): ?>
                            <h2 class="faq-heading"><?php echo esc_html($heading); ?></h2>
                        <?php endif; ?>
                        <?php if ($subheading): ?>
                            <p class="faq-subheading"><?php echo esc_html($subheading); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php 
                $intro_text = get_field('intro_text');
                if ($intro_text): 
                ?>
                    <div class="faq-intro"><?php echo wp_kses_post($intro_text); ?></div>
                <?php endif; ?>

                <?php if (!empty($items)): ?>
                    <div class="faq-accordion">
                        <?php foreach ($items as $item):
                            $question = $item['question'] ?? '';
                            $answer = $item['answer'] ?? '';
                            
                            if (empty($question)) continue;
                        ?>
                            <details class="faq-accordion-item">
                                <summary class="faq-accordion-question">
                                    <span class="faq-accordion-question-text"><?php echo esc_html($question); ?></span>
                                    <span class="faq-accordion-icon">
                                        <i data-lucide="plus" class="icon-plus"></i>
                                        <i data-lucide="minus" class="icon-minus"></i>
                                    </span>
                                </summary>
                                <div class="faq-accordion-answer"><?php echo wp_kses_post($answer); ?></div>
                            </details>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script>
  if (typeof lucide !== 'undefined') {
    lucide.createIcons();
  }
</script>
