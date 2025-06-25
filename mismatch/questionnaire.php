<?php
  // Start the session
  require_once('startsession.php');

  // Insert the page header
  $page_title = 'Questionnaire';
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

  // If the user has already answered the questionnaire, delete their old answers
  $query = "SELECT COUNT(*) as count FROM mismatch_response WHERE user_id = '" . $_SESSION['user_id'] . "'";
  $data = $dbc->query($query);
  $row = $data->fetchArray(SQLITE3_ASSOC);
  if ($row['count'] > 0) {
    $query = "DELETE FROM mismatch_response WHERE user_id = '" . $_SESSION['user_id'] . "'";
    $dbc->exec($query);
  }

  // If the questionnaire form has been submitted, write the form data to the database
  if (isset($_POST['submit'])) {
    // Write the questionnaire data to the database (if any)
    $query = "SELECT topic_id FROM mismatch_topic ORDER BY category_id, topic_id";
    $data = $dbc->query($query);
    while ($row = $data->fetchArray(SQLITE3_ASSOC)) {
      $query = "INSERT INTO mismatch_response (user_id, topic_id, response) VALUES ('" . $_SESSION['user_id'] . "', '" . $row['topic_id'] . "', '" . $_POST['response' . $row['topic_id']] . "')";
      $dbc->exec($query);
    }
    
    echo '<div style="max-width: 800px; margin: 50px auto; padding: 40px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); text-align: center;">';
    echo '<div style="font-size: 4em; margin-bottom: 20px;">🎉</div>';
    echo '<h2 style="color: #667eea; margin-bottom: 20px;">Questionnaire Saved!</h2>';
    echo '<p style="font-size: 1.2em; color: #666; margin-bottom: 30px;">Your preferences have been recorded. Now you can find your perfect mismatch!</p>';
    echo '<div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">';
    echo '<a href="mymismatch.php" style="background: linear-gradient(45deg, #667eea, #764ba2); color: white; padding: 15px 30px; border-radius: 25px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;">🔍 Find Matches</a>';
    echo '<a href="index.php" style="background: linear-gradient(45deg, #51cf66, #40c057); color: white; padding: 15px 30px; border-radius: 25px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;">🏠 Back to Home</a>';
    echo '</div>';
    echo '</div>';
  }
  else {
    // Grab the questionnaire data from the database to present the questions to the user
    $query = "SELECT mt.topic_id, mt.name AS topic_name, mc.name AS category_name " .
      "FROM mismatch_topic AS mt " .
      "INNER JOIN mismatch_category AS mc USING (category_id) " .
      "ORDER BY mc.category_id, mt.topic_id";
    $data = $dbc->query($query);
    
    echo '<div style="max-width: 900px; margin: 0 auto; padding: 20px;">';
    echo '<div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 20px; padding: 40px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); margin-bottom: 30px;">';
    echo '<h2 style="text-align: center; margin-bottom: 10px; background: linear-gradient(45deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-size: 2.5em;">📝 Personality Questionnaire</h2>';
    echo '<p style="text-align: center; font-size: 1.2em; color: #666; margin-bottom: 30px;">Tell us how you feel about each topic to find your perfect mismatch!</p>';
    
    echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
    
    $current_category = '';
    $question_count = 0;
    
    while ($row = $data->fetchArray(SQLITE3_ASSOC)) {
      $question_count++;
      
      // Start new category section
      if ($current_category != $row['category_name']) {
        if ($current_category != '') {
          echo '</div>'; // Close previous category
        }
        $current_category = $row['category_name'];
        echo '<div style="margin-bottom: 40px;">';
        echo '<h3 style="color: #667eea; font-size: 1.5em; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #667eea;">' . $current_category . '</h3>';
      }
      
      echo '<div style="background: rgba(102, 126, 234, 0.05); border-radius: 15px; padding: 25px; margin-bottom: 20px; border-left: 4px solid #667eea;">';
      echo '<h4 style="color: #2c3e50; margin-bottom: 15px; font-size: 1.1em;">' . $question_count . '. ' . $row['topic_name'] . '</h4>';
      
      echo '<div style="display: flex; gap: 20px; flex-wrap: wrap;">';
      echo '<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 10px 15px; background: white; border-radius: 25px; border: 2px solid #e1e5e9; transition: all 0.3s ease; min-width: 120px;">';
      echo '<input type="radio" name="response' . $row['topic_id'] . '" value="1" style="margin: 0;" required />';
      echo '<span style="color: #51cf66; font-weight: 600;">❤️ Love it</span>';
      echo '</label>';
      
      echo '<label style="display: flex; align-items: center; gap: 8px; cursor: pointer; padding: 10px 15px; background: white; border-radius: 25px; border: 2px solid #e1e5e9; transition: all 0.3s ease; min-width: 120px;">';
      echo '<input type="radio" name="response' . $row['topic_id'] . '" value="2" style="margin: 0;" required />';
      echo '<span style="color: #e74c3c; font-weight: 600;">💔 Hate it</span>';
      echo '</label>';
      echo '</div>';
      echo '</div>';
    }
    
    if ($current_category != '') {
      echo '</div>'; // Close last category
    }
    
    echo '<div style="text-align: center; margin-top: 40px;">';
    echo '<button type="submit" name="submit" style="background: linear-gradient(45deg, #667eea, #764ba2); color: white; padding: 18px 40px; border: none; border-radius: 30px; font-size: 1.2em; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);">';
    echo '💾 Save My Questionnaire';
    echo '</button>';
    echo '</div>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
  }

  $dbc->close();

  // Insert the page footer
  require_once('footer.php');
?>
