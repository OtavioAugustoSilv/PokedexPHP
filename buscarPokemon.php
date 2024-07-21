<?php
class Buscador{
function buscarDadosPoke(){

$hostname = "localhost";
$username = "root";
$password = "";
$database = "pokemons";


$conn = new mysqli($hostname, $username, $password, $database);



if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

    $query = $conn->prepare("SELECT * FROM pokemons");
    $query->execute();
    $result = $query->get_result();

    
    $resultado = array();
    while ($poke = $result->fetch_assoc()) {
        array_push($resultado, $poke);
    }
    return $resultado;
    $query->close();
}
}

?>