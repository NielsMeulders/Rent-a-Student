<?PHP

    include_once("classes/User.class.php");
    include_once("classes/Bezoeker.class.php");

    session_start();
    $b = new Bezoeker();

    if (!empty($_POST))
    {
        try
        {
            $b->Name = $_POST['name'];
            $b->Email = $_POST['email'];
            $b->Picture = "https://graph.facebook.com/".  $_SESSION['FBID']. "/picture";
            $b->save();

            //header("Location: index.php");
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }

    $all_users = $b->getAll();

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

    <?php if (isset($_SESSION['FBID'])): ?>
        <?php echo $_SESSION['EMAIL']; ?>

        <form action="" method="post">
            <label for="name">Naam</label>
            <input type="text" name="name" id="name" <?php echo " value='". $_SESSION['FULLNAME']."'"; ?>/>

            <label for="email">Email</label>
            <input type="email" name="email" id="email"/>

            <label for="pic">Profielfoto</label>
            <img src="https://graph.facebook.com/<?php echo $_SESSION['FBID']; ?>/picture" alt="Pic"/>

            <button id="post_btn">Registreer!</button>
            <div><a href="logout.php">Logout</a></div>
        </form>

    <?php else: ?>
        <div class="container">
            <a href="fbconfig.php">Login with Facebook</a>
        </div>
    <?php endif ?>

    <?PHP
    /*while($row = $all_users->fetch(PDO::FETCH_ASSOC)) {

    echo $row['name'];

    }*/
    ?>

</body>
</html>