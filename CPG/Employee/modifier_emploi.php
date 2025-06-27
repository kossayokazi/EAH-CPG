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

$id = $_GET['id']; 
$emploi = null;
$error_message = '';
$success_message = '';


$sql = "SELECT * FROM emploi_du_temps WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $emploi = $result->fetch_assoc();
} else {
    $error_message = "Aucun emploi du temps trouvé avec cet ID.";
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jour_semaine = $_POST['jour_semaine'];
    $seance_1 = $_POST['seance_1'];
    $seance_2 = $_POST['seance_2'];
    $est_jour_ferie = isset($_POST['est_jour_ferie']) ? 1 : 0;
    $est_weekend = isset($_POST['est_weekend']) ? 1 : 0;
    $jour_paiement = $_POST['jour_paiement'];

    
    $sql = "UPDATE emploi_du_temps SET 
            jour_semaine = '$jour_semaine', 
            seance_1 = '$seance_1', 
            seance_2 = '$seance_2', 
            est_jour_ferie = $est_jour_ferie, 
            est_weekend = $est_weekend, 
            jour_paiement = '$jour_paiement' 
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Emploi du temps modifié avec succès !";
        
        $sql = "SELECT * FROM emploi_du_temps WHERE id = $id";
        $result = $conn->query($sql);
        $emploi = $result->fetch_assoc();
    } else {
        $error_message = "Erreur lors de la modification de l'emploi du temps : " . $conn->error;
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'emploi du temps - CPG Gafsa</title>
    <style>
       
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
        overflow: auto;
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

    .form-container label {
        display: block;
        margin: 10px 0 5px;
        font-weight: bold;
        color: #333;
    }

    .form-container input[type="text"],
    .form-container input[type="time"],
    .form-container input[type="date"],
    .form-container select {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    .form-container input[type="checkbox"] {
        margin-right: 10px;
    }

    .form-container button {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        margin-top: 20px;
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
    </style>
</head>
<body>
    <header class="navbar">
        <div class="navbar-logo">
            <img src="CPG.svg" alt="CPG Gafsa" class="logo">
            <span class="navbar-title">Compagnie de Phosphate de Gafsa</span>
        </div>
    </header>

    <div class="form-container">
        <h2>Modifier l'emploi du temps</h2>
        <?php if (isset($success_message)) : ?>
            <p class="message success"><?php echo $success_message; ?></p>
        <?php endif; ?>
        <?php if (isset($error_message)) : ?>
            <p class="message error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <?php if ($emploi) : ?>
            <form method="POST" action="">
                <label for="jour_semaine">Jour de la semaine :</label>
                <select name="jour_semaine" required>
                    <option value="Lundi" <?php echo $emploi['jour_semaine'] === 'Lundi' ? 'selected' : ''; ?>>Lundi</option>
                    <option value="Mardi" <?php echo $emploi['jour_semaine'] === 'Mardi' ? 'selected' : ''; ?>>Mardi</option>
                    <option value="Mercredi" <?php echo $emploi['jour_semaine'] === 'Mercredi' ? 'selected' : ''; ?>>Mercredi</option>
                    <option value="Jeudi" <?php echo $emploi['jour_semaine'] === 'Jeudi' ? 'selected' : ''; ?>>Jeudi</option>
                    <option value="Vendredi" <?php echo $emploi['jour_semaine'] === 'Vendredi' ? 'selected' : ''; ?>>Vendredi</option>
                </select>

                <label for="seance_1">Séance 1 :</label>
                <input type="time" name="seance_1" value="<?php echo $emploi['seance_1']; ?>">

                <label for="seance_2">Séance 2 :</label>
                <input type="time" name="seance_2" value="<?php echo $emploi['seance_2']; ?>">

                <label for="est_jour_ferie">Jour férié :</label>
                <input type="checkbox" name="est_jour_ferie" <?php echo $emploi['est_jour_ferie'] ? 'checked' : ''; ?>>

                <label for="est_weekend">Weekend :</label>
                <input type="checkbox" name="est_weekend" <?php echo $emploi['est_weekend'] ? 'checked' : ''; ?>>

                <label for="jour_paiement">Jour de paiement :</label>
                <input type="date" name="jour_paiement" value="<?php echo $emploi['jour_paiement']; ?>">

                <button type="submit">Enregistrer</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>