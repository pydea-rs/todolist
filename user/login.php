<?php
    session_start();
    require_once '../common/config.php';

    $response = '';
    $logged_in = false;
    if(isset($_POST['login_attempt'])){
        if($connection) {
            if (isset($_POST['username']) && isset($_POST['password']) && $_POST['username'] && $_POST['password']) {
                $username = $_POST['username'];
                $password = $_POST['password'];

                $query = "SELECT " . USER_ID . ", " . USER_NAME . " FROM  `" . TABLE_USERS . "` WHERE username='$username' AND password='$password'";

                $result = $connection->query($query);
                if (!$result)
                    $response = '<p class="error">Something went wrong while obtaining data from database!</p>';
                else if ($result->num_rows > 0) {
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    $_SESSION[USER_ID] = $row[USER_ID];
                    $_SESSION[USER_NAME] = $row[USER_NAME];
                    $logged_in = true;
                }
                else {
                    $response = '<p class="error">Incorrect username or password!</p>';
                }

            } else
                $response = '<p class="error">Username and password fields are not allowed to be empty!</p>';

        }
        else {
            $response = '<p class="error">Cannot connect to the database!</p>';
        }
    }

    $_SESSION['response'] = $response;
    if(!$logged_in)
        header("Location: /login");
    else
        header("Location: /");