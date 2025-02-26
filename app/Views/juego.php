<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Adivinanza</title>
    <style>
/* Ajustes generales */
body {
    font-family: 'Arial', sans-serif;
    background-color: #181818;
    color: white;
    text-align: center;
    padding: 20px;
}

/* Estilo del título de turno */
h2 {
    margin-bottom: 10px;
    font-size: 24px;
}

/* 🔹 Estilo del temporizador */
#timer {
    font-size: 40px; /* Más grande */
    font-weight: bold;
    margin-bottom: 15px;
    background: none; /* Se quita el color de fondo */
    color: #00bcd4; /* Color azul llamativo */
    padding: 0;
    display: block;
}

/* 🔹 Ubicación del botón "Pasar Turno" debajo del contador */
#pasar-turno {
    display: block;
    margin: 10px auto 20px;
}

/* Estilo de los botones */
button {
    background-color: #00bcd4;
    color: white;
    border: none;
    padding: 10px 15px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    transition: background 0.3s;
}

button:hover {
    background-color: #00a4bb;
}

/* 🔹 Contenedor del juego */
.game-container {
    display: flex;
    justify-content: space-between;
    width: 80%;
    margin: auto;
    border: 2px solid #fff;
    padding: 20px;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.1);
}

/* Secciones de los jugadores */
.player-section {
    width: 50%;
    padding: 20px;
}

/* Línea divisoria */
.divider {
    width: 2px;
    background: white;
    height: 100%;
}

/* 🔹 Área de notas (No se puede redimensionar) */
textarea {
    width: 100%;
    height: 80px;
    background: #222;
    color: white;
    border: 1px solid #444;
    padding: 10px;
    border-radius: 5px;
    resize: none; /* Evita que se pueda agrandar */
}

/* 🔹 Inputs de búsqueda */
input {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #444;
    background: #222;
    color: white;
    border-radius: 5px;
    position: relative;
}

.suggestions {
    position: absolute;
    background: white;
    color: black;
    width: calc(104% - 2px); /* Coincide con el input */
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    max-height: 200px;
    overflow-y: auto;
    display: none;
    text-align: left;
    z-index: 1000;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Ajuste del ancho de las sugerencias */
.input-container {
    position: relative;
}
.suggestions div {
    padding: 10px;
    cursor: pointer;
    border-bottom: 1px solid #ddd;
}

.suggestions div:hover {
    background: #00bcd4;
    color: white;
}

/* Modal de victoria */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: white;
    color: black;
    padding: 20px;
    text-align: center;
    border-radius: 10px;
    width: 300px;
}

.modal-content h2 {
    font-size: 22px;
    margin-bottom: 10px;
}

.modal button {
    display: block;
    width: 100%;
    margin-top: 10px;
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
    let equipo1 = sessionStorage.getItem("equipo1") || "Equipo Desconocido";
    let equipo2 = sessionStorage.getItem("equipo2") || "Equipo Desconocido";

    let turno = 1;
    let chances = { 1: 3, 2: 3 };
    let tiempo = 60;
    let intervalo;

    function actualizarTurno() {
        document.getElementById("turno-texto").innerText = `Turno de: Jugador ${turno}`;
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
            if (tiempo <= 0) {
                limpiarInputYSugerencias();
                cambiarTurno();
            }
        }, 1000);
    }

    function limpiarInputYSugerencias() {
        let input = document.getElementById(`busqueda-equipo${turno}`);
        let sugerencias = document.getElementById(`sugerencias${turno}`);
        input.value = "";
        sugerencias.innerHTML = "";
        sugerencias.style.display = "none";
    }

    function cambiarTurno() {
        limpiarInputYSugerencias();
        turno = turno === 1 ? 2 : 1;
        actualizarTurno();
        iniciarTemporizador();
    }

    function detenerTemporizador() {
    clearInterval(intervalo);
    document.getElementById("timer").innerText = "60";
}

    function verificarDerrota() {
        if (chances[1] === 0 && chances[2] === 0) {
            detenerTemporizador();
            mostrarModalPerdieron();
        }
    }

    function mostrarModalPerdieron() {
        detenerTemporizador();
        const modal = document.createElement("div");
        modal.classList.add("modal");
        modal.style.display = "flex";
        modal.innerHTML = `
            <div class="modal-content">
                <h2>¡Han perdido!</h2>
                <p>Los equipos eran:</p>
                <p><strong>Jugador 1:</strong> ${equipo1}</p>
                <p><strong>Jugador 2:</strong> ${equipo2}</p>
                <button onclick="window.location.href='seleccion-equipos'">Jugar de nuevo</button>
                <button onclick="window.location.href='home'">Ir al inicio</button>
            </div>
        `;
        document.body.appendChild(modal);
    }

    function manejarEnvio(jugador) {
        if (jugador !== turno) return;

        let inputField = document.getElementById(`busqueda-equipo${jugador}`);
        let input = inputField.value.trim();
        let equipoCorrecto = jugador === 1 ? equipo2 : equipo1;

        if (input.toLowerCase() === equipoCorrecto.toLowerCase()) {
            mostrarModalGanador(jugador, equipoCorrecto);
        } else {
            chances[jugador] = Math.max(0, chances[jugador] - 1);
            document.getElementById(`chances${jugador}`).innerText = chances[jugador];
            limpiarInputYSugerencias();
            verificarDerrota();
            cambiarTurno();
        }
    }

    function mostrarModalGanador(jugador, equipo) {
        detenerTemporizador();
        const modal = document.createElement("div");
        modal.classList.add("modal");
        modal.innerHTML = `
            <div class="modal-content">
                <h2>¡Jugador ${jugador} ha ganado!</h2>
                <p>El equipo correcto era: <strong>${equipo}</strong></p>
                <button onclick="window.location.href='seleccion-equipos'">Jugar de nuevo</button>
                <button onclick="window.location.href='home'">Ir al inicio</button>
            </div>
        `;
        document.body.appendChild(modal);
        modal.style.display = "flex";
    }

    document.getElementById("pasar-turno").addEventListener("click", cambiarTurno);
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
