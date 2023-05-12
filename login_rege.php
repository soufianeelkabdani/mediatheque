<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login_rege.css">
    <title>Login and registration</title>
</head>

<body>
    <h1 style="text-align: center; margin-top: 20px;">Bienvenue chez Médiathèque</h1>
    <section>
        <img src="images/bibliotheque.jpg" alt="">


        <form id="login" class="input-group-login">
            <h2 style="text-align: center;">Connexion</h2>
            <input type="text" id="Surname" class="input-field" placeholder="Surname" name="Surname">
            <div class="erreur" id="SurnameErr"></div>
            <input type="text" id="login_email" class="input-field" placeholder="Email" name="email_login">
            <div class="erreur" id="emailErr"></div>
            <input type="password" id="login_password" class="input-field" placeholder="Mot de passe" name="motdepasse">
            <button type="submit" class="submit-btn" name="submit_login">Connexion</button>
        </form>





        <form name='register' class='input-group-register'>
            <h2 style="text-align: center;">Inscription</h2>
            <input type='text' class='input-field' name="nom" id="nom" placeholder='Nom'>
            <div class="erreur" id="nomErr"></div>
            <input type='text' class='input-field' name="prenom" id="prenom" placeholder='Prénom'>
            <div class="erreur" id="prenomErr"></div>
            <input type='text' class='input-field' name="surname" id="surname" placeholder='Surname'>
            <div class="erreur" id="surnameErr"></div>
            <input type='number' min="0" class='input-field' name="numtelephone" id="numtelephone" placeholder='Numéro de Téléphone'>
            <div class="erreur" id="teleErr"></div>
            <input type='text' class='input-field' placeholder='CIN' name="cin" id="cin">
            <div class="erreur" id="cinErr"></div>
            <input type='date' class='input-field' placeholder='Date de naissance' name="dateNaissance" id="dateNaissance">
            <div class="erreur" id="naissanceErr"></div>
            <input type='email' class='input-field' placeholder='Email' name="email_register" id="email">
            <div class="erreur" id="emailErr"></div>
            <input type='password' class='input-field' placeholder='Mot de passe' name="motdepasse" id="motdepasse">
            <div class="erreur" id="motdepasseErr"></div>
            <select name="type" id="type" class="inputSelect">
                <option value="Select">Select</option>
                <option value="Fonctionnaire">Fonctionnaire</option>
                <option value="Etudiant">Etudiant</option>
                <option value="Femme">Femme au foyer</option>
            </select>
            <div class="erreur" id="typeErr"></div><br>
            <button type='submit' id="submit-btn1" class='submit-btn1' name="submit_register">S'inscrire</button>
        </form>
    </section>



    <script src="validation.js"></script>

</body>

</html>