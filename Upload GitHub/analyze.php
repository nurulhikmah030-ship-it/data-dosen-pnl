<?php
$data = json_decode(file_get_contents('data.json'), true);
echo 'Total dosen: ' . count($data) . PHP_EOL;
$kosong = array_filter($data, function($d){
    return empty($d['penelitian']) && empty($d['pengabdian']) && empty($d['publikasi']);
});
echo 'Tanpa portofolio: ' . count($kosong) . PHP_EOL;
echo 'Dengan portofolio: ' . (count($data) - count($kosong)) . PHP_EOL;
$prodis = array_unique(array_column($data, 'prodi'));
sort($prodis);
echo 'Jumlah prodi: ' . count($prodis) . PHP_EOL;
foreach($prodis as $p) echo ' - ' . $p . PHP_EOL;

// Hitung total per kategori
$totalPenelitian = 0;
$totalPengabdian = 0;
$totalPublikasi = 0;
foreach($data as $d) {
    $totalPenelitian += count($d['penelitian'] ?? []);
    $totalPengabdian += count($d['pengabdian'] ?? []);
    $totalPublikasi += count($d['publikasi'] ?? []);
}
echo PHP_EOL;
echo 'Total penelitian: ' . $totalPenelitian . PHP_EOL;
echo 'Total pengabdian: ' . $totalPengabdian . PHP_EOL;
echo 'Total publikasi: ' . $totalPublikasi . PHP_EOL;
