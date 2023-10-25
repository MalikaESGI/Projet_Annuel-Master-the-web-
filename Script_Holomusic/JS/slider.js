const slide = ["concert1.webp", "chanteur.webp", "chanteur1.webp", "concert2.webp"];
let num = 0;

function ChangeSlide(sens) {
    num = num + sens;
    if (num > 3)
        num = 0;
    if (num < 0)
        num = 3;
    document.getElementById("slide").src = "../asset/" + slide[num];

}

setInterval("ChangeSlide(1)", 5000);

function acceptCookies() {
    localStorage.setItem('cookiesAccepted', 'true');
    hidePopup();
}

function hidePopup() {
    document.getElementById('popup-container').style.display = 'none';
}

window.onload = function() {
    var cookiesAccepted = localStorage.getItem('cookiesAccepted');
    if (!cookiesAccepted) {
        document.getElementById('popup-container').style.display = 'block';
    }
};
