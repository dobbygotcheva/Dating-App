<?php
  // Start the session
  require_once('startsession.php');

  // Insert the page header
  $page_title = 'Where opposites attract!';
  require_once('header.php');

  require_once('appvars.php');
  require_once('connectvars.php');

  // Show the navigation menu
  require_once('navmenu.php');

  // Connect to the database 
  $dbc = new SQLite3(DB_PATH); 

  // Retrieve ALL users from SQLite (not just 5)
  $query = "SELECT user_id, first_name, picture FROM mismatch_user WHERE first_name IS NOT NULL ORDER BY join_date DESC";
  $data = $dbc->query($query);

  // Welcome section with more prominent advertisement text and darker title
  echo '<div class="hero-section" style="text-align: center; padding: 60px 20px; color: white; margin-bottom: 40px; background: linear-gradient(135deg, rgba(102, 126, 234, 0.9), rgba(118, 75, 162, 0.9)); border-radius: 20px; margin: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">';
  echo '<h1 style="font-size: 4em; margin-bottom: 25px; text-shadow: 3px 3px 6px rgba(0,0,0,0.6); font-weight: 700; color: #1a1a1a;">💕 Welcome to Mismatch</h1>';
  echo '<p style="font-size: 1.5em; margin-bottom: 20px; font-weight: 600; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); color: #2c2c2c;">Where opposites attract!</p>';
  echo '<p style="font-size: 1.3em; margin-bottom: 40px; opacity: 0.95; text-shadow: 1px 1px 2px rgba(0,0,0,0.4); color: #333;">Find your perfect mismatch and start your journey to meaningful connections.</p>';
  
  if (!isset($_SESSION['user_id'])) {
    echo '<div style="margin: 40px 0;">';
    echo '<a href="signup.php" style="background: rgba(255,255,255,0.25); color: white; padding: 18px 35px; border-radius: 30px; text-decoration: none; margin: 0 15px; border: 3px solid white; transition: all 0.3s ease; display: inline-block; font-weight: 600; font-size: 1.1em; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">🚀 Join Now - Start Your Journey</a>';
    echo '<a href="login.php" style="background: white; color: #667eea; padding: 18px 35px; border-radius: 30px; text-decoration: none; margin: 0 15px; transition: all 0.3s ease; display: inline-block; font-weight: 600; font-size: 1.1em; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">🔑 Login to Your Account</a>';
    echo '</div>';
  }
  echo '</div>';

  // Advertisement Section
  echo '<div class="advertisement">';
  echo '<h3>🌟 Special Offer - Find Your Perfect Match!</h3>';
  echo '<img src="images/ad.jpg" alt="Special Dating Offer" style="max-width: 100%; height: auto; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);" />';
  echo '<p style="color: #666; font-size: 1.1em; line-height: 1.6; margin: 20px 0;">Discover amazing people who complement your personality perfectly. Our unique matching algorithm finds people with opposite preferences, creating the perfect balance for meaningful relationships.</p>';
  if (!isset($_SESSION['user_id'])) {
    echo '<a href="signup.php" style="background: linear-gradient(45deg, #667eea, #764ba2); color: white; padding: 15px 30px; border-radius: 25px; text-decoration: none; font-weight: 600; display: inline-block; margin-top: 15px; transition: all 0.3s ease;">🎯 Start Matching Now</a>';
  } else {
    echo '<a href="mymismatch.php" style="background: linear-gradient(45deg, #667eea, #764ba2); color: white; padding: 15px 30px; border-radius: 25px; text-decoration: none; font-weight: 600; display: inline-block; margin-top: 15px; transition: all 0.3s ease;">💕 View My Matches</a>';
  }
  echo '</div>';

  // Enhanced Features section with more prominent text
  echo '<div class="features" style="display: flex; justify-content: center; gap: 30px; margin: 50px 20px; flex-wrap: wrap;">';
  echo '<div class="feature" style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(15px); border-radius: 20px; padding: 30px; text-align: center; color: white; min-width: 250px; border: 2px solid rgba(255,255,255,0.3); box-shadow: 0 10px 25px rgba(0,0,0,0.2); transition: transform 0.3s ease;">';
  echo '<h3 style="color: white; margin-bottom: 15px; font-size: 1.4em; font-weight: 700; text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">🎯 Smart Matching Algorithm</h3>';
  echo '<p style="font-size: 1.1em; line-height: 1.5; text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">Our advanced algorithm finds people with opposite preferences, creating the perfect balance for meaningful relationships.</p>';
  echo '</div>';
  echo '<div class="feature" style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(15px); border-radius: 20px; padding: 30px; text-align: center; color: white; min-width: 250px; border: 2px solid rgba(255,255,255,0.3); box-shadow: 0 10px 25px rgba(0,0,0,0.2); transition: transform 0.3s ease;">';
  echo '<h3 style="color: white; margin-bottom: 15px; font-size: 1.4em; font-weight: 700; text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">🔒 Privacy & Security First</h3>';
  echo '<p style="font-size: 1.1em; line-height: 1.5; text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">Your privacy is our top priority. We use industry-standard security to protect your personal information.</p>';
  echo '</div>';
  echo '<div class="feature" style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(15px); border-radius: 20px; padding: 30px; text-align: center; color: white; min-width: 250px; border: 2px solid rgba(255,255,255,0.3); box-shadow: 0 10px 25px rgba(0,0,0,0.2); transition: transform 0.3s ease;">';
  echo '<h3 style="color: white; margin-bottom: 15px; font-size: 1.4em; font-weight: 700; text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">💬 Meaningful Connections</h3>';
  echo '<p style="font-size: 1.1em; line-height: 1.5; text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">Build genuine relationships based on complementary personalities and shared values.</p>';
  echo '</div>';
  echo '</div>';

  // Enhanced Latest members section - now shows ALL users
  echo '<div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 20px; padding: 40px; margin: 30px auto; max-width: 1200px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.2);">';
  echo '<h3 style="text-align: center; margin-bottom: 30px; background: linear-gradient(45deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-size: 2.2em; font-weight: 700;">🌟 Our Community Members</h3>';
  echo '<p style="text-align: center; color: #666; margin-bottom: 30px; font-size: 1.1em;">Discover amazing people in our community who are looking for their perfect mismatch!</p>';
  echo '<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 25px;">';
  
  $user_count = 0;
  while ($row = $data->fetchArray(SQLITE3_ASSOC)) {
    $user_count++;
    echo '<div style="text-align: center; padding: 20px; border-radius: 15px; background: rgba(102, 126, 234, 0.05); transition: transform 0.3s ease; border: 1px solid rgba(102, 126, 234, 0.1);">';
    
    if (is_file(MM_UPLOADPATH . $row['picture']) && filesize(MM_UPLOADPATH . $row['picture']) > 0) {
      echo '<img src="' . MM_UPLOADPATH . $row['picture'] . '" alt="' . $row['first_name'] . '" class="profile" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%; border: 3px solid #667eea; margin-bottom: 15px; box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);" />';
    }
    else {
      echo '<img src="' . MM_UPLOADPATH . 'nopic.jpg' . '" alt="' . $row['first_name'] . '" class="profile" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%; border: 3px solid #667eea; margin-bottom: 15px; box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);" />';
    }
    
    if (isset($_SESSION['user_id'])) {
      echo '<p><a href="viewprofile.php?user_id=' . $row['user_id'] . '" style="color: #667eea; text-decoration: none; font-weight: 600; font-size: 1.1em;">' . $row['first_name'] . '</a></p>';
    }
    else {
      echo '<p style="font-weight: 600; color: #2c3e50; font-size: 1.1em;">' . $row['first_name'] . '</p>';
    }
    echo '</div>';
  }
  echo '</div>';
  
  if ($user_count > 0) {
    echo '<div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 2px solid rgba(102, 126, 234, 0.1);">';
    echo '<p style="color: #667eea; font-weight: 600; font-size: 1.1em;">Total Members: ' . $user_count . '</p>';
    if (!isset($_SESSION['user_id'])) {
      echo '<p style="color: #666; margin-top: 10px;">Join our community to connect with these amazing people!</p>';
    }
    echo '</div>';
  }
  echo '</div>';

  $dbc->close();
?>

<?php
  // Insert the page footer
  require_once('footer.php');
?>

