<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="author" content="Jonathan Cowling">
  <meta name="date created" content="1 Feb 2017">
  <meta name="date edited" content="13 Feb 2017">
  <title>Just Play</title>
</head>
<body>

  

  <form method="post" action="../lib/process-search-form.php">
    Name:<input type="text" name="name" required><br>
    Sport:<select name="sport" required>
            <option value="football">Football</option>
            <option value="rugby">Rugby</option>
            <option value="basketball">Basketball</option>
            <option value="tennis">Tennis</option>
          </select><br>
    <!-- 
        by the end of sprint 2 this information will be obtained
        via javascript, so no form inputs will be required
    -->
    Location x y:<input type="hidden" name="latitude"><input type="hidden" name="longitude"><br>
    Disabled:<input type="checkbox" name="disabled"><br>

    <input type="submit" value="submit">
  </form>
</body>
</html>