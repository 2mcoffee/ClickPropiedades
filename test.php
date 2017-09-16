<?php

$url = $_SERVER['HTTP_HOST'];

if ($url = 'www.clickpropiedades.com' || $url = 'clickpropiedades.com') {
    header ("Location: ./d1.php");
}
else {
	header ("Location: ./d2.php");
};

?>