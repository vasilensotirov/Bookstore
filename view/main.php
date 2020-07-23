<?php
if (isset($_SESSION["logged_user"]['id']) && isset($_SESSION['logged_user']['role'])){
    $user_id = $_SESSION["logged_user"]["id"];
    $role = $_SESSION['logged_user']['role'];
}
require_once "header.php";
?>
<main>
<table>
<?php
if (isset($books)) {
    if ($books) {
        foreach ($books as $book) {
            var_dump($book['image']);
            echo "<tr><td colspan='2'><a href=/Bookstore/book/" . $book["id"] . "><img height='200px' width='100px' src='";
            echo $book["image"];
            echo "'></a></td><td><a href=/Bookstore/book/add/" . $book["id"] . ">Add to favourites</a></td></tr>";
            echo "<tr><td><b>";
            echo $book["name"];
            echo "</b></td></tr>";

            if ($role == 1) {
                echo "<tr><td><a href=/Bookstore/book/edit/" . $book["id"] . ">Edit</a></td></tr>";
                echo "<tr><td><a href=/Bookstore/book/delete/" . $book["id"] . ">Delete</a></td></tr>";
            }

        }
    }
}
?>
</table>
</main>
