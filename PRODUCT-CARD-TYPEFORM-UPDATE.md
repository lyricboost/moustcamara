# Product Card Block - Typeform Integration

## Enhancement Summary

The Product Card block now supports Typeform popup integration in addition to standard links and anchor links.

## New Features

### CTA Link Type Selector
Choose between:
1. **Direct Link or Anchor** - Traditional URL or anchor link behavior (default)
2. **Typeform Popup** - Opens a Typeform in a full-screen modal

### Configuration

**When "Direct Link or Anchor" is selected:**
- Use the existing "CTA Button Link" field
- Supports URLs (https://...) or anchor links (#section-id)

**When "Typeform Popup" is selected:**
- "CTA Button Link" field is hidden
- New "Typeform URL" field appears
- Enter full Typeform URL (e.g., `https://form.typeform.com/to/abc123xyz`)
- The button will automatically trigger a popup when clicked

## Usage Example

### Standard Link (Existing Behavior)
```
CTA Button Text: Apply Now
CTA Link Type: Direct Link or Anchor
CTA Button Link: #contact
```

### Typeform Popup (New)
```
CTA Button Text: Apply for Power Forward
CTA Link Type: Typeform Popup
Typeform URL: https://form.typeform.com/to/YOUR_FORM_ID
```

## Technical Details

### Implementation
- Conditional ACF fields based on link type selection
- Automatic Typeform ID extraction from URL
- Typeform embed script loaded only when needed
- Button element used for popup (instead of link)
- Maintains all existing styling

### CSS Updates
- Added `cursor: pointer` to button elements
- Added `font-family: inherit` for button text
- Buttons styled identically to links

### Script Loading
- Typeform embed script (`//embed.typeform.com/next/embed.js`) loads automatically
- Only loads when Typeform popup type is selected
- Prevents duplicate script loading

## Files Modified

1. **render.php**
   - Added `cta_link_type` and `typeform_url` fields
   - Added Typeform ID extraction logic
   - Updated CTA button rendering (both layouts)
   - Added conditional Typeform script loading

2. **group_moust_product_card.json** (ACF JSON)
   - Added `cta_link_type` select field
   - Added `typeform_url` URL field
   - Added conditional logic to show/hide fields

3. **acf-import-product-card.json**
   - Updated import file with new fields
   - Added conditional logic

4. **style.css**
   - Updated `.product-card-cta` to support button elements
   - Added `cursor: pointer` and `font-family: inherit`

## Browser Compatibility
Works in all modern browsers that support Typeform embeds:
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

## Backward Compatibility
✓ Fully backward compatible
- Existing Product Cards default to "Direct Link or Anchor"
- No changes needed to existing content
- All existing functionality preserved

## Testing Checklist
- [ ] Product Card with standard link still works
- [ ] Product Card with anchor link still works
- [ ] Product Card with Typeform popup opens modal
- [ ] Typeform script loads only when needed
- [ ] Conditional fields show/hide correctly in editor
- [ ] Button styling matches link styling
- [ ] Both centered and split layouts work
- [ ] Mobile responsive behavior maintained

## Use Case: Power Forward Application

Perfect for the Power Forward offering shown in the screenshot:
- Product name, description, pricing, and features display normally
- CTA button "Apply for Power Forward" opens Typeform popup
- User fills application form without leaving page
- Seamless experience, no navigation away from product info
