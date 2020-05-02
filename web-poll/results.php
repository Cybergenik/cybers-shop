<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <title>Poll Results</title>
</head>
<body id="bg">
<?php
    include_once('../includes/db.php'); 
    $conn = new Conn();
    $select = "SELECT * FROM web_poll";
    $results = mysqli_query($conn->getConn(), $select);
    $data = Array(mysqli_fetch_array($results));

    $league = ($data[0]['league'] / $data[0]['moba_total']) * 100;
    $dota = ($data[0]['dota'] / $data[0]['moba_total']) * 100;
    $smite = ($data[0]['smite'] / $data[0]['moba_total']) * 100;
    $hots = ($data[0]['hots'] / $data[0]['moba_total']) * 100;

    $mobasData = array( 
        array("label"=>"League of Legends", "y"=>$league),
        array("label"=>"DOTA", "y"=>$dota),
        array("label"=>"Smite", "y"=>$smite),
        array("label"=>"Heroes of the Storm", "y"=>$hots),
    );
    $csgo = ($data[0]['csgo'] / $data[0]['shooter_total']) * 100;
    $overwatch = ($data[0]['overwatch'] / $data[0]['shooter_total']) * 100;
    $cod = ($data[0]['cod'] / $data[0]['shooter_total']) * 100;
    $fortnite = ($data[0]['fortnite'] / $data[0]['shooter_total']) * 100;

    $shootersData = array( 
        array("label"=>"Counter Strike", "y"=>$csgo),
        array("label"=>"Overwatch", "y"=>$overwatch),
        array("label"=>"Call Of Duty", "y"=>$cod),
        array("label"=>"Fortnite", "y"=>$fortnite),
    );
    
    echo "<br><div id='mobasContainer' style='height: 370px; width: 100%; text-color: white;'></div>";
    echo '
    <script>
        var mobas = new CanvasJS.Chart("mobasContainer", {
        animationEnabled: true,
        backgroundColor: null,
        title: {
            text: "MOBA Popularity",
            fontColor: "white"
        },
        subtitles: [{
            text: "2020",
            fontColor: "white"
        }],
        data: [{
            type: "pie",
            indexLabelFontColor: "white",
            yValueFormatString: "#,##0.00\"%\"",
            indexLabel: "{label} ({y})",
            dataPoints: '.json_encode($mobasData, JSON_NUMERIC_CHECK).'
        }]
    });
    mobas.render();
    </script>
    ';
    echo "<br><br><div id='shootersContainer' style='height: 370px; width: 100%; color: white;'></div>";
    echo '
    <script>
        var shooters = new CanvasJS.Chart("shootersContainer", {
        animationEnabled: true,
        backgroundColor: null,
        colorSet:  "colorSet1",
        title: {
            text: "Shooters Popularity",
            fontColor: "white"
        },
        subtitles: [{
            text: "2020",
            fontColor: "white"
        }],
        data: [{
            type: "pie",
            indexLabelFontColor: "white",
            yValueFormatString: "#,##0.00\"%\"",
            indexLabel: "{label} ({y})",
            dataPoints: '.json_encode($shootersData, JSON_NUMERIC_CHECK).'
        }]
    });
    shooters.render();
    </script>
    ';
    $conn->closeConn();
?>
</body>
</html>