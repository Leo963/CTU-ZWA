/**
 * Shows the appropriate tab
 */
function openTab() {
    let clickedTab = this.id;

    let allTabs = document.querySelectorAll('.tab');
    let allButtons = document.querySelectorAll('.tablink');

    allTabs.forEach((element) => {
        element.classList.remove('active');
    });

    allButtons.forEach((element) => {
        element.classList.remove('active');
    });

    document.querySelector(`#${ clickedTab}`).classList.add('active');
    document.querySelector(`#${ clickedTab }-tab`).classList.add('active');
}

/**
 * Initializes EventListeners on the load of the window
 */
function init() {
    document.querySelector('.tablink#students').addEventListener('click', openTab);
    document.querySelector('.tablink#subjects').addEventListener('click', openTab);
}

window.addEventListener('load', init);
