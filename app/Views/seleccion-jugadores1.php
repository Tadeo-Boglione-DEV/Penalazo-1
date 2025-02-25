<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/inicio.css">
    <link rel="stylesheet" href="./css/seleccion-j1.css">
    <link rel="shortcut icon" href="./img/logo.png">
    <title>Selección de Jugadores Retirados</title>
</head>
<body>

<?= view('Includes/Header') ?>

<div class="container">
    <h2 id="titulo-jugador">Jugador 1, eliga una leyenda</h2>
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
                        div.innerHTML = `<strong>${jugador.nombre}</strong> (${jugador.posicion}), ${jugador.nacionalidad}, ${jugador.fecha_de_nacimiento}`;
                        div.addEventListener("click", function() {
                            inputBusqueda.value = `${jugador.nombre} (${jugador.posicion}), ${jugador.nacionalidad}, ${jugador.fecha_de_nacimiento}`;
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
            tituloJugador.innerText = "Jugador 2, eliga una leyenda";
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
