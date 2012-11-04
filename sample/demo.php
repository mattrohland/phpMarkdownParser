<?
error_reporting(E_ALL);
ini_set('display_errors', '1');
require('../markdown.php');
$markdown = new Markdown();
?><!DOCTYPE html>
<html>
<head>
<title>PHP Markdown Parser - Demo</title>
<style type="text/css">
	h1,
	h2,
	h3,
	h4,
	h5,
	h6,
	.snippetCode{margin: 0 0 1em 0;}
	body{
		font-family: helvetica, sans-serif;
		padding: 40px;
	}
	.snippetCode{
		display: block;
		background: #EEEEEE;
		border: 1px solid #E0E0E0;
		white-space: pre;
		padding: 20px;
	}
	.htmlPreview{
		margin-top: 20px;
		margin-bottom: 3em;
		border: 1px dashed #DDDDDD;
		padding: 20px;
	}
</style>
</head>
<body>
<h1>PHP Markdown Parser - Demo</h1>

<h2>Headlines</h2>
<code class="snippetCode"><?= $snippet = @file_get_contents('snippets/headlines.md'); ?></code>
<div class="htmlPreview">
<?= $markdown->get( $snippet ); ?>
</div>

<h2>Paragraphs and line breaks</h2>
<code class="snippetCode"><?= $snippet = @file_get_contents('snippets/paragraphs.md'); ?></code>
<div class="htmlPreview">
<?= $markdown->get( $snippet ); ?>
</div>

<h2>Ordered list</h2>
<code class="snippetCode"><?= $snippet = @file_get_contents('snippets/orderedList.md'); ?></code>
<div class="htmlPreview">
<?= $markdown->get( $snippet ); ?>
</div>

<h2>Unordered list</h2>
<code class="snippetCode"><?= $snippet = @file_get_contents('snippets/unorderedList.md'); ?></code>
<div class="htmlPreview">
<?= $markdown->get( $snippet ); ?>
</div>

<h2>Emphasis</h2>
<code class="snippetCode"><?= $snippet = @file_get_contents('snippets/emphasis.md'); ?></code>
<div class="htmlPreview">
<?= $markdown->get( $snippet ); ?>
</div>

<h2>Image</h2>
<code class="snippetCode"><?= $snippet = @file_get_contents('snippets/image.md'); ?></code>
<div class="htmlPreview">
<?= $markdown->get( $snippet ); ?>
</div>

</body>
</html>