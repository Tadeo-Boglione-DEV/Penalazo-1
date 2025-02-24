<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selección de Equipos</title>
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
    position: relative; /* 👈 Agregado */
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
    z-index: 1000; /* 👈 Asegura que aparezca encima de otros elementos */
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

        .flag {
            width: 20px;
            height: 15px;
            margin-right: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 id="titulo-jugador">Jugador 1, elige tu equipo</h2>
    <input type="text" id="busqueda-equipo" placeholder="Escribe el nombre del equipo">
    <div id="sugerencias" class="suggestions"></div>
    <button id="btn-listo" disabled>Listo</button>
</div>


<script>
document.addEventListener("DOMContentLoaded", function() {
    const inputBusqueda = document.getElementById("busqueda-equipo");
    const listaSugerencias = document.getElementById("sugerencias");
    const botonListo = document.getElementById("btn-listo");
    const tituloJugador = document.getElementById("titulo-jugador");

    let equipoJugador1 = "";
    let equipoJugador2 = "";
    let turnoJugador = 1; // 1 = Jugador 1, 2 = Jugador 2

    inputBusqueda.addEventListener("input", function() {
        let query = inputBusqueda.value.trim();
        
        if (query.length >= 2) {
            fetch(`http://localhost:8080/api/buscarEquipos?nombre=${encodeURIComponent(query)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Error HTTP: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    listaSugerencias.innerHTML = "";
                    listaSugerencias.style.display = data.length > 0 ? "block" : "none";

                    if (data.length === 0) {
                        listaSugerencias.innerHTML = "<div>No hay resultados</div>";
                        return;
                    }

                    data.forEach(equipo => {
                        let div = document.createElement("div");

                        // 📌 URL del escudo del equipo
                        let escudoSrc = equipo.imagen 
                            ? equipo.imagen  
                            : "/uploads/equipos/default.jpg"; 

                        let img = document.createElement("img");
                        img.src = escudoSrc;
                        img.classList.add("escudo");
                        img.style.width = "30px";
                        img.style.height = "30px";
                        img.style.marginRight = "10px";

                        // 🚨 Oculta imágenes rotas
                        img.onerror = function() {
                            this.style.display = "none";
                        };

                        div.appendChild(img);
                        div.innerHTML += `<strong>${equipo.nombre}</strong>, ${equipo.pais || "Desconocido"}`;

                        div.addEventListener("click", function() {
                            // ✅ Nombre y país en el input
                            inputBusqueda.value = `${equipo.nombre}, ${equipo.pais}`;
                            listaSugerencias.style.display = "none";
                            botonListo.disabled = false;
                        });

                        listaSugerencias.appendChild(div);
                    });
                })
                .catch(error => {
                    console.error("❌ Error al buscar equipos:", error);
                    listaSugerencias.innerHTML = `<div style="color: red;">Error al cargar equipos</div>`;
                    listaSugerencias.style.display = "block";
                });
        } else {
            listaSugerencias.style.display = "none";
            botonListo.disabled = true;
        }
    });

    // 📌 Lógica para cambiar de jugador y luego iniciar el juego
    botonListo.addEventListener("click", function() {
        let equipoSeleccionado = inputBusqueda.value.trim();
        if (turnoJugador === 1) {
            equipoJugador1 = equipoSeleccionado;
            turnoJugador = 2;
            tituloJugador.innerText = "Jugador 2, elige tu equipo";
            inputBusqueda.value = "";
            botonListo.disabled = true;
        } else {
            equipoJugador2 = equipoSeleccionado;

            // 📌 Ir a la vista de juego con los equipos seleccionados
            window.location.href = `juego?equipo1=${encodeURIComponent(equipoJugador1)}&equipo2=${encodeURIComponent(equipoJugador2)}`;
        }
    });

    // Ocultar la lista cuando se haga clic fuera
    document.addEventListener("click", function(event) {
        if (!inputBusqueda.contains(event.target) && !listaSugerencias.contains(event.target)) {
            listaSugerencias.style.display = "none";
        }
    });
});
</script>




</body>
</html>
