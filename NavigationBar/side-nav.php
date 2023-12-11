<!-- version of the sidebar for when a user is logged in, includes logout button-->
<div id="mySidebar" class="sidebar">
<a class="x" href="javascript:void(0)" class="closebtn" onclick="closeFilter();">&times;</a>
    <div class="side-bar"> 
        <!--  Logo as a link to the home page -->
        <a href='../homepage/homepage.php'>
            <img src='../img/placeholderlogo.png' alt='Wolverine Work Logo' style='width: 250px; height: 250px; margin-left: 22px;'>
        </a>
        <br><br><br>
        <div class="side-bar-buttons">
            <a class="nav" href='../Search/search.php'>Search</a>
            <?php
                // Check if the user logged in
                if (isset($_SESSION['loggedin'])) {
                    echo "<a class='nav' href='../CreateAPost/CreateaPost.php'>Create a Post</a>";
                    echo "<a class='nav' href='../Profile/Profile.php?username=" . $_SESSION['name'] . "'>View Profile</a>";
                    echo '<a class="nav" onclick="return confirm(\'Are you sure you want to log out?\')" href="../Login/logout.php">Log out</a>';

                }
                else {
                    echo "<a class='nav' href='../Login/login-page.html'>Log In</a>";
                    echo "<a class='nav' href='../Register/register-page.html'>Register</a>";
                }
            ?>
        </div>
    </div>
</div>