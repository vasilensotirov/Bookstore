<?php
if(isset($_SESSION['logged_user']['id']) && isset($_SESSION['logged_user']['role'])){
    $user_id = $_SESSION['logged_user']['id'];
    $role = $_SESSION['logged_user']['role'];
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Document</title>
</head>
<body>
<header>
    <?php
    if ($role == 1) {
        ?>
        <a href="../view/create">
            <button class="headerButtons">Create a book</button>
        </a>
        <?php
    }
    ?>
    <?php
    if (isset($user_id) && !empty($user_id)){
        ?>
        <a href="/Bookstore/view/editProfile"><button class="headerButtons">Edit profile</button></a>
        <a href="/Bookstore/user/logout"><button class="headerButtons">Logout</button></a>
        <?php
    }
    ?>
</header>
</body>
</html>