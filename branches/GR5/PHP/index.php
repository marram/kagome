<?php
/*
 * This code needs a major overhaul. It works but is quick and dirty.
 * 
 * 
 */
 
 $atmStatesFile = "C:\\OL333\\Server\\lps-3.3.3\\Kagome\\ATM\\atmstates.lzx";
 $atmFile = "C:\\OL333\\Server\\lps-3.3.3\\Kagome\\ATM\\atm.lzx";
 
 $compiler = "C:\\OL333\\bin\\lzc";
 $demobuilder = "C:\\OL333\\Server\\lps-3.3.3\\Kagome\\demoloader.lzx";
 
 $src = "C:\\OL333\\Server\\lps-3.3.3\\Kagome\\build\\demoloader\\atm.lzx.swf";
 $dst = "C:\\OL333\\Server\\lps-3.3.3\\Kagome\\build\\main\\atm.lzx.swf";
 
	require("class.atmstate.php");
	set_magic_quotes_runtime(0);
	$graph = $_GET['graph'];
	$graph = stripslashes($graph);

	$fh = fopen("testFile.txt", 'w');
	fwrite($fh, $graph);
	
	$graphObj = json_decode($graph, true);
	
	$nodes = array();
	foreach ($graphObj["nodes"] as $node) {
		$nObj = new atmstate($node);
		$nObj->doXML();
		array_push($nodes, $nObj);
	}
	
	
	$atmStates = new DOMDocument();
	$lib = $atmStates->createElement("library");
	$lib = $atmStates->appendChild($lib);
	
	setHandlers($nodes, $graphObj["edges"]);
	


	foreach ($nodes as $node) {
				for ($i=1; $i <5; $i++) {
			if (!in_array($i, $node->handlers))
				$node->setHandler($i, "");
		}
		$content = $atmStates->importNode($node->root, true);
		$lib->appendChild($content);
	}

	$fh = fopen($atmStatesFile, 'w');
	fwrite($fh, $atmStates->saveXML());
	fclose($fh);
	print("<OK />");
	
	writeATMFile($atmFile, $nodes);
	function setHandlers($nodes, $edges) {
		
		$snodes = array();
		foreach ($edges as $edge ) {	
			$sNode = getNodeByUID($nodes, $edge["from"]);
			$tNode = getNodeByUID($nodes, $edge["to"]);
			$sNode->setHandler($edge["sourceButton"], $tNode->getName());				
		}
	}
	
	
	function writeATMFile($file, $nodes) {
		$doc = new DOMDocument();
		$doc->load($file);	
		$atmNode = $doc->getElementsByTagName("atm")->item(0);
		while ($atmNode->firstChild != null)
			$atmNode->removeChild($atmNode->firstChild);
		$i = 0;
		foreach ($nodes as $node) {
			$s = $doc->createElement($node->getName());
			$s->setAttribute("name", $node->getName());
			$i == 0 ? $s->setAttribute("apply", "true") : $s->setAttribute("apply", "false");
			$atmNode->appendChild($s);
			$i++;
		}
		//$atmNode = $newAtmNode;
		$doc->save($file);
	}
	
	function getNodeByUID($nodes, $uid) {
		foreach ($nodes as $node) {
			if ($node->uid == $uid) return $node;
			
		}
	}
?>