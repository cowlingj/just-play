<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Broadcast Request Details | JustPlay</title>
    <link rel="stylesheet/less" type="text/css" href="../assets/css/style.less" />
    <?= style("style"); ?>
    <?= script("jquery-min"); ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDP9ofPjKpQ3eRwJFOwPgP-BBXgTn9phis" type="text/javascript"></script>
    <?= script("map-functions"); ?>
    <?= script("search-map"); ?>
    <?= script("map-sizing"); ?>
  </head>
  <body>
    <header class="small">
      <div class="center-container">
        <h1 class="logo">
          <a href="#">J<span>P</span></a>
        </h1>
      </div><!-- end .center-container -->
    </header>
    <div class="clear-header"></div><!-- end .clear-header -->
    <main class="map">
      <section id="map"><!-- google map goes inside here --></section>
      <aside class="map-sidebar">
        <h3 id="search-results">Broadcast Request Details</h3>
        <div class="details">
          <table>
            <tr class="header">
              <td><em>Opponent:</em> </td>
              <td><?= $opponent; ?></td>
            </tr>
            <tr>
              <td><em>Sport:</em></td>
              <td class="info"><?= $sport; ?></td>
            </tr>
            <tr>
              <td><em>Location:</em></td>
              <td class="info"><?= $location; ?></td>
            </tr>
          </table>
        </div><!-- end .details -->
        <div class="email-reminder">
          <p>Please note that if you do not give feedback about this game, the game will be dropped from our database and we will not be able to make more appropriate matches based on your ability.</p>
        </div>
      </aside>
    </main>
    <footer>
      <div class="center-container">
        <em>Copyright &copy; 2017 &mdash; Group M3</em>
      </div><!-- end .center-container -->
    </footer>
  </body>
</html>