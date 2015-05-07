<?PHP
include_once('classes/Imd_student.class.php');
include_once('classes/Date_available.class.php');
session_start();
$a = new Imd_student();
$allstudents = $a->getAll();

$d = new Date_available();
$allDates = $d->getAll();

$conn = Db::getInstance();

$statement = $conn->prepare('SELECT * FROM student WHERE id=:id');

$statement->bindParam(':id',$_SESSION['id']);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home | Bezoeker</title>
    <script src="js/script.js"></script>
    <!-- Bootstrap -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
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

<?PHP if (!empty($_SESSION['loggedIn']) && $_SESSION['type']=='student'): ?>
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
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="student_aanpassen.php">Account aanpassen</a></li>

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?PHP $style = "background-image:url(". $user['picture'] .");" ?>
                    <li class="login_icon" style=<?PHP echo $style ?>></li>
                    <li><a class="btn" id="btnlogout" href="logout.php">Logout</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav><!--end nav-->

    <div class="col-md-12" id="bezhometitle">
        <h1>Welkom <?PHP echo $user['name']; ?></h1>
    </div>


    <div class="row rowhomepage">
        <div id="welcomewrap">
            <div id="collinks"class="col-sm-6 text-left" >
                <div class="jumbotron">
                    <?PHP $style = "background-image:url(".$user['picture'].");" ?>
                    <div class="profile_pic_full" style=<?PHP echo $style?>;></div>
                </div>
            </div><!--end collinks-->
            <div id="colrechts"class="col-sm-6 text-left">
                <div class="jumbotron">
                    <p>Email: <?PHP echo $user['email']; ?></p>
                    <p>Jaar: <?PHP echo $user['year']; ?></p>
                    <?PHP

                        switch($user['branch'])
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

        <div class="clearfix"></div>
        <div id="collinks"class="col-sm-12 text-left" >
            <div class="jumbotron">
                <h3>Meer over mij</h3>
                <p><?PHP echo nl2br($user['description']); ?></p>
            </div>
        </div><!--end collinks-->
            <div id="collinks"class="col-sm-12 text-left" >
                <div class="jumbotron">
                    <h3>Nieuwe beschikbaarheid</h3>
                    <select>
                        <?PHP while($date = $allDates->fetch(PDO::FETCH_ASSOC)): ?>
                            <option><?PHP echo $date['date'] ?></option>
                        <?PHP endwhile; ?>
                    </select>

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