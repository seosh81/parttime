<?php
	$c = '(ab)';
	$p = '/\(.*?:(.*?)\)/';
	// preg_match('(title:This is a title)', $p, $match);
	// print_r($match);

	$val = file_get_contents('page2');
	$regex = "/commentPopup\([0-9]+\)/";
	$ret = preg_match_all($regex, $val, $matches, PREG_PATTERN_ORDER);
	print_r($matches);
	// echo $filtered_str;
