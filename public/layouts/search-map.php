<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Search Map | JustPlay</title>
    <!--
      When you want to change styles, this file must be edited, compiled and minified to create the file
      <link rel="stylesheet/less" type="text/css" href="../assets/css/style.less" />
      <script src="../assets/js/less.min.js" type="text/javascript"></script>
    -->
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
          <a href="/mbax4msk/just_play/">J<span>P</span></a>
        </h1>
      </div><!-- end .center-container -->
    </header>
    <div class="clear-header"></div><!-- end .clear-header -->
    <main class="map">
      <section id="map"><!-- google map goes inside here --></section>
      <aside class="map-sidebar">
        <h3 id="search-results">Your Search Results</h3>
        <?php
          $requestCount = 0;
          foreach ($orderedRequests as $request): 
              if ($requestCount == 0) {
                print("<tr class=\"result\" id=\"this\">");
              } else {
                print("<tr class=\"result\">");
              }
        ?>
          <td class="pad"><!-- --></td>
            <td class="info">
              <?= $request["broadcaster"]; ?> is <em><?= $request["dist"]; ?></em> km away
            </td>
            <!-- 
              TODO:
              is there functionality (or even a url) that accepts a request?
            -->
            <td class="button">
              <a href="#">Accept</a>
            </td>
          </tr>
        <?php
          $requestCount++;
          endforeach; 
        ?>
        </table>
      </aside>
    </main>
    <footer>
      <div class="center-container">
        <em class="small-broadcast">
          <a href="/mbax4msk/just_play/broadcast-request-form">Can't find a match? Create a Broadcast Request</a>
        </em>
      </div><!-- end .center-container -->
    </footer>
  </body>
</html>