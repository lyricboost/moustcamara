# Mailing List Signup Block

A WordPress block for creating mailing list signup forms with Mailchimp integration support.

## Features

- **Flexible Layouts**: Split (with image) or Centered (no image)
- **Repeatable Form Fields**: Add text and email fields dynamically
- **Mailchimp Integration**: Ready for Mailchimp API integration
- **Field Mapping**: Map form fields to Mailchimp merge fields (EMAIL, FNAME, LNAME, NAME)
- **CTA Button Styling**: Matches product card button styling for consistency
- **Dark Background Support**: Automatic text color adaptation
- **Responsive Design**: Mobile-optimized layouts
- **AJAX Submission**: No page reload, instant feedback

## Setup

### 1. Import ACF Fields

1. Go to **Custom Fields > Tools**
2. Click **Import Field Groups**
3. Upload `acf-import-mailing-list.json`
4. Click **Import**

### 2. Add the Block

1. Edit any page/post
2. Click **+** to add a block
3. Search for "Moust Mailing List"
4. Configure your settings

## Configuration

### Layout Options
- **Split**: Image on left or right, content on the other side
- **Centered**: No image, content centered

### Content Fields
- **Badge**: Optional small label above heading
- **Heading**: Main title (required)
- **Heading Size**: Medium or Large
- **Description**: Optional WYSIWYG content
- **Fine Print**: Small disclaimer text at bottom

### Form Fields (Repeatable)

Each field has:
- **Field Type**: Text or Email
- **Label**: Field label (also used as fallback name)
- **Placeholder**: Placeholder text in input
- **Required**: Mark as required field
- **Mailchimp Field Name**: Map to Mailchimp merge field

**Mailchimp Field Mappings:**
- `EMAIL` - Email Address
- `FNAME` - First Name  
- `LNAME` - Last Name
- `NAME` - Full Name

### Mailchimp Integration

- **Mailchimp List ID**: Your audience/list ID from Mailchimp
- **Mailchimp API Key**: Your Mailchimp API key

**Note**: Current implementation stores signups locally and sends admin email notifications. Full Mailchimp API integration is marked as TODO in the code.

### Styling Options
- **Background Color**: None, Light Gray, Medium Gray, Navy, Dark Gray, Black
- **Submit Button Text**: Customize the CTA button text

## Usage Example

### Basic Newsletter Signup

**Layout**: Centered
**Heading**: Stay Updated
**Description**: Get the latest insights delivered to your inbox.

**Form Fields**:
1. Field Type: Text
   - Label: Name
   - Placeholder: Your name
   - Mailchimp Field: FNAME
   - Required: Yes

2. Field Type: Email
   - Label: Email
   - Placeholder: your@email.com
   - Mailchimp Field: EMAIL
   - Required: Yes

**Submit Text**: Subscribe Now

### With Image Layout

**Layout**: Split
**Image Position**: Left
**Image Style**: Circle
**Heading**: Join Our Community
**Description**: Be the first to know about new programs and opportunities.

(Same form fields as above)

## Form Behavior

### Submission Flow
1. User fills out form and clicks submit
2. Button text changes to "Subscribing..."
3. Form data sent via AJAX
4. Success: Shows success message, form resets
5. Error: Shows error message, form remains

### Data Handling
- Validates email field exists
- Sanitizes all input data
- Stores in WordPress options table as `mailing_list_subscribers`
- Sends notification email to site admin
- Returns JSON response to form

### Success Message
> "Thank you for subscribing!"

### Error Messages
- "Security verification failed." (nonce invalid)
- "Please provide a valid email address." (no email found)
- "Network error. Please try again." (AJAX failure)

## Button Styling

The submit button uses the same styling as the Product Card CTA button:
- Navy background (#313d59)
- White text
- Rounded pill shape (50px border-radius)
- Hover: Transparent background, navy outline
- On dark backgrounds: Darker background, white outline on hover
- Arrow icon with slide animation on hover

## Dark Background Behavior

When background is set to Navy, Dark Gray, or Black:
- White text for heading and description
- Semi-transparent white inputs with white borders
- White placeholder text (50% opacity)
- Submit button adapts to white outline on hover

## Mobile Optimizations

- Section padding reduced from 80px to 60px
- Content gap reduced from 32px to 20px
- Heading size reduced to 28px
- Image wrapper max-width 300px
- Submit button full width
- Font sizes adjusted for readability

## Technical Details

### AJAX Endpoint
- Action: `mailing_list_signup`
- Method: POST
- Nonce: `mailing_list_nonce`

### Data Storage
Stored in WordPress options as `mailing_list_subscribers`:
```php
array(
    'email' => 'user@example.com',
    'data' => array(...),
    'list_id' => 'abc123',
    'timestamp' => '2026-08-21 12:00:00'
)
```

### Admin Notifications
Email sent to site admin with:
- Subscriber email
- All form field values
- List ID
- Timestamp

## Mailchimp Integration (TODO)

To enable full Mailchimp integration:

1. Add Mailchimp API library to theme
2. Update `handle_mailing_list_signup()` function
3. Use API key and List ID from ACF fields
4. Map form fields to Mailchimp merge fields
5. Handle API response and errors

Example integration point in `functions.php`:
```php
// TODO: Integrate with Mailchimp API here
// Use $list_id, $subscriber_data, and API key
```

## Browser Compatibility
- Chrome (latest) ✓
- Firefox (latest) ✓
- Safari (latest) ✓
- Edge (latest) ✓
- Mobile Safari ✓
- Chrome Mobile ✓

## Files

- `blocks/mailing-list/block.json` - Block metadata
- `blocks/mailing-list/render.php` - Block template
- `acf-json/group_mailing_list.json` - ACF field group
- `acf-import-mailing-list.json` - Import file
- `functions.php` - Block registration + AJAX handler
- `style.css` - Block styling

## Future Enhancements

- [ ] Full Mailchimp API integration
- [ ] Double opt-in support
- [ ] Custom success redirect
- [ ] Multi-list selection
- [ ] ConvertKit integration option
- [ ] Custom field types (phone, checkbox, select)
- [ ] reCAPTCHA support
- [ ] Export subscribers to CSV
