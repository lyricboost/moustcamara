<?php
/**
 * Contact Form Block Template
 */

$heading = get_field('heading');
$description = get_field('description');
$side_image = get_field('side_image');
$background_color = get_field('background_color') ?: 'white';
$form_fields = get_field('form_fields');
$submit_text = get_field('submit_text') ?: 'Send Message';
$recipient_email = get_field('recipient_email') ?: get_option('admin_email');
$success_message = get_field('success_message') ?: 'Thank you! Your message has been sent.';

// Set text color based on background
$text_class = '';
if (in_array($background_color, ['navy', 'dark-gray', 'black'])) {
    $text_class = 'text-light';
}

// Background color mapping
$block_classes = 'moust-contact-form';
if ($background_color !== 'white') {
    $block_classes .= ' bg-' . $background_color;
}
if ($text_class) {
    $block_classes .= ' ' . $text_class;
}

$has_image = !empty($side_image);
?>

<section class="<?php echo esc_attr($block_classes); ?>">
    <div class="container-fluid px-4">
        <div class="contact-form-inner">
            <?php if ($has_image): ?>
            <div class="row align-items-center g-5">
                <div class="col-lg-6 order-2 order-lg-1">
                    <div class="contact-form-image-wrapper d-flex justify-content-center justify-content-lg-start" style="background-image: url(<?php echo esc_url($side_image['url']); ?>);">
                        <div class="contact-form-image">
                            <img src="<?php echo esc_url($side_image['url']); ?>" alt="<?php echo esc_attr($side_image['alt'] ?: 'Contact'); ?>" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2">
                    <div class="contact-form-content">
                        <?php if ($heading || $description): ?>
                        <div class="form-header mb-4">
                            <?php if ($heading): ?>
                                <h2 class="mb-3"><?php echo esc_html($heading); ?></h2>
                            <?php endif; ?>
                            <?php if ($description): ?>
                                <div class="form-description"><?php echo $description; ?></div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        
                        <form class="moust-form" data-recipient="<?php echo esc_attr($recipient_email); ?>" data-success="<?php echo esc_attr($success_message); ?>">
                            <?php wp_nonce_field('moust_contact_form', 'moust_contact_nonce'); ?>
                            
                            <?php if ($form_fields && count($form_fields) > 0): ?>
                                <?php foreach ($form_fields as $field): 
                                    $field_type = $field['field_type'];
                                    $field_label = $field['label'];
                                    $field_name = sanitize_title($field_label);
                                    $field_required = $field['required'];
                                    $field_placeholder = $field['placeholder'] ?? '';
                                    $required_attr = $field_required ? 'required' : '';
                                    $required_mark = $field_required ? '<span class="required-mark">*</span>' : '';
                                ?>
                                
                                <div class="form-group mb-3">
                                    <label for="<?php echo esc_attr($field_name); ?>" class="form-label">
                                        <?php echo esc_html($field_label); ?><?php echo $required_mark; ?>
                                    </label>
                                    
                                    <?php if ($field_type === 'text' || $field_type === 'email'): ?>
                                        <input 
                                            type="<?php echo esc_attr($field_type); ?>" 
                                            class="form-control" 
                                            id="<?php echo esc_attr($field_name); ?>" 
                                            name="<?php echo esc_attr($field_name); ?>" 
                                            placeholder="<?php echo esc_attr($field_placeholder); ?>"
                                            <?php echo $required_attr; ?>
                                        >
                                    
                                    <?php elseif ($field_type === 'textarea'): ?>
                                        <textarea 
                                            class="form-control" 
                                            id="<?php echo esc_attr($field_name); ?>" 
                                            name="<?php echo esc_attr($field_name); ?>" 
                                            rows="5"
                                            placeholder="<?php echo esc_attr($field_placeholder); ?>"
                                            <?php echo $required_attr; ?>
                                        ></textarea>
                                    
                                    <?php elseif ($field_type === 'select' && !empty($field['options'])): ?>
                                        <select 
                                            class="form-select" 
                                            id="<?php echo esc_attr($field_name); ?>" 
                                            name="<?php echo esc_attr($field_name); ?>"
                                            <?php echo $required_attr; ?>
                                        >
                                            <option value="">Select an option</option>
                                            <?php 
                                            $options = explode("\n", $field['options']);
                                            foreach ($options as $option): 
                                                $option = trim($option);
                                                if (!empty($option)):
                                            ?>
                                                <option value="<?php echo esc_attr($option); ?>"><?php echo esc_html($option); ?></option>
                                            <?php 
                                                endif;
                                            endforeach; 
                                            ?>
                                        </select>
                                    
                                    <?php elseif ($field_type === 'radio' && !empty($field['options'])): ?>
                                        <?php 
                                        $options = explode("\n", $field['options']);
                                        foreach ($options as $index => $option): 
                                            $option = trim($option);
                                            if (!empty($option)):
                                                $radio_id = $field_name . '_' . $index;
                                        ?>
                                            <div class="form-check">
                                                <input 
                                                    class="form-check-input" 
                                                    type="radio" 
                                                    name="<?php echo esc_attr($field_name); ?>" 
                                                    id="<?php echo esc_attr($radio_id); ?>" 
                                                    value="<?php echo esc_attr($option); ?>"
                                                    <?php echo $required_attr; ?>
                                                >
                                                <label class="form-check-label" for="<?php echo esc_attr($radio_id); ?>">
                                                    <?php echo esc_html($option); ?>
                                                </label>
                                            </div>
                                        <?php 
                                            endif;
                                        endforeach; 
                                        ?>
                                    
                                    <?php elseif ($field_type === 'checkbox' && !empty($field['options'])): ?>
                                        <?php 
                                        $options = explode("\n", $field['options']);
                                        foreach ($options as $index => $option): 
                                            $option = trim($option);
                                            if (!empty($option)):
                                                $checkbox_id = $field_name . '_' . $index;
                                        ?>
                                            <div class="form-check">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    name="<?php echo esc_attr($field_name); ?>[]" 
                                                    id="<?php echo esc_attr($checkbox_id); ?>" 
                                                    value="<?php echo esc_attr($option); ?>"
                                                >
                                                <label class="form-check-label" for="<?php echo esc_attr($checkbox_id); ?>">
                                                    <?php echo esc_html($option); ?>
                                                </label>
                                            </div>
                                        <?php 
                                            endif;
                                        endforeach; 
                                        ?>
                                    
                                    <?php endif; ?>
                                </div>
                                
                                <?php endforeach; ?>
                            <?php endif; ?>
                            
                            <div class="form-message mt-4" style="display: none;"></div>
                            
                            <div class="form-actions mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <?php echo esc_html($submit_text); ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="contact-form-content">
                        <?php if ($heading || $description): ?>
                        <div class="form-header mb-4">
                            <?php if ($heading): ?>
                                <h2 class="mb-3"><?php echo esc_html($heading); ?></h2>
                            <?php endif; ?>
                            <?php if ($description): ?>
                                <div class="form-description"><?php echo $description; ?></div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        
                        <form class="moust-form" data-recipient="<?php echo esc_attr($recipient_email); ?>" data-success="<?php echo esc_attr($success_message); ?>">
                            <?php wp_nonce_field('moust_contact_form', 'moust_contact_nonce'); ?>
                            
                            <?php if ($form_fields && count($form_fields) > 0): ?>
                                <?php foreach ($form_fields as $field): 
                                    $field_type = $field['field_type'];
                                    $field_label = $field['label'];
                                    $field_name = sanitize_title($field_label);
                                    $field_required = $field['required'];
                                    $field_placeholder = $field['placeholder'] ?? '';
                                    $required_attr = $field_required ? 'required' : '';
                                    $required_mark = $field_required ? '<span class="required-mark">*</span>' : '';
                                ?>
                                
                                <div class="form-group mb-3">
                                    <label for="<?php echo esc_attr($field_name); ?>" class="form-label">
                                        <?php echo esc_html($field_label); ?><?php echo $required_mark; ?>
                                    </label>
                                    
                                    <?php if ($field_type === 'text' || $field_type === 'email'): ?>
                                        <input 
                                            type="<?php echo esc_attr($field_type); ?>" 
                                            class="form-control" 
                                            id="<?php echo esc_attr($field_name); ?>" 
                                            name="<?php echo esc_attr($field_name); ?>" 
                                            placeholder="<?php echo esc_attr($field_placeholder); ?>"
                                            <?php echo $required_attr; ?>
                                        >
                                    
                                    <?php elseif ($field_type === 'textarea'): ?>
                                        <textarea 
                                            class="form-control" 
                                            id="<?php echo esc_attr($field_name); ?>" 
                                            name="<?php echo esc_attr($field_name); ?>" 
                                            rows="5"
                                            placeholder="<?php echo esc_attr($field_placeholder); ?>"
                                            <?php echo $required_attr; ?>
                                        ></textarea>
                                    
                                    <?php elseif ($field_type === 'select' && !empty($field['options'])): ?>
                                        <select 
                                            class="form-select" 
                                            id="<?php echo esc_attr($field_name); ?>" 
                                            name="<?php echo esc_attr($field_name); ?>"
                                            <?php echo $required_attr; ?>
                                        >
                                            <option value="">Select an option</option>
                                            <?php 
                                            $options = explode("\n", $field['options']);
                                            foreach ($options as $option): 
                                                $option = trim($option);
                                                if (!empty($option)):
                                            ?>
                                                <option value="<?php echo esc_attr($option); ?>"><?php echo esc_html($option); ?></option>
                                            <?php 
                                                endif;
                                            endforeach; 
                                            ?>
                                        </select>
                                    
                                    <?php elseif ($field_type === 'radio' && !empty($field['options'])): ?>
                                        <?php 
                                        $options = explode("\n", $field['options']);
                                        foreach ($options as $index => $option): 
                                            $option = trim($option);
                                            if (!empty($option)):
                                                $radio_id = $field_name . '_' . $index;
                                        ?>
                                            <div class="form-check">
                                                <input 
                                                    class="form-check-input" 
                                                    type="radio" 
                                                    name="<?php echo esc_attr($field_name); ?>" 
                                                    id="<?php echo esc_attr($radio_id); ?>" 
                                                    value="<?php echo esc_attr($option); ?>"
                                                    <?php echo $required_attr; ?>
                                                >
                                                <label class="form-check-label" for="<?php echo esc_attr($radio_id); ?>">
                                                    <?php echo esc_html($option); ?>
                                                </label>
                                            </div>
                                        <?php 
                                            endif;
                                        endforeach; 
                                        ?>
                                    
                                    <?php elseif ($field_type === 'checkbox' && !empty($field['options'])): ?>
                                        <?php 
                                        $options = explode("\n", $field['options']);
                                        foreach ($options as $index => $option): 
                                            $option = trim($option);
                                            if (!empty($option)):
                                                $checkbox_id = $field_name . '_' . $index;
                                        ?>
                                            <div class="form-check">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    name="<?php echo esc_attr($field_name); ?>[]" 
                                                    id="<?php echo esc_attr($checkbox_id); ?>" 
                                                    value="<?php echo esc_attr($option); ?>"
                                                >
                                                <label class="form-check-label" for="<?php echo esc_attr($checkbox_id); ?>">
                                                    <?php echo esc_html($option); ?>
                                                </label>
                                            </div>
                                        <?php 
                                            endif;
                                        endforeach; 
                                        ?>
                                    
                                    <?php endif; ?>
                                </div>
                                
                                <?php endforeach; ?>
                            <?php endif; ?>
                            
                            <div class="form-message mt-4" style="display: none;"></div>
                            
                            <div class="form-actions mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <?php echo esc_html($submit_text); ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
