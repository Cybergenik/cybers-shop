<!DOCTYPE html>
<html>
    <head>
        <script src="js/jquery.js"></script>
        <script src="js/script.js"></script>
        <link rel="stylesheet" href="css/style.css">
        
        <script>
            $.getJSON('https://api.coronastatistics.live/all', function(data) {
                countUp('confirmedCases', data.cases);
                countUp('totalDeaths', data.deaths);
                countUp('totalRecovered', data.recovered);
            })

            function countUp(id, countTo) {
                $({ countNum: $(`#${id}`).text()  }).animate({ countNum: countTo }, {
                    duration: 800,
                    easing: 'linear',
                    step: function() {
                        $(`#${id}`).text(Math.floor(this.countNum).toLocaleString());
                    },
                    complete: function() {
                        $(`#${id}`).text(this.countNum.toLocaleString());
                    }
                })
            }
        </script>
    </head>
    <body>
        <div class="banner banner-fullscreen">
            <h1><span>COVID-</span>19</h1>
            <div class="tracker-container">
                <div id="row-data">
                <p class="tracker-bold">Confirmed:</p>
                <p id="confirmedCases"></p>
                </div><p style="padding-right: 10px; padding-left: 10px;">-</p>
                <div id="row-data">
                <p class="tracker-bold">Deaths:</p>
                <p id="totalDeaths"></p>
                </div><p style="padding-right: 10px; padding-left: 10px;">-</p>
                <div id="row-data">
                <p class="tracker-bold">Recovered:</p>
                <p id="totalRecovered"></p>
                </div>
            </div>
            <div class="banner-nav">
                <a href="timeline.html">Timeline</a>
                <a href="safety.html">Safety</a>
            </div>
        </div>
    </body>
</html>