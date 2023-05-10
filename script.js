function saveAboutMe() {
    var input = document.getElementById("edit-about-me").value;
    $.ajax({
        method: "POST",
        url: 'utils/save_about_me.php',
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