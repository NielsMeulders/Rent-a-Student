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
        <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <meta name="keywords" content="Rentastudent, rent a student, imd, interactive, multimedia, design, thomas, more, mechelen, app">
    <meta name="description" content="Zin om een dagje mee te volgen met een IMD-student? Boek hier je persoonlijke IMD-gids!" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
</head>
<body>

    <?php if (isset($_SESSION['FBID'])): ?>
        <?php echo $_SESSION['EMAIL']; ?>
    <div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 no-padding">
            <div id="topbar"></div>
            <div class="jumbotron register" id="jumbologin"><h1>Registreer via Facebook</h1></div> <!--end jumbotron-->
            <form id="loginform" action="" method="post">
                 <div class="form-group">
                    <img src="https://graph.facebook.com/<?php echo $_SESSION['FBID']; ?>/picture" alt="Pic"/>
                </div>
                <div class="form-group">
                    <label for="name">Naam</label>
                    <input type="text" class="form-control" name="name" id="name" <?php echo " value='". $_SESSION['FULLNAME']."'"; ?>/>
                </div>
                <div class="form-group">
                    <label for="email" >Email</label>
                    <input type="email" class="form-control" name="email" id="email"/>
                </div>
                


                <button id="post_btn" class="btn btn-default">Registreer!</button>
                <div><a href="logout.php">Logout</a></div>
            </form>
        </div><!--end column-->
    </div><!--end row-->

    <div class="row" >        
    <div class="col-xs-12" id="relatedlinks">
        <ul>
           <li><a href="http://www.thecreativitygym.be/"><img src="img/gym_logo.png" alt="Creativity Gym logo"></a></li>
           <li><a id="weareimd" href="http://www.weareimd.be/"><img src="img/weareimd_logo.svg" alt="We Are IMD logo"></a></li>
           <li><a id="thomasmore" href="http://www.thomasmore.be/interactive-multimedia-design-imd"><img src="img/thomasmore_logo.png" alt="Thomas More logo"></a></li>
        </ul>
    </div><!--end relatedlinks-->
    </div><!--end row-->
    <?php else: ?>
        <div class="container">
            <a href="fbconfig.php" id="loginwithfb">Login with Facebook</a>
    </div>
    <?php endif ?>

    <?PHP
    /*while($row = $all_users->fetch(PDO::FETCH_ASSOC)) {

    echo $row['name'];

    }*/
    ?>
    <footer class="footer">&copy Thomas More</footer>
    </div><!--end container-->
</body>
</html>