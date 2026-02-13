# Moust Camara Website - ACF Blocks Setup

## Overview
This theme is built with ACF Pro blocks for the Moust Camara personal brand website. It features a modular block system with elegant color theming and responsive design.

## Brand Colors
- **Terracotta**: `#9E6B5B` - Primary brand color
- **Terracotta Dark**: `#7A503F` - Darker accent
- **Cream**: `#F5F0EB` - Light, warm background
- **Black**: `#1a1a1a` - Dark background option
- **White**: `#ffffff` - Clean background

## Page Templates
Three page templates are available in the theme:

1. **Home Page (Full Width)** - `page-home.php`
   - Template Name: "Home Page (Full Width)"
   - No container, allows full-width blocks
   - Perfect for landing pages

2. **Default Page** - `page.php`
   - Template Name: "Default Page"
   - Contains content in a centered container
   - Displays page title
   - Max width: 1200px

3. **Full Width** - `page-fullwidth.php`
   - Template Name: "Full Width"
   - No container, allows full-width blocks
   - No page title displayed

## ACF Blocks

### 1. Hero Block
**Name**: `acf/hero`
**Category**: Moust Camara Blocks

**Fields**:
- Name (text)
- Description (textarea)
- Company (text)
- Company Link (url)
- Role (text)
- Location (text)
- Email Link (url)
- LinkedIn Link (url)
- Hero Image (image)
- Background Color (select)

**Features**:
- Circular profile image
- Responsive layout
- Social links with icons
- Company reference with link

---

### 2. Lead-in Text Block
**Name**: `acf/lead-in`
**Category**: Moust Camara Blocks

**Fields**:
- Lead-in Text (wysiwyg)
- Background Color (select)

**Features**:
- Large, impactful typography
- Support for italic emphasis
- Centered layout
- Full-width capable

---

### 3. Split Layout Block
**Name**: `acf/split`
**Category**: Moust Camara Blocks

**Fields**:
- Image (image)
- Heading (text)
- Main Text (textarea)
- Secondary Text (textarea, optional)
- Image Position (select: left/right)
- Background Color (select)

**Features**:
- Two-column responsive layout
- Circular image treatment
- Flexible image positioning
- Stacks vertically on mobile

---

### 4. Grid Items Block
**Name**: `acf/grid-items`
**Category**: Moust Camara Blocks

**Fields**:
- Heading (text)
- Grid Items (repeater)
  - Title (text)
  - Description (textarea)
  - Button Text (text)
  - Button Link (url)
- Background Color (select)

**Features**:
- 3-column grid layout
- Repeater field for unlimited items
- Call-to-action buttons
- Responsive (stacks on mobile)
- Default placeholder content for preview

---

### 5. Final CTA Block
**Name**: `acf/final-cta`
**Category**: Moust Camara Blocks

**Fields**:
- Heading (text)
- Text (textarea)
- Button Text (text)
- Button Link (url)
- Background Color (select)

**Features**:
- Centered content layout
- Large heading typography
- Prominent CTA button
- Newsletter/signup focused

---

## Background Color System

Each block includes a "Background Color" field with these options:

- **None (White)**: Default white background
- **Cream**: Warm, light background
- **Terracotta**: Primary brand color
- **Terracotta Dark**: Darker brand accent
- **Black**: Dark, dramatic background

### Automatic Text Color Adjustment

The theme automatically adjusts text colors based on background:

- **Light backgrounds** (None, Cream): Dark text
- **Dark backgrounds** (Terracotta, Terracotta Dark, Black): Light text

This applies to:
- Headings
- Body text
- Links
- Buttons
- Icons

---

## ACF JSON Sync

ACF field groups are stored in `/acf-json/` directory for version control and automatic syncing.

**Benefits**:
- Field definitions committed to git
- Automatic sync between environments
- No manual field group imports needed
- Changes tracked in version control

**Files**:
- `group_hero_block.json`
- `group_lead_in_block.json`
- `group_split_block.json`
- `group_grid_items_block.json`
- `group_final_cta_block.json`

---

## Using WP-CLI with ACF

With WP-CLI installed, you can manage ACF field groups from the command line:

```bash
# Navigate to WordPress directory
cd /Users/moustcamara/Documents/BRANDS/Moust\ Camara/moustcamaraweb/app/public

# List all ACF field groups
wp acf get-field-groups

# Export field groups to JSON (already configured)
# Field groups auto-save to /acf-json/

# Import field groups from JSON
wp acf sync
```

---

## WordPress Block Alignments

Blocks support WordPress alignment options:

- **Default**: Contained within content width
- **Wide**: Extended width (1400px)
- **Full Width**: Edge-to-edge, full viewport width

Use `.alignwide` and `.alignfull` classes automatically applied by WordPress.

---

## File Structure

```
moustcamara-plain/
├── acf-json/
│   ├── group_hero_block.json
│   ├── group_lead_in_block.json
│   ├── group_split_block.json
│   ├── group_grid_items_block.json
│   └── group_final_cta_block.json
├── blocks/
│   ├── hero-acf/
│   │   ├── block.json
│   │   └── render.php
│   ├── lead-in/
│   │   ├── block.json
│   │   └── render.php
│   ├── split/
│   │   ├── block.json
│   │   └── render.php
│   ├── grid-items/
│   │   ├── block.json
│   │   └── render.php
│   └── final-cta/
│       ├── block.json
│       └── render.php
├── footer.php
├── functions.php
├── header.php
├── index.php
├── page-home.php
├── page.php
├── page-fullwidth.php
├── style.css
└── README.md
```

---

## Development Notes

### Typography
- Primary font: **Poppins** (loaded via Google Fonts)
- Fallbacks: system-ui, -apple-system, sans-serif
- Fluid typography using `clamp()` for responsive sizing

### Icons
- Uses **Lucide** icons library
- Icons loaded via CDN in header.php
- Auto-initialized via JavaScript in blocks

### Responsive Breakpoints
- Desktop: 1200px+
- Tablet: 768px - 968px
- Mobile: < 768px

---

## Getting Started

1. Ensure ACF Pro is installed and activated
2. ACF field groups will auto-sync from `/acf-json/`
3. Create a new page and assign a page template
4. Add blocks from the "Moust Camara Blocks" category
5. Configure each block's fields in the editor
6. Publish and view!

---

## Next Steps

- Upload brand images
- Configure actual links (email, LinkedIn, company)
- Add real content to blocks
- Test across devices
- Set up forms/newsletter integration

---

## Support

For questions or issues, contact Moust Camara.
