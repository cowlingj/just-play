<?php
// Database variables will come from the parent database-functions.php file
$dist_att = 1; 		 //Distance attenuation
$elo_att = 100;  		   //Elo attenuation
$disabled_att = 1;	 //Disabled status attenuation
$k_constant = 32;

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
function vincentyGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000) {
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

//A comparison function used for sorting the recommended broadcasts by matchStrength
function cmp($a, $b)
{
  if ($a["matchStrength"] == $b["matchStrength"]) {
    return 0;
  }

  return ($a["matchStrength"] < $b["matchStrength"]) ? -1 : 1;
}

/**
 * Returns a list of the best matches for a given person. Frees $queryResults
 * @param float $playerLatitude Latitude of player [deg decimal]
 * @param float $playerLongitude Longitude of player [deg decimal]
 * @param result object $queryResults A sql query containing broadcaster, latitude, longitude, sport,
 * @param float $playerELO The elo of the player (not used in current function)
 * @param maximumDistance (in metres), i.e. the size of the map
 * @return array An ordered array where the best mach is first index - keys is userID and values are distances
 */
//5km

function getRankedRequests($playerLatitude, $playerLongitude, $queryResults, $playerELO ) {
  //Auxilary array for sorting the positions
  $auxilaryArray = array();

	// loop through each row for
	foreach ($queryResults as $row) {
    $broadcaster = $row["broadcaster"];
    $latitude = $row["latitude"];
		$longitude = $row["longitude"];
    $elo = $row["elo"];

 		$distance = vincentyGreatCircleDistance($playerLatitude, $playerLongitude, $latitude, $longitude);
    $ELODiff = $elo-$playerELO;

    // if this broadcast is inside the player radius
    $maximumDistance =5000;
    if ($distance < $maximumDistance) {
      //--
      $auxilaryArray[$broadcaster]=array (
                                  "distance"  => $distance,
                                  "ELODiff" => $ELODiff,
                                  "matchStrength" =>  $distance * $dist_att + abs($eloDifference) * $elo_att
      );
      //--
    }
  }

  // orders the auxilary array  by 'best match'
	uasort($auxilaryArray, "cmp");
  //Move sorted data in a convinient to use array

  $returnArray = array();

  foreach ($auxilaryArray as $key => $value) {
      array_push(
          $returnArray,array (
                                  "broadcaster" => $key,
                                  "distance"  => $value["distance"],
                                  "ELODiff" => $value["ELODiff"]
      )
    );
  }


	return $returnArray;
}

abstract class MatchOutCome {
    const WIN = 0;
    const LOSE = 1;
    const DRAW = 2;
    // etc.
}

/**
 * Returns an array with the updated player scores. Indexed by "ply1" and "ply2"
 * @param float $player1ELOELO Elo of player 1
 * @param float $player2ELO Elo of player 2
 * @param $outcome a MatchOutCome enum
 * @return An array with the scayer1ELO */
function recalculateElo($player1ELO ,$player2ELO, $outcome) {
	//Calculate transformed rating for each player
	$R1 = pow(10, $player1ELOELO / 400);//Player 1
	$R2 = pow(10, $player2ELO / 400);//Player 2

	//Calculate expecter score for each player
	$e1 = $R1 / ($R1 + $R2);
	$e2 = $R2 / ($R1 + $R2);

	//Not-so magic constants
	$s1 =- 1;
	$s2 =- 1;
	switch ($outcome) {
		//Player 1 WON
		case MatchOutCome::WIN:
			$s1 = 1;
			$s2 = 0;
			break;
		//Player 1 LOST the match
		case MatchOutCome::LOSE:
			$s1 = 0;
			$s2 = 0;
			break;
		//Match ended in a draw
		case MatchOutCome::DRAW;
			$s1 = 0.5;
			$s2 = 0.5;
	}

  // updates elo scores by formula: old ELO + small change in ELO (from game)
	$updatedElos = array(
		"ply1" => $player1ELO + $k_constant*($s1-$e1),
		"ply2" => $player2ELO + $k_constant*($s2-$e2)
	);
	return $updatedElos;
}
//  ODO:Implement this https://www.cs.cmu.edu/~wjh/go/Ratings.pseudo-code
?>
