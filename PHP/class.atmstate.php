<?php
class atmstate {
	public $b1text;
	public $b2text;
	public $b3text;
	public $b4text;
	public $uid;
	public $title;
	
	public function __construct(uid, title, b1text, b2text, b3text, b4text) {
		$this->Args = func_get_args();
	}
	
	public function toXML() {
		$doc = new dom
	}
}
?>