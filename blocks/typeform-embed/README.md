# Typeform Embed Block

A WordPress block for embedding Typeform surveys and forms with multiple display options.

## Features

- **Multiple Display Modes:**
  - Standard Embed (inline)
  - Popup (full-screen modal)
  - Slider (side panel)
  - Popover (centered modal)

- **Customization Options:**
  - Adjustable embed height
  - Custom button text for popup/slider/popover modes
  - Optional section heading and description
  - Background color options

## Setup

### 1. Import ACF Fields

In WordPress Admin:
1. Go to **Custom Fields > Tools**
2. Click **Import Field Groups**
3. Upload `acf-import-typeform.json` from the theme root
4. Click **Import**

The field group will be automatically synced to `/acf-json/group_typeform_embed.json`

### 2. Add the Block

1. Edit any page or post
2. Click the **+** button to add a block
3. Search for "Moust Typeform Embed" or find it under the **Moust Camara** category
4. Configure your Typeform settings

## Usage

### Getting Your Typeform URL

1. Log in to your Typeform account
2. Open your form
3. Click **Share** in the top right
4. Copy the form URL (e.g., `https://form.typeform.com/to/abc123xyz`)

### Display Modes Explained

**Standard Embed (inline)**
- Embeds the form directly on the page
- Best for: Primary forms, landing pages
- Configure the height in pixels (default: 500px)

**Popup (full-screen modal)**
- Opens the form in a full-screen overlay
- Best for: Surveys, multi-step forms
- Triggered by a button click

**Slider (side panel)**
- Opens the form in a side panel from the right
- Best for: Feedback forms, quick surveys
- Triggered by a button click

**Popover (centered modal)**
- Opens the form in a centered modal window
- Best for: Newsletter signups, short forms
- Triggered by a button click

## Configuration Options

### Required Fields
- **Typeform URL**: The full URL of your Typeform

### Display Settings
- **Display Mode**: Choose how the form appears (embed/popup/slider/popover)
- **Embed Height**: Only for standard embed mode (300-1000px)
- **Button Text**: For popup/slider/popover modes

### Content Options
- **Section Heading**: Optional title above the form
- **Description**: Optional descriptive text
- **Background Color**: Choose from preset background colors

## Examples

### Example 1: Contact Form (Inline)
- Display Mode: Standard Embed
- Embed Height: 600px
- Heading: "Get In Touch"
- Description: "Fill out the form below and we'll get back to you shortly."
- Background Color: Light Gray

### Example 2: Survey (Popup)
- Display Mode: Popup
- Button Text: "Take Our Survey"
- Heading: "We Value Your Feedback"
- Description: "Help us improve by sharing your thoughts."
- Background Color: None

### Example 3: Quick Feedback (Slider)
- Display Mode: Slider
- Button Text: "Share Feedback"
- Background Color: None

## Technical Notes

### Typeform Embed Script
The block automatically loads the Typeform embed script from:
```
//embed.typeform.com/next/embed.js
```

### Browser Support
The Typeform embed library supports all modern browsers:
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)

### Performance
- The Typeform script is loaded only when the block is present on the page
- Lazy loading is handled automatically by Typeform

## Troubleshooting

**Form not appearing?**
- Verify the Typeform URL is correct
- Make sure the Typeform is published (not in draft mode)
- Check browser console for errors

**Button not triggering popup/slider/popover?**
- Clear browser cache
- Ensure JavaScript is enabled
- Check for JavaScript conflicts with other plugins

## Support

For Typeform-specific issues:
- Visit [Typeform Help Center](https://www.typeform.com/help/)

For block-related issues:
- Contact your site administrator
- Check ACF field configuration
- Review WordPress error logs

## Version History

- **1.0** - Initial release with all display modes and configuration options
