<?php

require_once __DIR__.'/config.php';

spl_autoload_register(function ($classname) {
	$classname = ltrim($classname, "\\");
	preg_match('/^(.+)?([^\\\\]+)$/U', $classname, $match);
	$dir = str_replace("\\", "/", $match[1]);
	$basename = str_replace(["\\", "_"], "/", $match[2]);
	include __DIR__."/php/$dir$basename.php";
});