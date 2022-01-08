/**
 * General validation of signup values
 * @param {Event} event event
 */
function validate(event) {
    const unameLen = 5;
    const lnameLen = 0;
    const fnameLen = 0;
    const passLen = 7;
    const minAge = 15;
    const UNIXoffset = 1970;

    let username = document.querySelector('#username');
    let pass = document.querySelector('#pass');

    let fname = document.querySelector('#fname');
    let lname = document.querySelector('#lname');
    let dob = document.querySelector('#dob');

    if (username.value.length <= unameLen) {
        event.preventDefault();
        alert('Uživatelské jméno musí mít alespoň šest znak');
    }

    if (fname.value.length <= fnameLen || lname.value.length <= lnameLen) {
        event.preventDefault();
        alert('Jméno i příjmení musí mít alespoň jeden znak');
    }

    if (pass.value.length <= passLen) {
        event.preventDefault();
        alert('Heslo musí být alespoň 8 znaků dlouhé');
    }

    if (new Date(new Date() - dob.valueAsDate).getUTCFullYear() - UNIXoffset < minAge) {
        event.preventDefault();
        alert('Tato služba je bohužel dostupná až od 15 let.');
    }

    console.log();
}

/**
 * Function generates username from:
 *      first 4 letters of last name
 *      first 3 letters of first name
 *      4 random characters of md5 hash from the previous 2 parts concatenated
 *          and interpreted as a base 16 number
 * @param {Event} event event variable
 */
function generateUsername(event) {
    const start = 0;
    const lnameLen = 4;
    const fnameLen = 3;

    const charsOfHash = 4;
    const maxCharsOfHash = 11;
    const startOffset = 2;

    let username = document.querySelector('#username');
    let fname = document.querySelector('#fname').value;
    let lname = document.querySelector('#lname').value;

    if (!(event.target.id === 'fname')) {
        if (!username.value) {
            let charPart = lname.substr(start, lnameLen) +
                fname.substr(start, fnameLen);
            username.value =
                charPart +
                parseInt(
                    // eslint-disable-next-line no-undef
                    md5(charPart), 16)
                    .toString()
                    .substr(Math.floor(Math.random() * maxCharsOfHash) + startOffset, charsOfHash);
        }
    }
}

/**
 * Checks if the current username is not already used
 * @param {Event} event event variable
 */
function checkUsername(event) {
    let xrq = new XMLHttpRequest();
    // eslint-disable-next-line func-names
    xrq.onload = function() {
        if (this.responseText === '400') {
            alert('Uživatelské jméno již existuje');
        }
    };
    xrq.open('GET', `checkuser.php?uname=${document.querySelector(`#${ event.target.id}`).value}`);
    xrq.send();
}

/**
 * Initializes EventListeners on the load of the window
 */
function init() {
    document.querySelector('#signup').addEventListener('submit', validate);
    document.querySelector('#fname').addEventListener('blur', generateUsername);
    document.querySelector('#lname').addEventListener('blur', generateUsername);
    document.querySelector('#username').addEventListener('focusout', checkUsername);
}

window.addEventListener('load', init);
