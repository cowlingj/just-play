<!--
  TODO:
  similar to 'view-broadcast.php', we must retrieve the broadcast information 
  (if it exists) so that we can autofill the fields for users who are editing their broadcast request
-->
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Broadcast | JustPlay</title>>
    <!--
      When you want to change styles, this file must be edited, compiled and minified to create the file
      <link rel="stylesheet/less" type="text/css" href="../assets/css/style.less" />
      <script src="../assets/js/less.min.js" type="text/javascript"></script>
    -->
    <?= style("style"); ?>
    <?= script("jquery-min"); ?>
    <?= script("header-toggle"); ?>
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
    <header class="small">
      <div class="center-container">
        <h1 class="logo">
          <a href="#">J<span>P</span></a>
        </h1>
      </div><!-- end .center-container -->
    </header><!-- end header.small -->
    <div class="clear-header"><!-- --></div><!-- end .empty-header -->
    <main class="search">
      <div class="page-heading">
        <div class="center-container">
          <h3>Create Broadcast</h3>
        </div><!-- end .center-container -->
      </div><!-- end .page-heading -->
      <div class="center-container">
        <div class="form">
          <form action="/mbax4msk/just_play/response-map" method="POST">
            <div class="text-inputs">
              <div class="input">
                <label for="name">Sport: </label>
                <select name="sport" id="sport">
                  <option value="tennis">Tennis</option>
                  <option value="badminton">Badminton</option>
                </select>
              </div><!-- end .input -->
              <div class="input">
                <label for="location">Location: </label>
                <input type="text" /><!-- this is a dropdown menu from google maps api -->
                <input type="hidden" name="latitude" value="google will autofill in this field" />
                <input type="hidden" name="longitude" value="google will autofill in this field" />
              </div>
              <div id="map-search"><!-- google map goes here --></div>
              <div class="submit">
                <input type="submit" value="Place Request" />
              </div><!-- end .submit -->
            </div><!-- end .text-inputs -->
          </form>
        </div><!-- end .form -->
      </div><!-- end .center-container -->
    </main>
    <footer>
      <div class="center-container">
        <em>Copyright &copy; 2017 &mdash; Group M3</em>
      </div><!-- end .center-container -->
    </footer>
  </body>
</html>