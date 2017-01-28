<?php
session_start();
require_once 'class.user.php';
$user_login = new USER();

if($user_login->is_logged_in()!="")
{
	$user_login->redirect('home.php');
}

if(isset($_POST['btn-login']))
{
	$email = trim($_POST['txtemail']);
	$upass = trim($_POST['txtupass']);
	
	if($user_login->login($email,$upass))
	{
		$user_login->redirect('home.php');
	}
}
?>

<!DOCTYPE html>
<html>
  <head><meta charset="UTF-8">
    <meta property="fb:app_id" content="387566021597106">
    <meta property="og:url" content="http://client.groupepjv.com" />
<meta property="og:type"               content="website" />
<meta property="og:title"              content="Groupe PJV - Espace-client" />
<meta property="og:description"        content="Accédez à votre espace-client pour les produits de Groupe PJV." />
<meta property="og:image"              content="http://client.groupepjv.com/Logo_FB-pjv.png" />
   <meta property="og:image:width"              content="1200" />
   <meta property="og:image:height"              content="630" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Groupe PJV | Connexion à l'espace-client</title>
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="assets/styles.css" rel="stylesheet" media="screen">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
  </head>
  <body id="login">
    <div class="container">
		<?php 
		if(isset($_GET['inactive']))
		{
			?>
            <div class='alert alert-error'>
				<button class='close' data-dismiss='alert'>&times;</button>
				<strong>Désolé!</strong> Votre compte n'est pas encore activé, vérifiez votre boîte de courriel et cliquez sur le lien d'activation. 
			</div>
            <?php
		}
		?>
        <form class="form-signin" method="post">
        <?php
        if(isset($_GET['error']))
		{
			?>
            <div class='alert alert-success'>
				<button class='close' data-dismiss='alert'>&times;</button>
				<strong>Veuillez corriger vos informations!</strong> 
			</div>
            <?php
		}
		?>
       <img src="Logo_PJV.png" Logo_FB-pjv.png">
			<br><h4 class="form-signin-heading">Bienvenue dans l'espace-client</h4><hr /></br>
       Veuillez entrer vos informations d'identification.<br><br>
        <input type="email" class="input-block-level" placeholder="Courriel" name="txtemail" required />
        <input type="password" class="input-block-level" placeholder="Mot de passe" name="txtupass" required />
     	<hr />
        <button class="btn btn-large btn-primary" type="submit" name="btn-login">Connexion</button><br>
			<br><a href="fpass.php">Mot de passe oublié? </a></br>
		<br><a href="signup.php">Vous n'avez pas de compte?</a></br>
      </form>

    </div> <!-- /container -->
    <script src="bootstrap/js/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>