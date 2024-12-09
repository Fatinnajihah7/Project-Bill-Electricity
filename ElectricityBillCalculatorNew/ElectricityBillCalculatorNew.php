<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electricity Bill Calculator</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Electricity Bill Calculator (Domestic Tariff)</h2>
        <form method="POST" action="" class="border p-4 bg-light rounded">
            <div class="form-group">
                <label for="voltage">Voltage (V):</label>
                <input type="number" step="any" name="voltage" id="voltage" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="current">Current (A):</label>
                <input type="number" step="any" name="current" id="current" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="rate">Rate (RM per kWh):</label>
                <input type="number" step="any" name="rate" id="rate" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Calculate</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // User Inputs
            $voltage = $_POST['voltage'];
            $current = $_POST['current'];
            $rate = $_POST['rate'];

            // Function to calculate power in kW
            function calculatePower($voltage, $current) {
                return ($voltage * $current) / 1000; // Convert watts to kilowatts
            }

            // Function to calculate energy for a given hour
            function calculateEnergy($power, $hours) {
                return $power * $hours; // Energy in kWh
            }

            // Function to calculate cost
            function calculateCost($energy, $rate) {
                return $energy * $rate; // Cost in RM
            }

            // Calculate power
            $power = calculatePower($voltage, $current);

            echo "<div class='mt-4 p-4 bg-success text-white rounded'>";
            echo "<h4>Summary:</h4>";
            echo "<p>Power: <strong>" . number_format($power, 4) . " kW</strong></p>";
            echo "<p>Rate: <strong>RM " . number_format($rate, 3) . "</strong> per kWh</p>";
            echo "</div>";

            // Generate Table for 24 Hours
            echo "<table class='table table-bordered mt-4'>";
            echo "<thead class='thead-dark'><tr><th>#</th><th>Hour</th><th>Energy (kWh)</th><th>Total (RM)</th></tr></thead>";
            echo "<tbody>";

            for ($hour = 1; $hour <= 24; $hour++) {
                $energy = calculateEnergy($power, $hour); // Energy for this hour
                $total = calculateCost($energy, $rate);  // Cost for this hour
                echo "<tr>
                        <td>$hour</td>
                        <td>$hour</td>
                        <td>" . number_format($energy, 4) . "</td>
                        <td>RM " . number_format($total, 2) . "</td>
                      </tr>";
            }

            echo "</tbody>";
            echo "</table>";
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>