      <?php
      	/*
      	$database_host = "dbhost.cs.man.ac.uk";
 		$database_user = "mbaxarm3";
 		$database_pass = "160190pi";
 		$database_name = "mbaxarm3";
 		$group_dbnames = array(
     	"2016_comp10120_m3",);
*/	
     	define("dist_att", 1); 		//Distance attenuation
     	define("elo_att", 1);  		//Elo attenuation
     	define("disabled_att", 1);	//Disabled status attenuation
     	//Credit to http://stackoverflow.com/questions/10053358/measuring-the-distance-between-two-coordinates-in-php
     	/**
		 * Calculates the great-circle distance between two points, with
		 * the Vincenty formula.
		 * @param float $latitudeFrom Latitude of start point in [deg decimal]
		 * @param float $longitudeFrom Longitude of start point in [deg decimal]
		 * @param float $latitudeTo Latitude of target point in [deg decimal]
		 * @param float $longitudeTo Longitude of target point in [deg decimal]
		 * @param float $earthRadius Mean earth radius in [m]
		 * @return float Distance between points in [m] (same as earthRadius)
		 */
		function vincentyGreatCircleDistance(
		  $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
		{
		  // convert from degrees to radians
		  $latFrom = deg2rad($latitudeFrom);
		  $lonFrom = deg2rad($longitudeFrom);
		  $latTo = deg2rad($latitudeTo);
		  $lonTo = deg2rad($longitudeTo);

		  $lonDelta = $lonTo - $lonFrom;
		  $a = pow(cos($latTo) * sin($lonDelta), 2) +
		    pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
		  $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

		  $angle = atan2(sqrt($a), $b);
		  return $angle * $earthRadius;
		}


         /**
		 * Returns a list of the best matches for a given person. Frees $query_results
		 * @param float $ply_lat Latitude of player [deg decimal]
		 * @param float $ply_long Longitude of player [deg decimal]
		 * @param result object $query_results A sql query containing broadcaster, latitude, longitude, sport,
		 * @param float $ply_elo The elo of the player
		 */
        function getRankedRequests($ply_lat,$ply_long,$query_results,$ply_elo) 
        {
        	//Requests are store here
        	$requsts = array();
        	//TODO: mysql_fetch_assoc is deprecated.
        	while ($row = mysql_fetch_assoc($query_results)) {
        		$lat=$row["latitude"];
        		$long=$row["longitude"];
        		$broadcaster=$row["broadcaster"];
        		$dist=vincentyGreatCircleDistance($ply_lat,$ply_long,$lat,$long);
        		$requsts[$broadcaster]=$dist;
			}
			arsort($requsts);
			//Free given results
			//TODO: mysql_free_result is deprecated.
			mysql_free_result($query_results);
			
			return $requests;
		}
		//TODO:Implement this https://www.cs.cmu.edu/~wjh/go/Ratings.pseudo-code 
      ?>