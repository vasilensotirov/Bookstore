<!doctype html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bookstore</title>
</head>
<body>
<?php
if (isset($msg)) {
    ?>
    <div style="text-align: center;" class="alert alert-danger" role="alert">
        <?php echo $msg ?>
    </div>
    <?php
}
?>
<form action="/Bookstore/user/login" method="post">
    <table>
        <tr>
            <td>Email</td>
            <td><input type="email" required name="email" ></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" required name="password" ></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="Login" name="login"></td>
        </tr>
        <tr>
            <td colspan="2"><a href="../view/register">Register</a></td>
        </tr>
    </table>
</form>
</body>
</html>