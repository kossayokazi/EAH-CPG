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


$sql = "SELECT * FROM emploi_du_temps";
$result = $conn->query($sql);


if ($result === false) {
    die("Erreur lors de l'exécution de la requête : " . $conn->error);
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emploi du temps - CPG Gafsa</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: url('bg.jpeg');
            background-size: cover;
            background-position: center;
        }

        .table-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 1000px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        .table-container h2 {
            margin-bottom: 20px;
            color: #333;
            font-size: 24px;
            animation: slideInDown 1s ease-in-out;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            animation: slideInUp 1s ease-in-out;
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        table th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        table td {
            background-color: #f9f9f9;
        }

        table td.weekend {
            background-color: #ffcccc;
        }

        table td.holiday {
            background-color: #ccffcc;
        }

        table td.payment-day {
            background-color: #ccccff;
        }

        table td.today {
            background-color: #ffffcc;
            font-weight: bold;
        }

        table td:hover {
            background-color: #e0e0e0;
            transform: scale(1.05);
            cursor: pointer;
        }

       
        .legend {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
            animation: fadeIn 1.5s ease-in-out;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            transition: transform 0.3s ease;
        }

        .legend-color.workday {
            background-color: #f9f9f9;
        }

        .legend-color.weekend {
            background-color: #ffcccc;
        }

        .legend-color.holiday {
            background-color: #ccffcc;
        }

        .legend-color.payment-day {
            background-color: #ccccff;
        }

        .legend-item:hover .legend-color {
            transform: scale(1.2);
        }

       
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideInDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideInUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="table-container">
        <h2>Emploi du temps - CPG Gafsa</h2>
        <table>
            <thead>
                <tr>
                    <th>Jour</th>
                    <th>Séance 1</th>
                    <th>Séance 2</th>
                    <th>Jour férié</th>
                    <th>Weekend</th>
                    <th>Jour de paiement</th>
                    <th>Lieu de travail</th> <!-- Nouvelle colonne -->
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <?php
                        
                        $class = '';
                        if ($row['est_weekend']) {
                            $class = 'weekend';
                        } elseif ($row['est_jour_ferie']) {
                            $class = 'holiday';
                        } elseif ($row['jour_paiement']) {
                            $class = 'payment-day';
                        }
                        ?>
                        <tr>
                            <td class="<?php echo $class; ?>"><?php echo $row['jour_semaine']; ?></td>
                            <td><?php echo $row['seance_1']; ?></td>
                            <td><?php echo $row['seance_2']; ?></td>
                            <td><?php echo $row['est_jour_ferie'] ? 'Oui' : 'Non'; ?></td>
                            <td><?php echo $row['est_weekend'] ? 'Oui' : 'Non'; ?></td>
                            <td><?php echo $row['jour_paiement']; ?></td>
                            <td><?php echo $row['place_de_travail']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7">Aucun emploi du temps trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="legend">
            <div class="legend-item">
                <div class="legend-color workday"></div>
                <span>Jours de travail</span>
            </div>
            <div class="legend-item">
                <div class="legend-color weekend"></div>
                <span>Weekends</span>
            </div>
            <div class="legend-item">
                <div class="legend-color holiday"></div>
                <span>Jours fériés</span>
            </div>
            <div class="legend-item">
                <div class="legend-color payment-day"></div>
                <span>Jours de paiement</span>
            </div>
        </div>
    </div>
</body>
</html>