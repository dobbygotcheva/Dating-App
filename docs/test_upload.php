<?php
// Test script to verify file upload functionality
require_once('mismatch/appvars.php');
require_once('mismatch/connectvars.php');

echo "Testing File Upload Functionality\n";
echo "=================================\n\n";

// Test 1: Check if images directory exists and is writable
echo "1. Checking images directory...\n";
$images_path = 'mismatch/' . MM_UPLOADPATH;
if (is_dir($images_path)) {
    echo "   ✓ Images directory exists: $images_path\n";
    if (is_writable($images_path)) {
        echo "   ✓ Images directory is writable\n";
    } else {
        echo "   ✗ Images directory is NOT writable\n";
    }
} else {
    echo "   ✗ Images directory does not exist: $images_path\n";
}

// Test 2: Check upload constants
echo "\n2. Checking upload constants...\n";
echo "   MM_UPLOADPATH: " . MM_UPLOADPATH . "\n";
echo "   MM_MAXFILESIZE: " . MM_MAXFILESIZE . " bytes (" . (MM_MAXFILESIZE / 1024) . " KB)\n";
echo "   MM_MAXIMGWIDTH: " . MM_MAXIMGWIDTH . " pixels\n";
echo "   MM_MAXIMGHEIGHT: " . MM_MAXIMGHEIGHT . " pixels\n";

// Test 3: Check if sample images exist
echo "\n3. Checking sample images...\n";
$sample_images = ['nopic.jpg', 'owenpic.jpg', 'elmerpic.jpg'];
foreach ($sample_images as $image) {
    $path = $images_path . $image;
    if (file_exists($path)) {
        $size = filesize($path);
        echo "   ✓ $image exists (" . $size . " bytes)\n";
    } else {
        echo "   ✗ $image does not exist\n";
    }
}

// Test 4: Test image validation function
echo "\n4. Testing image validation...\n";
function testImageValidation($filename, $images_path) {
    $path = $images_path . $filename;
    if (file_exists($path)) {
        $size = filesize($path);
        $image_info = getimagesize($path);
        if ($image_info !== false) {
            $width = $image_info[0];
            $height = $image_info[1];
            $type = $image_info['mime'];
            
            echo "   Testing $filename:\n";
            echo "     Size: $size bytes\n";
            echo "     Dimensions: ${width}x${height}\n";
            echo "     Type: $type\n";
            
            $valid_size = ($size > 0 && $size <= MM_MAXFILESIZE);
            $valid_dimensions = ($width <= MM_MAXIMGWIDTH && $height <= MM_MAXIMGHEIGHT);
            $valid_type = in_array($type, ['image/gif', 'image/jpeg', 'image/pjpeg', 'image/png']);
            
            echo "     Size valid: " . ($valid_size ? "✓" : "✗") . "\n";
            echo "     Dimensions valid: " . ($valid_dimensions ? "✓" : "✗") . "\n";
            echo "     Type valid: " . ($valid_type ? "✓" : "✗") . "\n";
            
            return $valid_size && $valid_dimensions && $valid_type;
        } else {
            echo "   ✗ $filename is not a valid image\n";
            return false;
        }
    } else {
        echo "   ✗ $filename does not exist\n";
        return false;
    }
}

testImageValidation('nopic.jpg', $images_path);
testImageValidation('owenpic.jpg', $images_path);

echo "\n5. Testing database connection...\n";
try {
    $dbc = new SQLite3(DB_PATH);
    echo "   ✓ Database connection successful\n";
    
    // Test query to check if users table has picture column
    $query = "SELECT user_id, username, picture FROM mismatch_user LIMIT 3";
    $result = $dbc->query($query);
    if ($result) {
        echo "   ✓ Database query successful\n";
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            echo "     User: " . $row['username'] . " - Picture: " . ($row['picture'] ?: 'none') . "\n";
        }
    } else {
        echo "   ✗ Database query failed\n";
    }
    $dbc->close();
} catch (Exception $e) {
    echo "   ✗ Database connection failed: " . $e->getMessage() . "\n";
}

echo "\nTest completed!\n";
?> 