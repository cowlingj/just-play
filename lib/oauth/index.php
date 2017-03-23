<?php 

  require_once 'app/init.php';

  $db = new DB;
  $googleClient = new Google_Client;

  $auth = new GoogleAuth($db, $googleClient);

  if(auth->checkRedirectCode()) {
    header('Location: index.php');
  } 


 ?>

 <!DOCTYPE html>
 <html>
 <head>
   <meta charset="utf-8">
   <title>Website</title>
 </head>
 <body>
    <?php if(!$auth->isLoggedIn()); ?>
      <a href="<<?php echo $auth->getAuthUrl(); ?>">Sign in with google</a>
    <?php else: ?>
      You are signed in. <a href="logout.php">Sign out</a>
    <?php endif; ?>
 </body>
 </html>