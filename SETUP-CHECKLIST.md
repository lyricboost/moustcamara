# ✅ Moust Camara Website Setup Checklist

Use this checklist when setting up your site in WordPress!

---

## 🔧 Initial Setup

### WordPress Admin Login
- [ ] Log into WordPress admin (`/wp-admin`)
- [ ] Verify ACF Pro is installed and activated
- [ ] Go to **Appearance → Themes**
- [ ] Activate **Moust Camara - Plain** theme

---

## 💾 Sync ACF Field Groups

### In WordPress Admin:
- [ ] Go to **Custom Fields** in the sidebar
- [ ] Click **Tools** in the ACF menu
- [ ] Look for the **Sync** tab
- [ ] You should see 5 field groups available for sync:
  - [ ] Hero Block Fields
  - [ ] Lead-in Text Block Fields
  - [ ] Split Layout Block Fields
  - [ ] Grid Items Block Fields
  - [ ] Final CTA Block Fields
- [ ] Click **Sync Available** button
- [ ] Verify all 5 groups are imported

### Or Using WP-CLI (Faster):
```bash
cd "/Users/moustcamara/Documents/BRANDS/Moust Camara/moustcamaraweb/app/public"
wp acf sync
```

---

## 📄 Create Your Home Page

### 1. Create New Page
- [ ] Go to **Pages → Add New**
- [ ] Title: "Home" (or your preferred name)
- [ ] In **Page Attributes** → **Template**, select **Home Page (Full Width)**
- [ ] Don't publish yet!

### 2. Add Hero Block
- [ ] Click the `+` (Add Block) button
- [ ] Look for **Moust Camara Blocks** category
- [ ] Select **Hero** block
- [ ] Fill in the fields:
  - [ ] Name: Your name
  - [ ] Description: Your bio/tagline
  - [ ] Company: Lyric Boost (or your company)
  - [ ] Company Link: https://lyricboost.com
  - [ ] Role: Systems Builder (or your role)
  - [ ] Location: Plano, TX (or your location)
  - [ ] Email Link: Your email (mailto:you@email.com)
  - [ ] LinkedIn Link: Your LinkedIn URL
  - [ ] Hero Image: Upload your profile photo
  - [ ] Background Color: Choose (White, Cream, Terracotta, etc.)

### 3. Add Lead-in Text Block
- [ ] Click `+` to add another block
- [ ] Select **Lead-in Text** from Moust Camara Blocks
- [ ] Edit the text (use `<em>` tags for emphasis)
- [ ] Example: `Your <em>multiple passions</em> and <em>skills</em>...`
- [ ] Choose Background Color: **Cream** looks great here

### 4. Add Split Layout Block
- [ ] Add **Split Layout** block
- [ ] Upload an image
- [ ] Add heading: "I've never believed in choosing just one path."
- [ ] Add your story/bio text
- [ ] Choose Image Position: Left or Right
- [ ] Background Color: **Terracotta** for visual interest

### 5. Add Grid Items Block
- [ ] Add **Grid Items** block
- [ ] Heading: "Here's How We Can Work Together"
- [ ] Click **Add Item** to add grid items (aim for 3)
- [ ] For each item:
  - [ ] Title: Service/offering name
  - [ ] Description: Brief description
  - [ ] Button Text: "Learn More", "Enquire", etc.
  - [ ] Button Link: URL
- [ ] Background Color: **Terracotta Dark** or **Black**

### 6. Add Final CTA Block
- [ ] Add **Final CTA** block
- [ ] Heading: "More information coming soon..." (or your CTA)
- [ ] Text: Newsletter signup message
- [ ] Button Text: "Sign Up Page"
- [ ] Button Link: Your signup page URL
- [ ] Background Color: **Terracotta** or **Black**

### 7. Publish!
- [ ] Review your page in preview mode
- [ ] Check mobile view (click device icons in preview)
- [ ] When satisfied, click **Publish**

---

## 🏠 Set as Homepage

### Option A: In WordPress Admin
- [ ] Go to **Settings → Reading**
- [ ] Select **A static page**
- [ ] Homepage: Select your "Home" page
- [ ] Click **Save Changes**

### Option B: Using WP-CLI
```bash
# Get your page ID first
wp post list --post_type=page --fields=ID,post_title

# Set as homepage (replace PAGE_ID with actual ID)
wp option update page_on_front PAGE_ID
wp option update show_on_front page
```

---

## 🎨 Test All Background Colors

For each block, try different background colors to see what looks best:

- [ ] Hero Block - Try: **White** (clean) or **Terracotta** (bold)
- [ ] Lead-in - Try: **Cream** (subtle) or **Terracotta Dark** (dramatic)
- [ ] Split - Try: **Terracotta** (warm) or **Black** (contrast)
- [ ] Grid Items - Try: **Terracotta Dark** (rich) or **Black** (bold)
- [ ] Final CTA - Try: **Terracotta** (on-brand) or **Black** (powerful)

---

## 📱 Mobile Testing

- [ ] View site on your phone
- [ ] Check that:
  - [ ] Hero image displays correctly
  - [ ] Text is readable at all sizes
  - [ ] Buttons are tappable
  - [ ] Split layout stacks properly
  - [ ] Grid converts to single column
  - [ ] All links work

---

## 🔍 Final Quality Checks

### Content
- [ ] All text is spelled correctly
- [ ] Links go to correct destinations
- [ ] Images are high quality and load fast
- [ ] Company/project links are accurate
- [ ] Contact information is current

### Design
- [ ] Background colors provide good contrast
- [ ] Text is easily readable
- [ ] Spacing feels balanced
- [ ] No elements are cut off or overlapping
- [ ] Colors match your brand

### Functionality
- [ ] All buttons are clickable
- [ ] Email link opens email client
- [ ] LinkedIn link opens in new tab
- [ ] External links have proper attributes
- [ ] Images have alt text

---

## 🚀 Optional Enhancements

### Additional Pages
- [ ] Create **About** page (use Default Page template)
- [ ] Create **Contact** page
- [ ] Create **Services** page (use Full Width template)
- [ ] Add pages to WordPress menu

### Navigation Menu
- [ ] Go to **Appearance → Menus**
- [ ] Create a new menu
- [ ] Add your pages
- [ ] Assign to a theme location (if supported)

### SEO & Meta
- [ ] Install Yoast SEO or Rank Math plugin
- [ ] Set page titles and meta descriptions
- [ ] Add social media preview images

### Analytics
- [ ] Set up Google Analytics
- [ ] Add tracking code to header
- [ ] Set up conversion goals

---

## 🎉 You're Done!

Your Moust Camara website is now live with:
- ✅ 5 custom ACF blocks
- ✅ 3 page templates
- ✅ Beautiful brand colors
- ✅ Fully responsive design
- ✅ Easy content editing

### Need Help?
- 📖 Check [README.md](README.md) for detailed documentation
- 🎨 View [color-reference.html](color-reference.html) for brand colors
- 📋 Review [BUILD-SUMMARY.md](BUILD-SUMMARY.md) for overview
- 🔧 Use `wp-cli-commands.sh` for CLI reference

---

**Congratulations! Your site is ready to make an impact! 🚀**
