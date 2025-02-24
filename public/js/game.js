document.addEventListener("DOMContentLoaded", function () {
    let currentPlayer = 1; // Jugador 1 empieza preguntando
    let isGameOver = false; // Controla si el juego terminó

    const questionInput = document.getElementById("questionInput");
    const askButton = document.getElementById("askButton");
    const responseSection = document.getElementById("responseSection");
    const responseButtons = document.querySelectorAll(".response-button");
    const turnIndicator = document.getElementById("turnIndicator");
    const gameLog = document.getElementById("gameLog");

    function updateTurnIndicator() {
        turnIndicator.textContent = `Turno del Jugador ${currentPlayer}`;
    }

    function logMessage(message) {
        const logItem = document.createElement("p");
        logItem.textContent = message;
        gameLog.appendChild(logItem);
        gameLog.scrollTop = gameLog.scrollHeight; // Auto scroll hacia abajo
    }

    askButton.addEventListener("click", function () {
        if (isGameOver) return; // No seguir si ya terminó

        const question = questionInput.value.trim();
        if (question === "") {
            alert("Por favor, ingresa una pregunta.");
            return;
        }

        logMessage(`Jugador ${currentPlayer} pregunta: "${question}"`);
        questionInput.value = "";
        responseSection.style.display = "block"; // Mostrar botones de respuesta
    });

    responseButtons.forEach(button => {
        button.addEventListener("click", function () {
            if (isGameOver) return;

            const response = this.textContent;
            logMessage(`Jugador ${currentPlayer === 1 ? 2 : 1} responde: "${response}"`);

            if (response === "Sí" || response === "No") {
                responseSection.style.display = "none"; // Ocultar respuestas tras responder
                currentPlayer = currentPlayer === 1 ? 2 : 1; // Cambiar turno
                updateTurnIndicator();
            }
        });
    });

    // Función para terminar el juego cuando alguien acierta
    document.getElementById("guessButton").addEventListener("click", function () {
        if (isGameOver) return;

        const guess = prompt("¿Cuál es tu respuesta?");
        if (!guess) return;

        const confirmation = confirm(`¿"${guess}" es correcto?`);
        if (confirmation) {
            logMessage(`🎉 ¡Jugador ${currentPlayer} ha adivinado correctamente!`);
            isGameOver = true;
        } else {
            logMessage(`Jugador ${currentPlayer} intentó adivinar con "${guess}", pero no era correcto.`);
            currentPlayer = currentPlayer === 1 ? 2 : 1;
            updateTurnIndicator();
        }
    });

    updateTurnIndicator(); // Inicializa la UI con el primer turno
});
