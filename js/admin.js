function openTab(event) {
    var clickedTab = this.id;

    var allTabs = document.querySelectorAll('.tab');
    var allButtons = document.querySelectorAll('.tablink')

    allTabs.forEach((element) => {
        element.classList.remove('active');
    })

    allButtons.forEach((element) => {
        element.classList.remove('active');
    })

    document.querySelector('#' + clickedTab).classList.add('active')
    document.querySelector('#' + clickedTab + '-tab').classList.add('active')


}

function init() {
    document.querySelector('.tablink#students').addEventListener('click', openTab);
    document.querySelector('.tablink#subjects').addEventListener('click', openTab);
}

window.addEventListener('load',init)