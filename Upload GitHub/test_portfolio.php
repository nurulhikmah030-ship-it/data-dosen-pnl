<?php

$url = "https://garuda.kemdiktisaintek.go.id/author/view/10524535";

$ch = curl_init($url);

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_USERAGENT => "Mozilla/5.0"
]);

$html = curl_exec($ch);
$error = curl_error($ch);

curl_close($ch);

libxml_use_internal_errors(true);

$dom = new DOMDocument();
$dom->loadHTML($html);

libxml_clear_errors();

$xpath = new DOMXPath($dom);

?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Portfolio Dosen</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f5f3ff;
    padding: 30px;
}

.box {
    max-width: 1000px;
    margin: auto;
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,.08);
}

h1 {
    color: #6d28d9;
}

h2 {
    margin-top: 30px;
}

.success {
    background: #dcfce7;
    color: #166534;
    padding: 15px;
    border-radius: 10px;
    margin: 20px 0;
}

.item {
    padding: 18px;
    margin: 12px 0;
    background: #fafafa;
    border-left: 5px solid #7c3aed;
    border-radius: 8px;
}

.item a {
    color: #5b21b6;
    font-weight: bold;
    text-decoration: none;
}

.item a:hover {
    text-decoration: underline;
}

.tahun {
    color: #666;
    margin-top: 8px;
}
</style>

</head>

<body>

<div class="box">

<h1>Portfolio Dosen</h1>

<p><b>Nama:</b> ASWANDI</p>
<p><b>NIDN:</b> 0024097203</p>

<?php

if ($error) {

    echo "<div class='success'>
        ❌ Gagal mengambil data Garuda.
    </div>";

} else {

    echo "<div class='success'>
        ✅ Berhasil mengambil data Garuda Aswandi PNL.
    </div>";

    /*
     * Garuda menggunakan URL:
     * /documents/detail/
     */

    $links = $xpath->query(
        "//a[contains(@href, '/documents/detail/')]"
    );

    $data = [];

    foreach ($links as $link) {

        $judul = trim(
            preg_replace(
                '/\s+/',
                ' ',
                $link->textContent
            )
        );

        $href = $link->getAttribute("href");

        if ($judul == "") {
            continue;
        }

        if (
            strtolower($judul) == "original source" ||
            strtolower($judul) == "download original"
        ) {
            continue;
        }

        if (in_array($judul, $data)) {
            continue;
        }

        $data[] = [
            "judul" => $judul,
            "link" => $href
        ];
    }

    echo "<h2>Publikasi</h2>";

    if (count($data) == 0) {

        echo "<p>Data publikasi belum ditemukan.</p>";

    } else {

        $no = 1;

        foreach ($data as $item) {

            $judul = htmlspecialchars($item["judul"]);

            $link = htmlspecialchars($item["link"]);

            echo "
            <div class='item'>

                <b>$no. 
                    <a href='$link' target='_blank'>
                        $judul
                    </a>
                </b>

            </div>
            ";

            $no++;
        }

        echo "
        <p>
            <b>Total ditemukan: " . count($data) . " publikasi</b>
        </p>
        ";
    }
}

?>

</div>

</body>
</html>