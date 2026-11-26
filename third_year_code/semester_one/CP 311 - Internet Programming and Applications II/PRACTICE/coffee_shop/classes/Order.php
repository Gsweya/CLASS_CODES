<?php
// =====================================================================
// Order: one customer's finished order
// =====================================================================
// Uses: ENCAPSULATION (private data, checked in the constructor)
//       INTERFACE (implements Exportable, so it can become XML)

class Order implements Exportable
{
    private string $id;
    private string $customer;
    private string $date;
    private array $lines = [];   // each line: ['item' => MenuItem, 'qty' => int]

    public function __construct(string $customer)
    {
        $customer = trim($customer);

        // Letters and spaces only. This also keeps the name safe to use
        // inside an XPath search later (see OrderRepository::byCustomer).
        if (!preg_match('/^[A-Za-z ]{2,40}$/', $customer)) {
            throw new InvalidArgumentException("Name must be 2 to 40 letters (spaces allowed).");
        }

        $this->customer = $customer;
        $this->date = date('Y-m-d H:i');
        $this->id = 'ORD' . date('ymdHis') . rand(1, 9);
    }

    public function addLine(MenuItem $item, int $qty): void
    {
        $this->lines[] = ['item' => $item, 'qty' => $qty];
    }

    public function getId(): string       { return $this->id; }
    public function getCustomer(): string { return $this->customer; }

    public function total(): float
    {
        $total = 0;
        foreach ($this->lines as $line) {
            $total = $total + $line['item']->getPrice() * $line['qty'];
        }
        return $total;
    }

    // From the Exportable interface. Builds:
    // <order id="..." customer="..." date="...">
    //   <line item="d1" type="drink" qty="2" price="3000">Espresso</line>
    //   <total>6000</total>
    // </order>
    public function toXml(DOMDocument $doc): DOMElement
    {
        $order = $doc->createElement('order');
        $order->setAttribute('id', $this->id);
        $order->setAttribute('customer', $this->customer);
        $order->setAttribute('date', $this->date);

        foreach ($this->lines as $line) {
            $item = $line['item'];

            $el = $doc->createElement('line');
            $el->setAttribute('item', $item->getId());
            $el->setAttribute('type', $item->type());
            $el->setAttribute('qty', (string) $line['qty']);
            $el->setAttribute('price', (string) $item->getPrice());
            $el->appendChild($doc->createTextNode($item->getName()));

            $order->appendChild($el);
        }

        $total = $doc->createElement('total');
        $total->appendChild($doc->createTextNode((string) $this->total()));
        $order->appendChild($total);

        return $order;
    }
}
