const removeFavoriteButtons = document.querySelectorAll('.remove-favorite');

removeFavoriteButtons.forEach(button => {
    button.addEventListener('click', function () {
        const movieId = button.dataset.movieId;
        var xhttp = new XMLHttpRequest();
        var functionName = "deleteFavoriteMovies";
        var parameters = "user_id=1&movie_id=5";
        var url = "Services/UserService.php?function=" + functionName + "&" + parameters;
        
        xhttp.open("GET", url, true);
        xhttp.send();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {console.log(url);
            }
            
        };
    });
});