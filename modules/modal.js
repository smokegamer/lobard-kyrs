document.addEventListener("DOMContentLoaded", function () {
    const openModalBtn = document.getElementById("openModal");
    const closeModalBtns = document.getElementsByClassName("close");

    openModalBtn.addEventListener("click", function () {
        document.getElementById("myModal").style.display = "block";
    });

    for (let btn of closeModalBtns) {
        btn.addEventListener("click", function () {
            document.getElementById("myModal").style.display = "none";
        });
    }
});
