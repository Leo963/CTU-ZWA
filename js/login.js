function validate(event) {
    var name = document.querySelector('#username')
    var pass = document.querySelector('#pass')
    if (name.value.length <= 0 || pass.value.length <= 0) {
        event.preventDefault();
        alert("Zadejte jméno a heslo");
    }
}

function init() {
    document.querySelector('#login').addEventListener('submit',validate)
}

window.addEventListener('load',init)