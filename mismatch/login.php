<?php
  require_once('connectvars.php');

  // Start the session
  session_start();

  // Clear the error message
  $error_msg = "";

  // If the user isn't logged in, try to log them in
  if (!isset($_SESSION['user_id'])) {
    if (isset($_POST['submit'])) {
      // Connect to the database
      $dbc = new SQLite3(DB_PATH);

      // Grab the user-entered log-in data
      $user_username = SQLite3::escapeString(trim($_POST['username']));
      $user_password = SQLite3::escapeString(trim($_POST['password']));

      if (!empty($user_username) && !empty($user_password)) {
        // Look up the username and password in the database
        $query = "SELECT user_id, username FROM mismatch_user WHERE username = '$user_username' AND password = '$user_password'";
        $data = $dbc->query($query);

        if ($data && $data->fetchArray()) {
          // Reset the result pointer
          $data->reset();
          $row = $data->fetchArray(SQLITE3_ASSOC);
          
          // The log-in is OK so set the user ID and username session vars (and cookies), and redirect to the home page
          $_SESSION['user_id'] = $row['user_id'];
          $_SESSION['username'] = $row['username'];
          setcookie('user_id', $row['user_id'], time() + (60 * 60 * 24 * 30));    // expires in 30 days
          setcookie('username', $row['username'], time() + (60 * 60 * 24 * 30));  // expires in 30 days
          $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
          header('Location: ' . $home_url);
        }
        else {
          // The username/password are incorrect so set an error message
          $error_msg = 'Sorry, you must enter a valid username and password to log in.';
        }
      }
      else {
        // The username/password weren't entered so set an error message
        $error_msg = 'Sorry, you must enter your username and password to log in.';
      }
    }
  }

  // Insert the page header
  $page_title = 'Log In';
  require_once('header.php');

  // If the session var is empty, show any error message and the log-in form; otherwise confirm the log-in
  if (empty($_SESSION['user_id'])) {
    if (!empty($error_msg)) {
      echo '<div class="error">';
      echo '<h3>⚠️ Login Error</h3>';
      echo '<p>' . $error_msg . '</p>';
      echo '</div>';
    }
?>

  <div style="text-align: center; padding: 40px 20px; color: white; margin-bottom: 40px;">
    <h1 style="font-size: 3em; margin-bottom: 20px; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">🔑 Welcome Back</h1>
    <p style="font-size: 1.2em; opacity: 0.9;">Log in to your Mismatch account and continue your journey!</p>
  </div>

  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
      <legend>🌟 Login to Your Account</legend>
      <label for="username">👤 Username:</label>
      <input type="text" id="username" name="username" value="<?php if (!empty($user_username)) echo htmlspecialchars($user_username); ?>" required placeholder="Enter your username" />
      
      <label for="password">🔐 Password:</label>
      <input type="password" id="password" name="password" required placeholder="Enter your password" />
    </fieldset>
    <input type="submit" value="🚀 Log In" name="submit" />
  </form>

  <div style="text-align: center; margin-top: 30px;">
    <p style="color: white; margin-bottom: 15px;">Don't have an account?</p>
    <a href="signup.php" style="background: rgba(255,255,255,0.2); color: white; padding: 10px 20px; border-radius: 25px; text-decoration: none; border: 2px solid white; transition: all 0.3s ease; display: inline-block;">💕 Sign Up Now</a>
  </div>

<?php
  }
  else {
    // Confirm the successful log-in
    echo '<div class="login">';
    echo '<h3>🎉 Welcome back!</h3>';
    echo '<p>You are logged in as <strong>' . htmlspecialchars($_SESSION['username']) . '</strong>.</p>';
    echo '<p><a href="index.php" style="color: white; text-decoration: underline;">Continue to your dashboard</a></p>';
    echo '</div>';
  }
?>

<?php
  // Insert the page footer
  require_once('footer.php');
?>
