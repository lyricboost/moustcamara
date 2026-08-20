# Typeform Embed Block - Visual Examples

## Block Editor Interface

When you add the Typeform Embed block, you'll see these ACF fields:

```
┌─────────────────────────────────────────────────────────┐
│ Moust Typeform Embed Block                             │
├─────────────────────────────────────────────────────────┤
│                                                          │
│ Typeform URL *                                          │
│ ┌────────────────────────────────────────────────────┐ │
│ │ https://form.typeform.com/to/YOUR_FORM_ID          │ │
│ └────────────────────────────────────────────────────┘ │
│ Enter the full Typeform URL                             │
│                                                          │
│ Display Mode *                                          │
│ ┌────────────────────────────────────────────────────┐ │
│ │ Standard Embed (inline)                ▼           │ │
│ └────────────────────────────────────────────────────┘ │
│ Choose how the Typeform should be displayed            │
│                                                          │
│ Embed Height                                            │
│ ┌──────┐                                                │
│ │ 500  │ px                                             │
│ └──────┘                                                │
│ Height in pixels for the embedded form                  │
│                                                          │
│ Section Heading                                         │
│ ┌────────────────────────────────────────────────────┐ │
│ │                                                     │ │
│ └────────────────────────────────────────────────────┘ │
│ Optional heading above the form                         │
│                                                          │
│ Description                                             │
│ ┌────────────────────────────────────────────────────┐ │
│ │                                                     │ │
│ │                                                     │ │
│ └────────────────────────────────────────────────────┘ │
│ Optional description text                               │
│                                                          │
│ Background Color                                        │
│ ┌────────────────────────────────────────────────────┐ │
│ │ None (White)                           ▼           │ │
│ └────────────────────────────────────────────────────┘ │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

## Display Mode Options

### 1. Standard Embed (inline)
```
Display Mode: Standard Embed (inline)
Shows field: Embed Height
Hides field: Button Text

Result:
┌───────────────────────────────────────┐
│     [Form loads inline on page]       │
│                                        │
│  Name:  [________________]             │
│  Email: [________________]             │
│  Message: [________________]           │
│           [________________]           │
│                                        │
│         [ Submit ]                     │
└───────────────────────────────────────┘
```

### 2. Popup (full screen modal)
```
Display Mode: Popup (full screen modal)
Shows field: Button Text
Hides field: Embed Height

Result:
┌───────────────────────────────────────┐
│      [ Open Form ]  ← Button          │
└───────────────────────────────────────┘

On click → Full screen overlay with form
```

### 3. Slider (side panel)
```
Display Mode: Slider (side panel)
Shows field: Button Text
Hides field: Embed Height

Result:
┌───────────────────────────────────────┐
│      [ Share Feedback ]  ← Button     │
└───────────────────────────────────────┘

On click → Slides in from right side
```

### 4. Popover (centered modal)
```
Display Mode: Popover (centered modal)
Shows field: Button Text
Hides field: Embed Height

Result:
┌───────────────────────────────────────┐
│      [ Subscribe Now ]  ← Button      │
└───────────────────────────────────────┘

On click → Centered modal at 70% screen
```

## Complete Examples

### Example 1: Contact Form with Heading

**Settings:**
```
Typeform URL: https://form.typeform.com/to/abc123
Display Mode: Standard Embed
Embed Height: 600
Heading: Get In Touch
Description: Fill out the form and we'll respond within 24 hours
Background Color: Light Gray
```

**Frontend Output:**
```
╔═══════════════════════════════════════════════════╗
║                                                   ║
║              Get In Touch                         ║
║                                                   ║
║   Fill out the form and we'll respond within      ║
║              24 hours                             ║
║                                                   ║
║   ┌──────────────────────────────────────────┐   ║
║   │                                           │   ║
║   │    [Typeform embedded here - 600px]      │   ║
║   │                                           │   ║
║   │                                           │   ║
║   └──────────────────────────────────────────┘   ║
║                                                   ║
╚═══════════════════════════════════════════════════╝
```

### Example 2: Survey Popup

**Settings:**
```
Typeform URL: https://form.typeform.com/to/xyz789
Display Mode: Popup
Button Text: Take Our 2-Minute Survey
Heading: We Value Your Feedback
Description: Your input helps us improve our services
Background Color: Navy
```

**Frontend Output:**
```
╔═══════════════════════════════════════════════════╗
║                 NAVY BACKGROUND                   ║
║                                                   ║
║         We Value Your Feedback                    ║
║                                                   ║
║     Your input helps us improve our services      ║
║                                                   ║
║      ┌──────────────────────────────┐            ║
║      │ Take Our 2-Minute Survey     │            ║
║      └──────────────────────────────┘            ║
║                                                   ║
╚═══════════════════════════════════════════════════╝
```

### Example 3: Simple Newsletter Signup

**Settings:**
```
Typeform URL: https://form.typeform.com/to/newsletter
Display Mode: Popover
Button Text: Join Our Newsletter
Heading: (empty)
Description: (empty)
Background Color: None
```

**Frontend Output:**
```
┌─────────────────────────────────────────────────┐
│                                                  │
│         ┌──────────────────────────┐            │
│         │ Join Our Newsletter      │            │
│         └──────────────────────────┘            │
│                                                  │
└─────────────────────────────────────────────────┘
```

## Conditional Field Display

The block uses conditional logic to show/hide fields based on Display Mode:

```
IF Display Mode = "Standard Embed"
  → Show: Embed Height field
  → Hide: Button Text field

IF Display Mode = "Popup" OR "Slider" OR "Popover"
  → Show: Button Text field
  → Hide: Embed Height field
```

## Background Color Effects

```
Background: None (White)
→ Text Color: Dark (#333)

Background: Light Gray / Medium Gray
→ Text Color: Dark (#333)

Background: Dark Gray / Black / Navy
→ Text Color: Light (#FFF)
```

## Mobile Responsive Behavior

**Desktop (768px+):**
- Section padding: 5rem (80px)
- Full typography sizes
- Standard layouts

**Mobile (<768px):**
- Section padding: 2rem (32px)
- Reduced heading size
- Minimum embed height: 400px
- Buttons remain centered

## Integration with Typeform

The block automatically:
1. Extracts form ID from your URL
2. Loads Typeform embed script
3. Initializes the correct display mode
4. Passes configuration to Typeform
5. Handles responsive sizing

**Supported URL formats:**
- `https://form.typeform.com/to/abc123xyz`
- `https://yourcompany.typeform.com/to/abc123xyz`
- `https://www.typeform.com/to/abc123xyz`

## Preview Mode

In the WordPress editor, you'll see:

**Valid URL:**
- Live preview of the embedded form or button

**Invalid/Missing URL:**
```
┌─────────────────────────────────────────────────┐
│ ⚠ Typeform Embed Block:                         │
│                                                  │
│ Please enter a valid Typeform URL               │
│ (e.g., https://form.typeform.com/to/YOUR_ID)    │
└─────────────────────────────────────────────────┘
```

## Accessibility Features

All embeds include:
- `title="Typeform"` on iframe
- Semantic HTML structure
- Keyboard accessible buttons
- ARIA attributes for screen readers
- High contrast text on dark backgrounds

## Browser Testing

Test the block in:
- ✓ Chrome/Edge (Chromium)
- ✓ Firefox
- ✓ Safari
- ✓ Mobile Safari (iOS)
- ✓ Chrome Mobile (Android)
