<?php
/*
	
	# PHP Markdown Parser
	
	A PHP class used to parse markdown.
	
	+	Build 0
	+	(c) 2012 Matt Rohland
	+	github@mattrohland.com
	
*/
if(!class_exists('Markdown')) throw new Exception('Markdown is already defined.');
class Markdown{
	
	/*
		## Public variables
		===
	*/
	public $markdown = ''; // The markdown content
	
	/*
		## Private variables
		===
	*/
	public static $processedDefault = array(
		'html' => false
	);
	private $processed = array(
		'html' => false
	);
	
	/*
		## Public methods
		===
	*/
	public function get($userProvidedMarkdown = false, $format = 'html'){
		if($userProvidedMarkdown) $this->set($userProvidedMarkdown);
		if(!$this->processed[$format]) $this->process($format);
		return $this->processed[$format];
	}

	public function set($userProvidedMarkdown){
		$this->markdown = $userProvidedMarkdown;
		$this->processed = self::$processedDefault;
		return true;
	}
	
	/*
		## Private methods
		===
	*/
	private function process($format){
		$processedData = $this->markdown;
		switch($format):
			case 'html':
				$processedData = $this->markdownToHTML($processedData);
				break;
		endswitch;
		$this->processed[$format] = $processedData;
		return $this->processed[$format];
	}
	
	private function markdownToHTML($data){
		$patternArray = array();
		$replaceArray = array();
		$i = 0;
		
		/*
			### Resolve Block Elements
		*/
		
		// Line breaks
		$patternArray[] = "/(\r?\n){1}/";
		$replaceArray[] = "<br>";
		
		// Paragraphs
		$patternArray[] = "/^(.*)$/s";
		$replaceArray[] = "<p>$1</p>";
		$patternArray[] = "/(<br>){2}/s";
		$replaceArray[] = "</p><p>";
		
		// Headers
		$patternArray[] = "/(?:(?:<p>)?<br>|<p>)\s?#{6}\s?(.*?)\s?(?:<br>|<\/p>|(<.*?>))/";
		$replaceArray[] = '<h6>$1</h6>$2';
		$patternArray[] = "/(?:(?:<p>)?<br>|<p>)\s?#{5}\s?(.*?)\s?(?:<br>|<\/p>|(<.*?>))/";
		$replaceArray[] = '<h5>$1</h5>$2';
		$patternArray[] = "/(?:(?:<p>)?<br>|<p>)\s?#{4}\s?(.*?)\s?(?:<br>|<\/p>|(<.*?>))/";
		$replaceArray[] = '<h4>$1</h4>$2';
		$patternArray[] = "/(?:(?:<p>)?<br>|<p>)\s?#{3}\s?(.*?)\s?(?:<br>|<\/p>|(<.*?>))/";
		$replaceArray[] = '<h3>$1</h3>$2';
		$patternArray[] = "/(?:(?:<p>)?<br>|<p>)\s?#{2}\s?(.*?)\s?(?:<br>|<\/p>|(<.*?>))/";
		$replaceArray[] = '<h2>$1</h2>$2';
		$patternArray[] = "/(?:(?:<p>)?<br>|<p>)\s?#{1}\s?(.*?)\s?(?:<br>|<\/p>|(<.*?>))/";
		$replaceArray[] = '<h1>$1</h1>$2';
		
		// Ordered Lists
		$patternArray[] = "/(?:<p>)(?:\d*[).]?\t)(.*?)(?:<\/p>)/s";
		$replaceArray[] = '<ol><li>$1</li></ol>';
		
		// Unordered Lists
		$patternArray[] = "/(?:<p>)(?:\+\t)(.*?)(?:<\/p>)/s";
		$replaceArray[] = '<ul><li>$1</li></ul>';
		
		// List items
		$patternArray[] = "/<br>(?:\d*[.]?|\+)\t/s";
		$replaceArray[] = '$1</li><li>$2';
		
		// Images
		$patternArray[] = "/!\[(.*?)\]\((.*?)\s\"(.*?)\"\)/";
		$replaceArray[] = '<img src="$2" alt="$1" title="$3"/>';
		
		/*
			### Resolve Inline Elements
		*/
		
		// Emphasize a lot
		$patternArray[] = '/[\*_]{2}(.*?)[\*_]{2}?/';
		$replaceArray[] = '<strong>$1</strong>';
		
		// Emphasize a little
		$patternArray[] = '/[\*_]{1}(.*?)[\*_]{1}?/';
		$replaceArray[] = '<em>$1</em>';
		
		// Quirks
		$patternArray[] = '/<p>\s*?<\/p>/';
		$replaceArray[] = '<p>&nbsp;</p>';
		
		return preg_replace($patternArray, $replaceArray, $data);
	}
}
?>