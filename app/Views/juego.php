<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 📌 Obtener los parámetros de la URL
    const params = new URLSearchParams(window.location.search);
    const equipo1 = params.get("equipo1");
    const equipo2 = params.get("equipo2");

    document.body.innerHTML = `<h1>¡Empieza el partido!</h1>
                               <p><strong>Jugador 1:</strong> ${equipo1}</p>
                               <p><strong>Jugador 2:</strong> ${equipo2}</p>`;
});
</script>

</body>
</html>