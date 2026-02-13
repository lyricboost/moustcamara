<section class="hero-section">
  <div class="hero-section-inner">
    <div class="hero-content">
      <h1 class="hero-name"><?php echo esc_html($attributes['heroName']); ?></h1>
      
      <p class="hero-about">
        <?php echo esc_html($attributes['aboutText']); ?>
      </p>
      
      <div class="hero-founder">
        Founder, <a href="https://lyricboost.com" target="_blank" rel="noopener">Lyric Boost</a> · Systems Builder
      </div>
      
      <div class="hero-location">
        <i data-lucide="map-pin" class="hero-icon"></i>
        <span>Plano, TX</span>
      </div>
      
      <div class="hero-links">
        <a href="<?php echo esc_url($attributes['emailLink']); ?>" class="hero-link">
          <i data-lucide="mail" class="hero-icon"></i>
          <span>Email</span>
        </a>
        <a href="<?php echo esc_url($attributes['linkedInLink']); ?>" target="_blank" rel="noopener" class="hero-link">
          <i data-lucide="linkedin" class="hero-icon"></i>
          <span>LinkedIn</span>
        </a>
      </div>
    </div>
    
    <div class="hero-image">
      <?php if (!empty($attributes['imageUrl'])): ?>
        <div class="hero-image-circle">
          <img src="<?php echo esc_url($attributes['imageUrl']); ?>" alt="<?php echo esc_attr($attributes['heroName']); ?>">
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
<script>
  if (typeof lucide !== 'undefined') {
    lucide.createIcons();
  }
</script>
