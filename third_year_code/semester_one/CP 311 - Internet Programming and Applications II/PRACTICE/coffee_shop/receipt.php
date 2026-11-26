<?php
// =====================================================================
// receipt.php?id=ORD...   ->  an XML receipt made with XMLWriter
// =====================================================================
// XMLWriter is a third way to write XML (besides DOMDocument and
// building strings). It writes start to finish, like typing the file:
//   startElement -> write things inside -> endElement
// It is fast and uses little memory, so it suits big exports.
//
// Add &download=1 to the URL to download it as a file.

require __DIR__ . '/bootstrap.php';

$order = $orders->find($_GET['id'] ?? '');

if ($order === null) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    echo "Order not found.";
    exit;
}

$writer = new XMLWriter();
$writer->openMemory();          // build in memory, print at the end
$writer->setIndent(true);
$writer->startDocument('1.0', 'UTF-8');

$writer->startElement('receipt');                        // <receipt>
$writer->writeAttribute('shop', $menu->shopName());
$writer->writeAttribute('currency', 'TZS');

$writer->writeElement('orderId', (string) $order['id']);  // <orderId>...</orderId>
$writer->writeElement('customer', (string) $order['customer']);
$writer->writeElement('date', (string) $order['date']);

$writer->startElement('items');                          // <items>
foreach ($order->line as $line) {
    $qty = (int) $line['qty'];
    $price = (float) $line['price'];

    $writer->startElement('item');                       //   <item>
    $writer->writeAttribute('code', (string) $line['item']);
    $writer->writeElement('name', (string) $line);
    $writer->writeElement('qty', (string) $qty);
    $writer->writeElement('unitPrice', (string) $price);
    $writer->writeElement('subtotal', (string) ($qty * $price));
    $writer->endElement();                               //   </item>
}
$writer->endElement();                                   // </items>

$writer->writeElement('total', (string) $order->total);
$writer->writeComment(' Asante kwa kununua! ');          // <!-- ... -->
$writer->endElement();                                   // </receipt>
$writer->endDocument();

header('Content-Type: application/xml; charset=utf-8');
if (isset($_GET['download'])) {
    header('Content-Disposition: attachment; filename="receipt-' . $order['id'] . '.xml"');
}
echo $writer->outputMemory();
