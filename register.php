<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <title>Sign Up</title>
    </head>

    <body>
        <?php require_once("inc/header.php") ?>
        <div align="center">
            <span>
                <p style="font-size: 25px;"><b>Sign Up</b></p>
            </span>
            <form method='post' action='register.post.php'>
                <p><b>ID &nbsp;&nbsp;</b><input name="signin_id" type="text"></p>
                <p><b>PW &nbsp;&nbsp;</b><input name="signin_pw" type="password"></p>
                <p><b>Name &nbsp;</b><input name="signin_name" type="text"></p>
                <br/>
                <input type="submit" value="Create Account">
            </form>
        </div>
    </body>
</html>
