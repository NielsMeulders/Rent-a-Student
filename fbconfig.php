<?php
session_start();
// added in v4.0.0
require_once 'autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;
include_once("classes/Bezoeker.class.php");
$b = new Bezoeker();
$conn = Db::getInstance();
// init app with app id and secret
FacebookSession::setDefaultApplication( '369182239939237','08d8f9b8d93af2f96b5b77ee7b639178' );
// login helper with redirect_uri
    $helper = new FacebookRedirectLoginHelper('http://localhost:8888/Rent-a-Student/fbconfig.php' );
try {
  $session = $helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
} catch( Exception $ex ) {
  // When validation fails or other local issues
}
// see if we have a session
if ( isset( $session ) ) {
  // graph api request for user data
  $request = new FacebookRequest( $session, 'GET', '/me' );
  $response = $request->execute();
  // get response
  $graphObject = $response->getGraphObject();
     	$fbid = $graphObject->getProperty('id');              // To Get Facebook ID
 	    $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
	    $femail = $graphObject->getProperty('email');    // To Get Facebook email ID
	/* ---- Session Variables -----*/
	    $_SESSION['FBID'] = $fbid;           
        $_SESSION['FULLNAME'] = $fbfullname;
	    $_SESSION['EMAIL'] =  $femail;
        $_SESSION['type'] ='bezoeker';
        $_SESSION['loggedIn'] = true;
        if (!$b->checkDoubleMail($femail))
        {
            $statement = $conn->prepare('INSERT INTO bezoeker (name,email,fbid) VALUES  ( :name, :email,:fbid)');
            $statement->bindValue(':name',$fbfullname);
            $statement->bindValue(':email',$femail);
            $statement->bindValue(':fbid',$fbid);
            $statement->execute();
        }
    /* ---- header location after session ----*/
  header("Location: bezoeker_home.php");
} else {
  $loginUrl = $helper->getLoginUrl(array('scope'=>'email'));
 header("Location: ".$loginUrl);
}
?>