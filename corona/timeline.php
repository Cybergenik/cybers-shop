<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery.js"></script>
    <script src="js/script.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>Timeline</title>
    <script>
    $(document).ready(function(){
        var casesData = [];
        var deathData = [];
        var recoveredData = [];
        var chart = new CanvasJS.Chart("chartContainer", {
        //theme: "light2", // "light1", "light2", "dark1", "dark2"
        theme: "dark2",
        animationEnabled: true,
	    zoomEnabled: true,
        animationEnabled: true,
        title:{
            text: "2020 Global COVID-19 spread",
            verticalAlign: "top",
            horizontalAlign: "center",
            padding:{
                right: 600,
            }
        },
        axisX:{
            title: "Day",
            valueFormatString: "MM/DD",
            interval: 5

        },
        axisY:{
            title: "People",
            titleFontColor: "#6D78AD",
            lineColor: "#6D78AD",
            gridThickness: 0,
            lineThickness: 1,
            includeZero: true,
        },
        legend: {
            cursor: "pointer",
            verticalAlign: "center",
            fontSize: 15,
            dockInsidePlotArea: true
            },
        toolTip: {
            shared: true
        },
        data: [{
            type: "spline",
            name: "Cases",
            markerSize: 5,
            showInLegend: true,
            dataPoints: casesData,
            
        },
        {
            type: "spline",
            name: "Recovered",
            markerSize: 5,
            showInLegend: true,
            dataPoints: recoveredData,
        },
        {
            type: "spline",
            name: "Deaths",
            markerSize: 5,
            showInLegend: true,
            dataPoints: deathData,
        }]
        });
        function addData(data) {
            for (var i = 0; i < Object.keys(data).length; i++) {
                year = parseInt(Object.keys(data)[i].split('-')[0]);
                month = parseInt(Object.keys(data)[i].split('-')[1]) - 1;
                day = parseInt(Object.keys(data)[i].split('-')[2]);
                casesData.push({
                    x: new Date(year, month, day),
                    y: data[Object.keys(data)[i]].cases,
                });
                deathData.push({
                    x: new Date(year, month, day),
                    y: data[Object.keys(data)[i]].deaths,
                });
                recoveredData.push({
                    x: new Date(year, month, day),
                    y: data[Object.keys(data)[i]].recovered,
                });

            };
        chart.render();
        }
    $.getJSON("https://api.coronastatistics.live/timeline/global", addData);
    });
    </script>
</head>
<body>
    <div class="banner">
		<h1><span>COVID-</span>19</h1>
		<p>Everything you need to know</p>
    </div>
    <nav>
        <a href="index.php">Home</a>
        <a href="timeline.php" class="active">Timeline</a>
        <a href="safety.php">Safety</a>
    </nav>

    <div id="chartContainer" style="height: 70%; width: 90%; padding: 1%; padding-left: 3%;"></div>
</body>
</html>