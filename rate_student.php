<?PHP

include_once("classes/Imd_student.class.php");
include_once("classes/Date_available.class.php");
include_once("classes/Rating.class.php");
session_start();
$conn=Db::getInstance();

$page_id = $_GET['id'];
$a = new Imd_student();
$current_student = $a->getOne($_GET['id']);

$fbid = $_SESSION['FBID'];
$statement = $conn->query("SELECT * FROM bezoeker WHERE fbid = $fbid");
$visitor = $statement->fetch(PDO::FETCH_ASSOC);

if (!empty($_POST))
{
    try
    {
        $r = new Rating();
        $r->Rating=$_POST['gidsrating'];
        $r->Comment=$_POST['gidscomment'];
        $current_user_id= $visitor['id'];
        $current_student_id= $current_student['id'];
        $r->save($current_user_id, $current_student_id);
        $feedback = "Uw feedback is verstuurd. Bedankt!";
    }
    catch(Exception $e)
    {
        $error = $e->getMessage();
    }
}


// $statement->bindParam(':id',$_SESSION['EMAIL']);
// $statement->execute();
// $user = $statement->fetch(PDO::FETCH_ASSOC);


// $dates_available = $conn->query("SELECT student_id, date_id, DATE_FORMAT(date,'%d-%c-%Y') as date FROM date_gids_available INNER JOIN date_available ON date_gids_available.date_id = date_available.id WHERE student_id = $page_id");

// $fbid = $_SESSION['FBID'];
// $statement = $conn->query("SELECT * FROM bezoeker WHERE fbid = $fbid");
// $visitor = $statement->fetch(PDO::FETCH_ASSOC);
// $visitor_id = $visitor['id'];

// if (!empty($_GET))
// {
//     $a = new Imd_student();
//     $current_student = $a->getOne($_GET['id']);
// }

// if (!empty($_GET['book_id']))
// {
//     $book = new Date_available();
//     $from = $visitor_id;
//     $to = $page_id;
//     $date = $_GET['book_id'];
//     $book->bookDate($from,$to,$date);
// }

// try
// {
//     if (!empty($_POST))
//     {
//         if (!empty($_POST['message']))
//         {
//             $name = $_SESSION['FULLNAME'];
//             $adr = $current_student['email'];
//             $msg = $_POST['message'];
//             $headers = 'From: ' . $_SESSION['EMAIL'] . "\r\n" .
//                 'Reply-To: ' . $_SESSION['EMAIL'] . "\r\n";
//             mail($adr, "Bericht van " . $name, $msg, $headers);
//         }
//         else
//         {
//             throw new Exception("Een bericht ingeven is verplicht!");
//         }

//     }
// }
// catch (Exception $e)
// {
//     $error = $e->getMessage();
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rate <?PHP if (isset($current_student['name'])): echo $current_student['name']; endif;?></title>
    <script src="js/script.js"></script>
    <!-- Bootstrap -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no;">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/star-rating.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/star-rating.min.js"></script>
    <style>.label, .glyphicon-minus-sign{display: none;} .ratediv{text-align: center;} .ratediv textarea {width: 100%;max-width: 600px;min-height: 200px;}</style>
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
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <a class="navbar-brand" id="logo" href="index.php"><img src="img/logo.svg" alt="Logo"/></a>
                <ul class="nav navbar-nav">
                    <li ><a href="bezoeker_home.php">Browse</a></li>
                    <li class="active"><a href="rate_student.php?id=<?PHP echo $_GET['id'] ?>">Beoordeel</a></li>

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
        <h1>Rate deze student</h1>
    </div>

    <div class="row rowhomepage">
        <div id="welcomewrap">
            <div id="collinks"class="col-xs-12 text-left container">
                <div class="jumbotron ratediv">
                    <div class="rate_image" style='background-image: url("<?PHP echo $current_student['picture'] ?>");'></div>
                    <h3>Rate jouw gids</h3>
                    <form action="" method="post">
                        <input name="gidsrating" id="input-id" type="number" step="any" class="rating" data-size="sm" data-rtl="false" hoverEnabled="false">
                        <label for="gidscomment"><h3>Wat vond je van de tour?</h3></label>
                        </br>
                        <textarea name="gidscomment" id="gidscomment" type="textarea" placeholder="Laat even kort weten wat je ervan vond."></textarea>
                        </br>
                        <button type="submit" class="btn">Verstuur</button>
                    </form>
                </div>
            </div><!--end collinks-->
        </div><!--end welcomewrap-->
    </div><!-- end row -->

    <!-- TWIXFIX EINDE -->


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
        <?PHP include_once('404.php') ?>
    <?PHP endif; ?>

</div> <!--end container-->
</body>
</html>