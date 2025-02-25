<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/inicio.css">
    <link rel="stylesheet" href="./css/seleccion-eq.css">
    <link rel="shortcut icon" href="./img/logo.png">
    <title>Selección de Equipos</title>
</head>
<body>

<?= view('Includes/Header') ?>

<div class="container">
    <h2 id="titulo-jugador">Jugador 1, eliga su equipo</h2>
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
    let turnoJugador = 1;

    inputBusqueda.addEventListener("input", function() {
        let query = inputBusqueda.value.trim();
        
        if (query.length >= 2) {
            fetch(`http://localhost:8080/api/buscarEquipos?nombre=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    listaSugerencias.innerHTML = "";
                    listaSugerencias.style.display = data.length > 0 ? "block" : "none";

                    if (data.length === 0) {
                        listaSugerencias.innerHTML = "<div>No hay resultados</div>";
                        return;
                    }

                    data.forEach(equipo => {
                        let div = document.createElement("div");
                        div.innerHTML = `<strong>${equipo.nombre}</strong>, ${equipo.pais || "Desconocido"}`;
                        div.addEventListener("click", function() {
                            inputBusqueda.value = `${equipo.nombre}, ${equipo.pais}`;
                            listaSugerencias.style.display = "none";
                            botonListo.disabled = false;
                        });
                        listaSugerencias.appendChild(div);
                    });
                })
                .catch(error => {
                    console.error("Error al buscar equipos:", error);
                    listaSugerencias.innerHTML = `<div style="color: red;">Error al cargar equipos</div>`;
                    listaSugerencias.style.display = "block";
                });
        } else {
            listaSugerencias.style.display = "none";
            botonListo.disabled = true;
        }
    });

// 📌 Al hacer clic en "Listo" del segundo jugador
botonListo.addEventListener("click", function() {
    if (turnoJugador === 1) {
        equipoJugador1 = inputBusqueda.value.trim();
        turnoJugador = 2;
        tituloJugador.innerText = "Jugador 2, elige su equipo";
        inputBusqueda.value = "";
        botonListo.disabled = true;
    } else {
        equipoJugador2 = inputBusqueda.value.trim();
        
        // ✅ Guardar los equipos en sessionStorage en lugar de la URL
        sessionStorage.setItem("equipo1", equipoJugador1);
        sessionStorage.setItem("equipo2", equipoJugador2);
        
        // ✅ Redirigir sin información en la URL
        window.location.href = "juego";
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