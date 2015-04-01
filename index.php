<?PHP

    session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rent-a-Student</title>
    <script src="js/script.js"></script>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <meta name="keywords" content="Rentastudent, rent a student, imd, interactive, multimedia, design, thomas, more, mechelen, app">
	<meta name="description" content="Zin om een dagje mee te volgen met een IMD-student? Boek hier je persoonlijke IMD-gids!" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
</head>
<body>
 
    <?php if ($_SESSION['FBID']): ?>
       <img src="https://graph.facebook.com/<?php echo $_SESSION['FBID']; ?>/picture">
       <h1>Hello <?php echo $_SESSION['FULLNAME']; ?></h1>
       <div><a href="logout.php">Logout</a></div>
    <?php else: ?>
        <div class="container">
            <a href="fbconfig.php">Login with Facebook</a>
        </div>
    <?php endif ?>

</body>
</html>