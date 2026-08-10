# Table Grid Block - Setup Guide

## Overview
The Table Grid block is a sexy, responsive comparison table block inspired by modern SaaS pricing tables. It features:

- ✅ Desktop table view with highlighted columns
- ✅ Mobile accordion view for better UX on small screens
- ✅ Tooltips for feature explanations
- ✅ Customizable columns (2-4 columns supported)
- ✅ Multiple feature groups
- ✅ Checkmark, text, or empty cell values
- ✅ Button CTAs per column
- ✅ Light/dark background variants
- ✅ Lucide React icons integration

## Installation

### 1. Import ACF Fields
1. Go to **Custom Fields > Tools** in WordPress admin
2. Click **Import Field Groups**
3. Upload or paste the contents of `acf-import-table-grid.json`
4. Click **Import JSON**

### 2. Verify Block Registration
The block is automatically registered in `functions.php`. No additional action needed.

### 3. Files Included
- `/blocks/table-grid/block.json` - Block configuration
- `/blocks/table-grid/render.php` - Block template
- `/js/table-grid.js` - Mobile accordion & tooltips JavaScript
- `/acf-import-table-grid.json` - ACF field configuration
- CSS added to main `style.css`

## Usage

### Adding the Block
1. Edit a page in WordPress
2. Click **+** to add a block
3. Search for **"Moust Table Grid"** under Moust Camara Blocks category
4. Configure the block settings

### Block Settings

#### General Settings
- **Custom ID**: Optional HTML ID for anchor links
- **Heading**: Main heading text
- **Subheading**: Supporting text below heading
- **Heading Size**: Large or Medium
- **Reduced Padding**: Tighter vertical spacing
- **Background Color**: None, Light Gray, Dark Gray, or Black

#### Columns (2-4 columns)
For each column:
- **Column Name**: Display name (e.g., "Basic", "Pro", "Enterprise")
- **Highlight**: Add visual emphasis to this column
- **Button Text**: CTA button label
- **Button Link**: CTA button URL
- **Button Variant**: Primary, Secondary, or Disabled

#### Feature Groups
Organize features into logical groups:
- **Group Name**: Category name (e.g., "Core Features", "Storage")
- **Features**: Individual features in this group
  - **Feature Name**: What the feature is
  - **Tooltip**: Optional hover explanation
  - **Values**: One value per column (Checkmark, Text, or None)

## Design System

### Colors
- **Text Dark**: `#313d59` (--color-text-dark)
- **Text Gray**: `#6c7386` (--color-text-gray)
- **Light Gray**: `#f5f5f5` (--color-light-gray)
- **Medium Gray**: `#e0e0e0` (--color-medium-gray)
- **Checkmark Green**: `#10b981`

### Typography
- **Heading**: 32-48px (clamp), weight 700
- **Subheading**: 18px, weight 400
- **Table Headers**: 0.8rem, weight 700, uppercase
- **Feature Names**: 14px, weight 400
- **Cell Content**: 14px

### Responsive Breakpoints
- **Desktop**: Table view (> 920px)
- **Mobile**: Accordion view (≤ 920px)
- **Small Mobile**: Single column accordion (≤ 768px)

### Icons
Uses Lucide React icons:
- `help-circle`: Tooltips
- `check-circle-2`: Checkmarks
- `chevron-down`: Mobile accordion

## Examples

### Basic 3-Column Comparison
```
Columns:
- Basic | Pro | Enterprise

Feature Groups:
1. Core Features
   - Storage: 10GB | 100GB | Unlimited
   - Users: 1 | 5 | Unlimited
   - Support: Email | Priority | Dedicated

2. Advanced Features
   - API Access: — | ✓ | ✓
   - Custom Domain: — | ✓ | ✓
   - White Label: — | — | ✓
```

### Service Packages
```
Columns:
- Consultation | Implementation | Full Support

Features:
- Initial Assessment: ✓ | ✓ | ✓
- Strategy Document: ✓ | ✓ | ✓
- Implementation: — | ✓ | ✓
- Ongoing Support: — | 1 month | 6 months
```

## Customization

### Modify Colors
Edit in `style.css`:
```css
.table-grid__column--highlight::after {
  background: var(--color-text-dark); /* Change highlight color */
}

.table-grid-checkmark {
  color: #10b981; /* Change checkmark color */
}
```

### Adjust Mobile Breakpoint
Change the breakpoint in `style.css`:
```css
@media (max-width: 920px) { /* Adjust this value */
  .table-grid-wrapper {
    display: none;
  }
  /* ... */
}
```

### Add More Columns
The block supports 2-4 columns by default. To add more:
1. Edit ACF field `table_columns`
2. Increase `max` value
3. Adjust table column width in CSS

## JavaScript Functionality

### Mobile Accordion
Auto-initializes on page load. Features:
- Click to expand/collapse feature details
- Smooth height transitions
- ARIA attributes for accessibility

### Tooltips
Hover over help icons to see explanations:
- Auto-positioning (above or below trigger)
- Prevents overflow off screen
- Follows cursor movement

### ACF Preview Support
Works in Gutenberg editor preview mode with automatic re-initialization.

## Browser Support
- Chrome/Edge (last 2 versions)
- Firefox (last 2 versions)
- Safari (last 2 versions)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Accessibility
- Semantic HTML table structure
- ARIA labels on accordion controls
- Keyboard navigation support
- Screen reader friendly
- Sufficient color contrast ratios

## Performance
- Minimal JavaScript (~3KB minified)
- CSS-only hover effects
- Hardware-accelerated transitions
- Lazy icon loading via Lucide

## Credits
Inspired by the plan-comparison block from Lyric Boost website, refined for Moust Camara branding with cleaner aesthetics and moustcamara-plain design system integration.
