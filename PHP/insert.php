<?php
function throwException(){
    throw new Exception('');
}

try {
    $firstname = (isset($_POST["firstname"]) && $_POST["firstname"] != '') ? $_POST["firstname"] : "-";
    $lastname = (isset($_POST["lastname"]) && $_POST["lastname"] != '') ? $_POST["lastname"] : "-";
    $street = (isset($_POST["street"]) && $_POST["street"] != '') ? $_POST["street"] : "-";
    $city = (isset($_POST["city"]) && $_POST["city"] != '') ? $_POST["city"] : "-";
    $telnr = (isset($_POST["telnr"]) && $_POST["telnr"] != '') ? $_POST["telnr"] : "-";
    $user = (isset($_POST["user"]) && $_POST["user"] != '') ? $_POST["user"] : "";

    $mysqli = new mysqli("127.0.0.1", $user, "", "adressbook");
    //check connection
    if ($mysqli->connect_error) {
        throwException();
    }

    //prepared statement with basic Exceptions on failures
    ($stmt = $mysqli->prepare("INSERT INTO person (firstname, lastname, street,city, telnr) VALUES (?, ?, ?, ?, ?)")) ? : throwException();
    ($stmt->bind_param("sssss", $firstname, $lastname, $street, $city, $telnr)) ? : throwException();
    if ($stmt->execute()) {
        echo "<tr>";
        echo "<td>Insertion successfully";
    } else {
        throwException();
    }
    $stmt->close();
}
catch(Exception $e){
    echo "<tr>";
    echo "<td>Insertion failed";
}
?>