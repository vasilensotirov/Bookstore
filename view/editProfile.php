<?php
if (!isset($_SESSION["logged_user"])){
    header("Location:/Bookstore/view/login");
}
$user = $_SESSION['logged_user'];
require_once "header.php";
?>
<form action="/Bookstore/user/edit" method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <td><label for="first_name"><b>First name:</b></label></td>
            <td><input type="text" id="first_name" name="first_name" value="<?= $user['first_name'] ?>" required></td>
        </tr>
        <tr>
            <td><label for="last_name"><b>Last name:</b></label></td>
            <td><input type="text" id="last_name" name="last_name" value="<?= $user['last_name'] ?>" required></td>
        </tr>
        <tr>
            <td><label for="email"><b>Email:</b></label></td>
            <td><input type="email" id="email" name="email" value="<?= $user['email'] ?>" required></td>
        </tr>

        <tr>
            <td><label for="password"><b>Current password:</b></label></td>
            <td><input type="password" id="password" name="password" required></td>
        </tr>
        <tr>
            <td><label for="new_password"><b>New password:</b></label></td>
            <td><input type="password" id="new_password" name="new_password"></td>
        </tr>
        <tr>
            <td><label for="cpassword"><b>Confirm password:</b></label></td>
            <td><input type="password" id="cpassword" name="cpassword"></td>
        </tr>
        <tr>
            <td>Choose a role</td>
            <td>
                <select id="role" name="role">
                    <option value="1">Admin</option>
                    <option value="0">User</option></td>
        </tr>
        <tr>
            <td><input type="submit" name="edit" value="Edit"></td>
        </tr>
    </table>
</form>