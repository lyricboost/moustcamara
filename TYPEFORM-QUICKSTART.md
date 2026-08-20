# Quick Start: Typeform Embed Block

## 1-Minute Setup

### Step 1: Import Fields (One-time setup)
1. Go to WordPress Admin → **Custom Fields** → **Tools**
2. Click **Import Field Groups**
3. Upload `acf-import-typeform.json` from theme root
4. Click **Import**

### Step 2: Add to Page
1. Edit any page/post
2. Click **+** (Add block)
3. Search "Typeform" or find under **Moust Camara**
4. Add **Moust Typeform Embed** block

### Step 3: Configure
1. **Typeform URL**: Paste your Typeform link
   - Example: `https://form.typeform.com/to/abc123xyz`
2. **Display Mode**: Choose how it appears
3. Add optional heading/description
4. Publish!

## Display Modes Quick Guide

### 📄 Embed (Default)
- Form appears inline on page
- Set height (300-1000px)
- Best for: Primary forms

### 🚀 Popup
- Button opens full-screen overlay
- Customize button text
- Best for: Surveys, long forms

### 📱 Slider
- Button opens side panel
- Slides in from right
- Best for: Feedback, quick forms

### 💬 Popover
- Button opens centered modal
- 70% screen size
- Best for: Signups, short forms

## Common Use Cases

**Contact Form**
```
Display Mode: Embed
Height: 600px
Heading: "Get In Touch"
Background: Light Gray
```

**Newsletter Signup**
```
Display Mode: Popover
Button Text: "Subscribe Now"
Heading: "Join Our Newsletter"
Background: None
```

**Customer Survey**
```
Display Mode: Popup
Button Text: "Share Your Feedback"
Heading: "We Value Your Opinion"
Background: Navy
```

## Getting Your Typeform URL

1. Log in to [Typeform](https://typeform.com)
2. Open your form
3. Click **Share** (top right)
4. Copy the URL under **Share your typeform**
5. Paste into the block

That's it! 🎉

## Need Help?

See full documentation: `blocks/typeform-embed/README.md`
