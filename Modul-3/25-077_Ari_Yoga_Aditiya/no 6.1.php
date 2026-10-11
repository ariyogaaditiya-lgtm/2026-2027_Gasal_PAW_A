<?php

// 1. array_push
$a = array("A");
echo "Array awal: (\"A\")<br>";

array_push($a, "B");
echo "Hasil array_push: " . implode(" ", $a) . "<br><br>";


// 2. array_merge
$a = array("A", "B");
$b = array("C");

echo "Array awal: (\"A\", \"B\") digabung dengan (\"C\")<br>";

$c = array_merge($a, $b);
echo "Hasil array_merge: " . implode(" ", $c) . "<br><br>";


// 3. array_values
$a = array("x" => 1, "y" => 2);

echo "Array awal: (\"x\" => 1, \"y\" => 2)<br>";

$b = array_values($a);
echo "Hasil array_values: " . implode(" ", $b) . "<br><br>";


// 4. array_search
$a = array("A", "B", "C");

echo "Mencari \"B\" pada array: (\"A\", \"B\", \"C\")<br>";

$b = array_search("B", $a);
echo "Hasil array_search: " . $b . "<br><br>";


// 5. array_filter
$a = array(0, 1, false, 2, "", 3, "array");

echo "Array awal: (0, 1, false, 2, \"\", 3, \"array\")<br>";

$b = array_filter($a);
echo "Hasil array_filter: " . implode(" ", $b) . "<br><br>";


// 6. sort dan rsort
$a = array(3, 1, 2);

echo "Array awal: (3, 1, 2)<br>";

$b = $a;
sort($b);
echo "Hasil sort: " . implode(" ", $b) . "<br>";

$b = $a;
rsort($b);
echo "Hasil rsort: " . implode(" ", $b) . "<br><br>";


// 7. Sorting array asosiatif
$a = array(
    "Peter" => 35,
    "Ben" => 37,
    "Joe" => 43
);

echo "Array awal: (\"Peter\"=>35, \"Ben\"=>37, \"Joe\"=>43)<br>";

// asort
$b = $a;
asort($b);
echo "Hasil asort: ";
foreach ($b as $nama => $umur) {
    echo "$nama=>$umur, ";
}
echo "<br>";

// ksort
$b = $a;
ksort($b);
echo "Hasil ksort: ";
foreach ($b as $nama => $umur) {
    echo "$nama=>$umur, ";
}
echo "<br>";

// arsort
$b = $a;
arsort($b);
echo "Hasil arsort: ";
foreach ($b as $nama => $umur) {
    echo "$nama=>$umur, ";
}
echo "<br>";

// krsort
$b = $a;
krsort($b);
echo "Hasil krsort: ";
foreach ($b as $nama => $umur) {
    echo "$nama=>$umur, ";
}
echo "<br>";

?>
```