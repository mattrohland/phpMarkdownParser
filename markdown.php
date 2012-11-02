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
			### RegEx Partials 
		*/
		$EOL = '(\r|\r\n|\n)';
		
		/*
			### Resolve Block Elements
		*/
		
		// Wrap the whole thing into a single paragraph
		$data = '<p>'.trim($data).'</p>';
		
		// Convert any 2 EOL into a paragraph break
		$patternArray[] = "/{$EOL}{2}/";
		$replaceArray[] = '</p><p>';
		
		// Convert every remaining EOL into a line break
		$patternArray[] = "/{$EOL}{1}/";
		$replaceArray[] = '<br>';
		
		// Headers
		for($j=6; $j>0; $j--):
			$patternArray[] = "/(?:<p>)#{{$j}}(.*?)(?:#{{$j}})?(?:<br>|<\/p>)(?:<\/p>)?/";
			$replaceArray[] = '<h'.$j.'>$1</h'.$j.'><p>';
		endfor;
		
		// Ordered Lists
		$patternArray[] = "/(?:<p>)(?:\d*[).]?\t)(.*?)(?:<\/p>)/s";
		$replaceArray[] = '<ol><li>$1</li></ol>';
		
		// Unordered Lists
		$patternArray[] = "/(?:<p>)(?:\+\t)(.*?)(?:<\/p>)/s";
		$replaceArray[] = '<ul><li>$1</li></ul>';
		
		// List items
		$patternArray[] = "/(?:\d*[).]?|\+)\t/s";
		$replaceArray[] = '$1</li><li>$2';
		
		/*
			### Resolve Inline Elements
		*/
		
		// Emphasize a lot
		$patternArray[] = '/\*{2}(.*?)\*{2}?/';
		$replaceArray[] = '<strong>$1</strong>';
		
		// Emphasize a little
		$patternArray[] = '/\*{1}(.*?)\*{1}?/';
		$replaceArray[] = '<em>$1</em>';
		
		return preg_replace($patternArray, $replaceArray, $data);
	}
}
?>