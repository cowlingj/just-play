<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Search | JustPlay</title>
    <!--
      When you want to change styles, this file must be edited, compiled and minified to create the file
      <link rel="stylesheet/less" type="text/css" href="../assets/css/style.less" />
      <script src="../assets/js/less.min.js" type="text/javascript"></script>
    -->
    <?= style("style"); ?>
    <?= script("jquery.min"); ?>
    <?= script("search-location-functions"); ?>
  </head>
  <body>
    <header class="big">
      <div class="center-container">
        <h1 class="logo">
          <a href="/mbax4msk/just_play/">
            Just<span>Play</span>
          </a>
        </h1>
      </div><!-- end .center-container -->
    </header>
    <div class="clear-header"><!-- --></div><!-- end .empty-header -->
    <main class="search">
      <div class="page-heading">
        <div class="center-container">
          <h3>Search for a Match</h3>
        </div><!-- end .center-container -->
      </div><!-- end .page-heading -->
      <div class="center-container">
        <div class="form">
          <form action="/mbax4msk/just_play/response" method="GET">
            <div class="input">
              <label for="name">Sport: </label>
              <select name="sport" id="sport">
                <?php
                  foreach($sports as $sport) {
                    echo "<option value=\"".$sport["id"]."\">".$sport["name"]."</option>";
                  }
                ?>
              </select>
            </div><!-- end .input -->
            <div class="hidden-allow-location">
              <em>You must allow Location services in order to use JustPlay.</em>
            </div><!-- end .hidden-allow-location -->
            <div class="submit">
              <input id="submit-button" type="submit" value="Find a Match" />
            </div><!-- end .submit -->
          </form>
        </div><!-- end .form -->
      </div><!-- end .center-container -->
    </main>
    <div class="clear-footer"></div><!-- end .clear-footer -->
    <footer>
      <div class="center-container">
        <em>Copyright &copy; 2017 &mdash; Group M3</em>
      </div><!-- end .center-container -->
    </footer>
  </body>
</html>