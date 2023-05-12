function printError(Id, Msg) {
  document.getElementById(Id).innerHTML = Msg;
}
const form = document.querySelector(".input-group-register");

form.addEventListener("submit", async function validatForm(e) {
  // prevent the default form submission behavior
  e.preventDefault();

  var nom = document.register.nom.value;
  var prenom = document.register.prenom.value;
  var surname = document.register.surname.value;
  var numtelephone = document.register.numtelephone.value;
  var cin = document.register.cin.value;
  var dateNaissance = document.register.dateNaissance.value;
  var email = document.register.email.value;
  var motdepasse = document.register.motdepasse.value;
  var type = document.register.type.value;

  var nomErr = true;
  var prenomErr = true;
  var surnameErr = true;
  var teleErr = true;
  var cinErr = true;
  var naissanceErr = true;
  var emailErr = true;
  var motdepasseErr = true;
  var typeErr = true;
  // ========================= Nom ==========================//
  if (nom == "") {
    printError("nomErr", "le nom est vide");
    nomErr = false;
    var elem = document.getElementById("nom");
    elem.classList.add("input-2");
    elem.classList.remove("input-1");
  } else {
    var regex = /^[a-zA-Z\s]+$/;
    if (regex.test(nom) === false) {
      printError("nomErr", "Entrer le nom valide");
      nomErr = false;
      var elem = document.getElementById("nom");
      elem.classList.add("input-2");
      elem.classList.remove("input-1");
    } else {
      nomErr = true;
    }
  }
  // ========================= prenom ==========================//
  if (prenom == "") {
    printError("prenomErr", "le prénom est vide");
    prenomErr = false;
    var elem = document.getElementById("prenom");
    elem.classList.add("input-2");
    elem.classList.remove("input-1");
  } else {
    var regex = /^[a-zA-Z\s]+$/;
    if (regex.test(prenom) === false) {
      printError("prenomErr", "Entrer le prénom valide");
      prenomErr = false;
      var elem = document.getElementById("prenom");
      elem.classList.add("input-2");
      elem.classList.remove("input-1");
    } else {
      prenomErr = true;
    }
  }
   // ========================= surname ==========================//
   if (surname == "") {
    printError("surnameErr", "Le surname est vide");
    surnameErr = false;
    var elem = document.getElementById("surname");
    elem.classList.add("input-2");
    elem.classList.remove("input-1");
  } else {
    var regex = /^[a-zA-Z\s]+$/;
    if (regex.test(surname) === false) {
      printError("surnameErr", "Entrer un surname valide");
      surnameErr = false;
      var elem = document.getElementById("surname");
      elem.classList.add("input-2");
      elem.classList.remove("input-1");
    } else {
      surnameErr = true;
    }
  }

  // ========================= Numero de telephone ==========================//
  if (numtelephone === "") {
    printError("teleErr", "Le numéro de téléphone est vide");
    var elem = document.getElementById("numtelephone");
    teleErr = false;
    elem.classList.add("input-2");
    elem.classList.remove("input-1");
  } else {
    var regex = /^(0[567]\d{8}|0[67]\d{8})$/;
    if (!regex.test(numtelephone)) {
      printError("teleErr", "Entrez un numéro de téléphone valide");
      teleErr = false;
      var elem = document.getElementById("numtelephone");
      elem.classList.add("input-2");
      elem.classList.remove("input-1");
    } else {
      teleErr = true;
    }
  }
  
  // ========================= CIN ==========================//
  if (cin == "") {
    printError("cinErr", "le cin est vide");
    var elem = document.getElementById("cin");
    cinErr = false;
    elem.classList.add("input-2");
    elem.classList.remove("input-1");
  } else {
    var regex = /^[a-zA-Z]{2}\d*$/;
    if (regex.test(cin) === false) {
      printError("cinErr", "Entrer cin valide");
      cinErr = false;
      var elem = document.getElementById("cin");
      elem.classList.add("input-2");
      elem.classList.remove("input-1");
    } else {
      cinErr = true;
    }
  }
  // ========================= date de naissance ==========================//
  if (dateNaissance == "") {
    printError("naissanceErr", "la date de naissance est vide");
    naissanceErr = false;
    var elem = document.getElementById("dateNaissance");
    elem.classList.add("input-2");
    elem.classList.remove("input-1");
  } else {
    naissanceErr = true;
  }

  // ========================= Email ==========================//
  if (email == "") {
    printError("emailErr", "Email est vide");
    emailErr = false;
    var elem = document.getElementById("email");
    elem.classList.add("input-2");
    elem.classList.remove("input-1");
  } else {
    var regex = /^\S+@\S+\.\S+$/;
    if (regex.test(email) === false) {
      printError("emailErr", "Entrer email valide");
      emailErr = false;
      var elem = document.getElementById("email");
      elem.classList.add("input-2");
      elem.classList.remove("input-1");
    } else {
      emailErr = true;
    }
  }
  // ========================= date de naissance ==========================//
  if (motdepasse == "") {
    printError("motdepasse", "le mot de passe est vide");
    motdepasseErr = false;
    var elem = document.getElementById("motdepasse");
    elem.classList.add("input-2");
    elem.classList.remove("input-1");
  } else {
    motdepasseErr = true;
  }
  // ========================= type ==========================//
  if (type == "Select") {
    printError("typeErr", "type est vide");
    typeErr = false;
    var elem = document.getElementById("type");
    elem.classList.add("input-5");
    elem.classList.remove("input-3");
  } else {
    typeErr = true;
  }

  // ========================== All is true ==========================

  if (
    nomErr &&
    prenomErr &&
    surnameErr &&
    teleErr &&
    cinErr &&
    naissanceErr &&
    emailErr &&
    motdepasseErr &&
    typeErr
  ) {
    try {
      const response = await fetch("signup.php", {
        method: "POST",
        body: JSON.stringify({
          nom,
          prenom,
          surname,
          numtelephone,
          cin,
          dateNaissance,
          email,
          motdepasse,
          type,
        }),
        headers: {
          "Content-Type": "application/json",
        },
      });

      if (response.ok) {
        // handle successful response
        console.log("Sign up successful!");
      } else {
        // handle error response
        console.error("Sign up failed.");
      }
    } catch (error) {
      console.error(error);
    }
  }
});



