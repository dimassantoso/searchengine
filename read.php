<?php 
	$id = $_GET['article'];
?>
<html>
	<head>
		<title>Read</title>
		<link rel="stylesheet" type="text/css" href="semantic/dist/semantic.min.css">
		<script
		  src="https://code.jquery.com/jquery-3.1.1.min.js"
		  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
		  crossorigin="anonymous"></script>
		<script src="semantic/dist/semantic.min.js"></script>
		<style type="text/css">
			body {
				padding: 10px 200px 50px 200px;
			}
		</style>
	</head>
	<body>
		<div class="ui grid">
  			<div class="sixteen wide column">
  				<div class="ui segment">
  					<?php $handle = fopen("article/".$id.".txt", "r");
  						if ($handle) {?>  							
  					<div class="ui blue header"><?php echo fgets($handle);?></p></div>
  					<p class="description" style="text-align:justify;"><?php 
	  						while(!feof($handle)) {
	  								echo fgets($handle) . "<br>";
	  						}	?>	
  					</p>
  					<?php fclose($handle); }?>
				</div>
  			</div>
		</div>	
	</body>
</html>