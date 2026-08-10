# Table Grid Block - Quick Start

## 🚀 Installation (5 minutes)

### Step 1: Import ACF Fields
1. Open WordPress Admin
2. Navigate to **Custom Fields → Tools**
3. Click **Import Field Groups**
4. Upload `acf-import-table-grid.json` from the theme root
5. Click **Import JSON**

### Step 2: Verify Installation
The block is already registered! Just check:
- Go to any page editor
- Click **+** to add block
- Search for "Table Grid" or "Moust"
- You should see **"Moust Table Grid"** block

### Step 3: Add Your First Table
1. Insert the block on a page
2. Set heading: "Compare Our Services"
3. Add 3 columns: Basic, Pro, Enterprise
4. Add feature group: "Core Features"
5. Add features with values
6. Save and preview!

## 📋 Quick Example Setup

### Columns (3)
```
Column 1: Basic
- Highlight: No
- Button: "Get Started" → /contact

Column 2: Pro
- Highlight: Yes (recommended)
- Button: "Start Free Trial" → /signup

Column 3: Enterprise
- Highlight: No
- Button: "Contact Sales" → /contact
```

### Feature Groups (2)

**Group 1: Core Features**
- Storage
  - Basic: "10 GB" (text)
  - Pro: "100 GB" (text)
  - Enterprise: "Unlimited" (text)
  
- Team Members
  - Basic: "1" (text)
  - Pro: "5" (text)
  - Enterprise: "Unlimited" (text)

- 24/7 Support
  - Basic: None (dash)
  - Pro: Checkmark
  - Enterprise: Checkmark

**Group 2: Advanced Features**
- API Access
  - Basic: None
  - Pro: Checkmark
  - Enterprise: Checkmark
  - Tooltip: "REST API for custom integrations"

- Custom Branding
  - Basic: None
  - Pro: None
  - Enterprise: Checkmark

## 🎨 Design Tips

### For Pricing Tables
- Use highlight on your "recommended" plan
- Keep feature names concise (2-4 words)
- Use tooltips for technical terms
- Group related features together

### For Service Packages
- Lead with value, not features
- Use text values for quantities/durations
- Keep 2-3 columns for clarity
- Add compelling CTAs

### For Product Comparisons
- Start with most important features
- Use checkmarks for yes/no features
- Add tooltips for specifications
- Highlight your flagship product

## 🎯 Pro Tips

1. **Keep it Simple**: 3-5 feature groups max
2. **Be Consistent**: Use same value types in a row
3. **Mobile First**: Test on mobile - accordion works great
4. **Tooltips Matter**: Explain technical or unique features
5. **CTA Clarity**: Make buttons actionable ("Start Trial" not "Learn More")

## 🐛 Troubleshooting

**Block doesn't appear?**
- Check ACF Pro is installed and activated
- Verify fields imported successfully
- Clear WordPress cache

**Styles look off?**
- Hard refresh browser (Cmd/Ctrl + Shift + R)
- Check theme version is 0.6.4+
- Verify Lucide icons are loading

**Mobile accordion not working?**
- Check browser console for JS errors
- Ensure table-grid.js is enqueued
- Verify Lucide icons script is loaded

## 📱 Responsive Behavior

- **Desktop (>920px)**: Full table view
- **Tablet (768-920px)**: Table with horizontal scroll
- **Mobile (<768px)**: Accordion view with tap-to-expand

## 🎨 Customization Examples

### Change Highlight Color
In `style.css`:
```css
.table-grid__column--highlight::after {
  background: #your-color;
}
```

### Adjust Table Spacing
```css
.table-grid__feature-row td {
  padding: 20px 24px; /* Increase spacing */
}
```

### Customize Checkmark Color
```css
.table-grid-checkmark {
  color: #your-green;
}
```

## 📚 Full Documentation
See `/blocks/table-grid/README.md` for complete technical documentation.

---

**Need help?** Check the README or review the Lyric Boost implementation for reference patterns.
