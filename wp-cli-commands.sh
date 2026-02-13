#!/bin/bash

# Moust Camara Website - WP-CLI Quick Commands
# Navigate to WordPress root first: cd /Users/moustcamara/Documents/BRANDS/Moust\ Camara/moustcamaraweb/app/public

echo "==================================="
echo "Moust Camara WP-CLI Quick Commands"
echo "==================================="

WP_PATH="/Users/moustcamara/Documents/BRANDS/Moust Camara/moustcamaraweb/app/public"

# Check if we're in the right directory
if [ ! -f "$WP_PATH/wp-config.php" ]; then
    echo "Error: WordPress not found at $WP_PATH"
    exit 1
fi

cd "$WP_PATH"

echo ""
echo "1. ACF Commands"
echo "---------------"
echo "List ACF field groups:"
echo "  wp acf get-field-groups"
echo ""
echo "Sync ACF field groups from JSON:"
echo "  wp acf sync"
echo ""

echo "2. Theme Commands"
echo "-----------------"
echo "List themes:"
echo "  wp theme list"
echo ""
echo "Activate theme:"
echo "  wp theme activate moustcamara-plain"
echo ""

echo "3. Plugin Commands"
echo "------------------"
echo "List plugins:"
echo "  wp plugin list"
echo ""
echo "Install ACF Pro (if needed):"
echo "  # Download from ACF website, then:"
echo "  wp plugin install /path/to/advanced-custom-fields-pro.zip --activate"
echo ""

echo "4. Database Commands"
echo "--------------------"
echo "Check database:"
echo "  wp db check"
echo ""
echo "Search/replace URLs:"
echo "  wp search-replace 'http://oldurl.local' 'http://newurl.local'"
echo ""

echo "5. Cache Commands"
echo "-----------------"
echo "Flush cache:"
echo "  wp cache flush"
echo ""
echo "Flush rewrite rules:"
echo "  wp rewrite flush"
echo ""

echo "6. Page Management"
echo "------------------"
echo "List pages:"
echo "  wp post list --post_type=page"
echo ""
echo "Create a new page:"
echo "  wp post create --post_type=page --post_title='New Page' --post_status=publish"
echo ""

echo "==================================="
echo ""
echo "For more commands, visit: https://developer.wordpress.org/cli/commands/"
echo ""
