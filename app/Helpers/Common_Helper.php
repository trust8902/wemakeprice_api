<?php
function getBody($html, $stripTags) {
	if(!$html) {
		return '';
	}

	$html = preg_replace('/<(style|script|address)[\\w\\W]+?<\/(style|script|address)>/i', '', $html);
	preg_match('/<body[^>]*>([\w|\W]*)<\/body>/i', $html, $match); 
	$html = $match[1];

	if($stripTags == '0') {
		$html = strip_tags($html);
	}

	return $html;
}