<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=1440, maximum-scale=1.0" />
    <meta name="twitter:card" content="photo" />

    <link rel="stylesheet" href="global.css" />
    
  </head>
  <body style="margin: 0; background: #00274c">
    <input type="hidden" id="anPageName" name="page" value="login-page" />
    
    <div class="container-center-horizontal">
      <!-- Login Form -->
      <form class="login-page screen" name="loginform" action="loginform" method="post">
        
        <div class="overlap-group overlap">
          <div class="overlap-group1 overlap">
            <!-- White Box Section-->
            <div class="login-form"></div>
            <!--Yellow Box Section-->
            <img class="logo_-section" src="img/logo-section.svg" alt="Logo_Section" />
            
            <h1 class="welcome-back_-text valign-text-middle">Welcome Back!</h1>
            <div class="login_-text valign-text-middle">Login</div>

            <!--Remember Me Section-->
            <!--Might remove later-->
            <div class="remember-me valign-text-middle">
              <label>
                <!--<img class="remember-me-box" src="img/remembermebox.svg" alt="RememberMeBox" /> -->
                <input type="checkbox" checked="checked" name="remember"> Remember Me?
              </label>
             </div>

            <!--Forgot Password Section-->
            <!--Might remove later-->
            <div class="forgot-password valign-text-middle">Forgot Password?</div>

            <!--Switch to Register Page-->
            <p class="dont-have-an-account-sign-up-today valign-text-middle">Don't Have an Account? Sign Up Today!</p>
            
            <!--Logo-->
            <img class="place-holder-logo" src="img/placeholderlogo.png" alt="PlaceHolderLogo" />
            
            <!--Login Section-->
            <div class="login-form-1">
              <!--Username Input-->
              <div class="username">
                <div class="username-1">
                  <input
                    class="username-2 nunitosans-normal-pale-sky-14px"
                    name="username"
                    placeholder="Username"
                    type="text"
                    required
                  />
                </div>
              </div>

               <!--Password Input-->
              <div class="password">
                <div class="password-1">
                  <input
                    class="password-2 nunitosans-normal-pale-sky-14px"
                    name="password"
                    placeholder="Password"
                    type="password"
                    required
                  />
                </div>
              </div>

            </div>

            <a href="javascript:SubmitForm('loginform')">
              <div class="login_submit"><div class="log-in valign-text-middle">Log In</div></div></a
            >
          </div>

          <!--Username/Password icons-->
          <img class="user-icon" src="img/username-icon.png" alt="User-icon" />
          <img class="password-icon" src="img/password-icon@2x.png" alt="password-icon" />
        
        </div>
      </form>
    </div>

    <?php
        session_start();
        // Change this to your connection info.
        $DATABASE_HOST = 'localhost';
        $DATABASE_USER = 'root';
        $DATABASE_PASS = '';

        //change to Wolverine work database!!!!
        $DATABASE_NAME = '';

        // Try and connect using the info above.
        $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
        if ( mysqli_connect_errno() ) {
        // If there is an error with the connection, stop the script and display the error.
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
        }
        // Now we check if the data from the login form was submitted, isset() will check if the data exists.
        if ( !isset($_POST['username'], $_POST['password']) ) {
        // Could not get the data that should have been sent.
        exit('Please fill both the username and password fields!');
        }

        // Prepare our SQL, preparing the SQL statement will prevent SQL injection.

        //REPLACE "accounts" WITH TABLE NAME FROM WOLVERINE WORK DATABASE!!!!!!!!!
        if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
        // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        // Store the result so we can check if the account exists in the database.
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            /*put on register page
            $stmt->bind_result($id, $email);
            $stmt->fetch();
            
            $tld = substr($email, strlen($email)-2, 9);    // three last chars of the string
            if ($tld = "umich.edu") {
                // do stuff
            }
            */

            $stmt->bind_result($id, $password);
            $stmt->fetch();
            echo '$password';
            // Account exists, now we verify the password.
            // Note: remember to use password_hash in your registration file to store the hashed passwords. (done)
            if (password_verify($_POST['password'], $password)) {
                // Verification success! User has logged-in!
                // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
                
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $_POST['username'];
                $_SESSION['id'] = $id;

                //CHANGE NAME TO THAT OF THE HOMEPAGE IF DIFFERENT!!!!!!!!!!
                header('Location: ../home/home-page.html');
                exit;
            } else {
                // Incorrect password
                echo 'Incorrect password!';
            }
        } else {
            // Incorrect username
            echo 'Incorrect username!';
        }
        $stmt->close();
        }
    ?>

    
    </script>
  </body>
</html>
