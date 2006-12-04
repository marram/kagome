<?php
/*
 * This code needs a major overhaul. It works but is quick and dirty.
 * 
 * 
 */
 $lzdir = "C:\\OL3.3.3\\";
 
 $atmStatesFile = $lzdir . "Server\\lps-3.3.3\\Kagome\\ATM\\atmstates.lzx";
 $atmFile = $lzdir . "Server\\lps-3.3.3\\Kagome\\ATM\\atm.lzx";
 
 $compiler = $lzdir . "bin\\lzc";
 $demobuilder = $lzdir . "Server\\lps-3.3.3\\Kagome\\demoloader.lzx";
 
 $src = $lzdir . "Server\\lps-3.3.3\\Kagome\\build\\demoloader\\atm.lzx.swf";
 $dst = $lzdir . "Server\\lps-3.3.3\\Kagome\\build\\main\\atm.lzx.swf";
 
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
	
	//now, compile and replace demo
	$cmd = $compiler . " " . $demobuilder;
	//write it to a compile batch script
	$batchScript = fopen("compile.bat", 'w');
	fwrite($batchScript, $cmd);
	exec("compile.bat");
	//overwrite compiled demo
	$copyCmd = "copy " . $src . " " . $dst;
	exec($copyCmd);

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