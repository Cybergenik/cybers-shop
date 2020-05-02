<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="js/jquery.js"></script>
        <script src="js/script.js"></script>
        <script src="js/jquery-ui.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">
        <script>
            var html = '';
                $.getJSON('data/safety-items.json',function (data) {
                    $.each(data, function (key, value) {
                        //each sub-object in the JSON object
                        $.each(value, function (index, stuff){
                            html += '<div class="card" style="background: #8cb3ff;">';
                            html += '   <div class="card-header" id="heading'+index+'">';    
                            html += '       <button class="mybutton" type="button" data-toggle="collapse" data-target="#item'+index+'" aria-expanded="true" aria-controls="item'+index+'">'+(index + 1)+'. '+ stuff.title +'</a>';
                            html += '   </div>';
                            html += '   <div class="collapse" id="item'+index+'" aria-labelledby="item'+index+'" data-parent="#accordion">';
                            html += '   <div class="flex-safety" class="card-body">';
                            html += '       <img src="' + stuff.img + '" style="width: 25%; height: 15%;" alt="image of safety">';
                            html += '       <p id="content">' + stuff.desc + '</p>';
                            html += '   </div>';
                            html += '   </div>';
                            html += '</div>';
                        });
                    });
                    $('#accordion').html(html);
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
            <a href="timeline.php">Timeline</a>
            <a href="safety.php" class="active">Safety</a>
        </nav>

        <div id="accordion" class="accordion" class="flex-container">
            
        </div>
        <footer>

        </footer>
    </body>
</html>