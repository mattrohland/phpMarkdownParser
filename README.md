#PHP Markdown Parser

A PHP class used to parse markdown.

##Status

At the moment the class supports very little markdown syntax and only outputs as html but fulfills my immediate needs. I do plan on refactoring and expanding the class in the near future.

##Basic Usage

**Getting parsed markdown as HTML:**

```PHP
$markdown = new Markdown();
$markdown->get('Insert your markdown content here.');
```