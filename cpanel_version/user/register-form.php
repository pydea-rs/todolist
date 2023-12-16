<?php require_once __DIR__ . "/../config.php"; ?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <link rel="stylesheet" type="text/css" href="../css/users.css">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Todos</title>
</head>

<body>
    <?php
        // log out first
        unset($_SESSION[USER_ID]);
        unset($_SESSION[USER_NAME]);
    ?>
    <form action="/user/register.php" method="post">
        <div class="user-card">
            <h1>Registration Form:</h1>
            <br >
            <?php
                if(isset($_SESSION['response'])){
                    echo $_SESSION['response'];
                    unset($_SESSION['response']);
                }
            ?>
            <br >
            <input placeholder="Username" name="username" class="user-inputs" id="txtUsername" type="text" required="required" />
            <br > <br >
            <input placeholder="Password" name="password" class="user-inputs" id="txtPassword" type="password" required="required" />
            <br > <br >
            Already have an account? <a href="/login">Login</a>
            <br > <br >
            <button type="submit" class="submit-button" name="register_attempt" id="btnRegister">Register</button>
        </div>
    </form>
</body>
</html>
