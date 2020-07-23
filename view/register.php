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
<form action="/Bookstore/user/register" method="post">
    <table>
        <tr>
            <td>First name</td>
            <td><input type="text" required name="firstName" ></td>
        </tr>
        <tr>
            <td>Last name</td>
            <td><input type="text" required name="lastName" ></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="email" required name="email" ></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" required name="password" ></td>
        </tr>
        <tr>
            <td>Repeat password</td>
            <td><input type="password" required name="cpassword" ></td>
        </tr>
        <tr>
            <td>Choose a role</td>
            <td>
                <select id="role" name="role">
                    <option value="1">Admin</option>
                    <option value="0">User</option></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="Register" name="register"></td>
        </tr>
        <tr>
            <td colspan="2">Already have an account? <a href="../view/login">Log In</a></td>
        </tr>
    </table>
</form>
</body>
</html>