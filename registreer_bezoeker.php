<?PHP

    include_once("classes/User.class.php");
    include_once("classes/Bezoeker.class.php");

    session_start();
    $b = new Bezoeker();

    if (!empty($_POST))
    {
        try
        {
            $b->checkPass($_POST['pass'],$_POST['pass_rep']);

            $b->Name = $_POST['name'];
            $b->Email = $_POST['email'];
            $b->Password = $_POST['pass'];
            $b->Picture = "https://graph.facebook.com/".  $_SESSION['FBID']. "/picture";
            $b->save();

            header("Location: login_page.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no;">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/logo_badge.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="img/logo_badge.png" type="image/x-icon"/>
    <meta name="keywords" content="Rentastudent, rent a student, imd, interactive, multimedia, design, thomas, more, mechelen, app">
    <meta name="description" content="Zin om een dagje mee te volgen met een IMD-student? Boek hier je persoonlijke IMD-gids!" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
</head>
<body>

    <div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 no-padding">
            <div id="topbar"></div>
            <div class="jumbotron register" id="jumbologin"><h1>Registreer via Facebook</h1></div> <!--end jumbotron-->


                <?PHP if(isset($error)): ?>

                    <div class="alert alert-danger" role="alert" ><?PHP echo $error;?></div>

                <?PHP endif; ?>

            <?php if (isset($_SESSION['FBID'])): ?>
            <form id="loginform" action="" method="post">
                 <div class="form-group">
                    <img src="https://graph.facebook.com/<?php echo $_SESSION['FBID']; ?>/picture" alt="Pic"/>
                </div>
                <div class="form-group">
                    <label for="name">Naam</label>
                    <input type="text" class="form-control" name="name" id="name" <?php echo " value='". $_SESSION['FULLNAME']."'"; echo 'readonly' ?>/>
                </div>
                <div class="form-group">
                    <label for="email" >Email</label>
                    <input type="email" class="form-control" name="email" id="email" <?php echo " value='". $_SESSION['EMAIL']."'"; echo 'readonly' ?>/>
                </div>
                <div class="form-group">
                    <label for="pass">Wachtwoord</label>
                    <input type="password" class="form-control" id="pass" name="pass">
                </div>
                <div class="form-group">
                    <label for="pass_rep">Wachtwoord herhalen</label>
                    <input type="password" class="form-control" id="pass_rep" name="pass_rep">
                </div>
                


                <button id="post_btn" class="btn btn-default">Registreer!</button>
                <div><a href="logout.php">Logout</a></div>
            </form>
            <?php else: ?>

            <div class="col-xs-12 no-padding regfb">
                <a href="fbconfig.php" id="loginwithfb">Login with Facebook</a>

    </div>
    <?php endif ?>
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
    

    <?PHP
    /*while($row = $all_users->fetch(PDO::FETCH_ASSOC)) {

    echo $row['name'];

    }*/
    ?>
    <footer class="footer">&copy Thomas More</footer>
    </div><!--end container-->
</body>
</html>