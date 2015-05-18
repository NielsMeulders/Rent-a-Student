<?PHP
include_once('classes/Admin.class.php');
include_once('classes/Date_available.class.php');

session_start();
$u = new Admin();
$d = new Date_available();
$allDates = $d->getAll();

$conn = Db::getInstance();

$statement = $conn->prepare('SELECT * FROM admin WHERE id=:id');

$statement->bindParam(':id',$_SESSION['id']);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);

$get_count = $conn->query('SELECT count(*) as email FROM email');
$count_email = $get_count->fetch();

$get_count = $conn->query('SELECT count(*) as aantal FROM student');
$count_students = $get_count->fetch();

$get_count = $conn->query('SELECT count(*) as aantal FROM bezoeker');
$count_visitors = $get_count->fetch();

$get_count = $conn->query('SELECT count(*) as aantal FROM boeking');
$count_booking = $get_count->fetch();

$allBookings = $d->getBookingForAdmin();

if (isset($_REQUEST['download_newsletter']))
{
    $u->download_newsletter();
    $ready_newsletter = true;
}

if (isset($_REQUEST['download_students']))
{
    $u->download_students();
    $ready_students = true;
}


if(!empty($_POST['date_submit']))
{
    try
    {
    $d->Date = $_POST['date_input'];
    $d->save();
    $feedback = "Nieuwe datum is toegevoegd";
}
catch (Exception $e)
{
    $error = $e->getMessage();
}
}

if(!empty($_GET['id']))
{
    $d->remove($_GET['id']);
    header('location: admin_home.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home | Admin</title>
    <script src="js/script.js"></script>
    <!-- Bootstrap -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no;">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" href="img/logo_badge.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="img/logo_badge.png" type="image/x-icon"/>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>


    <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
    <link rel="stylesheet" href="css/bootstrap-datepicker.min.css"/>
    <link rel="stylesheet" href="css/bootstrap-datepicker.css"/>



</head>

<body>

<?PHP if (!empty($_SESSION['loggedIn']) && $_SESSION['type']=='admin'): ?>
<div class="container-fluid" >


    <!--nav-->
    <nav class="navbar navbar-default navbar-static-top">
        <?PHP if(isset($error)): ?>

            <div class="alert alert-danger" role="alert"><?PHP echo $error?></div>

        <?PHP endif; ?>
        <?PHP if(isset($feedback)): ?>

            <div class="alert alert-success" role="alert"><?PHP echo $feedback?></div>

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
                <ul class="nav navbar-nav">
                    <a class="navbar-brand" id="logo" href="index.php"><img src="img/logo.svg" alt="Logo"/></a>
                    <li class="active"><a href="admin_home.php">Home</a></li>
                    <li><a href="registreer_admin.php">Account toevoegen</a></li>

                </ul>
                <ul class="nav navbar-nav navbar-right">
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
            <div id="collinks"class="col-sm-12 text-left" >
                <div class="jumbotron">
                    <h3>Boekingen</h3>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Datum</th>
                            <th>Naam</th>
                            <th>Email</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?PHP while($booking = $allBookings->fetch()): ?>
                            <tr>
                                <td><?PHP echo $booking['date'] ?></td>
                                <td><?PHP echo $booking['visitor_name'] . " (bezoeker)" ?></td>
                                <td><a href="mailto:<?PHP echo $booking['visitor_email'] ?>"><?PHP echo $booking['visitor_email'] ?></a></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><?PHP echo $booking['student_name'] . " (student)" ?></td>
                                <td><a href="mailto:<?PHP echo $booking['student_email'] ?>"><?PHP echo $booking['student_email'] ?></a></td>
                            </tr>
                        <?PHP endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div><!--end collinks-->
            <div class="clearfix"></div>
            <div id="colrechts"class="col-sm-6 text-left">
                <div class="jumbotron">
                    <h3>Statistieken</h3>
                    <div id="collinks" class="col-sm-6 text-left">
                        <h4>Nieuwsbrief</h4>
                        <?PHP
                        echo '<li class="list-group-item text-center">' . $count_email['email'] . '</li>';
                        ?>
                        <form action="">
                            <input type="submit" name="download_newsletter" value="Download" class="fullwidth"/>
                        </form>
                        <?PHP if (isset($ready_newsletter)): echo '<a download href="emails.txt">Download file</a>'; endif; ?>
                    </div>

                    <div id="colrechts" class="col-sm-6 text-left">
                        <h4>Studenten</h4>
                        <?PHP
                        echo '<li class="list-group-item text-center">' . $count_students['aantal'] . '</li>';
                        ?>
                        <form action="">
                            <input type="submit" name="download_students" value="Download" class="fullwidth"/>
                        </form>
                        <?PHP if (isset($ready_students)): echo '<a download href="students.txt">Download file</a>'; endif; ?>
                    </div>

                    <div class="clearfix"></div>
                    <br/>

                    <div id="collinks" class="col-sm-6 text-left">
                        <h4>Gebruikers</h4>
                        <?PHP
                        echo '<li class="list-group-item text-center">' . $count_visitors['aantal'] . '</li>';
                        ?>

                    </div>

                    <div id="colrechts" class="col-sm-6 text-left">
                        <h4>Boekingen</h4>
                        <?PHP
                        echo '<li class="list-group-item text-center">' . $count_booking['aantal'] . '</li>';
                        ?>

                    </div>
                </div>
            </div><!--end colrechts-->
            <div id="collinks"class="col-sm-6 text-left" >
                <div class="jumbotron">
                    <h3>Beschikbare data</h3>
                    <ul class="list-group" id="list-available-dates">
                        <?PHP while($date = $allDates->fetch(PDO::FETCH_ASSOC)): ?>
                            <li class="list-group-item"><?PHP echo $date['date'] ?><span class="badge"><a style="color: #F2F2F2" href="?id=<?PHP echo $date['id'] ?>">delete</a></span></li>
                        <?PHP endwhile; ?>
                    </ul>
                </div>
            </div><!--end collinks-->
            <div id="colrechts"class="col-sm-6 text-left" >
                <div class="jumbotron">
                    <h3>Nieuwe data toevoegen</h3>
                    <form action="" method="post" enctype="multipart/form-data" id="sandbox-container">
                        <div class="form-group">
                            <input type="text" class="form-control" id="date_input" name="date_input">
                        </div>
                        <input type="submit" name="date_submit" value="Voeg toe" class="btn btn-default"/>
                    </form>
                    <script>
                        $('#sandbox-container #date_input').datepicker({
                            weekStart: 1,
                            startDate: "today",
                            clearBtn: true,
                            language: "nl",
                            daysOfWeekDisabled: "0,6",
                            autoclose: true,
                            todayHighlight: true,
                            format: "yyyy-mm-dd"
                        });
                    </script>
                </div>
            </div><!--end colrechts-->
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

    <?PHP else: ?>
        <?PHP include_once('404.php') ?>
    <?PHP endif; ?>

</div> <!--end container-->
</body>
</html>