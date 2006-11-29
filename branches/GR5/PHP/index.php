<?php
	$graph = $_GET['graph'];
	$file = "testFile.txt";
	$fh = fopen($file, 'w');
	fwrite($fh, $graph);
	//fwrite($fh, print_r(json_decode($graph)));
	fclose($fh);
	//print_r(json_decode($graph));
	print("<OK />");
	
?>