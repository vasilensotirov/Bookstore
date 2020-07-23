<?php
if (!isset($_SESSION["logged_user"])){
    header("Location:/Bookstore/view/login");
}
$user_id = $_SESSION["logged_user"]["id"];
if (!isset($book)){
    header("Location:/Bookstore/view/main");
}

require_once "header.php";
?>
<form action="/Bookstore/book/edit" method="post" enctype="multipart/form-data">
    <table>
        <input type="hidden" name="id" value="<?= $book["id"]; ?>"
        <tr>
            <td><label for="name"><b>Name:</b></label></td>
            <td><input type="text" id="name" name="name"></td>
        </tr>
        <tr>
            <td><label for="isbn"><b>ISBN:</b></label></td>
            <td><input type="text" id="isbn" name="isbn" required></td>
        </tr>
        <tr>
            <td><label for="description"><b>Description</b></label></td>
            <td><input type="text" id="description" name="description"></td>
        </tr>
        <tr>
            <td><label for="image"><b>Image</b></label></td>
            <td><input type="file" id="image" name="image"></td>
        </tr>
        <tr>
            <td><input type="submit" name="edit" value="Edit"></td>
        </tr>
    </table>
</form>