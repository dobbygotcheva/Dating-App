<?php
  // Start the session
  require_once('startsession.php');

  // Insert the page header
  $page_title = 'My Mismatch - Where opposites attract!';
  require_once('header.php');

  require_once('appvars.php');
  require_once('connectvars.php');

  // Show the navigation menu
  require_once('navmenu.php');

  // Connect to the database
  $dbc = new SQLite3(DB_PATH);

  // Make sure the user is logged in before going any further.
  if (!isset($_SESSION['user_id'])) {
    echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
    exit();
  }

  // Check if the user has completed the questionnaire
  $query = "SELECT COUNT(*) as count FROM mismatch_response WHERE user_id = " . $_SESSION['user_id'];
  $result = $dbc->query($query);
  $row = $result->fetchArray(SQLITE3_ASSOC);
  
  if ($row['count'] == 0) {
    echo '<div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 20px; padding: 40px; margin: 30px auto; max-width: 600px; text-align: center; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.2);">';
    echo '<h3 style="color: #2c3e50; margin-bottom: 20px; font-size: 1.8em;">📝 Complete Your Questionnaire First</h3>';
    echo '<p style="color: #666; font-size: 1.1em; line-height: 1.6; margin: 20px 0;">To find your perfect matches, you need to complete the questionnaire first. This helps us understand your preferences and find people with opposite tastes!</p>';
    echo '<a href="questionnaire.php" style="background: linear-gradient(45deg, #667eea, #764ba2); color: white; padding: 15px 30px; border-radius: 25px; text-decoration: none; font-weight: 600; display: inline-block; margin-top: 20px; transition: all 0.3s ease;">📋 Take the Questionnaire</a>';
    echo '</div>';
    $dbc->close();
    exit();
  }

  // Get the user's responses
  $query = "SELECT topic_id, response FROM mismatch_response WHERE user_id = " . $_SESSION['user_id'];
  $user_responses = $dbc->query($query);
  
  $user_preferences = array();
  while ($row = $user_responses->fetchArray(SQLITE3_ASSOC)) {
    $user_preferences[$row['topic_id']] = $row['response'];
  }

  // Find users with opposite responses (mismatches)
  $mismatch_users = array();
  
  // Get all other users who have completed the questionnaire
  $query = "SELECT DISTINCT u.user_id, u.first_name, u.last_name, u.gender, u.city, u.state, u.picture 
            FROM mismatch_user u 
            INNER JOIN mismatch_response r ON u.user_id = r.user_id 
            WHERE u.user_id != " . $_SESSION['user_id'] . " 
            AND u.first_name IS NOT NULL 
            GROUP BY u.user_id 
            HAVING COUNT(r.response_id) > 0";
  
  $other_users = $dbc->query($query);
  
  while ($user = $other_users->fetchArray(SQLITE3_ASSOC)) {
    // Get this user's responses
    $query = "SELECT topic_id, response FROM mismatch_response WHERE user_id = " . $user['user_id'];
    $other_responses = $dbc->query($query);
    
    $mismatch_count = 0;
    $total_questions = 0;
    
    while ($response = $other_responses->fetchArray(SQLITE3_ASSOC)) {
      if (isset($user_preferences[$response['topic_id']])) {
        $total_questions++;
        // Check if responses are opposite (1 vs 2)
        if ($user_preferences[$response['topic_id']] != $response['response']) {
          $mismatch_count++;
        }
      }
    }
    
    // Calculate mismatch percentage (only if they answered enough questions)
    if ($total_questions >= 5) { // Require at least 5 common questions
      $mismatch_percentage = ($mismatch_count / $total_questions) * 100;
      $user['mismatch_percentage'] = round($mismatch_percentage);
      $user['mismatch_count'] = $mismatch_count;
      $user['total_questions'] = $total_questions;
      $mismatch_users[] = $user;
    }
  }

  // Sort by mismatch percentage (highest first)
  usort($mismatch_users, function($a, $b) {
    return $b['mismatch_percentage'] - $a['mismatch_percentage'];
  });

  // Display the matches
  echo '<div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 20px; padding: 40px; margin: 30px auto; max-width: 1200px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.2);">';
  echo '<h3 style="text-align: center; margin-bottom: 30px; background: linear-gradient(45deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-size: 2.2em; font-weight: 700;">💕 Your Perfect Mismatches</h3>';
  
  if (empty($mismatch_users)) {
    echo '<div style="text-align: center; padding: 40px;">';
    echo '<p style="color: #666; font-size: 1.2em; margin-bottom: 20px;">No matches found yet. More people need to complete the questionnaire!</p>';
    echo '<p style="color: #667eea; font-weight: 600;">Share Mismatch with your friends to find more potential matches!</p>';
    echo '</div>';
  } else {
    echo '<p style="text-align: center; color: #666; margin-bottom: 30px; font-size: 1.1em;">These people have opposite preferences to yours - perfect for creating interesting conversations!</p>';
    
    echo '<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 25px;">';
    
    foreach ($mismatch_users as $match) {
      $match_level = '';
      $match_color = '';
      
      if ($match['mismatch_percentage'] >= 80) {
        $match_level = '🔥 Perfect Mismatch';
        $match_color = '#e74c3c';
      } elseif ($match['mismatch_percentage'] >= 60) {
        $match_level = '💫 Great Mismatch';
        $match_color = '#f39c12';
      } else {
        $match_level = '✨ Good Mismatch';
        $match_color = '#27ae60';
      }
      
      echo '<div style="background: rgba(255, 255, 255, 0.8); border-radius: 15px; padding: 25px; border: 2px solid ' . $match_color . '; box-shadow: 0 8px 25px rgba(0,0,0,0.1); transition: transform 0.3s ease;">';
      
      // Profile picture
      if (!empty($match['picture']) && is_file(MM_UPLOADPATH . $match['picture']) && filesize(MM_UPLOADPATH . $match['picture']) > 0) {
        echo '<img src="' . MM_UPLOADPATH . $match['picture'] . '" alt="' . $match['first_name'] . '" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; border: 4px solid ' . $match_color . '; margin: 0 auto 20px; display: block; box-shadow: 0 5px 15px rgba(0,0,0,0.2);" />';
      } else {
        echo '<img src="' . MM_UPLOADPATH . 'nopic.jpg' . '" alt="' . $match['first_name'] . '" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; border: 4px solid ' . $match_color . '; margin: 0 auto 20px; display: block; box-shadow: 0 5px 15px rgba(0,0,0,0.2);" />';
      }
      
      // Name and basic info
      echo '<h4 style="text-align: center; color: #2c3e50; margin-bottom: 10px; font-size: 1.3em;">' . $match['first_name'] . ' ' . $match['last_name'] . '</h4>';
      
      if (!empty($match['city']) || !empty($match['state'])) {
        echo '<p style="text-align: center; color: #666; margin-bottom: 15px; font-size: 0.9em;">📍 ' . $match['city'] . ', ' . $match['state'] . '</p>';
      }
      
      // Mismatch percentage
      echo '<div style="text-align: center; margin-bottom: 15px;">';
      echo '<span style="background: ' . $match_color . '; color: white; padding: 5px 12px; border-radius: 15px; font-size: 0.9em; font-weight: 600;">' . $match_level . '</span>';
      echo '</div>';
      
      echo '<div style="text-align: center; margin-bottom: 20px;">';
      echo '<p style="color: #2c3e50; font-weight: 600; margin-bottom: 5px;">Mismatch Score: ' . $match['mismatch_percentage'] . '%</p>';
      echo '<p style="color: #666; font-size: 0.9em;">' . $match['mismatch_count'] . ' out of ' . $match['total_questions'] . ' preferences differ</p>';
      echo '</div>';
      
      // View profile button
      echo '<div style="text-align: center;">';
      echo '<a href="viewprofile.php?user_id=' . $match['user_id'] . '" style="background: linear-gradient(45deg, #667eea, #764ba2); color: white; padding: 10px 20px; border-radius: 20px; text-decoration: none; font-weight: 600; display: inline-block; transition: all 0.3s ease; font-size: 0.9em;">👤 View Profile</a>';
      echo '</div>';
      
      echo '</div>';
    }
    
    echo '</div>';
    
    // Summary
    echo '<div style="text-align: center; margin-top: 40px; padding-top: 30px; border-top: 2px solid rgba(102, 126, 234, 0.1);">';
    echo '<p style="color: #667eea; font-weight: 600; font-size: 1.1em;">Found ' . count($mismatch_users) . ' potential matches for you!</p>';
    echo '<p style="color: #666; margin-top: 10px;">The higher the mismatch percentage, the more opposite your preferences are - perfect for interesting conversations!</p>';
    echo '</div>';
  }
  
  echo '</div>';

  // Delete profile section (keeping the original functionality)
  echo '<div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 20px; padding: 30px; margin: 30px auto; max-width: 600px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.2);">';
  echo '<h3 style="text-align: center; margin-bottom: 20px; color: #e74c3c; font-size: 1.5em;">⚠️ Delete My Profile</h3>';
  echo '<p style="text-align: center; color: #666; margin-bottom: 20px; line-height: 1.6;">Once you delete your profile, you\'ll need to create a new profile if you ever want to use Mismatch again.</p>';
  echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '" style="text-align: center;">';
  echo '<input type="submit" value="🗑️ Delete My Profile" name="submit" style="background: linear-gradient(45deg, #e74c3c, #c0392b); color: white; padding: 12px 25px; border: none; border-radius: 20px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;" />';
  echo '</form>';
  echo '</div>';

  // Handle profile deletion
  if (isset($_POST['submit'])) {
    // Delete user's responses first
    $query = "DELETE FROM mismatch_response WHERE user_id = " . $_SESSION['user_id'];
    $dbc->query($query);
    
    // Delete user's profile
    $query = "DELETE FROM mismatch_user WHERE user_id = " . $_SESSION['user_id'];
    $result = $dbc->query($query);
    
    if ($result) {
      echo '<div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 20px; padding: 30px; margin: 30px auto; max-width: 600px; text-align: center; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.2);">';
      echo '<h3 style="color: #27ae60; margin-bottom: 20px;">✅ Profile Deleted Successfully</h3>';
      echo '<p style="color: #666; margin-bottom: 20px;">Your Mismatch profile has been permanently deleted.</p>';
      echo '<a href="index.php" style="background: linear-gradient(45deg, #667eea, #764ba2); color: white; padding: 12px 25px; border-radius: 20px; text-decoration: none; font-weight: 600; display: inline-block;">🏠 Return to Home</a>';
      echo '</div>';
      
      // Clear session
      session_destroy();
      $dbc->close();
      exit();
    } else {
      echo '<div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 20px; padding: 30px; margin: 30px auto; max-width: 600px; text-align: center; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.2);">';
      echo '<h3 style="color: #e74c3c; margin-bottom: 20px;">❌ Error</h3>';
      echo '<p style="color: #666;">There was a problem removing your profile. Please try again.</p>';
      echo '</div>';
    }
  }

  $dbc->close();
?>

<?php
  // Insert the page footer
  require_once('footer.php');
?>
