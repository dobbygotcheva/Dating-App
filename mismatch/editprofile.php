<?php
  // Start the session
  require_once('startsession.php');

  // Insert the page header
  $page_title = 'Edit Profile';
  require_once('header.php');

  require_once('appvars.php');
  require_once('connectvars.php');

  // Make sure the user is logged in before going any further.
  if (!isset($_SESSION['user_id'])) {
    echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
    exit();
  }

  // Show the navigation menu
  require_once('navmenu.php');

  // Connect to the database
  $dbc = new SQLite3(DB_PATH);

  // Handle form submissions
  if (isset($_POST['submit'])) {
    $action = $_POST['action'];
    $error = false;
    $success_message = '';

    switch ($action) {
      case 'update_personal':
        // Update personal information
        $first_name = SQLite3::escapeString(trim($_POST['firstname']));
        $last_name = SQLite3::escapeString(trim($_POST['lastname']));
        $gender = SQLite3::escapeString(trim($_POST['gender']));
        $birthdate = SQLite3::escapeString(trim($_POST['birthdate']));
        
        if (!empty($first_name) && !empty($last_name) && !empty($gender) && !empty($birthdate)) {
          $query = "UPDATE mismatch_user SET first_name = '$first_name', last_name = '$last_name', 
                    gender = '$gender', birthdate = '$birthdate' WHERE user_id = '" . $_SESSION['user_id'] . "'";
          $result = $dbc->exec($query);
          if ($result !== false) {
            $success_message = 'Personal information updated successfully!';
          } else {
            $error = true;
            echo '<p class="error">Error updating personal information: ' . $dbc->lastErrorMsg() . '</p>';
          }
        } else {
          $error = true;
          echo '<p class="error">Please fill in all personal information fields.</p>';
        }
        break;

      case 'update_location':
        // Update location information
        $city = SQLite3::escapeString(trim($_POST['city']));
        $state = SQLite3::escapeString(trim($_POST['state']));
        
        if (!empty($city) && !empty($state)) {
          $query = "UPDATE mismatch_user SET city = '$city', state = '$state' 
                    WHERE user_id = '" . $_SESSION['user_id'] . "'";
          $result = $dbc->exec($query);
          if ($result !== false) {
            $success_message = 'Location information updated successfully!';
          } else {
            $error = true;
            echo '<p class="error">Error updating location: ' . $dbc->lastErrorMsg() . '</p>';
          }
        } else {
          $error = true;
          echo '<p class="error">Please fill in both city and state.</p>';
        }
        break;

      case 'update_picture':
        // Update profile picture
        $old_picture = SQLite3::escapeString(trim($_POST['old_picture']));
        $new_picture = SQLite3::escapeString(trim($_FILES['new_picture']['name']));
        $new_picture_type = $_FILES['new_picture']['type'];
        $new_picture_size = $_FILES['new_picture']['size'];

        if (!empty($new_picture) && $_FILES['new_picture']['error'] == 0) {
          if (!empty($_FILES['new_picture']['tmp_name']) && is_uploaded_file($_FILES['new_picture']['tmp_name'])) {
            list($new_picture_width, $new_picture_height) = getimagesize($_FILES['new_picture']['tmp_name']);
            
            if ((($new_picture_type == 'image/gif') || ($new_picture_type == 'image/jpeg') || ($new_picture_type == 'image/pjpeg') ||
              ($new_picture_type == 'image/png')) && ($new_picture_size > 0) && ($new_picture_size <= MM_MAXFILESIZE) &&
              ($new_picture_width <= MM_MAXIMGWIDTH) && ($new_picture_height <= MM_MAXIMGHEIGHT)) {
              
              $target = MM_UPLOADPATH . basename($new_picture);
              if (move_uploaded_file($_FILES['new_picture']['tmp_name'], $target)) {
                if (!empty($old_picture) && ($old_picture != $new_picture)) {
                  @unlink(MM_UPLOADPATH . $old_picture);
                }
                
                $query = "UPDATE mismatch_user SET picture = '$new_picture' WHERE user_id = '" . $_SESSION['user_id'] . "'";
                $result = $dbc->exec($query);
                if ($result !== false) {
                  $success_message = 'Profile picture updated successfully!';
                } else {
                  $error = true;
                  echo '<p class="error">Error updating profile picture in database: ' . $dbc->lastErrorMsg() . '</p>';
                }
              } else {
                $error = true;
                echo '<p class="error">Sorry, there was a problem uploading your picture.</p>';
              }
            } else {
              $error = true;
              echo '<p class="error">Your picture must be a GIF, JPEG, or PNG image file no greater than ' . (MM_MAXFILESIZE / 1024) .
                ' KB and ' . MM_MAXIMGWIDTH . 'x' . MM_MAXIMGHEIGHT . ' pixels in size.</p>';
            }
          } else {
            $error = true;
            echo '<p class="error">There was a problem with the uploaded file.</p>';
          }
        } else {
          $error = true;
          echo '<p class="error">Please select a picture to upload.</p>';
        }
        break;
    }

    if (!empty($success_message)) {
      echo '<div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0; border: 1px solid #c3e6cb;">';
      echo '<strong>✓ Success!</strong> ' . $success_message;
      echo '</div>';
    }
  }

  // Grab the current profile data from the database
  $query = "SELECT first_name, last_name, gender, birthdate, city, state, picture FROM mismatch_user WHERE user_id = '" . $_SESSION['user_id'] . "'";
  $data = $dbc->query($query);
  $row = $data->fetchArray(SQLITE3_ASSOC);

  if ($row != NULL) {
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $gender = $row['gender'];
    $birthdate = $row['birthdate'];
    $city = $row['city'];
    $state = $row['state'];
    $old_picture = $row['picture'];
  } else {
    echo '<p class="error">There was a problem accessing your profile.</p>';
    $dbc->close();
    exit();
  }

  $dbc->close();
