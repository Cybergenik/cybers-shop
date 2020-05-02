<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/main.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <title>Web Poll</title>
    <script>
        function graph(){
            var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            title: {
                text: "Usage Share of Desktop Browsers"
            },
            subtitles: [{
                text: "November 2017"
            }],
            data: [{
                type: "pie",
                yValueFormatString: "#,##0.00\"%\"",
                indexLabel: "{label} ({y})",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
        
        }
    </script>
</head>
<body id="bg">
<?php if(!isset($_COOKIE['voted'])) :?>
    <?php
        include_once('../includes/db.php');
        $conn = new Conn();
        $select = "SELECT * FROM web_poll";
        $results = mysqli_query($conn->getConn(), $select);

        $data = Array(mysqli_fetch_array($results));
        $x = false;
        if(!empty($_POST)){
            //Make sure fields are filled
            if(empty($_POST['moba']) || empty($_POST['shooter'])){
                echo "<h4 style='text-align: center'>Please fill out all fields<h4>";
            }
            else{
                $moba = $data[0][$_POST['moba']] + 1;
                $moba_total = $data[0]['moba_total'] + 1;
                $shooter =  $data[0][$_POST['shooter']] + 1;
                $shooter_total = $data[0]['shooter_total'] + 1;
                $insert = "UPDATE web_poll 
                           SET ".$_POST['moba']." = $moba, ".$_POST['shooter']." = $shooter, moba_total = $moba_total, shooter_total = $shooter_total 
                           WHERE id = 1";
                mysqli_query($conn->getConn(), $insert);
                setcookie('voted', true, time()+86400, '/');
                $x = true;
            }
        }
    ?>
    <?php if (empty($_POST) || !$x) :?>
        <form class="flex-container" action="index.php" method="post">
        <h2>What is your favorite MOBA:</h2><br>
            <div>
                <input name="moba" id="league" type="radio" value="league">
                <label for="league">League of Legends</label><br>        
                    <input name="moba" id="dota" type="radio" value="dota">
                <label for="dota">DOTA</label><br>        
                    <input name="moba" id="smite" type="radio" value="smite">
                <label for="smite">Smite</label><br>        
                    <input name="moba" id="hots" type="radio" value="hots">
                <label for="hots">Heroes of the Storm</label><br>
            </div><br>       

            <h2>What is your Favorite Shooter:</h2><br>
            <div style="left: 100px">
                    <input name="shooter" id="csgo" type="radio" value="csgo">
                <label for="csgo">Counter Strike(csgo)</label><br>        
                    <input name="shooter" id="overwatch" type="radio" value="overwatch">
                <label for="overwatch">Overwatch</label><br>        
                    <input name="shooter" id="cod" type="radio" value="cod">
                <label for="cod">Call of Duty</label><br>        
                    <input name="shooter" id="fortnite" type="radio" value="fortnite">
                <label for="fortnite">Fortnite</label>        
            </div><br> 

            <div class="flex-container2">
                <input class="mybutton" type="submit">
                <input class="mybutton" type="reset">
            </div>
        </form>';
    <?php elseif ($x) :
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
        
        echo '<br><div id="mobasContainer" style="height: 370px; width: 100%; text-color: white;"></div>
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
        echo '<br><br><div id="shootersContainer" style="height: 370px; width: 100%; color: white;"></div>
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
    <?php endif ?>
<?php else: header('Location: results.php');?>
<?php endif ?>
</body>
</html>