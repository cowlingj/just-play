<!-- 
  TODO:
  Replace placeholder text in masthead
-->
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Home | JustPlay</title>
    <?= style("style"); ?>
    <?= script("jquery.min"); ?>
    <?= script("header-toggle"); ?>>
  </head>
  <body>
    <header class="big">
      <div class="center-container">
        <h1 class="logo">
          <a href="#">
            Just<span>Play</span>
          </a>
        </h1>
      </div><!-- end .center-container -->
    </header>
    <div class="clear-header"></div><!-- end .empty-header -->
    <main class="home">
      <div class="center-container">
        <div class="login-signup">
          <p>
            Want to find people to play sport with?
          </p>
          <p>
            Use Facebook or Google+ to login or signup to get started!
          </p>
          <div class="login-buttons">
            <a href="<?= $loginURL ?>" class="facebook login-signup">
              Login with Facebook
            </a>
            <a href="#" class="google login-signup">Login with Google+</a>
          </div><!-- end .login-buttons -->
        </div><!-- end .login-signup -->
      </div><!-- end .center-container -->
      <div class="masthead">
        <div class="center-container">
          <h3>Our Mission</h3>
          <blockquote>
            'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto incidunt quibusdam eius. Similique deleniti numquam, porro itaque modi, voluptatum esse nobis.'
          </blockquote>
        </div><!-- end .center-container -->
      </div><!-- end .masthead -->
    </main>
    <div class="clear-footer"></div><!-- end .clear-footer -->
    <footer>
      <div class="center-container">
        <em>Copyright &copy; 2017 &mdash; Group M3</em>
      </div><!-- end .center-container -->
    </footer>
  </body>
</html>
