 <!DOCTYPE html>
 <html>
 <head>
   <meta charset="utf-8">
   <title>Web</title>
 </head>
 <body>
<?php

  require_once 'app/init.php';

  $db = new DB();
  $googleClient = new Google_Client();
  $auth = new GoogleAuth($db, $googleClient);

  echo 'test';

  if($auth->checkRedirectCode()) {
    header('Location: index.php');
  }


 ?>


    <?php if(!$auth->isLoggedIn()):  ?>

      <a href="<?php echo $auth->getAuthUrl(); ?>">Sign in with google</a>

      <?php else: ?>
	     You are signed in. <a href="logout.php">Sign out </a>
      
      <?php endif; ?>
 </body>
 </html>

