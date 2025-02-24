<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/quien.css">
    <link rel="stylesheet" href="./css/inicio.css">
    <link rel="shortcut icon" href="./img/logo.png">
    <title>¿Quién es Quién?</title>
    <style>
        /* Botones en línea y más pequeños */
        .multiplayer-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 10px;
        }

        .multiplayer-buttons .play-button {
            padding: 10px 10px;
            font-size: 14px;
            background-color: #00aaff;
            border: none;
            color: white;
            cursor: pointer;
            transition: 0.3s;
            border-radius: 5px;
        }

        .multiplayer-buttons .play-button:hover {
            background-color: #0088cc;
        }

        /* Estilo del input */
        .room-input {
            width: 10%;
            padding: 8px;
            font-size: 16px;
            border: 2px solid #00aaff;
            border-radius: 5px;
            text-align: center;
            margin-top: 10px;
        }

        /* Minilista de códigos */
        .room-input::placeholder {
            color: #aaa;
            text-align: center;
        }

        .suggested-codes {
            margin-top: 5px;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>

<body>
    <?= view('Includes/Header') ?>

    <div class="game-selection">
    <!-- Jugar Local -->
    <div class="game-option">
        <h2 class="game-title">Jugar Local</h2>
        <img src="./img/lamine.jpg" alt="Jugar Local" class="game-image">
        <button class="play-button" onclick="openLocalModal()">JUGAR</button>
    </div>

    <!-- Multijugador -->
    <div class="game-option">
        <h2 class="game-title">Multijugador</h2>
        <img src="./img/vini.jpg" alt="Multijugador" class="game-image">
        <button class="play-button" onclick="openMultiplayerGameModal()">JUGAR</button>
    </div>
</div>

<!-- MODAL PARA JUEGO LOCAL -->
<div id="localGameModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeLocalModal()">&times;</span>
        <h2>Selecciona un modo de juego:</h2>

        <div class="game-option">
            <h3>Equipos</h3>
            <img src="./img/realmadrid.png" alt="Equipos" class="game-image">
            <button class="play-button">JUGAR</button>
        </div>

        <div class="game-option">
            <h3>Jugadores Retirados</h3>
            <img src="./img/diego.png" alt="Jugadores Retirados" class="game-image">
            <button class="play-button">JUGAR</button>
        </div>

        <div class="game-option">
            <h3>Jugadores Actuales</h3>
            <img src="./img/kevin.png" alt="Jugadores Actuales" class="game-image">
            <button class="play-button">JUGAR</button>
        </div>
    </div>
</div>

<!-- MODAL PARA SELECCIÓN DE MODO EN MULTIJUGADOR -->
<div id="multiplayerGameModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeMultiplayerGameModal()">&times;</span>
        <h2>Selecciona un modo de juego:</h2>

        <div class="game-option">
            <h3>Equipos</h3>
            <img src="./img/realmadrid.png" alt="Equipos" class="game-image">
            <button class="play-button" onclick="chooseMultiplayerMode('equipos')">JUGAR</button>
        </div>

        <div class="game-option">
            <h3>Jugadores Retirados</h3>
            <img src="./img/diego.png" alt="Jugadores Retirados" class="game-image">
            <button class="play-button" onclick="chooseMultiplayerMode('retirados')">JUGAR</button>
        </div>

        <div class="game-option">
            <h3>Jugadores Actuales</h3>
            <img src="./img/kevin.png" alt="Jugadores Actuales" class="game-image">
            <button class="play-button" onclick="chooseMultiplayerMode('actuales')">JUGAR</button>
        </div>
    </div>
</div>

<!-- MODAL PARA MULTIJUGADOR (CREAR O UNIRSE A UNA SALA) -->
<div id="multiplayerModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeMultiplayerModal()">&times;</span>
        <div id="multiplayerOptions" class="multiplayer-buttons">
            <button class="play-button" onclick="createRoom()">Crear Sala</button>
            <button class="play-button" onclick="joinRoom()">Unirse a Sala</button>
        </div>
        <div id="roomContent"></div>
    </div>
</div>

    <!-- FOOTER -->
    <?= view('Includes/Footer') ?>

<script>
    // 🏠 MODAL JUEGO LOCAL
    function openLocalModal() {
        document.getElementById("localGameModal").style.display = "flex";
        document.body.classList.add("modal-open");
    }

    function closeLocalModal() {
        document.getElementById("localGameModal").style.display = "none";
        document.body.classList.remove("modal-open");
    }

    // 🌍 MODAL SELECCIÓN DE MODO MULTIJUGADOR
    function openMultiplayerGameModal() {
        document.getElementById("multiplayerGameModal").style.display = "flex";
        document.body.classList.add("modal-open");
    }

    function closeMultiplayerGameModal() {
        document.getElementById("multiplayerGameModal").style.display = "none";
        document.body.classList.remove("modal-open");
    }

    // 🔄 ELEGIR MODO DE JUEGO Y ABRIR MODAL DE SALAS
    function chooseMultiplayerMode(mode) {
        console.log("Modo seleccionado:", mode); // Opcional: para verificar en la consola
        closeMultiplayerGameModal(); // Cierra el modal de selección de modo
        openMultiplayerModal(); // Abre el modal para crear/unirse a una sala
    }

    // 🌍 MODAL MULTIJUGADOR (SALAS)
    function openMultiplayerModal() {
        document.getElementById("multiplayerModal").style.display = "flex";
        document.body.classList.add("modal-open");
    }

    function closeMultiplayerModal() {
        document.getElementById("multiplayerModal").style.display = "none";
        document.getElementById("roomContent").innerHTML = "";
        document.getElementById("multiplayerOptions").style.display = "flex";
        document.body.classList.remove("modal-open");
    }

    // 🔢 CREAR SALA
    function createRoom() {
        let roomCode = Math.floor(1000 + Math.random() * 9000);
        document.getElementById("multiplayerOptions").style.display = "none";
        document.getElementById("roomContent").innerHTML = `
            <h3>Código de la Sala:</h3>
            <h2>${roomCode}</h2>
        `;
    }

    // 🎟️ UNIRSE A UNA SALA
    function joinRoom() {
        document.getElementById("multiplayerOptions").style.display = "none";
        document.getElementById("roomContent").innerHTML = `
            <h3>Ingresa el código de la Sala:</h3>
            <input type="text" class="room-input" placeholder="Ej: 9436">
        `;
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
