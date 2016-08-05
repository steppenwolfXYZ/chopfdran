<?php
abstract class ContentPart extends DBObject {
	protected $contentId;
	protected $content;
	protected $contentText;
	protected $contentText2;
	
	public function __construct(PDO $db, array $contentRow) {
		parent::__construct($db);
		$this->contentId = $contentRow['id'];
		$this->contentText = utf8_encode(str_replace("\r\n", "<br />\r\n",$contentRow['content']));
		$this->contentText2 = utf8_encode($contentRow['content2']);
		$this->init();
	}
	
	abstract protected function init();
	
	public function getContent() {
		return $this->content;
	}
}
?>