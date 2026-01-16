#!/bin/bash
# Theme Structure Validation Script
# Validates that all required files exist and have content

echo "========================================="
echo "Spaguettio Modern Theme - Validation"
echo "========================================="
echo ""

THEME_PATH="/home/runner/work/spaguettio/spaguettio/themes/spaguettio-modern"
ERROR_COUNT=0

# Function to check if file exists and has content
check_file() {
    local file=$1
    local description=$2
    
    if [ ! -f "$file" ]; then
        echo "❌ MISSING: $description"
        echo "   File: $file"
        ((ERROR_COUNT++))
    else
        local size=$(wc -c < "$file")
        if [ $size -eq 0 ]; then
            echo "❌ EMPTY: $description"
            echo "   File: $file"
            ((ERROR_COUNT++))
        else
            echo "✅ OK: $description (${size} bytes)"
        fi
    fi
}

# Check theme metadata files
echo "Checking theme metadata files..."
check_file "$THEME_PATH/ossn_theme.xml" "Theme XML metadata"
check_file "$THEME_PATH/ossn_theme.php" "Theme PHP initialization"
check_file "$THEME_PATH/README.md" "README documentation"
echo ""

# Check layout files
echo "Checking layout files..."
check_file "$THEME_PATH/plugins/default/theme/page/layouts/home.php" "Landing page layout"
echo ""

# Check CSS files
echo "Checking CSS files..."
check_file "$THEME_PATH/plugins/default/theme/css/core/spaguettio-modern.css" "Main CSS stylesheet"
echo ""

# Check JavaScript files
echo "Checking JavaScript files..."
check_file "$THEME_PATH/plugins/default/js/spaguettio-modern.js" "Main JavaScript file"
echo ""

# Check locale files
echo "Checking locale files..."
check_file "$THEME_PATH/plugins/default/locale/ossn.en.php" "English locale"
check_file "$THEME_PATH/plugins/default/locale/ossn.es.php" "Spanish locale"
echo ""

# Validate XML structure
echo "Validating XML structure..."
if xmllint --noout "$THEME_PATH/ossn_theme.xml" 2>/dev/null; then
    echo "✅ OK: XML is well-formed"
else
    echo "⚠️  WARNING: Could not validate XML (xmllint not available or XML has issues)"
fi
echo ""

# Check for PHP syntax errors
echo "Checking PHP syntax..."
PHP_FILES=(
    "$THEME_PATH/ossn_theme.php"
    "$THEME_PATH/plugins/default/theme/page/layouts/home.php"
    "$THEME_PATH/plugins/default/locale/ossn.en.php"
    "$THEME_PATH/plugins/default/locale/ossn.es.php"
)

PHP_ERROR=0
for php_file in "${PHP_FILES[@]}"; do
    if php -l "$php_file" > /dev/null 2>&1; then
        echo "✅ OK: $(basename $php_file) - No syntax errors"
    else
        echo "❌ ERROR: $(basename $php_file) - Syntax errors found"
        php -l "$php_file"
        ((PHP_ERROR++))
        ((ERROR_COUNT++))
    fi
done
echo ""

# Summary
echo "========================================="
echo "Validation Summary"
echo "========================================="
if [ $ERROR_COUNT -eq 0 ]; then
    echo "✅ All checks passed! Theme structure is valid."
    echo ""
    echo "Next steps:"
    echo "1. Copy the theme to your OSSN installation's themes directory"
    echo "2. Activate the theme from OSSN admin panel"
    echo "3. Clear OSSN cache"
    echo "4. Test the landing page while logged out"
    exit 0
else
    echo "❌ Found $ERROR_COUNT error(s). Please fix them before using the theme."
    exit 1
fi
