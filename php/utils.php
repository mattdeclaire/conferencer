<?php

function debug() {
	echo "<pre>";
	foreach (func_get_args() as $arg) {
		print_r($arg);
	}
	echo "</pre>";
}