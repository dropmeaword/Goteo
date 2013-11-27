<?php
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	
	$numids = 0;
	$numphpmatches = array();
	$numpomatches = array();
	
	function swapids($matches) {
		global $numids;
		global $numphpmatches;
		global $numpomatches;
		
		$numids++;
		$msgid = $matches[1];
		$msgstr = $matches[2];
		
		// replace occurances of msgid in po files by english counterparts
		$path = new RecursiveDirectoryIterator('../locale');
		$iterator = new RecursiveIteratorIterator($path);
		$files = new RegexIterator($iterator, '/^.+\.po$/i', RecursiveRegexIterator::GET_MATCH);
		foreach($files as $filename => $object) if (!strpos($filename, '/en_GB/')) {
			$poFile = file_get_contents($filename);
			
			$count = 0;
			$poFile = preg_replace('$msgid \"'.preg_quote($msgid).'\"$i', 'msgid "'.$msgstr.'"', $poFile, -1, $count);
			
			$numpomatches[$filename]+= $count;
			file_put_contents($filename, $poFile);
		}
		
		// replace occurances of msgid in php files by english counterparts
		$path = new RecursiveDirectoryIterator('../');
		$iterator = new RecursiveIteratorIterator($path);
		$files = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);
		foreach($files as $filename => $object) {
			$phpFile = file_get_contents($filename);
			$count = 0;
			$phpFile = preg_replace('/Text::_\(["\']'.preg_quote($msgid, '/').'["\']\)/i', 'Text::_("'.$msgstr.'")', $phpFile, -1, $count);
			$numphpmatches[$filename]+= $count;
			file_put_contents($filename, $phpFile);
		}
		
		// return string with swapped msgid and msgstr
		return 'msgid "'.$msgstr.'"'.PHP_EOL.'msgstr "'.$msgid.'"';
	}
	
	// get english po file
	$poFile = file_get_contents('../locale/en_GB/LC_MESSAGES/messages.po');
	
	// iterate over all msgid/msgstr pairs
	$poFile = preg_replace_callback('/msgid \"(.*?)\"'.PHP_EOL.'msgstr \"(.*?)\"/', 'swapids', $poFile);
	
	// write resulting file as spanish po file
	mkdir('../locale/es_ES');
	mkdir('../locale/es_ES/LC_MESSAGES');
	file_put_contents('../locale/es_ES/LC_MESSAGES/messages.po', $poFile);
	
	// remove english po file
	unlink('../locale/en_GB/LC_MESSAGES/messages.po');
	rmdir('../locale/en_GB/LC_MESSAGES');
	rmdir('../locale/en_GB');
	
	// output stats
	echo $numids.' msgid strings found'.PHP_EOL;
	foreach($numpomatches as $key => $value) echo $value.' replacements in '.$key.PHP_EOL;

	$count = 0;
	foreach($numphpmatches as $key => $value) $count+= $value;
	echo $count.' replacements in all php files'.PHP_EOL;
?>
