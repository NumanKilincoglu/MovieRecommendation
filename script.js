
function openModal() {
    var modal = document.getElementById("edit-about-me-modal");
    modal.style.display = "block";
    console.log("burda");
}

function closeModal() {
    document.getElementById("edit-about-me-modal").style.display = "none";
}

function saveAboutMe() {
    var input = document.getElementById("edit-about-me").value;
    $.ajax({
        method: "POST",
        url: 'save_about_me.php',
        data: { text: input },
        success: function (response) {
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error(xhr);
        }
    });

    console.log("Girilen değer: " + input);
    document.getElementById("edit-about-me").value = "";
}