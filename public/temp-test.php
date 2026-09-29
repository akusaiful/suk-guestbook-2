<?php

echo '<pre>';

echo "Loaded php.ini:\n";
var_dump(php_ini_loaded_file());

echo "\nsys_temp_dir setting:\n";
var_dump(ini_get('sys_temp_dir'));

echo "\nupload_tmp_dir setting:\n";
var_dump(ini_get('upload_tmp_dir'));

echo "\nTEMP env:\n";
var_dump(getenv('TEMP'));

echo "\nTMP env:\n";
var_dump(getenv('TMP'));

echo "\nsys_get_temp_dir():\n";
var_dump(sys_get_temp_dir());

echo "\nWritable:\n";
var_dump(is_writable(sys_get_temp_dir()));

echo "\nTemp file test:\n";
var_dump(tempnam(sys_get_temp_dir(), 'webtest_'));

echo '</pre>';