// Define regular expressions for nickname and email validation
const nicknameRegex = /^[a-zA-Z]+$/;
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

const loginForm = document.querySelector("#login");

let emailValid,
  surnameValid = false;
function validateNickname(nickname) {
  return nicknameRegex.test(nickname);
}

// Function to validate email
function validateEmail(email) {
  return emailRegex.test(email);
}

loginForm.addEventListener("submit", async (e) => {
  e.preventDefault();
  const surName = document.querySelector("#Surname").value;
  const loginEmail = document.querySelector("#login_email").value;
  const loginPassword = document.getElementById("login_password").value;
  let surnameValid = false;
  let emailValid = false;
  
  // Function to validate nickname
  if (surName == "") {
    printError("surnameErr", "Please fill in the nickname");
    document.querySelector("#Surname").classList.add("input-2");
    document.querySelector("#Surname").classList.remove("input-1");
  } else {
    if (!validateNickname(surName)) {
      printError("surnameErr", "Please enter a valid nickname");
      document.querySelector("#Surname").classList.add("input-2");
      document.querySelector("#Surname").classList.remove("input-1");
    } else {
      surnameValid = true;
    }
  }

  if (loginEmail == "") {
    printError("emailErr", "Please fill in the email");
    document.querySelector("#login_email").classList.add("input-2");
    document.querySelector("#login_email").classList.remove("input-1");
  } else {
    if (!validateEmail(loginEmail)) {
      printError("emailErr", "Please enter a valid email");
      document.querySelector("#login_email").classList.add("input-2");
      document.querySelector("#login_email").classList.remove("input-1");
    } else {
      emailValid = true;
    }
  }
  console.log(surnameValid);
  console.log(emailValid);

  if (surnameValid && emailValid) {
    try {
      const response = await fetch("login.php", {
        method: "POST",
        body: JSON.stringify({
          loginPassword,
          surName,
          loginEmail,
        }),
        headers: {
          "Content-Type": "application/json",
        },
      });

      if (response.ok) {

        try {
          const responseTwo = await fetch('check_admin.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `email=${loginEmail}&surname=${surName}&password=${loginPassword}`
          });
            if (responseTwo.ok) {
              const checkAccount = await responseTwo.json();
              if (checkAccount.admin && checkAccount.password) {
                window.location.href = "admin.php";
              } else if(!checkAccount.admin && checkAccount.password && checkAccount.penalities >= 3) {
                window.location.href = "banned.php";
              }else if(!checkAccount.admin && checkAccount.password && checkAccount.penalities < 3 ){
                window.location.href = "ouvres.php";
              }
            } else {
              console.log('Error:', responseTwo.status);
            }
          } catch (error) {
            console.log('Error:', error);
          }
     
      } else {
        // handle error response
        console.error("Sign up failed.");
      }
    } catch (error) {
      console.error(error);
    }
  }
});
