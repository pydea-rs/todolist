<?php
    session_start();
    require_once '../common/config.php';

    $response = '';
    if(isset($_POST['register_attempt'])){
        if($connection) {
            if (isset($_POST['username']) && isset($_POST['password']) && $_POST['username'] && $_POST['password']) {
                $username = $_POST['username'];
                $password = $_POST['password'];

                if(is_numeric(($username)))
                    $response = '<p class="error">Username can not be a number!</p>';
                else if(strlen($username) < 3)
                    $response = '<p class="error">This username is too short!</p>';
                else if(strlen($password) < 4)
                    $response = '<p class="error">Your password is too short!</p>';
                else {
                    $query = "SELECT * FROM  `" . TABLE_USERS . "` WHERE username='$username' ";
                    $result = $connection->query($query);
                    if (!$result)
                        $response = '<p class="error">Something went wrong while obtaining result from database!</p>';
                    else if ($result->num_rows > 0)
                        $response = '<p class="error">This username is already taken!</p>';
                    else {
                        $query = "INSERT INTO `" . TABLE_USERS . "` (" . USER_NAME . ", " . USER_PASSWORD . ") values ('$username', '$password')";
                        $result = $connection->query($query);
                        if ($result)
                            $response = '<p class="success">Registration completed.</p>';
                        else
                            $response = '<p class="error">Unknown error happened!</p>';
                    }
                }
            } else
                $response = '<p class="error">Username and password fields are not allowed to be empty!</p>';

        }
        else {
            $response = '<p class="error">Cannot connect to the database!</p>';
        }
    }

    $_SESSION['response'] = $response;
    header("Location: /register");