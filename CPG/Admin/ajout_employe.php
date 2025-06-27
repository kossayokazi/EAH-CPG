<?php
session_start();


$host = 'localhost'; 
$dbname = 'cpg'; 
$username = 'root'; 
$password = ''; 


$conn = new mysqli($host, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cin = $_POST['cin'];
    $nom = $_POST['nom'];
    $mail = $_POST['mail'];
    $password = $_POST['password']; 
    $poste = $_POST['poste'];
    $salaire = $_POST['salaire'];
    $date_affection = $_POST['date_affection'];

    
    $sql = "INSERT INTO employe (cin, nom, mail, password, poste, salaire, date_affection)
            VALUES ('$cin', '$nom', '$mail', '$password', '$poste', '$salaire', '$date_affection')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Employé ajouté avec succès !";
    } else {
        $error_message = "Erreur lors de l'ajout de l'employé : " . $conn->error;
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un employé - CPG Gafsa</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-image: url('bg.jpeg');
            background-color: #f0f0f0;
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow: hidden;
        }

        header {
            width: 100%;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 10px 20px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo {
            width: 50px;
            height: auto;
            animation: bounce 2s infinite;
        }

        .navbar-title {
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        .form-container {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            margin-top: 100px;
            width: 400px;
            text-align: center;
        }

        .form-container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .form-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        .message {
            margin-top: 10px;
            font-size: 14px;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="navbar-logo">
            <img src="CPG.png" alt="CPG Gafsa" class="logo">
            <span class="navbar-title">Compagnie de Phosphate de Gafsa</span>
        </div>
    </header>

    <div class="form-container">
        <h2>Ajouter un employé</h2>
        <?php if (isset($success_message)) : ?>
            <p class="message success"><?php echo $success_message; ?></p>
        <?php endif; ?>
        <?php if (isset($error_message)) : ?>
            <p class="message error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="cin" placeholder="CIN" required>
            <input type="text" name="nom" placeholder="Nom complet" required>
            <input type="email" name="mail" placeholder="Adresse e-mail" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="text" name="poste" placeholder="Poste" required>
            <input type="number" name="salaire" placeholder="Salaire" required>
            <input type="date" name="date_affection" placeholder="Date d'affection" required>
            <button type="submit">Ajouter</button>
        </form>
    </div>
</body>
</html>