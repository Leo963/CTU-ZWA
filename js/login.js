const minLen = 0;

/**
 * Validation of inputs
 * @param {Event} event event
 */
function validate(event) {
    let name = document.querySelector('#username');
    let pass = document.querySelector('#pass');
    if (name.value.length <= minLen || pass.value.length <= minLen) {
        event.preventDefault();
        alert('Zadejte jméno a heslo');
    }
}

/**
 * Initializes EventListeners on the load of the window
 */
function init() {
    document.querySelector('#login').addEventListener('submit', validate);
}

window.addEventListener('load', init);
