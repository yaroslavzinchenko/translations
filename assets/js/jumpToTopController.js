// When the user scrolls down Npx from the top of the document, show the button.
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 1 || document.documentElement.scrollTop > 1) {
        document.getElementById("toTopButton").style.display = "block";
    } else {
        document.getElementById("toTopButton").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document.
function jumpToTop() {
    document.body.scrollTop = 0; // For Safari.
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera.
}