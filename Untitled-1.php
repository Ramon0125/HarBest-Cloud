<?php 

$var = array('MANZANA');

echo implode(', ',array_slice($var,0)) . ' y ' . end($var); 