<?PHP
include_once('classes/Imd_student.class.php');
   session_start();
$a = new Imd_student();
$allstudents = $a->getAll();

$conn = Db::getInstance();

$statement = $conn->prepare('SELECT * FROM bezoeker WHERE id=:id');

$statement->bindParam(':id',$_SESSION['id']);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);

//echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home | Bezoeker</title>
    <script src="js/script.js"></script>
    <!-- Bootstrap -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no;">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
          <![endif]-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/jssocials.css" />
    <link rel="stylesheet" type="text/css" href="css/jssocials-theme-flat.css" />
    <script src="js/jssocials.min.js"></script>
</head>

<body>

<?PHP if (!empty($_SESSION['loggedIn']) && $_SESSION['type']=='bezoeker'): ?>
<div class="container-fluid" >

<!--nav-->
     <nav class="navbar navbar-default navbar-static-top">
         <?PHP if(isset($error)): ?>

             <div class="alert alert-danger" role="alert"><?PHP echo $error; ?></div>

         <?PHP endif; ?>
         <?PHP if(isset($feedback)): ?>

             <div class="alert alert-success" role="alert"><?PHP echo $feedback; ?></div>

         <?PHP endif; ?>
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Rent-a-Student</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Browse</a></li>
            <li><a href="#">Instellingen</a></li>
            
          </ul>
          <ul class="nav navbar-nav navbar-right">
              <li><a><?PHP echo $_SESSION['FULLNAME'] ?></a></li>
              <?PHP $style = "background-image:url('https://graph.facebook.com/". $_SESSION['FBID'] ."/picture');" ?>
              <li class="login_icon" style=<?PHP echo $style ?>></li>
            <li><a class="btn" id="btnlogout" href="logout.php">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav><!--end nav-->

    <div class="col-md-12" id="bezhometitle">
               <h1>Kies je gids</h1>
    </div>

   
    <div class="row rowhomepage">
    <div id="welcomewrap"><div class="jumbotron">

            <?php
        while($gebruiker = $allstudents->fetch(PDO::FETCH_ASSOC)): ?>


            <div id="collinks"class="col-sm-4">
                <?PHP $style = "background-image:url(". $gebruiker['picture'] .");" ?>
                <div class="profile_pic"  style=<?PHP echo $style?>></div>
               
                <h3><?php echo $gebruiker['name'] ?> </h3>
                <p><strong><?php
                echo $gebruiker['year'] . "de - ";
                switch ($gebruiker['branch']) {
                    case '1':
                        echo "Design";
                        break;
                    
                    case '2':
                        echo "Development";
                        break;
                }?> </strong></p>

                <p><?php echo substr($gebruiker['description'], 0, 100) ."..."?></p>

                <p><a class="btn btn-primary btn-lg" href="detailstudent.php?id=<?php echo $gebruiker['id']?>" role="button">Meer info</a></p>
       </div><!--end collinks-->

    <?php endwhile; ?>
    </div>



    </div><!--end welcomewrap-->
    </div><!-- end row -->

    <div class="row" >        
        <div class="col-md-12" id="relatedlinks">
            <ul>
                <li><a href="http://www.thecreativitygym.be/"><img src="img/gym_logo.png" alt="Creativity Gym logo"></a></li>
                <li><a id="weareimd" href="http://www.weareimd.be/"><img src="img/weareimd_logo.svg" alt="We Are IMD logo"></a></li>
                <li><a id="thomasmore" href="http://www.thomasmore.be/interactive-multimedia-design-imd"><img src="img/thomasmore_logo.png" alt="Thomas More logo"></a></li>
            </ul>
        </div><!--end relatedlinks-->
    </div><!--end row-->
    <footer class="footer"><div id="share"></div>&copy Thomas More</footer>
    <script>  $("#share").jsSocials({shares: ["twitter", "facebook", "googleplus"]});  </script>

<?PHP else: ?>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Rent-a-Student</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="btn" id="btnlogout" href="logout.php">Logout</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav><!--end nav-->

    <div class="col-md-12" id="bezhometitle">
        <h1>Oeps!</h1>
    </div>

    <div class="row rowhomepage">
        <div id="welcomewrap">
            <div id="collinks"class="col-xs-12 text-left container">
                <div class="jumbotron">
                    <h3>U heeft geen toegang tot deze pagina!</h3>
                    <p>Sorry,</p>
                    <p>om deze pagina te bekijken moet u ingelogd zijn als bezoeker.
                    Als u <a href="index.php">hier</a> klikt, zorgen wij ervoor dat u op de juist pagina terecht komt.</p>
                    <p>Bedankt.</p>
                </div>
            </div><!--end collinks-->
        </div><!--end welcomewrap-->
    </div><!-- end row -->

    <div class="row" >
        <div class="col-md-12" id="relatedlinks">
            <ul>
                <li><a href="http://www.thecreativitygym.be/"><img src="img/gym_logo.png" alt="Creativity Gym logo"></a></li>
                <li><a id="weareimd" href="http://www.weareimd.be/"><img src="img/weareimd_logo.svg" alt="We Are IMD logo"></a></li>
                <li><a id="thomasmore" href="http://www.thomasmore.be/interactive-multimedia-design-imd"><img src="img/thomasmore_logo.png" alt="Thomas More logo"></a></li>
            </ul>
        </div><!--end relatedlinks-->
    </div><!--end row-->
    <footer class="footer">&copy Thomas More</footer>
<?PHP endif; ?>

</div> <!--end container-->
</body>
</html>