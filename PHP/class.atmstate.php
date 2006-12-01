<?php
class atmstate {
	public $b1text;
	public $b2text;
	public $b3text;
	public $b4text;
	public $uid;
	public $title;
	public $message;
	public $root; //root node
		
	public function __construct() {
		 $arr = func_get_args();
		 $arr = $arr[0];
		 $this->uid = $arr["uid"];
		 $this->title = $arr["title"];
		 $this->message = $arr["message"];
	     $this->b1text = $arr["b1text"];
	     $this->b2text = $arr["b2text"];
	     $this->b3text = $arr["b3text"];
	     $this->b4text = $arr["b4text"];	
	     
	     $this->doc = new DOMDocument();
	     $this->root = $this->doc->createElement("class");
	     $this->root = $this->doc->appendChild($this->root);
	}
	
	public function setHandler($num, $apply) {
		$h = $this->doc->createElement("method");
		$h->setAttribute("name", "handlebutton" . $num);
		strlen($apply) > 0 ? $text = $apply . ".apply();" : $text = null;
		if ($text != null) {
		$txtNode = $this->doc->createTextNode($text);
		$h->appendChild($txtNode);
		$this->root->appendChild($h);
		}
		
	}
	public function getName() {
		return $this->title . $this->uid;
	}
	public function doXML() {

		$this->root->setAttribute("name", $this->getName());
		$this->root->setAttribute("extends", "state");
		
		//these should move to a loop
		$b1 = $this->doc->createElement("attribute");
		$b1->setAttribute("name", "b1label");
		$b1->setAttribute("type", "string");
		$b1->setAttribute("value", $this->b1text);

		$b2 = $this->doc->createElement("attribute");
		$b2->setAttribute("name", "b2label");
		$b2->setAttribute("type", "string");
		$b2->setAttribute("value", $this->b2text);
		
		$b3 = $this->doc->createElement("attribute");
		$b3->setAttribute("name", "b3label");
		$b3->setAttribute("type", "string");
		$b3->setAttribute("value", $this->b3text);

		$b4 = $this->doc->createElement("attribute");
		$b4->setAttribute("name", "b4label");
		$b4->setAttribute("type", "string");
		$b4->setAttribute("value", $this->b4text);

		$msg = $this->doc->createElement("attribute");
		$msg->setAttribute("name", "message");
		$msg->setAttribute("type", "string");
		$msg->setAttribute("value", $this->message);	

			
		$this->root->appendChild($b1);
		$this->root->appendChild($b2);
		$this->root->appendChild($b3);
		$this->root->appendChild($b4);
		$this->root->appendChild($msg);
	}
	
	public function getXML() {
		return $this->doc->saveXML();
	}
	

	

}
?>