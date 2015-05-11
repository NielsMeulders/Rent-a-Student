<?PHP

include_once("classes/Imd_student.class.php");
include_once("classes/Date_available.class.php");
session_start();

$conn = Db::getInstance();

$statement = $conn->prepare('SELECT * FROM bezoeker WHERE id=:id');

$statement->bindParam(':id',$_SESSION['id']);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);

$page_id = $_GET['id'];
$dates_available = $conn->query("SELECT student_id, date_id, DATE_FORMAT(date,'%d-%c-%Y') as date FROM date_gids_available INNER JOIN date_available ON date_gids_available.date_id = date_available.id WHERE student_id = $page_id");

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
            $name = $_SESSION['FULLNAME'];
            $adr = $current_student['email'];
            $msg = $_POST['message'];
            $headers = 'From: ' . $_SESSION['EMAIL'] . "\r\n" .
                'Reply-To: ' . $_SESSION['EMAIL'] . "\r\n";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no;">
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

                    <h3>Meer over mij</h3>
                    <p><?PHP echo nl2br($current_student['description']); ?></p>

                    <p><?PHP echo $current_student['name']; ?> zit momenteel in het <?PHP echo $current_student['year']; ?>e jaar
                        <?PHP if (isset($current_student['branch'])): ?>
                        en volgt het keuzetraject
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
                    <?PHP echo $branch ?></p>
                    <?PHP endif; ?>
                </div>
            </div><!--end colrechts-->

        <div id="collinks"class="col-sm-6 text-left" >
            <div class="jumbotron">
                <h3>Contacteer mij</h3>
                <form id="contactform" class="text-left" action="" method="post">
                    <div class="form-group">
                        <textarea class="studarea form-control" placeholder="Hoe kan ik je helpen?" name="message" class="form-control" id="message" cols="30" rows="10"></textarea>
                    </div>
                    </br>
                    <button type="submit" class="btn btn-default">Verzend</button>
                </form>
            </div>
        </div><!--end collinks-->
        <div id="colrechts"class="col-sm-6 text-left" >
            <div class="jumbotron">
                <h3>Mijn beschikbare dagen</h3>
                <ul class="list-group" id="list-available-dates">
                    <?PHP while($date = $dates_available->fetch(PDO::FETCH_ASSOC)): ?>
                        <li class="list-group-item"><?PHP echo $date['date'] ?></li>
                    <?PHP endwhile; ?>
                </ul>
            </div>
        </div><!--end collinks-->
    </div><!-- end row -->
    </div><!--end welcomewrap-->

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