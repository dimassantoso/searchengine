<?php
	 
	use Skyeng\Lemmatizer;
	use Skyeng\Lemma;

	// Require Composer's autoloader
	require_once __DIR__ . "/vendor/autoload.php";
	
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	ini_set("log_errors", 0);

	$query = strtolower($_GET["query"]);

	$lemmatizer = new Lemmatizer();
	$lemmas = array();
	$lemmas = $lemmatizer->getLemmas($query);
	$query = $lemmas[0]->getLemma();

	$token = explode(" ", $query);

	$start = TRUE;
	$miningResult = fopen("mining.csv", 'r');
	while (($line = fgetcsv($miningResult))!=FALSE) {
		if ($start) {
			$words = $line;
			$start = FALSE;
			continue;
		}
		$features[] = $line;
	}

	fclose($miningResult);

	for ($i=0; $i < sizeof($words) ; $i++) { 
		$count=0;
		for ($j=0; $j < sizeof($token) ; $j++) { 
			if ($words[$i]==$token[$j]) {
				$count++;
			}
		}
		$test[$i] = $count;
	}

	for ($i=0; $i < sizeof($features) ; $i++) { 
		$dotProduct = 0;
		for ($j=0; $j < sizeof($test) ; $j++) { 
			$dotProduct= $dotProduct+($features[$i][$j]*$test[$j]);
		}
		$result[$i]["dotProduct"] = $dotProduct;
		$result[$i]["class"] = $i+1;
	}

	usort($result, function($x, $y){
		return ($x['dotProduct'] > $y['dotProduct']) ? -1 : 1;
	});

	$result = array_slice($result, 0, 10);



	for ($i=0; $i < sizeof($result); $i++) { 
		$handle = fopen("article/".$result[$i]["class"].".txt", "r");
		if ($handle) {
   			while (($line = fgets($handle)) !== false) {  			
   				$title[$i] = $line;
   				//$textArticle
   				break;
    		}

    		$firstLine = fgets($handle);
			while(!feof($handle)){
			  $article[$i] = fgets($handle)."<br>";
			  break;
			}			
			fclose($handle);
    	}

	}

?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $_GET["query"]." - Penelusuran Good'S"; ?></title>
	<link rel="stylesheet" type="text/css" href="semantic/dist/semantic.min.css">
	<script
		  src="https://code.jquery.com/jquery-3.1.1.min.js"
		  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
		  crossorigin="anonymous">
	</script>
	<script src="semantic/dist/semantic.min.js"></script>
	<style type="text/css">
			#header{
				padding: 20px 200px 20px 20px; 
			}
			#container{
				padding: 10px 200px 50px 200px;
			}
		</style>
</head>
<body>

	<div id="header" class="ui grid">
	  <div class="two wide column">
	  	<a href="index"><img src="img/logo.png" width="120px" height="auto"></a>
	  </div>
	  <div class="fourteen wide column">
	  	<form method="GET" action="search.php">
			<div class="ui search">
			  <div class="ui fluid icon input">
			    <input class="prompt" type="text" placeholder="Search" name="query">
			    <i class="search icon"></i>
			  </div>
			  <div class="results"></div>
			</div>
		</form>
	  </div>
	</div>

	<hr>
	<div id="container">
		<h2><b><?php echo "Result for : ".$_GET["query"];?></b></h2>
		<?php for ($i=0; $i < sizeof($result); $i++) { ?>
		<div class="ui fluid card">
		  <div class="content">
		  	<?php $id = $result[$i]["class"]; ?>
		    <div class="ui blue header">
		    	<a href="read?article=<?php echo $id; ?>">
		    		<?php echo $title[$i]; ?>
		    	</a>	
		    </div>
		    <div class="description">
		      <p>
		      	<?php echo $article[$i]; ?>
		      </p>
		    </div>
		  </div>
		  <div class="extra content">
		    <span class="right floated star">
		    	

		    	<!-- <a href="article/<?php echo $result[$i]["class"]?>.txt">Read More <?php echo $result[$i]["class"]?>.txt</a> -->
		    	<a href="read?article=<?php echo $id; ?>">Read More</a>
		    </span>
		  </div>
		</div>
		<?php } ?>
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