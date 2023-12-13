<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <title>Sign In</title>
    </head>
    
    <body>
        <?php require_once("inc/header.php"); ?>
        <div align='center'>
            <span>
                <p style="font-size: 25px;"><b>Account Info</b></p>
            </span>
            <form method='post' action='login.post.php'>
                <p><b>ID &nbsp;</b><input name="login_id" type="text"></p>
                <p><b>PW &nbsp;</b><input name="login_pw" type="password"></p>
                <br/>&nbsp;
                <input type="submit" value="Sign In">&nbsp;&nbsp;
            </form>
            <br/>
            <button id="register" onclick="location.href='register.php'">Sign Up</button>
        </div>
    </body>
</html>
