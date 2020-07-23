<?php
if (!isset($_SESSION["logged_user"])) {
    header("Location:/Bookstore/view/login.php");
}
$user_id = $_SESSION['logged_user']['id'];
$role = $_SESSION['logged_user']['role'];

require_once "header.php";
?>
<form action="/Bookstore/book/create" method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <td><label for="title"><b>Name:</b></label></td>
            <td><input type="text" id="name" name="name" required></td>
        </tr>
        <tr>
            <td><label for="isbn"><b>ISBN:</b></label></td>
            <td><input type="text" id="isbn" name="isbn" required></td>
        </tr>
        <tr>
            <td><label for="description"><b>Description:</b></label></td>
            <td><textarea id="description" name="description" required></textarea></td>
        </tr>
        <tr>
            <td><label for="image"><b>Image:</b></label></td>
            <td><input type="file" id="image" name="image"</td>
        </tr>
        <tr>
            <td><input type="submit" name="create" value="Create"></td>
        </tr>
    </table>
</form>
