<?php
// index.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Pokemon</title>
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
        .cadastro {
            padding: 20px;
        }
        .cadastro label, input, select {
            margin: 20px;
        }
        .enviar{
            margin-left: 50%;
            transform: translateX(-50%);
            background-color: #4caf50;
            color: white;
            border-radius: 10px;
            border: none;
            padding: 10px;
        }
        .image-preview {
            margin-top: 20px;
            text-align: center;
        }
        .image-preview img {
            width: 200px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }
        .evolucao {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="pokedex-top"></div>
        <div class="pokedex-light"></div>
        <form action="processar_pokemon.php" class="cadastro" method="post">
            <label for="name">Nome</label>
            <input type="text" name="name">
            <br>
            <label for="type1">Tipo 1</label>
            <select name="type1" class="type">
                <option value="Fire">Fire</option>
                <option value="Water">Water</option>
                <option value="Grass">Grass</option>
                <option value="Electric">Electric</option>
                <option value="Psychic">Psychic</option>
                <option value="Ice">Ice</option>
                <option value="Dragon">Dragon</option>
                <option value="Dark">Dark</option>
                <option value="Fairy">Fairy</option>
                <option value="Normal">Normal</option>
                <option value="Fighting">Fighting</option>
                <option value="Flying">Flying</option>
                <option value="Poison">Poison</option>
                <option value="Ground">Ground</option>
                <option value="Rock">Rock</option>
                <option value="Bug">Bug</option>
                <option value="Ghost">Ghost</option>
                <option value="Steel">Steel</option>
            </select>
            <label for="type2">Tipo 2 (opcional)</label>
            <select name="type2" class="type">
                <option value=""></option>
                <option value="Fire">Fire</option>
                <option value="Water">Water</option>
                <option value="Grass">Grass</option>
                <option value="Electric">Electric</option>
                <option value="Psychic">Psychic</option>
                <option value="Ice">Ice</option>
                <option value="Dragon">Dragon</option>
                <option value="Dark">Dark</option>
                <option value="Fairy">Fairy</option>
                <option value="Normal">Normal</option>
                <option value="Fighting">Fighting</option>
                <option value="Flying">Flying</option>
                <option value="Poison">Poison</option>
                <option value="Ground">Ground</option>
                <option value="Rock">Rock</option>
                <option value="Bug">Bug</option>
                <option value="Ghost">Ghost</option>
                <option value="Steel">Steel</option>
            </select>
            <br>
            <label for="nextEvolve">Próximas Evoluções (caso não possua deixe 0)</label>
            <select name="nextEvolve" id="nextEvolve">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
            <div id="evolutionInfo" class="evolucao"></div>
            <br>
            <label for="imageLink">Link da Imagem</label>
            <input type="text" name="imageLink" id="imageLink">
            <br>
            <div class="image-preview" id="imagePreview">
                <a href="" target="_blank" id="imageLinkPreview">
                    <img src="" alt="Pré-visualização da imagem" style="display: none;">
                </a>
            </div>
            <input type="submit" class="enviar" value="Enviar">
        </form>
    </div>

    <script>
        document.getElementById('imageLink').addEventListener('input', function(event) {
            const link = event.target.value;
            const preview = document.getElementById('imagePreview');
            const img = preview.querySelector('img');
            const imageLinkPreview = document.getElementById('imageLinkPreview');

            if (link) {
                img.src = link;
                img.style.display = 'block';
                imageLinkPreview.href = link;
            } else {
                img.src = '';
                img.style.display = 'none';
                imageLinkPreview.href = '';
            }
        });

        document.getElementById('nextEvolve').addEventListener('change', function(event) {
            const count = parseInt(event.target.value);
            const evolutionInfo = document.getElementById('evolutionInfo');
            evolutionInfo.innerHTML = ''; // Clear previous evolution info

            for (let i = 1; i <= count; i++) {
                const label = document.createElement('label');
                label.textContent = `Evolução ${i}`;
                const input = document.createElement('input');
                input.type = 'text';
                input.name = `evolution${i}`;
                evolutionInfo.appendChild(label);
                evolutionInfo.appendChild(input);
                evolutionInfo.appendChild(document.createElement('br'));
            }
        });
    </script>
</body>
</html>
