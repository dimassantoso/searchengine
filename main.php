<?php
	use Skyeng\Lemmatizer;
	use Skyeng\Lemma;

	// Require Composer's autoloader
	require_once __DIR__ . "/vendor/autoload.php";
	
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	ini_set("log_errors", 0);

	$document = read();
	$stopWords = loadStopWord();
	$token = tokenizing($document);
	$filter = filtering($token, $stopWords);
	$stem = stemming_tagging($filter);
	countWords($stem);


	function read(){
		$setences = "";
		for ($i=1; $i <= 100; $i++) { 		
			$myfile = fopen("article/".$i.".txt", "r") or die("Unable to open file!");	
			$text = strtolower(preg_replace('/[^a-z]+/i', ' ', fread($myfile,filesize("article/1.txt"))));
			$articles[] = $text;
			$setences = $setences." ".$text;
			fclose($myfile);
		}
		$document = explode(" ", $setences);

		return $document;
	}

	function loadStopWord(){
		//$stopwords = array();	
		$handle = fopen("stopwords.txt", "r");
		if ($handle) {
	   		while (($line = fgets($handle)) !== false) {  			
	   			$stopWords[] = trim($line); 
	    	}
	   		fclose($handle);
	   	}
		return $stopWords;
	}
	
	function tokenizing($input){
		$words = [];
		for ($i=0; $i < sizeof($input); $i++) { 
			if (!in_array(trim($input[$i]), $words) && (strlen($input[$i]) > 3))  {
	    		$words[] = $input[$i];
			}
		}
		// print "Tokenizer :";
		// print "<pre>";
		// print_r($words);
		// print "</pre>";
		return $words;
	}
	function filtering($input, $stopWords){

		foreach($input as $value){
		    if(!in_array(strtolower($value), $stopWords)){
		        $result[] = $value;
		    }
		}   

	 //    print "Filtering :";
		// print "<pre>";
		// print_r($result);
		// print "</pre>";

		return $result;
	}

	function stemming_tagging($input){
		$lemmatizer = new Lemmatizer();
		$lemmas = array();
		foreach($input as $value){
			$lemmas = $lemmatizer->getLemmas($value);
			$result[] = $lemmas[0]->getLemma(); 
		}

		// print "Stemming :";
		// print "<pre>";
		// print_r($result);
		// print "</pre>";

		return $result;
		// $var_name=array('A','B','C');
		// if (is_array($input))
		// 	echo 'This is an array....';
		// else
		// 	echo 'This is not an array....';
    

	}

	function countWords($stem){

		for ($i=1; $i <= 100; $i++) { 		
			$myfile = fopen("article/".$i.".txt", "r") or die("Unable to open file!");	
			$text = strtolower(preg_replace('/[^a-z]+/i', ' ', fread($myfile,filesize("article/1.txt"))));
			$articles[] = $text;
			fclose($myfile);
		}

		$data = array();
		$data[0] = $stem;

		$lemmatizer = new Lemmatizer();
		$lemmas = array();


		for ($i=0; $i < sizeof($articles) ; $i++) { 
			$count = 0;
			$lemmas = $lemmatizer->getLemmas($articles[$i]);
			$articles[$i] = $lemmas[0]->getLemma();
			$words = explode(" ", $articles[$i]);
			for ($j=0; $j < sizeof($stem) ; $j++) { 
				$count=0;
				for ($k=0; $k < sizeof($words); $k++) { 
					if($stem[$j]==$words[$k]){
						$count++;
					}
				}
				$data[$i+1][$j] = $count;
			}
		}
	
		$fp = fopen('mining.csv', 'w');
		foreach ($data as $fields) {
	    	fputcsv($fp, $fields);
		}
		fclose($fp);
	}

?>