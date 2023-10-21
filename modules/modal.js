document.addEventListener("DOMContentLoaded", function () {
    const openModalBtn = document.getElementById("openModal");
    const modal = document.getElementById("myModal");
    const closeModalBtn = document.getElementById("closeModal");
    const closeModalFormBtn = document.getElementById("closeModalForm"); // Новая кнопка для закрытия формы
    const messageDiv = document.getElementById("message");
    let isFormSubmitted = false;

    openModalBtn.addEventListener("click", function () {
        modal.style.display = "block";
    });

    closeModalBtn.addEventListener("click", function () {
        if (!isFormSubmitted) {
            modal.style.display = "none";
        }
    });

    closeModalFormBtn.addEventListener("click", function () {
        modal.style.display = "none";
    });


    // Добавляем обработчик события на клик вне модального окна
    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            if (!isFormSubmitted) {
                modal.style.display = "none";
            }
        }
    });

    const applicationForm = document.getElementById("applicationForm");
    applicationForm.addEventListener("submit", function (event) {
        event.preventDefault();

        // Проверяем, не отправлена ли уже форма
        if (isFormSubmitted) {
            return;
        }

        // Устанавливаем флаг отправки формы
        isFormSubmitted = true;

        // Собираем данные из формы
        const formData = new FormData(applicationForm);

        // Отправляем POST-запрос на сервер
        fetch("../process_application.php", {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                // Получаем данные из ответа
                const applicationNumber = data.application_number;
                const login = data.login;
                const password = data.password;

                // Выводим сообщение пользователю
                messageDiv.innerHTML = `Ваша заявка успешно отправлена. Номер заявки: <strong>${applicationNumber}</strong><br>Скопируйте номер заявки или запишите!`;

                messageDiv.style.display = "block";

            })
            .catch(error => {
                console.error("Произошла ошибка при отправке заявки:", error);
                messageDiv.innerHTML = "Произошла ошибка при отправке заявки.";
            });
    });
});

