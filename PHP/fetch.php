<?php
//check for tags and empty, if not set value, if yes set placeholder
$firstname = (isset($_POST["firstname"]) && $_POST["firstname"] != '') ? $_POST["firstname"] : "%";
$lastname = (isset($_POST["lastname"]) && $_POST["lastname"] != '') ? $_POST["lastname"] : "%";
$street = (isset($_POST["street"]) && $_POST["street"] != '') ? $_POST["street"] : "%";
$city = (isset($_POST["city"]) && $_POST["city"] != '') ? $_POST["city"] : "%";
$telnr = (isset($_POST["telnr"]) && $_POST["telnr"] != '') ? $_POST["telnr"] : "%";
$filter = (isset($_POST["filter"]) && $_POST["filter"] != '') ? $_POST["filter"] : "firstname";
$direction = (isset($_POST["direction"]) && $_POST["direction"] != '') ? $_POST["direction"] : "ASC";
$user = (isset($_POST["user"]) && $_POST["user"] != '') ? $_POST["user"] : "";


//prepare connection
$mysqli = new mysqli("127.0.0.1", $user, "", "adressbook") or die("no db found");
if($mysqli->connect_error) {
    exit('Error connecting to database');
}

//prepared statement with whitelisting
$filterWhiteList = array("firstname","lastname","street", "city", "telnr");
$directionWhiteList = array("ASC","DESC");

$filter = $filterWhiteList[array_search($filter,$filterWhiteList)];
$direction = $directionWhiteList[array_search($direction ,$directionWhiteList)];

$sql = "SELECT * FROM person WHERE firstname LIKE ? AND lastname LIKE ? AND street LIKE ? AND city LIKE ? AND telnr LIKE ? ORDER BY `person`.`$filter` $direction";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sssss", $firstname, $lastname, $street, $city, $telnr);
$stmt->execute();

$result = $stmt->get_result();
if($result->num_rows === 0) exit('No rows');
while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["firstname"];
        echo "<td>".$row["lastname"];
        echo "<td>".$row["street"];
        echo "<td>".$row["city"];
        echo "<td>".$row["telnr"];
}

$stmt->close();
?>