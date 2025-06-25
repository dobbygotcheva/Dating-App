<?php
  // Start the session
  require_once('startsession.php');

  // Insert the page header
  $page_title = 'View Profile';
  require_once('header.php');

  require_once('appvars.php');
  require_once('connectvars.php');

  // Show the navigation menu
  require_once('navmenu.php');

  // Connect to the database
  $dbc = new SQLite3(DB_PATH);

  // Make sure the user is logged in before going any further.
  if (!isset($_SESSION['user_id'])) {
    echo '<div class="error">';
    echo '<h3>🔒 Access Restricted</h3>';
    echo '<p>Please <a href="login.php" style="color: white; text-decoration: underline;">log in</a> to access this page.</p>';
    echo '</div>';
    exit();
  }

  // Determine which profile to show
  $target_user_id = null;
  $is_own_profile = false;
  
  if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    // Viewing a specific user's profile
    $target_user_id = SQLite3::escapeString($_GET['user_id']);
    $is_own_profile = ($_SESSION['user_id'] == $_GET['user_id']);
  } else {
    // No user_id specified, show current user's profile
    $target_user_id = $_SESSION['user_id'];
    $is_own_profile = true;
  }

  // Grab the profile data from the database
  $query = "SELECT user_id, username, first_name, last_name, gender, birthdate, city, state, picture FROM mismatch_user WHERE user_id = '$target_user_id'";
  $data = $dbc->query($query);
  
  if ($data) {
    $row = $data->fetchArray(SQLITE3_ASSOC);
    if ($row) {
      // Profile found - display it beautifully
      echo '<div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 20px; padding: 40px; margin: 30px auto; max-width: 600px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.2);">';
      
      if ($is_own_profile) {
        echo '<h3 style="text-align: center; margin-bottom: 30px; background: linear-gradient(45deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">👤 My Profile</h3>';
      } else {
        echo '<h3 style="text-align: center; margin-bottom: 30px; background: linear-gradient(45deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">👤 User Profile</h3>';
      }
      
      // Profile picture
      if (!empty($row['picture']) && is_file(MM_UPLOADPATH . $row['picture']) && filesize(MM_UPLOADPATH . $row['picture']) > 0) {
        echo '<div style="text-align: center; margin-bottom: 30px;">';
        echo '<img src="' . MM_UPLOADPATH . $row['picture'] . '" alt="Profile Picture" class="profile" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; border: 4px solid #667eea; box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);" />';
        echo '</div>';
      } else {
        echo '<div style="text-align: center; margin-bottom: 30px;">';
        echo '<img src="' . MM_UPLOADPATH . 'nopic.jpg' . '" alt="Default Profile Picture" class="profile" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; border: 4px solid #667eea; box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);" />';
        echo '</div>';
      }
      
      // Profile information
      echo '<div style="display: grid; gap: 15px;">';
      
      if (!empty($row['username'])) {
        echo '<div style="background: rgba(102, 126, 234, 0.05); padding: 15px; border-radius: 10px; border-left: 4px solid #667eea;">';
        echo '<strong style="color: #667eea;">👤 Username:</strong> ' . htmlspecialchars($row['username']);
        echo '</div>';
      }
      
      if (!empty($row['first_name'])) {
        echo '<div style="background: rgba(102, 126, 234, 0.05); padding: 15px; border-radius: 10px; border-left: 4px solid #667eea;">';
        echo '<strong style="color: #667eea;">📝 First Name:</strong> ' . htmlspecialchars($row['first_name']);
        echo '</div>';
      }
      
      if (!empty($row['last_name'])) {
        echo '<div style="background: rgba(102, 126, 234, 0.05); padding: 15px; border-radius: 10px; border-left: 4px solid #667eea;">';
        echo '<strong style="color: #667eea;">📝 Last Name:</strong> ' . htmlspecialchars($row['last_name']);
        echo '</div>';
      }
      
      if (!empty($row['gender'])) {
        echo '<div style="background: rgba(102, 126, 234, 0.05); padding: 15px; border-radius: 10px; border-left: 4px solid #667eea;">';
        echo '<strong style="color: #667eea;">⚧ Gender:</strong> ';
        if ($row['gender'] == 'M') {
          echo '👨 Male';
        } else if ($row['gender'] == 'F') {
          echo '👩 Female';
        } else {
          echo '❓ Unknown';
        }
        echo '</div>';
      }
      
      if (!empty($row['birthdate'])) {
        echo '<div style="background: rgba(102, 126, 234, 0.05); padding: 15px; border-radius: 10px; border-left: 4px solid #667eea;">';
        if ($is_own_profile) {
          echo '<strong style="color: #667eea;">🎂 Birthdate:</strong> ' . htmlspecialchars($row['birthdate']);
        } else {
          list($year, $month, $day) = explode('-', $row['birthdate']);
          echo '<strong style="color: #667eea;">🎂 Birth Year:</strong> ' . htmlspecialchars($year);
        }
        echo '</div>';
      }
      
      if (!empty($row['city']) || !empty($row['state'])) {
        echo '<div style="background: rgba(102, 126, 234, 0.05); padding: 15px; border-radius: 10px; border-left: 4px solid #667eea;">';
        echo '<strong style="color: #667eea;">📍 Location:</strong> ' . htmlspecialchars($row['city']) . ', ' . htmlspecialchars($row['state']);
        echo '</div>';
      }
      
      echo '</div>';
      
      // Action buttons
      echo '<div style="text-align: center; margin-top: 30px; display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">';
      
      if ($is_own_profile) {
        echo '<a href="editprofile.php" style="background: linear-gradient(45deg, #51cf66, #40c057); color: white; padding: 10px 20px; border-radius: 25px; text-decoration: none; transition: all 0.3s ease; display: inline-block;">✏️ Edit Profile</a>';
      }
      
      echo '<a href="index.php" style="background: linear-gradient(45deg, #667eea, #764ba2); color: white; padding: 10px 20px; border-radius: 25px; text-decoration: none; transition: all 0.3s ease; display: inline-block;">← Back to Home</a>';
      
      echo '</div>';
      
      echo '</div>';
    } else {
      echo '<div class="error">';
      echo '<h3>❌ Profile Not Found</h3>';
      echo '<p>The user profile you requested does not exist.</p>';
      echo '<p><a href="index.php" style="color: white; text-decoration: underline;">← Back to Home</a></p>';
      echo '</div>';
    }
  } else {
    echo '<div class="error">';
    echo '<h3>⚠️ Database Error</h3>';
    echo '<p>There was a problem accessing the profile from the database.</p>';
    echo '<p><a href="index.php" style="color: white; text-decoration: underline;">← Back to Home</a></p>';
    echo '</div>';
  }

  $dbc->close();
?>

<?php
  // Insert the page footer
  require_once('footer.php');
?>
