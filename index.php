<html>
	<head>
		<title>Good'S</title>
		<link rel="stylesheet" type="text/css" href="semantic/dist/semantic.min.css">
		<script
		  src="https://code.jquery.com/jquery-3.1.1.min.js"
		  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
		  crossorigin="anonymous"></script>
		<script src="semantic/dist/semantic.min.js"></script>
		<style type="text/css">
			body{
				padding: 200px;
			}
		</style>
	</head>
	<body>
		<div id="container">
		<center><img src="img/logo.png" data-content="Thanks to SKYENG for LEMMATIZER library" width="300px" height="auto"></center>
		<br><br>
		<form method="GET" action="search">
			<div class="ui search">
			  <div class="ui fluid icon input">
			    <input class="prompt" type="text" placeholder="Search" name="query">
			    <i class="search icon"></i>
			  </div>
			  <div class="results"></div>
			</div>
		</form>
		</div>			
	</body>
</html>
<script type="text/javascript">
	$(document).ready(function () {
            var content = [
            { title: 'Taufik Hidayat' },
			{ title: 'Lee Chong Wei' },
  			{ title: 'Kevin Sanjaya' },
  			{ title: 'Marcus Gideon' },
  			{ title: 'Indonesia' },
  			{ title: 'Susi Susanti' },
  			{ title: 'Rudy Hartono' },
  			{ title: 'China' },
  			{ title: 'Lin Dan' },
  			{ title: 'Peter Gade' },
  			{ title: 'Malaysia' },
  			{ title: 'Lee Young Dae' },
  			{ title: 'Badminton' },
  			{ title: 'USA' },
  			{ title: 'Tony Gunawan' },
 			{ title: 'Japan' },
		  	{ title: 'Taufik' },
		  	{ title: 'Rexy' },
		  	{ title: 'Liem Swie King' },
		  	];

            $('.ui.search')
                .search({
                    type: 'standard',
                    source: content,
                    searchFields: ['title'],
                });

        });
</script>