<?php
include 'buscarPokemon.php';
$pokemons = json_decode(file_get_contents("http://canalti.com.br/api/pokemons.json"));
$pokemonsBd = array();

$buscador = new Buscador();

$pokemonsBD = $buscador->buscarDadosPoke();
$pokemon = array();
foreach ($pokemonsBD as $poke) {
    
    array_push($pokemonsBd, $poke);
}




$pokemonCount = count($pokemonsBd);
$pokemonCount += count($pokemons->pokemon);
$evolutionCount = 0;
// Verifica se houve uma submissão de pesquisa
$searchResults = [];
$searchResultsApi = [];
$suggestions = [];

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    foreach ($pokemonsBD as $pokemon) {
        // Verifica se o nome do Pokémon contém o termo de pesquisa
        if (stripos($pokemon['nome'], $searchTerm) !== false) {
            $searchResults[] = $pokemon;
        }
        // Cria sugestões com base no nome do Pokémon
        if (stripos($pokemon['nome'], $searchTerm) !== false) {
            $suggestions[] = $pokemon['nome'];
        }
    }
    foreach ($pokemons->pokemon as $obj) {
        // Verifica se o nome do Pokémon contém o termo de pesquisa
        if (stripos($obj->name, $searchTerm) !== false) {
            $searchResultsApi[] = $obj;
        }
        // Cria sugestões com base no nome do Pokémon
        if (stripos($obj->name, $searchTerm) !== false) {
            $suggestions[] = $obj->name;
        }
    }
} else {
    // Se não houver pesquisa, mostra todos os Pokémon
    $searchResults = $pokemonsBd;
    $searchResultsApi = $pokemons->pokemon;
    
}

$pokemonCount = count($searchResults);
$evolutionCount = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Cards</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(to right, #f44336, #d32f2f); /* Fundo gradiente */
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            max-width: 1200px;
            background-color: #fff;
            padding: 60px 20px 20px 20px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border: 10px solid gray; /* Borda para parecer uma Pokédex */
            position: relative;
        }
        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 2px 2px 12px rgba(0, 0, 0, 0.1);
            padding: 16px;
            margin: 20px;
            width: 300px;
            text-align: center;
            display: inline-block;
            vertical-align: top;
            background-color: #fff;
            transition: transform 0.2s, box-shadow 0.2s;
            position: relative;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 4px 4px 20px rgba(0, 0, 0, 0.2);
        }
        .card img {
            margin-top:30px;
            width: 200px;
            height: auto;
            border-radius: 8px;
        }
        .card p {
            margin: 8px 2px;
        }
        .types {
            position: absolute;
            top: 60px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 8px;
            padding: 4px 0;
        }
        .type {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            color: #fff;
        }
        .type.Fire { background-color: #f08030; }
        .type.Water { background-color: #6890f0; }
        .type.Grass { background-color: #78c850; }
        .type.Electric { background-color: #f8d030; }
        .type.Psychic { background-color: #f85888; }
        .type.Ice { background-color: #98d8d8; }
        .type.Dragon { background-color: #7038f8; }
        .type.Dark { background-color: #705848; }
        .type.Fairy { background-color: #ee99ac; }
        .type.Normal { background-color: #a8a878; }
        .type.Fighting { background-color: #c03028; }
        .type.Flying { background-color: #a890f0; }
        .type.Poison { background-color: #a040a0; }
        .type.Ground { background-color: #e0c068; }
        .type.Rock { background-color: #b8a038; }
        .type.Bug { background-color: #a8b820; }
        .type.Ghost { background-color: #705898; }
        .type.Steel { background-color: #b8b8d0; }
        /* Extra Pokédex Design Elements */
        .pokedex-top {
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 80px;
            background-color: #f44336;
            border-radius: 50%;
            border: 5px solid #fff;
        }
        .pokedex-light {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 20px;
            background-color: #ffeb3b;
            border-radius: 50%;
            box-shadow: 0 0 10px #ffeb3b;
        }
        .search-form {
            margin-top:20px;
            margin-bottom: 20px;
            text-align: center;
            width: 100%;
        }
        .search-input {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
            width: 300px;
            max-width: 100%;
        }
        .search-button {
            padding: 8px 16px;
            border: none;
            background-color: #f44336;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }
        .search-button:hover {
            background-color: #d32f2f;
        }
        .back-button {
            margin-top: 20px;
            text-align: center;
            width: 100%;
        }
        .back-button a {
            padding: 8px 16px;
            border: none;
            background-color: #4caf50;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
        }
        .back-button a:hover {
            background-color: #388e3c;
        }

        .newPoke{
            border-radius:10px;
            background-color:#4caf50;
            color:white;
            border:none;
            padding:10px;
            position:fixed;
            top:90%;
            right:5%;
           
        }
    </style>
    <script>
        // Função para enviar a solicitação de sugestões com base no que o usuário digita
        function getSuggestions(str) {
            if (str.length == 0) {
                document.getElementById("suggestions").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("suggestions").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "get_suggestions.php?q=" + str, true);
                xmlhttp.send();
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="pokedex-top"></div>
        <div class="pokedex-light"></div>
        <div class="search-form">
            <form method="get" action="">
                <input type="text" name="search" class="search-input" placeholder="Search Pokémon..." onkeyup="getSuggestions(this.value)">
                <button type="submit" class="search-button">Search</button>
            </form>
            <!-- Sugestões de pesquisa -->
            <div id="suggestions"></div>
        </div>
        <?php
        
        foreach($searchResultsApi as $Pokemon){
            echo '<div class="card">';
            echo '<h2>' . $Pokemon->name . '</h2>';
            echo '<div class="types">';
            foreach ($Pokemon->type as $type) {
                echo '<p class="type ' . $type . '">' . $type . '</p>';
            }
            echo '</div>';
            echo "<img src='" . $Pokemon->img . "'> ";

            if (isset($Pokemon->next_evolution)) {
                echo '<p><strong>Next Evolutions:</strong></p>';
                foreach ($Pokemon->next_evolution as $evolution) {
                    echo '<p>' . $evolution->name . '</p>';
                    $evolutionCount++;
                }
            }
            echo '</div>';
        }
        foreach($searchResults as $pokemon) {
            echo '<div class="card">';
            echo '<h2>' . $pokemon['nome'] . '</h2>';
            echo '<div class="types">';
            foreach (json_decode($pokemon['tipos'],true) as $type) {
                echo '<p class="type ' . $type . '">' . $type . '</p>';
            }
            echo '</div>';
            echo "<img src='" . $pokemon['img'] . "'> ";

            if (isset($pokemon['NextEvolve'])) {
                echo '<p><strong>Next Evolutions:</strong></p>';
                foreach (json_decode($pokemon['NextEvolve'], true) as $evolution) {
                    echo '<p>' . $evolution . '</p>';
                    $evolutionCount++;
                }
            }
            echo '</div>';
        }
        ?>
        <?php if (isset($_GET['search'])): ?>
        <div class="back-button">
            <a href="pokemon.php" class="back-link">Back to All Pokémon</a>
        </div>
        <?php endif; ?>
    </div>
    <div>
        <a href="cadastroPoke.php"><button class="newPoke">Adicionar novo pokemon</button></a>
    </div>
</body>
</html>
