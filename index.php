<?php

$xml = simplexml_load_file("https://biblioottawalibrary.ca/branches.xml"); //returns a SimpleXMLElement object

//Retrieve list of Ottawa libraries and hours

$branch_info = $xml->xpath("/BranchesInfo/BranchInfo"); //Equivalent to $branch_info = $xml->xpath("/BranchesInfo")[0]. To access all the children of the root element, remember that XML is an ARRAY
$branch_hours = $xml->xpath("/BranchesInfo/BranchInfo/BranchHours/Hours");

//var_dump($branch_info);
//var_dump ($branch_info->BranchInfo->BranchHours->Hours);



//The OpenWeatherMap API gives today's weather

$url = "http://api.openweathermap.org/data/2.5/weather?id=6094817&lang=en&units=metric&APPID=5f8ed8c6214982807a0188f7e1161f95";
$contents = file_get_contents($url);
$climate=json_decode($contents);

//Get and set weather details

$temp_max = $climate->main->temp_max;
$temp_min = $climate->main->temp_min;
$icon = $climate->weather[0]->icon.".png";
$weather_desc = $climate->weather[0]->main;
$weather_details = $climate->weather[0]->description;
$pressure = $climate->main->pressure;
$humidity = $climate->main->humidity;
$cityname = $climate->name;
/*$today = date("F j, Y, g:i a");*/


//Message for visitors

if ($weather_desc == "Thunderstorm"){
    $msg = "There is a thunderstorm warning, take care.";
} else if ($weather_desc == "Drizzle"){
    $msg = "Expect light showers today.";
} else if ($weather_desc == "Rain") {
    $msg = "Take your umbrella if you're going out today!";
} else if ($weather_desc == "Snow") {
    $msg = "Expect to see snowflakes today.";
} else if ($weather_desc == "Atmosphere") {
    $msg = "Chances of fog throughout the day.";
} else if ($weather_desc == "Clear") {
    $msg = "A beautiful clear day to visit the library!";
} else if ($weather_desc == "Clouds") {
    $msg = "Don't let the clouds stop you from reading today.";
} else if ($weather_desc == "Extreme") {
    $msg = "Stay at home today! Extreme weather warning.";
}



?>


<!DOCTYPE html>
<html lang= "en">
<head>
    <title>Ottawa Libraries</title>
    <link rel="stylesheet" href="css/main.css">
    <script type="text/javascript" src="js/script.js" ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
</head>
<body>


<div class="page-wrapper">
<header>
    <img id="logo" src="img/logo.png">
</header>

<main>


    <!-- Weather API -->

    <div class="weather_icon">
        <img src='http://openweathermap.org/img/w/<?php echo $icon; ?>'/ ><br>
        <span id="weather_quote"> <?php echo $weather_details; ?></span><br>
        <p class="weather_msg">"<?php echo $msg; ?>"</p>


        <div class="weather_deets">
            <!--<span><?php /*echo $cityname; */?></span><br>-->
            <!--<span><?php /*echo $today; */?></span><br>-->
            <span> Temp Max: <?php echo $temp_max; ?> &deg;C </span><br>
            <span> Temp Min: <?php echo $temp_min; ?> &deg;C </span><br>

            <span> Pressure: <?php echo $pressure; ?> hPA </span><br>
            <span> Humidity: <?php echo $humidity; ?> % </span>
        </div>
    </div>




    <h1>Ottawa Libraries</h1>

    <p>
        This website was designed to assist the public with finding a list of Ottawa libraries, including their
        location and hours of operation.
    </p>



    <!-- Library-specific Info -->

        <div class="library-info">
            <p><strong>Please select a library branch.</strong></p>
        </div>


    <!-- List of Libraries -->

            <div id="library_list">
                <?php foreach ($branch_info as $info) : ?>
                    <div class="location onelibrary">
                        <a class="library" href=""><?php echo $info->Name; ?></a>
                            <!-- Regular Hours -->
                            <div class="hidden">
                                <h2><?php echo $info->Name; ?> Library</h2>

                                <p><i><?php echo $info->Address; ?>, Ottawa, ON </i></p>

                                <br>

                                <p><strong>Hours:</strong></p>
                                    <?php foreach ($info->BranchHours->Hours as $hours) : ?>
                                        <ul><?php echo $hours->DayOfWeek; ?>
                                                <!-- Make it so that CLOSED - CLOSED doesn't appear -->
                                                <?php /*** NOT WORKING ***/
                                                if (strcmp($hours->Open, $hours->Close) == 0 ){
                                                    //Sometimes when you directly compare two strings, it doesn't work, so use strcmp()
                                                    echo "<li>" . $hours->Open . "</li>";
                                                } else {
                                                    echo "<li>" . $hours->Open . " - " .  $hours->Close . "</li>";
                                                }

                                                ?>
                                        </ul>
                                    <?php endforeach; ?>

                                <!--Holiday Hours-->

                                <div class="holiday_hours" ><strong> Holiday Closures:</strong>
                                    <div class="hidden2">
                                        <ul>
                                            <?php foreach ($info->HolidayClosures->HolidayClosure as $holiday) : ?>
                                                <li><?php echo $holiday->HolidayName; ?> - <?php echo $holiday->HolidayDate; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>

                                <div class="stash">
                                    <p class="lat"><?php echo $info->Coordinates->Latitude; ?></p>
                                    <p class="long"><?php echo $info->Coordinates->Longitude; ?></p>
                                </div>
                            </div> <!--end of hidden class -->
                    </div>
                <?php endforeach; ?>
            </div><!-- end of library list -->


    <!-- Google Location Map -->

    <div id="map" style="height: 500px; width: 500px"></div> <!--Placeholder for map-->


</div> <!-- end of page wrapper -->
</main>

<footer>
        <p>This is an API project created for Humber College, 2017.</p>
</footer>



<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmAcgMQfy4NMOlyJqv7vycSSwu3bChk4I">
   /* Removed initializeMap function portion because it looks for f(x) with empty parameters, which I don't have during page load*/
    <!--Place script to connect to API below all content so it loads last; Add API key here, callback is f(x) called after API load-->
</script>


</body>
</html>

