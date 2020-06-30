<?php
if($_COOKIE['idUser']!=""){
    header("Location:/mainPage.php",true,307);
}
?>
<html>
<head>
    <title>Auth page</title>
    <link rel="stylesheet" href="style.css">
</head>
    <body>
        <div class="box">
            <div class="button-box">
                <div id="btn"></div>
                <button class="toogle-btn" onclick="login()">Log in</button>
                <button class="toogle-btn" onclick="register()">Register</button>
            </div>
            <form id="loginForm" action="Engine.php" method="post" class="input-group">
                <input name="login" type="text" class="input-field" placeholder="UserId" required>
                <input name="password" type="password" class="input-field" placeholder="Password" required>
                <button type="submit" name="btnLogin" class="submit-btn">Log in</button>
                <label class="Error"><?=$_COOKIE['Errors']?></label>
            </form>
            <form id="registerForm" action="Engine.php" method="post" class="input-group">
                <input name="login" type="text" class="input-field" placeholder="User Id" required>
                <input name="password" type="password" class="input-field" placeholder="Password" required>
                <input name="submitPassword" type="password" class="input-field" placeholder="Repeat Password" required>
                <button type="submit" name="btnRegister" class="submit-btn">Register</button>
            </form>
        </div>
    </body>
    <script>
        var log = document.getElementById("loginForm");
        var reg = document.getElementById("registerForm");
        var buttons = document.getElementById("btn");

        function register() {
            log.style.left = "-400px";
            reg.style.left = "50px";
            buttons.style.left = "110px";
        }

        function login() {
            log.style.left="50px";
            reg.style.left="450px";
            buttons.style.left="0px";
        }
    </script>
</html>
