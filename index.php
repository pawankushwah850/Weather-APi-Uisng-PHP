<?php
    if(isset($_GET['submit'])){

        $id= $_GET['CityId'];
        $data=getd($id);
    }
    else{
         $data=getd("1273294");
    }
    $currentTime = time();

    function getd($id)
    {
        $apiKey = "147d3e5b76090779e4ab96ca45fbd7f1";
        $cityId = $id;

        if(is_numeric($id)) {$googleApiUrl = "http://api.openweathermap.org/data/2.5/weather?id=" . $cityId . "&lang=en&units=metric&APPID=" . $apiKey;}
        elseif (is_string($id)) {
            $googleApiUrl="api.openweathermap.org/data/2.5/weather?q=".$id."&lang=en&units=metric&APPID=" .$apiKey;
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);

        curl_close($ch);
        $data = json_decode($response);
    
        return $data;
    }
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Weather Report</title>
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../jquery/jquery.js"></script>
    <script src="../bootstrap/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>

</head>
<body>

    <div class="container">
       <div class="row">
        <div class="col-sm-12">
            <h1 class="bg-dark text-warning text-center text-uppercase font-weight-bold" style="letter-spacing: 3px">Weather Info </h1>
            <br><br>
        </div>
            <div class="col-sm-12">
                <form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF']); ?>" method="GET">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="CItyId" class="text-info" style="font-family: fantasy; font-weight: 600;
                            letter-spacing: 2px; font-size: 25px;">City Id / Name : </label>
                            <input type="tel" name="CityId" id="city" class="form-control" required>
                        </div>
                        <div class="col-sm-12">
                            <br>
                            <input type="submit" value="Submit" name="submit" class="btn btn-success p-2 offset-5" style="width:20%; letter-spacing: 3px; font-weight: 600; ">
                        </div>
                    </div>
                    <br>
                    <br>
                </form>
            </div>
           <div class="col-sm-12">
            <div class="card offset-4 p-2" style="width: 400px; ">
            <div class="card-header text-center" style="font-weight: 600; font-family: monospace;">
                <?php echo "Country : ".$data->sys->country; ?>
            </div>
            <div class="card-body bg-secondary text-light text-center" style="word-spacing: 4px; font-family: cursive; ">
                <div><?php echo date("l g:i a", $currentTime); ?></div>
                <div><?php echo date("jS F, Y",$currentTime); ?></div>
                <hr style="width: 100%; background-color: white">
                <div><?php echo ucwords($data->weather[0]->description); ?></div>
                <hr style="width: 100%; background-color: white">
           
            <div>
            <img
                src="http://openweathermap.org/img/w/<?php echo $data->weather[0]->icon; ?>.png"
                class="weather-icon" />
               <span> <?php echo $data->main->temp_max; ?>&deg;C</span>
                <span
                class="min-temperature"><?php echo $data->main->temp_min; ?>&deg;C</span>
                 <hr style="width: 100%; background-color: white">
            </div>
            <div class="time">
                <div>Humidity: <?php echo $data->main->humidity; ?> %</div>
                <div>Wind: <?php echo $data->wind->speed; ?> km/h</div>
            </div>
            </div>
            <div class="card-footer">
                 <div class="bg-light text-dark text-center" style="font-family: monospace;
                 font-weight: 700; letter-spacing: 1px;"><?php echo "City Name: ".$data->name."'s"; ?> Weather </div>
            </div>
        </div>
           </div>
       </div>
    </div>

<script>
    
</script>
</body>
</html>
