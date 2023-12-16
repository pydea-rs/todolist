<?php require_once __DIR__ . '/../config.php'; ?>

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
        if(isset($_SESSION[USER_ID]) && isset($_SESSION[USER_NAME]) && $_SESSION[USER_NAME] && $_SESSION[USER_ID])
            redirect2("/");
    ?>
    <form action="/user/login.php" method="post">
        <div class="user-card">
            <h1>Enter your credentials:</h1>
            <br >
            <?php
                if(isset($_SESSION['response'])){
                    echo $_SESSION['response'];
                    unset($_SESSION['response']);
                }
            ?>
            <br >
            <input placeholder="Username" name="username" class="user-inputs" id="txtUsername" type="text" />
            <br > <br >
            <input placeholder="Password" name="password" class="user-inputs" id="txtPassword" type="password" />
            <br > <br >
            Not registered yet?  <a href="/register">Register</a>
            <br > <br >
            <button type="submit" class="submit-button" name="login_attempt" id="btnLogin">Login</button>
        </div>
    </form>
</body>
</html>
