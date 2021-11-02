function validate(event) {
    var username = document.querySelector('#username')
    var pass = document.querySelector('#pass')

    var fname = document.querySelector('#fname')
    var lname = document.querySelector('#lname')
    var dob = document.querySelector('#dob')
    
    if (username.value.length <= 5) {
        event.preventDefault();
        alert("Uživatelské jméno musí mít alespoň šest znak");
    }

    if (fname.value.length <= 0 || lname.value.length <= 0) {
        event.preventDefault();
        alert("Jméno i příjmení musí mít alespoň jeden znak");
    }

    if (new Date(new Date() - dob.valueAsDate).getUTCFullYear()-1970 < 15) {
        event.preventDefault();
        alert("Tato služba je bohužel dostupná až od 15 let.")
    }

    console.log()
}

function generateUsername(event) {
    var username = document.querySelector('#username')
    var fname = document.querySelector('#fname').value
    var lname = document.querySelector('#lname').value

    if (!(event.target.id === "fname")) {
        if (!username.value) {
            username.value =
                lname.substr(0,4) +
                fname.substr(0, 3) +
                parseInt(
                    md5(lname.substr(0,4) + fname.substr(0, 3)),16)
                    .toString()
                    .substr(Math.floor(Math.random()*11)+2,4)
        }
    }
}

function init() {
    document.querySelector('#signup').addEventListener('submit',validate)
    document.querySelector('#fname').addEventListener('blur', generateUsername)
    document.querySelector('#lname').addEventListener('blur', generateUsername)
}

window.addEventListener('load',init)