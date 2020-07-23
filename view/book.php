<?php
if (isset($_SESSION["logged_user"])){
    $user_id = $_SESSION["logged_user"]["id"];
}
require_once "header.php";
echo "<hr>";
if (isset($book)) {
    foreach ($book as $key => $value)
    $bookId = $value['id'];
    echo "<tr><td><img height='400px' width='200px' src='";
    echo $value['image'];
    echo "'></a></td><td><br>";
    echo "<b>Name:</b>";
    echo $value["name"] . "<br>";
    echo "<b>ISBN:</b>";
    echo $value["isbn"] . "<br>";
    echo "<b>Description: </b>";
    echo $value["description"];
    echo "<hr>";
}