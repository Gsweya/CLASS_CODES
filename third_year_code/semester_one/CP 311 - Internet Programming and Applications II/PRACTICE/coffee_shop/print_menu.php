<?php
// =====================================================================
// print_menu.php: menu.xml + menu.xsl  ->  HTML, done on the SERVER
// =====================================================================
// XSLT is a language for transforming XML into something else (HTML,
// another XML, text). The rules are in data/menu.xsl.
//
// Compare: open data/menu.xml directly in the browser. The browser
// applies the same menu.xsl by itself (CLIENT side).

require __DIR__ . '/bootstrap.php';

if (!class_exists('XSLTProcessor')) {
    header('Content-Type: text/plain; charset=utf-8');
    echo "The PHP 'xsl' extension is not enabled.\n";
    echo "XAMPP: open php.ini, remove the ; before  extension=xsl  and restart Apache.";
    exit;
}

$xml = new DOMDocument();
$xml->load(DATA_DIR . '/menu.xml');

$xsl = new DOMDocument();
$xsl->load(DATA_DIR . '/menu.xsl');

$processor = new XSLTProcessor();
$processor->importStylesheet($xsl);

echo $processor->transformToXml($xml);
