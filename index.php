<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class="container">
    <header class="header">
        <div class="container nav">
            <a href="#" class="logo">
                <img src="logo.png" width="364" height="58" alt="logo">
            </a>
            <form action="" method="post">
                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Search City" aria-label="Search City" id="cityInput" name="city" required>
                    </div>
                    <div class="col">
                        <input type="submit" class="btn btn-primary" name="Search" value="Search">
                    </div>
                </div>
            </form>
        </div>
    </header>
    
    <section class="container">
        <?php
            if (isset($_POST['city'])) {
                $chosenCity = $_POST['city'];
            }
            else {
                echo '';
                exit;
            }
            $url = "https://api.openweathermap.org/data/2.5/forecast?q=" . $chosenCity . "&appid=f910019ea53081dada81c7c130f6691b&units=metric";
            $contents = file_get_contents($url);
            $clima = json_decode($contents);
            if ($clima) {
                $city_name = $clima->city->name;
            } 
            else {
                echo 'Please enter a valid city name';
                exit;
            }
        ?>

        <h2 class="forecast container">5-Days Forecast for <?php echo $city_name; ?></h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Day</th>
                    <th scope="col">Month</th>
                    <th scope="col">Time</th>
                    <th scope="col">Temperature (°C)</th>
                    <th scope="col">Feels Like (°C)</th>
                    <th scope="col">Temp Min (°C)</th>
                    <th scope="col">Temp Max (°C)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clima->list as $list) {
                    $date = date('Y-m-d', $list->dt);
                    $day = date('l', $list->dt);
                    $month = date('F', $list->dt);
                    $time = date('H:i:s', $list->dt);
                    $weatherIcon = $list->weather[0]->icon;
                    $iconUrl = "http://openweathermap.org/img/w/" . $weatherIcon . ".png";
                    $temp = $list->main->temp;
                    $feelsLike = $list->main->feels_like;
                    $tempMin = $list->main->temp_min;
                    $tempMax = $list->main->temp_max;
                    echo "
                        <tr>
                            <td>" . $date . "</td>
                            <td>" . $day . "</td>
                            <td>" . $month . "</td>
                            <td>" . $time . "</td>
                            <td><img src='" . $iconUrl . "' alt='" . $list->weather[0]->description . "'>" . $temp . "</td>
                            <td>" . $feelsLike . "</td>
                            <td>" . $tempMin . "</td>
                            <td>" . $tempMax . "</td>
                        </tr>
                    ";
                } ?>
            </tbody>
        </table>       
    </section>

    <footer class="footer">
        <p class="body-3">
            Copyright 2023 Nayeem Khan. All Rights Reserved
        </p>
        <p class="body-3">
            Powered By
            <a href="https://openweathermap.org/api" title="Free OpenWeather Api" target="_blank" rel="noopener" >
                <img src="openweather.png" width="150" height="30" loading="lazy" alt="OpenWeather" />
            </a>
        </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>