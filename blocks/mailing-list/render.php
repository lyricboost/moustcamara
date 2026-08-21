<?php
/**
 * Mailing List Signup Block
 * 
 * @package MoustCamara
 */

$custom_id = get_field('custom_id');
$eyebrow = get_field('eyebrow');
$heading = get_field('heading');
$heading_size = get_field('heading_size') ?: 'medium';
$description = get_field('description');
$form_fields = get_field('form_fields') ?: [];
$submit_text = get_field('submit_text') ?: 'Subscribe';
$fine_print = get_field('fine_print');
$image = get_field('image');
$image_position = get_field('image_position') ?: 'left';
$image_style = get_field('image_style') ?: 'square';
$image_focal_point = get_field('image_focal_point') ?: 'center';
$image_breakout = get_field('image_breakout');
$layout = get_field('layout') ?: 'split';
$background = get_field('background_color') ?: 'none';

// Mailchimp settings
$mailchimp_list_id = get_field('mailchimp_list_id');
$mailchimp_api_key = get_field('mailchimp_api_key');

// Build CSS classes
$classes = ['mailing-list-section'];

if ($background !== 'none') {
    $classes[] = 'bg-' . $background;
}

// Add text-light class for dark backgrounds
if (in_array($background, ['navy', 'dark-gray', 'black'])) {
    $classes[] = 'text-light';
}

if ($layout === 'centered') {
    $classes[] = 'mailing-list--centered';
} else {
    $classes[] = 'mailing-list--split';
    $classes[] = 'mailing-list--image-' . $image_position;
}

if ($heading_size === 'large') {
    $classes[] = 'mailing-list--heading-large';
}

if ($image_focal_point !== 'center') {
    $classes[] = 'mailing-list--focal-' . $image_focal_point;
}

if ($image_breakout && $layout === 'split') {
    $classes[] = 'mailing-list--breakout';
}

$image_wrapper_class = 'mailing-list-image-wrapper';
if ($image_style === 'square') {
    $image_wrapper_class .= ' mailing-list-image-wrapper--square';
}

$section_class = implode(' ', $classes);

// Generate unique form ID
$form_id = 'mailing-list-' . uniqid();
?>

