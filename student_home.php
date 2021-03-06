<?PHP
include_once('classes/Imd_student.class.php');
include_once('classes/Date_available.class.php');
include_once('classes/Rating.class.php');

try {
    session_start();

    $a = new Imd_student();
    $allstudents = $a->getAll();

    $conn = Db::getInstance();

    $statement = $conn->prepare('SELECT * FROM student WHERE id=:id');

    $statement->bindParam(':id', $_SESSION['id']);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    $current_user = $user['id'];

    $d = new Date_available();
    $allDates = $d->getAllJoin($current_user);
    $allBookings = $d->getBookingForStudent($current_user);

    $r = new Rating();
    $allRatings = $r->getAll(6);

    if (!empty($_POST['date_submit'])) {
        if (!empty($_POST['date_choose'])) {
            $statement = $conn->prepare('INSERT INTO date_gids_available (student_id,date_id) VALUES  (:stud,:date)');

            $statement->bindValue(':stud', $user['id']);
            $statement->bindValue(':date', $_POST['date_choose']);
            $statement->execute();
            header('location: student_home.php');
        } else {
            throw new Exception("Geen datum beschikbaar");
        }

    }

    $dates_available = $conn->query("SELECT date_gids_available.id as da_id, DATE_FORMAT(date,'%d-%c-%Y') as date, date_gids_available.date_id as gids_id FROM date_available INNER JOIN date_gids_available on date_available.id = date_gids_available.date_id WHERE date_gids_available.student_id = $current_user");

    if (!empty($_GET['id'])) {
        $curr_id = $_GET['id'];
        $conn->query("DELETE FROM date_gids_available WHERE id=$curr_id;");
        header('location: student_home.php');
    }

}
catch(Exception $e)
{
    $error = $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home | Student</title>
    <script src="js/script.js"></script>
    <!-- Bootstrap -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
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
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <a class="navbar-brand" id="logo" href="index.php"><img src="img/logo.svg" alt="Logo"/></a>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="student_aanpassen.php">Account aanpassen</a></li>

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?PHP $style = "background-image:url(". $user['picture'] .");" ?>
                    <li class="login_icon" style=<?PHP echo $style ?>><a href="student_aanpassen.php"></a></li>
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
                    <h3>Recente boekingen</h3>
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
                                <td><?PHP echo $booking['name'] ?></td>
                                <td><a href="mailto:<?PHP echo $booking['email'] ?>"><?PHP echo $booking['email'] ?></a></td>
                            </tr>
                        <?PHP endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div><!--end collinks-->
        <div class="clearfix"></div>
            <div id="collinks"class="col-sm-6 text-left" >
                <div class="jumbotron">
                    <h3>Datums beschikbaar</h3>
                    <ul class="list-group">
                    <?PHP while($date_available = $dates_available->fetch()): ?>
                        <li class="list-group-item"><?PHP echo $date_available['date'] ?><span class="badge"><a style="color: #F2F2F2" href="?id=<?PHP echo $date_available['da_id'] ?>">delete</a></span></li>
                    <?PHP endwhile; ?>
                    </ul>
                </div>
            </div><!--end collinks-->
            <div id="colrechts"class="col-sm-6 text-left" >
                <div class="jumbotron">
                    <h3>Nieuwe beschikbaarheid</h3>
                    <form action="" method="post" enctype="multipart/form-data" id="sandbox-container">
                    <select name="date_choose">
                        <?PHP while($date = $allDates->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?PHP echo $date['id'] ?>"><?PHP echo $date['date'] ?></option>
                        <?PHP endwhile; ?>
                    </select>
                        <input type="submit" name="date_submit" value="Voeg toe" class="btn btn-default"/>
                    </form>
                </div>
            </div><!--end colrechts-->
            <div id="collinks"class="col-sm-12 text-left">
                <div class="jumbotron">
                    <h3>Laatste reviews</h3>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Datum</th>
                            <th>Naam</th>
                            <th>Rating</th>
                            <th>Commentaar</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?PHP while($rating = $allRatings->fetch()): ?>
                            <tr>
                                <td><?PHP echo $rating['date'] ?></td>
                                <td><?PHP echo $rating['name'] ?></td>
                                <td><?PHP echo $rating['rating'] . "/5" ?></td>
                                <td><?PHP echo $rating['comment'] ?></td>
                            </tr>
                        <?PHP endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div><!--end colrechts-->
        </div><!--end welcomewrap-->
    </div><!-- end row -->

    <div class="row" >
        <div class="col-xs-12" id="relatedlinks">
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