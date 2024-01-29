<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>login page</title>
    <link rel="stylesheet" href="css/loginstyle.css">

    <?php require_once "config/styleLoad.php" ?>

</head>
<body>

<div class="login-container">
    <form class="login-form" method="post" action="action/sign-in.php">
        <h1>Welcome Back</h1>
        <p>Please login to your account</p>
        <div class="input-group">
            <input type="text" id="username" name="key" placeholder="Username or Mobile or Email" required>
        </div>
        <div class="input-group">
            <input type="password" id="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit" name="signin">Login</button>
        <div class="bottom-text">
            <p>Don't have an account? <a href="#">Sign Up</a></p>
            <p><a href="#">Forgot password?</a></p>
        </div>
    </form>
</div>

<?php require_once "config/errorLoaded.php"; ?>

</body>
</html>