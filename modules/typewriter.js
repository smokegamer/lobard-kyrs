function typeText(element, text, duration) {
    let index = 0;
    const textLength = text.length;
    const interval = duration / textLength;

    return new Promise((resolve) => {
        function type() {
            element.textContent += text[index];
            index++;

            if (index < textLength) {
                setTimeout(type, interval);
            } else {
                resolve();
            }
        }

        setTimeout(type, interval);
    });
}

// Вызов функции для анимации
const welcomeText = document.getElementById('welcome-text');

typeText(welcomeText, 'Ломбард "Лучший из лучших"', 3000);
