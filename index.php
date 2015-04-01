<?PHP



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rent-a-Student</title>
    <script src="js/script.js"></script>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <meta name="keywords" content="Rentastudent, rent a student, imd, interactive, multimedia, design, thomas, more, mechelen, app">
	<meta name="description" content="Zin om een dagje mee te volgen met een IMD-student? Boek hier je persoonlijke IMD-gids!" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
</head>
<body>
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '369182239939237',
            xfbml      : true,
            version    : 'v2.3'
        });
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

<div
    class="fb-like"
    data-share="true"
    data-width="450"
    data-show-faces="true">
</div>
</body>
</html>