?>

<div style="max-width: 800px; margin: 0 auto; padding: 20px;">
  <h2 style="text-align: center; margin-bottom: 30px; background: linear-gradient(45deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">✏️ Edit Your Profile</h2>

  <!-- Personal Information Section -->
  <div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 15px; padding: 25px; margin-bottom: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <h3 style="color: #667eea; margin-bottom: 20px;">👤 Personal Information</h3>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <input type="hidden" name="action" value="update_personal" />
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
        <div>
          <label for="firstname" style="display: block; margin-bottom: 5px; font-weight: 600; color: #333;">First name:</label>
          <input type="text" id="firstname" name="firstname" value="<?php if (!empty($first_name)) echo htmlspecialchars($first_name); ?>" 
                 style="width: 100%; padding: 10px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 14px;" />
        </div>
        <div>
          <label for="lastname" style="display: block; margin-bottom: 5px; font-weight: 600; color: #333;">Last name:</label>
          <input type="text" id="lastname" name="lastname" value="<?php if (!empty($last_name)) echo htmlspecialchars($last_name); ?>" 
                 style="width: 100%; padding: 10px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 14px;" />
        </div>
        <div>
          <label for="gender" style="display: block; margin-bottom: 5px; font-weight: 600; color: #333;">Gender:</label>
          <select id="gender" name="gender" style="width: 100%; padding: 10px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 14px;">
            <option value="M" <?php if (!empty($gender) && $gender == 'M') echo 'selected = "selected"'; ?>>Male</option>
            <option value="F" <?php if (!empty($gender) && $gender == 'F') echo 'selected = "selected"'; ?>>Female</option>
          </select>
        </div>
        <div>
          <label for="birthdate" style="display: block; margin-bottom: 5px; font-weight: 600; color: #333;">Birthdate:</label>
          <input type="text" id="birthdate" name="birthdate" value="<?php if (!empty($birthdate)) echo htmlspecialchars($birthdate); else echo 'YYYY-MM-DD'; ?>" 
                 style="width: 100%; padding: 10px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 14px;" />
        </div>
      </div>
      <button type="submit" name="submit" style="background: linear-gradient(45deg, #667eea, #764ba2); color: white; padding: 12px 25px; border: none; border-radius: 25px; cursor: pointer; font-size: 14px; font-weight: 600;">
        💾 Save Personal Info
      </button>
    </form>
  </div>

  <!-- Location Information Section -->
  <div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 15px; padding: 25px; margin-bottom: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <h3 style="color: #667eea; margin-bottom: 20px;">📍 Location Information</h3>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <input type="hidden" name="action" value="update_location" />
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
        <div>
          <label for="city" style="display: block; margin-bottom: 5px; font-weight: 600; color: #333;">City:</label>
          <input type="text" id="city" name="city" value="<?php if (!empty($city)) echo htmlspecialchars($city); ?>" 
                 style="width: 100%; padding: 10px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 14px;" />
        </div>
        <div>
          <label for="state" style="display: block; margin-bottom: 5px; font-weight: 600; color: #333;">State:</label>
          <input type="text" id="state" name="state" value="<?php if (!empty($state)) echo htmlspecialchars($state); ?>" 
                 style="width: 100%; padding: 10px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 14px;" />
        </div>
      </div>
      <button type="submit" name="submit" style="background: linear-gradient(45deg, #667eea, #764ba2); color: white; padding: 12px 25px; border: none; border-radius: 25px; cursor: pointer; font-size: 14px; font-weight: 600;">
        💾 Save Location
      </button>
    </form>
  </div>

  <!-- Profile Picture Section -->
  <div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 15px; padding: 25px; margin-bottom: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <h3 style="color: #667eea; margin-bottom: 20px;">📸 Profile Picture</h3>
    <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
      <input type="hidden" name="action" value="update_picture" />
      <input type="hidden" name="old_picture" value="<?php if (!empty($old_picture)) echo htmlspecialchars($old_picture); ?>" />
      
      <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 20px;">
        <div style="flex: 1;">
          <label for="new_picture" style="display: block; margin-bottom: 10px; font-weight: 600; color: #333;">Choose new picture:</label>
          <input type="file" id="new_picture" name="new_picture" 
                 style="width: 100%; padding: 10px; border: 2px solid #e1e5e9; border-radius: 8px; font-size: 14px;" />
          <small style="color: #666; display: block; margin-top: 5px;">
            Max size: <?php echo (MM_MAXFILESIZE / 1024); ?> KB, Max dimensions: <?php echo MM_MAXIMGWIDTH; ?>x<?php echo MM_MAXIMGHEIGHT; ?> pixels
          </small>
        </div>
        <div style="text-align: center;">
          <?php if (!empty($old_picture)) { ?>
            <img src="<?php echo MM_UPLOADPATH . htmlspecialchars($old_picture); ?>" alt="Current Profile Picture" 
                 style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; border: 3px solid #667eea;" />
            <p style="margin-top: 5px; font-size: 12px; color: #666;">Current picture</p>
          <?php } else { ?>
            <img src="<?php echo MM_UPLOADPATH; ?>nopic.jpg" alt="Default Profile Picture" 
                 style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; border: 3px solid #667eea;" />
            <p style="margin-top: 5px; font-size: 12px; color: #666;">Default picture</p>
          <?php } ?>
        </div>
      </div>
      <button type="submit" name="submit" style="background: linear-gradient(45deg, #667eea, #764ba2); color: white; padding: 12px 25px; border: none; border-radius: 25px; cursor: pointer; font-size: 14px; font-weight: 600;">
        📤 Upload Picture
      </button>
    </form>
  </div>

  <!-- Navigation -->
  <div style="text-align: center; margin-top: 30px;">
    <a href="viewprofile.php" style="background: linear-gradient(45deg, #51cf66, #40c057); color: white; padding: 12px 25px; border-radius: 25px; text-decoration: none; margin: 0 10px; display: inline-block; font-weight: 600;">
      👁️ View Profile
    </a>
    <a href="index.php" style="background: linear-gradient(45deg, #667eea, #764ba2); color: white; padding: 12px 25px; border-radius: 25px; text-decoration: none; margin: 0 10px; display: inline-block; font-weight: 600;">
      🏠 Back to Home
    </a>
  </div>
</div>

<?php
  // Insert the page footer
  require_once('footer.php');
?>
