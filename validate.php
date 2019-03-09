<?php
        include 'db.inc.php';
?>

<?php
	$valcode = $_GET['valcode'];
	$querycodeexisting = "SELECT id FROM validate_strikes_add WHERE code LIKE '$valcode';";
        $resultcodeexisting = mysqli_query($db, $querycodeexisting);
	

	if(mysqli_num_rows($resultcodeexisting) == "0") {
		echo "Obacht... Du hast schon auf den Link geklickt...";
	}
	if(mysqli_num_rows($resultcodeexisting) !== "0") {

	$queryuservalidate1 = "SELECT uservalidate1 FROM pending_strikes_add INNER JOIN validate_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid WHERE validate_strikes_add.code LIKE '$valcode';";
	$resultuservalidate1 = mysqli_query($db, $queryuservalidate1);
	while ($row = $resultuservalidate1->fetch_assoc()) {
    		$uservalidate1 = $row['uservalidate1'];
	}

	$queryuservalidate2 = "SELECT uservalidate2 FROM pending_strikes_add INNER JOIN validate_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid WHERE validate_strikes_add.code LIKE '$valcode';";
	$resultuservalidate2 = mysqli_query($db, $queryuservalidate2);
	while ($row = $resultuservalidate2->fetch_assoc()) {
    		$uservalidate2 = $row['uservalidate2'];
	}

	$queryvalidated = "SELECT validated FROM pending_strikes_add INNER JOIN validate_strikes_add ON pending_strikes_add.id = validate_strikes_add.psaid WHERE validate_strikes_add.code LIKE '$valcode';";
        $resultvalidated = mysqli_query($db, $queryvalidated);
        while ($row = $resultvalidated->fetch_assoc()) {
                $validated = $row['validated'];
        }

	if ($uservalidate1 == "0") {
		$querysetvalidate1 = "UPDATE pending_strikes_add INNER JOIN validate_strikes_add ON  pending_strikes_add.id = validate_strikes_add.psaid SET uservalidate1 = '1' WHERE validate_strikes_add.code LIKE '$valcode';";
		$resultsetvalidate1 = mysqli_query($db, $querysetvalidate1);
		echo "Validation 1 wurde mit dem Code $valcode erfolgreich durchgeführt! Es fehlt noch eine Validierung!";
	} elseif ($uservalidate2 == "0") {
		$querysetvalidate2 = "UPDATE pending_strikes_add INNER JOIN validate_strikes_add ON  pending_strikes_add.id = validate_strikes_add.psaid SET uservalidate2 = '1' WHERE validate_strikes_add.code LIKE '$valcode';";
                $resultsetvalidate2 = mysqli_query($db, $querysetvalidate2);

		$queryaddstrike ="UPDATE current_strikes INNER JOIN pending_strikes_add ON current_strikes.id = pending_strikes_add.userid SET currentstrikes = currentstrikes+1;";
     		$resultaddstrike = mysqli_query($db, $queryaddstrike);

		$queryvalidatepsa ="UPDATE pending_strikes_add INNER JOIN validate_strikes_add ON  pending_strikes_add.id = validate_strikes_add.psaid SET validated = '1' WHERE validate_strikes_add.code LIKE '$valcode';";
     		$resultvalidatepsa = mysqli_query($db, $queryvalidatepsa);
			
		echo "Validation 2 wurde mit dem Code $valcode erfolgreich durchgeführt! Der Strike wurde erfolgreich validiert!";
	} else {
		if ($validated) {
		echo "Zu langsam... Strike wurde bereits validiert!";
		}
	}

	$querydelcode = "DELETE FROM validate_strikes_add WHERE code LIKE '$valcode';";
        $resultdelcode = mysqli_query($db, $querydelcode);

	}
?>
