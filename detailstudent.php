<?PHP

include_once("classes/imd_student.class.php");
session_start();

if (!empty($_GET))
{
    $a = new Imd_student();
    $current_student = $a->getOne($_GET['id']);
}

try
{
    if (!empty($_POST))
    {
        if (!empty($_POST['message']))
        {
            $name = $current_student['name'];
            $adr = $current_student['email'];
            $msg = $_POST['message'];
            $headers = 'From: ' . $current_student['email'] . "\r\n" .
                'Reply-To: ' . $current_student['email'] . "\r\n";
            mail($adr, "Bericht van " . $name, $msg, $headers);
        }
        else
        {
            throw new Exception("Een bericht ingeven is verplicht!");
        }

    }
}
catch (Exception $e)
{
    $error = $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home | Bezoeker</title>
    <script src="js/script.js"></script>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body>

<?PHP if (!empty($_SESSION['loggedIn']) && $_SESSION['type']=='bezoeker'): ?>
<div class="container-fluid" >

    <!--nav-->
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
                <ul class="nav navbar-nav">
                    <li ><a href="bezoeker_home.php">Browse</a></li>
                    <li><a href="#">Instellingen</a></li>

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="btn" id="btnlogout" href="logout.php">Logout</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav><!--end nav-->

    <div class="col-md-12" id="bezhometitle">
        <h1><?PHP echo $current_student['name']; ?></h1>
    </div>


    <div class="row rowhomepage">
        <div id="welcomewrap">
            <div id="collinks"class="col-sm-6 text-left" >
                <div class="jumbotron">
                    <?PHP $style = "background-image:url(".$current_student['picture'].");" ?>
                    <div class="profile_pic_full" style=<?PHP echo $style?>;></div>
                </div>
            </div><!--end collinks-->
            <div id="colrechts"class="col-sm-6 text-left">
                <div class="jumbotron">
                    <p>Email: <?PHP echo $current_student['email']; ?></p>
                    <p>Jaar: <?PHP echo $current_student['year']; ?></p>
                    <?PHP

                    switch($current_student['branch'])
                    {
                        case '1':
                            $branch = "Design";
                            break;

                        case '2':
                            $branch = "Development";
                            break;
                    }

                    ?>
                    <p>Opleiding: <?PHP echo $branch ?></p>
                </div>
            </div><!--end colrechts-->
        </div><!--end welcomewrap-->
        <div id="collinks"class="col-sm-12 text-left" >
            <div class="jumbotron">
                <h3>Meer over mij:</h3>
                <p><?PHP echo nl2br($current_student['description']); ?></p>
            </div>
        </div><!--end collinks-->
        <div id="collinks"class="col-sm-12 text-left" >
            <div class="jumbotron">
                <h3>Contacteer mij:</h3>
                <form id="contactform" class="text-left" action="" method="post">
                    <div class="form-group">
                        <textarea class="studarea form-control" placeholder="Hoe kan ik je helpen?" name="message" class="form-control" id="message" cols="30" rows="10"></textarea>
                    </div>
                    </br>
                    <button type="submit" class="btn btn-default">Verzend!</button>
                </form>
            </div>
        </div><!--end collinks-->
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