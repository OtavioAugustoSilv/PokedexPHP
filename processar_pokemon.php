<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "pokemons";

$conn = new mysqli($hostname, $username, $password, $database);


if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
function enviarDadosPoke($conn, $name, $types, $nextEvolve, $imageLink){
    $query = $conn->prepare("INSERT INTO pokemons VALUES (null, ?, ?, ?, ?);");

    $query->bind_param("ssss", $name, $types,$nextEvolve, $imageLink);
    if ($query->execute()) {
         header('Location: pokemon.php');
    }
    $query->close();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $type1 = $_POST['type1'];
    $type2 = $_POST['type2'];
    $type = array($type1, $type2);
    
    $types= json_encode($type);
    $tipos = json_decode($types, true);
    $nextEvolve = $_POST['nextEvolve'];
    $imageLink = $_POST['imageLink'];

    $evolutions = [];
    for ($i = 1; $i <= $nextEvolve; $i++) {
        if (isset($_POST["evolution$i"])) {
            $evolutions[] = $_POST["evolution$i"];
        }
    }
    $evolutions = json_encode($evolutions);
     enviarDadosPoke($conn, $name, $types, $evolutions, $imageLink);
}
?>
