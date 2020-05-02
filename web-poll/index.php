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
                mysqli_query($conn, $insert);
                $x = true;
            }
        }
        //Display Form
        if (empty($_POST) || !$x){
            echo '<form class="flex-container" action="index.php" method="post">';
            echo '<h2>What is your favorite MOBA:</h2><br>';
            echo '<div>';
            echo '    <input name="moba" id="league" type="radio" value="league">';
            echo '<label for="league">League of Legends</label><br>';        
            echo '    <input name="moba" id="dota" type="radio" value="dota">';
            echo '<label for="dota">DOTA</label><br>';        
            echo '    <input name="moba" id="smite" type="radio" value="smite">';
            echo '<label for="smite">Smite</label><br>';        
            echo '    <input name="moba" id="hots" type="radio" value="hots">';
            echo '<label for="hots">Heroes of the Storm</label><br>';
            echo '</div><br>';       

            echo '<h2>What is your Favorite Shooter:</h2><br>';
            echo '<div style="left: 100px">';
            echo '    <input name="shooter" id="csgo" type="radio" value="csgo">';
            echo '<label for="csgo">Counter Strike(csgo)</label><br>';        
            echo '    <input name="shooter" id="overwatch" type="radio" value="overwatch">';
            echo '<label for="overwatch">Overwatch</label><br>';        
            echo '    <input name="shooter" id="cod" type="radio" value="cod">';
            echo '<label for="cod">Call of Duty</label><br>';        
            echo '    <input name="shooter" id="fortnite" type="radio" value="fortnite">';
            echo '<label for="fortnite">Fortnite</label>';        
            echo '</div><br>'; 

            echo '<div class="flex-container2">';
            echo '  <input class="mybutton" type="submit">';
            echo '  <input class="mybutton" type="reset">';
            echo '</div>';
            echo '</form>';
        }
        //Display Poll Results
        elseif ($x){
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
        }
    ?>
</body>
</html>