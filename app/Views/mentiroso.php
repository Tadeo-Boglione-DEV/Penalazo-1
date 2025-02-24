<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/mentiroso.css">
    <link rel="stylesheet" href="./css/inicio.css">
    <link rel="shortcut icon" href="./img/logo.png">
    <title>Mentiroso</title>
</head>
<body>
    <?= view('Includes/Header') ?>

    <div class="game-selection">
        <div class="game-option">
            <h2 class="game-title">Jugar Local</h2>
            <img src="./img/lautaro.jpg" alt="Jugar Local" class="game-image">
            <button class="play-button" onclick="openModal()">JUGAR</button>
        </div>
        <div class="game-option">
            <h2 class="game-title">Multijugador</h2>
            <img src="./img/leao.jpg" alt="Multijugador" class="game-image">
            <button class="play-button" onclick="openModal()">JUGAR</button>
        </div>
    </div>

    <?= view('Includes/Footer') ?>

    <script>
        function openModal() {
            document.getElementById("gameModal").style.display = "flex";
            document.body.classList.add("modal-open");
        }

        function closeModal() {
            document.getElementById("gameModal").style.display = "none";
            document.body.classList.remove("modal-open");
        }
    </script>

    <script>
        function toggleLogo(element) {
            const img = element.querySelector('.logo-img');
            element.classList.toggle('flipped');
            setTimeout(() => {
                img.src = element.classList.contains('flipped') ? './img/logo2.png' : './img/logo.png';
            }, 250);
        }
    </script>
</body>
</html>
