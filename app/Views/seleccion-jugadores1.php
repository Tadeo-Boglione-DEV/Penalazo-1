<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selección de Jugadores Retirados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .container {
            max-width: 400px;
            margin: auto;
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

        input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }

        .suggestions div {
            padding: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #ddd;
        }

        .suggestions div:hover {
            background: #007BFF;
            color: white;
        }

        .player-img {
            width: 30px;
            height: 30px;
            margin-right: 10px;
            border-radius: 50%;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 id="titulo-jugador">Jugador 1, elige un jugador retirado</h2>
    <input type="text" id="busqueda-jugador" placeholder="Escribe el nombre del jugador">
    <div id="sugerencias" class="suggestions"></div>
    <button id="btn-listo" disabled>Listo</button>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const inputBusqueda = document.getElementById("busqueda-jugador");
    const listaSugerencias = document.getElementById("sugerencias");
    const botonListo = document.getElementById("btn-listo");
    const tituloJugador = document.getElementById("titulo-jugador");

    let jugador1 = "";
    let jugador2 = "";
    let turnoJugador = 1; // 1 = Jugador 1, 2 = Jugador 2

    inputBusqueda.addEventListener("input", function() {
        let query = inputBusqueda.value.trim();
        
        if (query.length >= 2) {
            fetch(`http://localhost:8080/api/buscarJugadoresRetirados?nombre=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    listaSugerencias.innerHTML = "";
                    listaSugerencias.style.display = data.length > 0 ? "block" : "none";

                    if (data.length === 0) {
                        listaSugerencias.innerHTML = "<div>No hay resultados</div>";
                        return;
                    }

                    data.forEach(jugador => {
    let div = document.createElement("div");

    let img = document.createElement("img");
    img.src = jugador.imagen ? jugador.imagen : "/uploads/jugadores/default.jpg"; 
    img.classList.add("player-img");

    // ✅ Ocultar imagen si no carga
    img.onerror = function() {
        this.style.display = "none";
    };

    div.appendChild(img);
    div.innerHTML += `<strong>${jugador.nombre}</strong> (${jugador.posicion}), ${jugador.nacionalidad}`;

    div.addEventListener("click", function() {
        inputBusqueda.value = `${jugador.nombre} (${jugador.posicion}), ${jugador.nacionalidad}`;
        listaSugerencias.style.display = "none";
        botonListo.disabled = false;
    });

    listaSugerencias.appendChild(div);
});

                })
                .catch(error => {
                    console.error("❌ Error al buscar jugadores:", error);
                    listaSugerencias.innerHTML = `<div style="color: red;">Error al cargar jugadores</div>`;
                    listaSugerencias.style.display = "block";
                });
        } else {
            listaSugerencias.style.display = "none";
            botonListo.disabled = true;
        }
    });

    // 📌 Lógica para cambiar de jugador y luego iniciar el juego
    botonListo.addEventListener("click", function() {
        let jugadorSeleccionado = inputBusqueda.value.trim();
        if (turnoJugador === 1) {
            jugador1 = jugadorSeleccionado;
            turnoJugador = 2;
            tituloJugador.innerText = "Jugador 2, elige un jugador retirado";
            inputBusqueda.value = "";
            botonListo.disabled = true;
        } else {
            jugador2 = jugadorSeleccionado;

            // 📌 Ir a la vista de juego con los jugadores seleccionados
            window.location.href = `juego.html?jugador1=${encodeURIComponent(jugador1)}&jugador2=${encodeURIComponent(jugador2)}`;
        }
    });

    document.addEventListener("click", function(event) {
        if (!inputBusqueda.contains(event.target) && !listaSugerencias.contains(event.target)) {
            listaSugerencias.style.display = "none";
        }
    });
});
</script>

</body>
</html>
