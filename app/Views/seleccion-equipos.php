<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selección de Equipos</title>
    <link rel="stylesheet" href="/styles.css">
    <script defer src="/script.js"></script>
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

    let equipoSeleccionado = "";

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
                    console.log("📌 Equipos recibidos:", data); // 👈 Verifica que lleguen datos

                    listaSugerencias.innerHTML = "";
                    listaSugerencias.style.display = data.length > 0 ? "block" : "none";

                    if (data.length === 0) {
                        listaSugerencias.innerHTML = "<div>No hay resultados</div>";
                        return;
                    }

                    data.forEach(equipo => {
                        let div = document.createElement("div");
                        let banderaSrc = equipo.pais 
                            ? `/img/banderas/${equipo.pais.toLowerCase()}.png`
                            : "https://via.placeholder.com/20x15"; // Imagen por defecto

                        div.innerHTML = `<img src="${banderaSrc}" class="flag" onerror="this.src='https://via.placeholder.com/20x15';"> 
                                         <strong>${equipo.nombre}</strong> - ${equipo.pais || "Desconocido"}`;
                        div.addEventListener("click", function() {
                            inputBusqueda.value = equipo.nombre;
                            equipoSeleccionado = equipo.nombre;
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

    document.addEventListener("click", function(event) {
        if (!inputBusqueda.contains(event.target) && !listaSugerencias.contains(event.target)) {
            listaSugerencias.style.display = "none";
        }
    });
});

</script>


</body>
</html>
