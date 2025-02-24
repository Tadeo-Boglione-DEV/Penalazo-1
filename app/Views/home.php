<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/inicio.css">
    <link rel="shortcut icon" href="./img/logo.png">
    <title>Penalazo</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #000; /* Alternativa si la imagen no carga */
    background-image: url('./img/460493284.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed; /* Mantiene el fondo fijo */
    color: #fff;
    margin: 0;
    padding: 0;
    text-align: center;
}

/* BARRA CELESTE CENTRADA */
.header-bar {
    top: 135px;
    width: 45vw; /* Mantiene el tamaño relativo a la pantalla */
    max-width: 700px; /* Evita que sea demasiado grande en pantallas grandes */
    height: 15px;
    background-color: #60c0f9;
    border-radius: 10px;  
    position: absolute; /* Se mantiene dentro del header */
    bottom: 0; /* Se ajusta a la parte inferior del header */
    left: 50%;
    transform: translateX(-50%); /* Centra horizontalmente */   
    z-index: 1000; /* Se asegura de que esté sobre otros elementos */
}
    </style>
</head>
<body>    
    <!-- HEADER -->
    <?= view('Includes/Header') ?>
    <!-- MAIN -->
    <main class="main-container">
        <div class="banner">ACCEDE A NUESTROS MINIJUEGOS</div>
        <div class="games-container">
            <div class="game-card">
                <h2>¿QUIÉN ES QUIÉN?</h2>
                <img src="./img/pedri.jpg" alt="¿Quién es quién?">
                <a href="quien">
                <button class="play-btn">JUGAR</button>
                </a>
                <p>¿No sabes cómo se juega?<br><a href="#">Lee las reglas</a></p>
            </div>
            <div class="game-card">
                <h2>MENTIROSO</h2>
                <img src="./img/wirtz.jpg" alt="Mentiroso">
                <a href="mentiroso">
                <button class="play-btn">JUGAR</button>
                </a>
                <p>¿No sabes cómo se juega?<br><a href="#">Lee las reglas</a></p>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <?= view('Includes/Footer') ?>
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
