<?PHP

include_once("classes/User.class.php");
include_once("classes/Imd_student.class.php");

session_start();
$b = new Imd_student();

if (!empty($_POST))
{
    try
    {
        $b->checkPass($_POST['pass'],$_POST['pass_rep']);

        $b->Name = $_POST['name'];
        $b->Email = $_POST['email'];
        $b->Password = $_POST['pass'];
        $b->Picture = "images/profile_pics/".$_POST['email']."/".basename( $_FILES["fileToUpload"]["name"]);
        $b->Year = $_POST['year'];
        $b->Branch = $_POST['branch'];
        $b->Description = $_POST['description'];

        $dir = $_POST['email'];
        if (!file_exists("images/profile_pics/$dir")) {
            mkdir("images/profile_pics/$dir", 0777, true);
        }
        include_once("upload.php");

        $b->save();

        header("Location: index.php");
    }
    catch(Exception $e)
    {
        $error = $e->getMessage();
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
    <!-- Bootstrap -->    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
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
    <div class="row">
    	<div class="col-xs-12 no-padding" >
    		 <div id="topbar"></div>
    		 <div class="jumbotron" id="jumbologin"><h1>Registreer</h1></div>

			<form id="loginform" action="" method="post" enctype="multipart/form-data">
    <div class="col-md-1 styleguide">
			<h2>Registreer je hier!</h2>
			<?PHP if(isset($error)): ?>
                   
                   <div class="alert alert-danger" role="alert" ><?PHP echo $error;?></div>
                   
               <?PHP endif; ?>
			<form action="" method="post" enctype="multipart/form-data">
				  <div class="form-group">
				    <label for="name">Naam</label>
				    <input type="text" class="form-control" id="name" name="name">
				  </div>
				  <div class="form-group">
				    <label for="email">Email</label>
				    <input type="email" class="form-control" id="email" name="email">
				  </div>
				  <div class="form-group">
				    <label for="pass">Wachtwoord</label>
				    <input type="password" class="form-control" id="pass" name="pass">
				  </div>
				  <div class="form-group">
				    <label for="pass_rep">Wachtwoord herhalen</label>
				    <input type="password" class="form-control" id="pass_rep" name="pass_rep">
				  </div>
				  <div class="form-group">
				    <label for="year">Opleidingsjaar</label>
				    <select name="year" id="year" >
				        <option value="1">1</option>
				        <option value="2">2</option>
				        <option value="3">3</option>
				    </select >
				  </div>
				  <div class="form-group">
				    <label for="branch">Keuzerichting</label>
				    <select name="branch" id="year">
				        <option value="null"></option>
				        <option value="1">Design</option>
				        <option value="2">Development</option>
				    </select>
				  </div>
				  <div class="form-group">
				    <label for="description">Motivatie</label>
				    <textarea class="studarea form-control" name="description" class="form-control" id="description" cols="30" rows="10"></textarea>
				  </div>
				  <div class="form-group">
				    <label for="pic">Profielfoto (max 1Mb)</label>
				    <input type="file" name="fileToUpload" id="fileToUpload">
				  </div></br></br>
				  <button type="submit" class="btn btn-default">Submit</button>
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