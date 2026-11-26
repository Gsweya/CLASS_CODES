<?php
// =====================================================================
// OrderRepository: the ONLY class that touches data/orders.xml
// =====================================================================
// XML tools used here:
//   WRITE      -> DOMDocument (append a new <order>)
//   READ       -> SimpleXML
//   SEARCH     -> XPath with contains()
//   CALCULATE  -> XPath count() and sum() through DOMXPath

class OrderRepository
{
    private string $file;

    public function __construct(string $file)
    {
        $this->file = $file;

        // First run: create an empty <orders/> file
        if (!file_exists($file)) {
            file_put_contents($file, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<orders/>\n");
        }
    }

    // ---------------------------------------------------------------
    // WRITE
    // ---------------------------------------------------------------
    public function save(Order $order): void
    {
        $doc = new DOMDocument();
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;
        $doc->load($this->file);

        $doc->documentElement->appendChild($order->toXml($doc));
        $doc->save($this->file);
    }

    // ---------------------------------------------------------------
    // READ (newest first)
    // ---------------------------------------------------------------
    public function all(): array
    {
        $list = [];
        foreach ($this->load()->order as $order) {
            $list[] = $order;
        }
        return array_reverse($list);
    }

    public function find(string $id): ?SimpleXMLElement
    {
        if (!preg_match('/^ORD[0-9]+$/', $id)) {
            return null;
        }
        $found = $this->load()->xpath("//order[@id='$id']");
        return $found[0] ?? null;
    }

    // ---------------------------------------------------------------
    // SEARCH: orders whose customer name CONTAINS the text
    // XPath: //order[contains(@customer, 'Ju')]
    // ---------------------------------------------------------------
    public function byCustomer(string $name): array
    {
        // Same rule as Order: letters and spaces only (keeps XPath safe)
        if (!preg_match('/^[A-Za-z ]{1,40}$/', $name)) {
            return [];
        }
        $found = $this->load()->xpath("//order[contains(@customer, '$name')]");
        return array_reverse($found);
    }

    // ---------------------------------------------------------------
    // CALCULATE: XPath can do maths, not only find nodes
    // ---------------------------------------------------------------
    public function stats(): array
    {
        $doc = new DOMDocument();
        $doc->load($this->file);
        $xpath = new DOMXPath($doc);

        return [
            'orders'  => (int)   $xpath->evaluate('count(//order)'),
            'revenue' => (float) $xpath->evaluate('sum(//order/total)'),
            'drinks'  => (int)   $xpath->evaluate('sum(//line[@type="drink"]/@qty)'),
            'food'    => (int)   $xpath->evaluate('sum(//line[@type="food"]/@qty)'),
        ];
    }

    private function load(): SimpleXMLElement
    {
        $xml = simplexml_load_file($this->file);
        if ($xml === false) {
            throw new RuntimeException("Could not read orders.xml. Is the XML well-formed?");
        }
        return $xml;
    }
}
