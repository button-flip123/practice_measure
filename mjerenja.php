<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Measurements</title>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <img src="imgs/etsbi_logo.png" alt="Logo" style="width: 60px; height: auto;">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2">
                    <li class="nav-item">
                        <a style="font-family: 'Open Sans'; font-size: 13px;" id="ease-out" class="nav-link active" href="index.php">Trenutna mjerenja</a>
                    </li>
                    <li class="nav-item">
                        <a style="font-family: 'Open Sans'; font-size: 13px;" id="ease-out" class="nav-link" href="mjerenja.php">Mjerenja</a>
                    </li>
                </ul>
                <form class="d-flex" method="post">
                    <input class="form-control me-2" name="date" type="text" placeholder="Unesite datum (YYYY, YYYY-MM, YYYY-MM-DD)">
                    <button class="btn btn-outline-success" type="submit" name="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
</header>
<main>
    <div class="container">
        <?php
        include_once 'config.php';

        $db = new Connection;
        $conn = $db->open();

        function GetMeasures($conn, $dateInput): void {
            if (!preg_match('/^\d{4}(-\d{2})?(-\d{2})?$/', $dateInput)) {
                echo "<p class='text-danger'>Invalid date format. Use YYYY, YYYY-MM, or YYYY-MM-DD.</p>";
                return;
            }

            try {
                $query = "SELECT id, temp_value, dat_value, humidity_value FROM tbl_temp WHERE ";
                if (strlen($dateInput) === 4) {
                    $query .= "DATE_FORMAT(dat_value, '%Y') = :date";
                } elseif (strlen($dateInput) === 7) {
                    $query .= "DATE_FORMAT(dat_value, '%Y-%m') = :date";
                } else {
                    $query .= "DATE(dat_value) = :date";
                }

                $stmt = $conn->prepare($query);
                $stmt->bindParam(':date', $dateInput);
                $stmt->execute();
                $values = $stmt->fetchAll();

                if ($values) {
                    foreach ($values as $vl) {
                        echo '
                            <div class="mjerilo">
                                <div class="row text-center">
                                    <div class="col-md-4">
                                        <p style="font-family: "Roboto"; font-size: 12px; ">Temperatura: ' . $vl['temp_value'] . '°C</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p style="font-family: "Roboto"; font-size: 12px; ">Vlaznost: ' . $vl['humidity_value'] . '%</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p style="font-family: "Roboto"; font-size: 12px; ">Datum: ' . $vl['dat_value'] . '</p>
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                } else {
                    echo "<p class='text-warning'>No measurements found for this date.</p>";
                }
            } catch (PDOException $e) {
                echo "<p class='text-danger'>Error: " . $e->getMessage() . "</p>";
            }
        }

        if (isset($_POST['submit']) && !empty($_POST['date'])) {
            $date = htmlspecialchars(trim($_POST['date']));
            echo "<p>Pretraga za mjerenjima: $date</p>";
            GetMeasures($conn, $date);
        }
        ?>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
