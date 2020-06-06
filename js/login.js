var span = document.getElementById("closeModal");
var login = document.getElementById("login");

span.onclick = function() {
    closeModal();
}

window.onclick = function(event) {
    var targetModal = document.getElementById('login');
    if (event.target == targetModal) {
         closeModal();
    }
}

function closeModal(){
    login.style.display = "none";
}

function openModal(){
    login.style.display = "initial";
}