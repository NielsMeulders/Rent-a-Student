<?PHP

include_once("classes/User.class.php");
include_once("classes/Imd_student.class.php");

include_once('classes/Imd_student.class.php');
session_start();
$a = new Imd_student();
$allstudents = $a->getAll();

$conn = Db::getInstance();

$statement = $conn->prepare('SELECT * FROM student WHERE id=:id');

$statement->bindParam(':id',$_SESSION['id']);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);

try
{
    if (!empty($_POST))
    {
        $a->checkPass($_POST['pass'], $_POST['pass_rep']);
        $a->update($_POST['name'],$_POST['pass'], $_POST['year'], $_POST['branch'], $_POST['description']);
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
    <title>Rent-a-Student</title>
    <script src="js/script.js"></script>
    <!-- Bootstrap -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no;">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" href="img/logo_badge.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="img/logo_badge.png" type="image/x-icon"/>
        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
          <![endif]-->
    <meta name="keywords" content="Rent-a-student, rent a student, imd, interactive, multimedia, design, thomas, more, mechelen, app">
    <meta name="description" content="Zin om een dagje mee te volgen met een IMD-student? Boek hier je persoonlijke IMD-gids!" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
</head>
<body>
    
<div class="container-fluid">
   
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
                <a class="navbar-brand" href="student_home.php">Rent-a-Student</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="student_home.php">Home</a></li>
                    <li class="active"><a href="student_aanpassen.php">Account aanpassen</a></li>

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
    	<div class="col-xs-12 no-padding" >

			<form id="loginform" action="" method="post" enctype="multipart/form-data">
    <div class="col-md-1 styleguide">
			<?PHP if(isset($error)): ?>
                   
                   <div class="alert alert-danger" role="alert" ><?PHP echo $error;?></div>
                   
               <?PHP endif; ?>
			<form action="" method="post" enctype="multipart/form-data">
				  <div class="form-group">
				    <label for="name">Naam</label>
				    <input type="text" class="form-control" id="name" name="name" <?PHP echo " value='". $user['name']."'"; ?>>
				  </div>
				  <div class="form-group">
				    <label for="email">Email</label>
				    <input type="email" class="form-control" id="email" name="email" <?PHP echo " value='". $user['email']."'"; ?> readonly>
				  </div>
				  <div class="form-group">
				    <label for="pass">Nieuw wachtwoord</label>
				    <input type="password" class="form-control" id="pass" name="pass">
				  </div>
				  <div class="form-group">
				    <label for="pass_rep">Wachtwoord herhalen</label>
				    <input type="password" class="form-control" id="pass_rep" name="pass_rep">
				  </div>
				  <div class="form-group">
				    <label for="year">Opleidingsjaar</label>
				    <select name="year" id="year">
				        <option value="1" <?php if($user['year'] == 1) echo "selected"; ?>>1</option>
				        <option value="2" <?php if($user['year'] == 2) echo "selected"; ?>>2</option>
				        <option value="3" <?php if($user['year'] == 3) echo "selected"; ?>>3</option>
				    </select >
				  </div>
				  <div class="form-group">
				    <label for="branch">Keuzerichting</label>
				    <select name="branch" id="year">
				        <option value="1" <?php if($user['branch'] == 1) echo "selected"; ?>>Design</option>
				        <option value="2" <?php if($user['branch'] == 2) echo "selected"; ?>>Development</option>
				    </select>
				  </div>
				  <div class="form-group">
				    <label for="description">Motivatie</label>
				    <textarea class="studarea form-control" name="description" class="form-control" id="description" cols="30" rows="10"><?PHP echo htmlspecialchars($user['description']); ?></textarea>
				  </div></br>
				  <p>Als u geen wijzigingen wilt doorvoeren, gaat u terug naar Home zonder op onderstaande knop te klikken.</p>
				  <button type="submit" class="btn btn-default">Profiel aanpassen</button>
			</form>
			</div>
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

    <footer class="footer">&copy Thomas More</footer>
	
</div> <!-- end container -->
</body>
</html>