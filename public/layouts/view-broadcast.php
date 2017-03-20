<?php


?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Your Current Broadcast Request | JustPlay</title>
    <!--
      When you want to change styles, this file must be edited, compiled and minified to create the file
      <link rel="stylesheet/less" type="text/css" href="../assets/css/style.less" />
      <script src="../assets/js/less.min.js" type="text/javascript"></script>
    -->
    <?=style("style");?>
    <?=script("jquery-min");?>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDP9ofPjKpQ3eRwJFOwPgP-BBXgTn9phis" type="text/javascript"></script>
    <?=script("map-functions");?>
    <?=script("search-map");?>
    <?=script("map-sizing");?>
  </head>
  <body>
    <header class="small">
      <div class="center-container">
        <h1 class="logo">
          <a href="/mbax4msk/just_play/">J<span>P</span></a>
        </h1>
      </div><!-- end .center-container -->
    </header>
    <div class="clear-header"></div><!-- end .clear-header -->
    <main class="map">
      <section id="map"><!-- google map goes inside here --></section>
      <aside class="map-sidebar">
        <h3 id="search-results">Your Current Broadcast Request</h3>
        <div class="details">
          <h4 class="user-name">John Doe</h4>
          <table>
            <tr>
              <td><em>Sport:</em></td>
              <td class="info">Tennis</td>
            </tr>
            <tr>
              <td><em>Location:</em></td>
              <td class="info">Plattfields Park</td>
            </tr>
          </table>
        </div><!-- end .details -->
        <div class="broadcast-status">
          <table>
            <tr>
              <td><em>Status:</em></td>
              <td class="info">Pending</td>
            </tr>
          </table>
        </div>
        <div class="delete-edit">
          <a href="#" class="edit">Edit this Broadcast</a>
          <a class="delete" href="#">Delete this Broadcast</a>
        </div><!-- end .delete-edit -->
      </aside>
    </main>
    <footer>
      <div class="center-container">
        <em>Copyright &copy; 2017 &mdash; Group M3</em>
      </div><!-- end .center-container -->
    </footer>
  </body>
</html>