<?php
  // Insert the page header
  $page_title = 'Sign Up';
  require_once('header.php');

  require_once('appvars.php');
  require_once('connectvars.php');

  // Connect to the database
  $dbc = new SQLite3(DB_PATH);

  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $username = SQLite3::escapeString(trim($_POST['username']));
    $password1 = SQLite3::escapeString(trim($_POST['password1']));
    $password2 = SQLite3::escapeString(trim($_POST['password2']));

    if (!empty($username) && !empty($password1) && !empty($password2) && ($password1 == $password2)) {
      // Make sure someone isn't already registered using this username
      $query = "SELECT * FROM mismatch_user WHERE username = '$username'";
      $data = $dbc->query($query);
      if (!$data->fetchArray()) {
        // The username is unique, so insert the data into the database
        $query = "INSERT INTO mismatch_user (username, password, join_date) VALUES ('$username', '$password1', datetime('now'))";
        $result = $dbc->exec($query);
        
        if ($result !== false) {
          // Confirm success with the user
          echo '<p>Your new account has been successfully created. You\'re now ready to <a href="login.php">log in</a>.</p>';
          $dbc->close();
          exit();
        } else {
          // Database insertion failed
          echo '<p class="error">Error creating account: ' . $dbc->lastErrorMsg() . '</p>';
        }
      }
      else {
        // An account already exists for this username, so display an error message
        echo '<p class="error">An account already exists for this username. Please use a different address.</p>';
        $username = "";
      }
    }
    else {
      echo '<p class="error">You must enter all of the sign-up data, including the desired password twice.</p>';
    }
  }

  $dbc->close();
?>

  <p>Please enter your username and desired password to sign up to Mismatch.</p>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
      <legend>Registration Info</legend>
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" value="<?php if (!empty($username)) echo $username; ?>" required /><br />
      <label for="password1">Password:</label>
      <input type="password" id="password1" name="password1" required /><br />
      <label for="password2">Password (retype):</label>
      <input type="password" id="password2" name="password2" required /><br />
    </fieldset>
    <input type="submit" value="Sign Up" name="submit" />
  </form>

<?php
  // Insert the page footer
  require_once('footer.php');
?>