<section class="<?php echo esc_attr($section_class); ?>"<?php echo $custom_id ? ' id="' . esc_attr($custom_id) . '"' : ''; ?>>
    <div class="container-fluid px-4">
        <?php if ($layout === 'centered'): ?>
            <!-- Centered Layout (no image) -->
            <div class="mailing-list-wrapper mailing-list-wrapper--centered">
                <div class="mailing-list-content">
                    <?php if ($eyebrow): ?>
                        <div class="mailing-list-eyebrow"><?php echo esc_html($eyebrow); ?></div>
                    <?php endif; ?>
                    
                    <?php if ($heading): ?>
                        <h2 class="mailing-list-heading"><?php echo esc_html($heading); ?></h2>
                    <?php endif; ?>
                    
                    <?php if ($description): ?>
                        <div class="mailing-list-description"><?php echo wp_kses_post($description); ?></div>
                    <?php endif; ?>
                    
                    <!-- Mailing List Form -->
                    <form class="mailing-list-form" id="<?php echo esc_attr($form_id); ?>" data-list-id="<?php echo esc_attr($mailchimp_list_id); ?>">
                        <?php wp_nonce_field('mailing_list_signup', 'mailing_list_nonce'); ?>
                        <input type="hidden" name="list_id" value="<?php echo esc_attr($mailchimp_list_id); ?>">
                        <input type="hidden" name="mailchimp_api_key" value="<?php echo esc_attr($mailchimp_api_key); ?>">
                        
                        <?php if (!empty($form_fields)): ?>
                            <div class="mailing-list-fields">
                                <?php foreach ($form_fields as $field): 
                                    $field_type = $field['field_type'];
                                    $field_label = $field['label'];
                                    $field_placeholder = $field['placeholder'] ?? '';
                                    $field_required = $field['required'] ?? false;
                                    $mailchimp_field = $field['mailchimp_field'] ?? '';
                                    
                                    // Generate field name from mailchimp field or label
                                    $field_name = !empty($mailchimp_field) ? $mailchimp_field : sanitize_title($field_label);
                                    $required_attr = $field_required ? 'required' : '';
                                ?>
                                
                                <div class="mailing-list-field">
                                    <?php if ($field_type === 'text'): ?>
                                        <input 
                                            type="text" 
                                            class="mailing-list-input" 
                                            id="<?php echo esc_attr($field_name); ?>" 
                                            name="<?php echo esc_attr($field_name); ?>" 
                                            placeholder="<?php echo esc_attr($field_placeholder ?: $field_label); ?>"
                                            data-mailchimp-field="<?php echo esc_attr($mailchimp_field); ?>"
                                            <?php echo $required_attr; ?>
                                        >
                                    <?php elseif ($field_type === 'email'): ?>
                                        <input 
                                            type="email" 
                                            class="mailing-list-input" 
                                            id="<?php echo esc_attr($field_name); ?>" 
                                            name="<?php echo esc_attr($field_name); ?>" 
                                            placeholder="<?php echo esc_attr($field_placeholder ?: $field_label); ?>"
                                            data-mailchimp-field="<?php echo esc_attr($mailchimp_field); ?>"
                                            <?php echo $required_attr; ?>
                                        >
                                    <?php endif; ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <button type="submit" class="mailing-list-submit">
                            <?php echo esc_html($submit_text); ?>
                            <svg class="mailing-list-submit-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </button>
                        
                        <div class="mailing-list-message" style="display: none;"></div>
                    </form>
                    
                    <?php if ($fine_print): ?>
                        <div class="mailing-list-fine-print"><?php echo wp_kses_post($fine_print); ?></div>
                    <?php endif; ?>
                </div>
            </div>
            
        <?php else: ?>
            <!-- Split Layout (with image) -->
            <div class="mailing-list-wrapper mailing-list-wrapper--split">
                <div class="row align-items-center g-5">
                    <?php if ($image_position === 'left'): ?>
                        <!-- Image Left -->
                        <div class="col-lg-6 order-2 order-lg-1">
                            <div class="mailing-list-image d-flex justify-content-center justify-content-lg-start" <?php if ($image) : ?>style="background-image: url(<?php echo esc_url($image['url']); ?>);"<?php endif; ?>>
                                <div class="<?php echo esc_attr($image_wrapper_class); ?>">
                                    <?php if ($image): ?>
                                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?: $heading); ?>" class="mailing-list-image-element" />
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/600x600" alt="<?php echo esc_attr($heading); ?>" class="mailing-list-image-element" />
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 order-1 order-lg-2">
                    <?php else: ?>
                        <!-- Image Right -->
                        <div class="col-lg-6 order-1 order-lg-1">
                    <?php endif; ?>
                    
                            <div class="mailing-list-content">
                                <?php if ($eyebrow): ?>
                                    <div class="mailing-list-eyebrow"><?php echo esc_html($eyebrow); ?></div>
                                <?php endif; ?>
                                
                                <?php if ($heading): ?>
                                    <h2 class="mailing-list-heading"><?php echo esc_html($heading); ?></h2>
                                <?php endif; ?>
                                
                                <?php if ($description): ?>
                                    <div class="mailing-list-description"><?php echo wp_kses_post($description); ?></div>
                                <?php endif; ?>
                                
                                <!-- Mailing List Form -->
                                <form class="mailing-list-form" id="<?php echo esc_attr($form_id); ?>" data-list-id="<?php echo esc_attr($mailchimp_list_id); ?>">
                                    <?php wp_nonce_field('mailing_list_signup', 'mailing_list_nonce'); ?>
                                    <input type="hidden" name="list_id" value="<?php echo esc_attr($mailchimp_list_id); ?>">
                                    <input type="hidden" name="mailchimp_api_key" value="<?php echo esc_attr($mailchimp_api_key); ?>">
                                    
                                    <?php if (!empty($form_fields)): ?>
                                        <div class="mailing-list-fields">
                                            <?php foreach ($form_fields as $field): 
                                                $field_type = $field['field_type'];
                                                $field_label = $field['label'];
                                                $field_placeholder = $field['placeholder'] ?? '';
                                                $field_required = $field['required'] ?? false;
                                                $mailchimp_field = $field['mailchimp_field'] ?? '';
                                                
                                                // Generate field name from mailchimp field or label
                                                $field_name = !empty($mailchimp_field) ? $mailchimp_field : sanitize_title($field_label);
                                                $required_attr = $field_required ? 'required' : '';
                                            ?>
                                            
                                            <div class="mailing-list-field">
                                                <?php if ($field_type === 'text'): ?>
                                                    <input 
                                                        type="text" 
                                                        class="mailing-list-input" 
                                                        id="<?php echo esc_attr($field_name); ?>" 
                                                        name="<?php echo esc_attr($field_name); ?>" 
                                                        placeholder="<?php echo esc_attr($field_placeholder ?: $field_label); ?>"
                                                        data-mailchimp-field="<?php echo esc_attr($mailchimp_field); ?>"
                                                        <?php echo $required_attr; ?>
                                                    >
                                                <?php elseif ($field_type === 'email'): ?>
                                                    <input 
                                                        type="email" 
                                                        class="mailing-list-input" 
                                                        id="<?php echo esc_attr($field_name); ?>" 
                                                        name="<?php echo esc_attr($field_name); ?>" 
                                                        placeholder="<?php echo esc_attr($field_placeholder ?: $field_label); ?>"
                                                        data-mailchimp-field="<?php echo esc_attr($mailchimp_field); ?>"
                                                        <?php echo $required_attr; ?>
                                                    >
                                                <?php endif; ?>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <button type="submit" class="mailing-list-submit">
                                        <?php echo esc_html($submit_text); ?>
                                        <svg class="mailing-list-submit-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </button>
                                    
                                    <div class="mailing-list-message" style="display: none;"></div>
                                </form>
                                
                                <?php if ($fine_print): ?>
                                    <div class="mailing-list-fine-print"><?php echo wp_kses_post($fine_print); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                    <?php if ($image_position === 'right'): ?>
                        <div class="col-lg-6 order-2 order-lg-2">
                            <div class="mailing-list-image d-flex justify-content-center justify-content-lg-end" <?php if ($image) : ?>style="background-image: url(<?php echo esc_url($image['url']); ?>);"<?php endif; ?>>
                                <div class="<?php echo esc_attr($image_wrapper_class); ?>">
                                    <?php if ($image): ?>
                                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?: $heading); ?>" class="mailing-list-image-element" />
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/600x600" alt="<?php echo esc_attr($heading); ?>" class="mailing-list-image-element" />
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('<?php echo esc_js($form_id); ?>');
    if (!form) return;
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const submitButton = form.querySelector('.mailing-list-submit');
        const messageDiv = form.querySelector('.mailing-list-message');
        const originalText = submitButton.innerHTML;
        
        // Disable button and show loading
        submitButton.disabled = true;
        submitButton.innerHTML = 'Subscribing...';
        messageDiv.style.display = 'none';
        
        // Collect form data
        const formData = new FormData(form);
        formData.append('action', 'mailing_list_signup');
        
        try {
            const response = await fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                messageDiv.className = 'mailing-list-message mailing-list-message--success';
                messageDiv.textContent = result.data.message || 'Thank you for subscribing!';
                messageDiv.style.display = 'block';
                form.reset();
            } else {
                messageDiv.className = 'mailing-list-message mailing-list-message--error';
                messageDiv.textContent = result.data.message || 'Something went wrong. Please try again.';
                messageDiv.style.display = 'block';
            }
        } catch (error) {
            messageDiv.className = 'mailing-list-message mailing-list-message--error';
            messageDiv.textContent = 'Network error. Please try again.';
            messageDiv.style.display = 'block';
        } finally {
            submitButton.disabled = false;
            submitButton.innerHTML = originalText;
        }
    });
});
</script>
