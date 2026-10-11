
<?php
$weight = array(
    "Andy" => 70,
    "Barry" => 65,
    "Charlie" => 75
);

$nama = array_keys($weight);

for ($i = 0; $i < count($weight); $i++) {
    echo $nama[$i] . " is " . $weight[$nama[$i]] . " kg.<br>";
}
?>
