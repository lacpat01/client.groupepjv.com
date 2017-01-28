<?php
session_start();
require_once 'class.user.php';

$reg_user = new USER();

if($reg_user->is_logged_in()!="")
{
	$reg_user->redirect('home.php');
}


if(isset($_POST['btn-signup']))
{
	$uname = trim($_POST['txtuname']);
	$email = trim($_POST['txtemail']);
	$upass = trim($_POST['txtpass']);
	$code = md5(uniqid(rand()));
	
	$stmt = $reg_user->runQuery("SELECT * FROM tbl_users WHERE userEmail=:email_id");
	$stmt->execute(array(":email_id"=>$email));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	if($stmt->rowCount() > 0)
	{
		$msg = "
		      <div class='alert alert-error'>
				<button class='close' data-dismiss='alert'>&times;</button>
					<strong>Désolé !</strong> un compte avec ce courriel existe déjà. Réessayez avec un autre courriel.
			  </div>
			  ";
	}
	else
	{
		if($reg_user->register($uname,$email,$upass,$code))
		{			
			$id = $reg_user->lasdID();		
			$key = base64_encode($id);
			$id = $key;

			
			
			$message = "					
						Bonjour $uname,
						<br /><br />
						Bienvenue sur l'espace client de Groupe PJV!<br/>
						Confirmez votre adhésion en cliquand sur le lien suivant:<br/>
						<br /><br />
						<a href='http://client.groupepjv.com/verify.php?id=$id&code=$code'>Cliquez ici pour activer votre compte</a>
						<br /><br />
						Merci,<br><br>
						L'équipe de Groupe PJV";
						
			$subject = "Espace-client Groupe PJV : Confirmer votre adhésion.";		
			$reg_user->send_mail($email,utf8_decode($message),utf8_decode($subject));	
			$msg = "
					<div class='alert alert-success'>
						<button class='close' data-dismiss='alert'>&times;</button>
						<strong>Votre demande est complétée!</strong>  Nous avons envoyé un courriel à $email.
                    Pour compléter votre adhésion, cliquez sur le lien au bas du courriel que vous avez reçu. 
			  		</div>
					";
		}
		else
		{
			echo "sorry , Query could no execute...";
		}		
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
    <title>Groupe PJV | Création d'un compte</title>
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
				<?php if(isset($msg)) echo $msg;  ?>
      <form class="form-signin" method="post">
        <img src="Logo_PJV.png" alt="Logo Groupe PJV" style="width:250px;height:106px;">
			<br><h4 class="form-signin-heading">Bienvenue dans l'espace-client</h4><hr /></br>
       Veuillez entrer vos informations afin de créer un compte.<br><br>
        <input type="text" class="input-block-level" placeholder="Code de magasin Ex.: BMR000123" name="txtuname" required />
        <input type="email" class="input-block-level" placeholder="Courriel" name="txtemail" required />
        <input type="password" class="input-block-level" placeholder="Mot de passe" name="txtpass" required />
     	<hr />
        <button class="btn btn-large btn-primary" type="submit" name="btn-signup">Soumettre</button><br><br>
        <a href="index.php">Vous avez déjà un compte?</a>
      </form>
   

    </div> <!-- /container -->
    <script src="vendors/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>