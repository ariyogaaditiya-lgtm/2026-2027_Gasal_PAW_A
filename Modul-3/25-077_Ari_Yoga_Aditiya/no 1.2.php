<?php

$fruits = array("Avocado", "Blueberry", "Cherry");

$fruits[] = "Durian";
$fruits[] = "Elderberry";
$fruits[] = "Fig";
$fruits[] = "Grape";
$fruits[] = "Honeydew";

unset($fruits[1]);

echo "Data Blueberry dihapus.";

echo "<br>";

echo "fruits = ";
print_r($fruits);

echo "<br>";

echo "Nilai dengan indeks tertinggi: " . $fruits[count($fruits) - 1];

?>