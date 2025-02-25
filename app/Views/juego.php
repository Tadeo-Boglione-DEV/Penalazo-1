<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Adivinanza</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .game-container {
            display: flex;
            justify-content: space-between;
            width: 80%;
            margin: auto;
            border: 2px solid white;
            padding: 20px;
        }
        .player-section {
            width: 50%;
            padding: 20px;
        }
        .divider {
            width: 2px;
            background: white;
            height: 100%;
        }
        .input-container {
            position: relative;
        }
        .suggestions {
            position: absolute;
            background: white;
            color: black;
            width: 100%;
            border: 1px solid #ccc;
            max-height: 200px;
            overflow-y: auto;
            display: none;
            text-align: left;
            z-index: 1000;
        }
    </style>
</head>
<body>

<h2 id="turno-texto">Turno de: Jugador 1</h2>
<div id="timer">60</div>
<button id="pasar-turno">Pasar Turno</button>

<div class="game-container">
    <div class="player-section" id="jugador1">
        <h2>Jugador 1</h2>
        <p>Anotar:</p>
        <textarea id="notas1"></textarea>
        <div class="input-container">
            <input type="text" id="busqueda-equipo1" placeholder="Escribe el equipo">
            <div id="sugerencias1" class="suggestions"></div>
        </div>
        <button id="enviar1">Enviar</button>
        <p>Oportunidades de arriesgar: <span id="chances1">3</span>/3</p>
    </div>

    <div class="divider"></div>

    <div class="player-section" id="jugador2">
        <h2>Jugador 2</h2>
        <p>Anotar:</p>
        <textarea id="notas2"></textarea>
        <div class="input-container">
            <input type="text" id="busqueda-equipo2" placeholder="Escribe el equipo">
            <div id="sugerencias2" class="suggestions"></div>
        </div>
        <button id="enviar2">Enviar</button>
        <p>Oportunidades de arriesgar: <span id="chances2">3</span>/3</p>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let equipo1 = sessionStorage.getItem("equipo1");
    let equipo2 = sessionStorage.getItem("equipo2");

    let turno = 1;
    let chances = { 1: 3, 2: 3 };
    let tiempo = 60;
    let intervalo;

    function actualizarTurno() {
        document.getElementById("turno-texto").innerText = `Turno de: Jugador ${turno}`;
        
        // Habilitar el botón del jugador en turno y deshabilitar el otro
        document.getElementById("enviar1").disabled = turno !== 1;
        document.getElementById("enviar2").disabled = turno !== 2;
    }

    function iniciarTemporizador() {
        if (intervalo) clearInterval(intervalo);
        tiempo = 60;
        document.getElementById("timer").innerText = tiempo;
        intervalo = setInterval(() => {
            tiempo--;
            document.getElementById("timer").innerText = tiempo;
            if (tiempo <= 0) cambiarTurno();
        }, 1000);
    }

    function cambiarTurno() {
        turno = turno === 1 ? 2 : 1;
        actualizarTurno();
        iniciarTemporizador();
    }

    document.getElementById("pasar-turno").addEventListener("click", cambiarTurno);

    function manejarEnvio(jugador) {
        if (jugador !== turno) return; // Bloquear intentos fuera de turno

        let inputField = document.getElementById(`busqueda-equipo${jugador}`);
        let input = inputField.value.trim();
        let equipoCorrecto = jugador === 1 ? equipo2 : equipo1; // Adivina el equipo del rival

        if (input.toLowerCase() === equipoCorrecto.toLowerCase()) {
            alert(`¡Jugador ${jugador} adivinó correctamente!`);
            cambiarTurno();
        } else {
            chances[jugador] = Math.max(0, chances[jugador] - 1); // No bajar de 0
            document.getElementById(`chances${jugador}`).innerText = chances[jugador];
            inputField.value = ""; // Borrar input si falla
            cambiarTurno(); // Pasar turno al fallar
        }
    }

    document.getElementById("enviar1").addEventListener("click", () => manejarEnvio(1));
    document.getElementById("enviar2").addEventListener("click", () => manejarEnvio(2));

    function configurarAutocompletado(inputId, sugerenciasId) {
        let inputBusqueda = document.getElementById(inputId);
        let listaSugerencias = document.getElementById(sugerenciasId);

        inputBusqueda.addEventListener("input", function() {
            let query = inputBusqueda.value.trim();
            if (query.length >= 2) {
                fetch(`http://localhost:8080/api/buscarEquipos?nombre=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        listaSugerencias.innerHTML = "";
                        listaSugerencias.style.display = data.length > 0 ? "block" : "none";

                        data.forEach(equipo => {
                            let div = document.createElement("div");
                            div.innerHTML = `<strong>${equipo.nombre}</strong>, ${equipo.pais || "Desconocido"}`;
                            div.addEventListener("click", function() {
                                inputBusqueda.value = `${equipo.nombre}, ${equipo.pais}`;
                                listaSugerencias.style.display = "none";
                            });
                            listaSugerencias.appendChild(div);
                        });
                    })
                    .catch(error => console.error("Error al buscar equipos:", error));
            } else {
                listaSugerencias.style.display = "none";
            }
        });
    }

    configurarAutocompletado("busqueda-equipo1", "sugerencias1");
    configurarAutocompletado("busqueda-equipo2", "sugerencias2");
    actualizarTurno();
    iniciarTemporizador();
});
</script>



</body>
</html>
