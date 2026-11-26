<?php
// =====================================================================
// MenuRepository: the ONLY class that touches data/menu.xml
// =====================================================================
// XML tools used here:
//   READ    -> SimpleXML  (easy: $node->name, $node['id'])
//   SEARCH  -> XPath      (like SQL WHERE, but for XML)
//   WRITE   -> DOMDocument
//   CHECK   -> XSD schema validation before saving
//
// The rest of the app never sees XML. It just gets Drink and Food OBJECTS.

class MenuRepository
{
    private string $file;
    private string $schemaFile;

    public function __construct(string $file, string $schemaFile)
    {
        $this->file = $file;
        $this->schemaFile = $schemaFile;
    }

    // ---------------------------------------------------------------
    // READING with SimpleXML
    // ---------------------------------------------------------------

    /** All items, as Drink / Food objects. */
    public function all(): array
    {
        $xml = $this->load();
        $items = [];
        foreach ($xml->item as $node) {
            $items[] = $this->makeItem($node);
        }
        return $items;
    }

    public function shopName(): string
    {
        return (string) $this->load()['shop'];   // attribute of the root <menu>
    }

    // ---------------------------------------------------------------
    // SEARCHING with XPath
    // ---------------------------------------------------------------

    /** One item by id, or null if not found. XPath: //item[@id='d1'] */
    public function findById(string $id): ?MenuItem
    {
        // Only allow ids like d1 or f12, so nobody can inject XPath code
        if (!preg_match('/^[df][0-9]+$/', $id)) {
            return null;
        }

        $found = $this->load()->xpath("//item[@id='$id']");
        if (count($found) === 0) {
            return null;
        }
        return $this->makeItem($found[0]);
    }

    /** Items in one category. XPath: //item[@category='coffee'] */
    public function byCategory(string $category): array
    {
        if (!in_array($category, $this->categories())) {
            return [];
        }

        $items = [];
        foreach ($this->load()->xpath("//item[@category='$category']") as $node) {
            $items[] = $this->makeItem($node);
        }
        return $items;
    }

    /** The list of categories, without repeats. XPath: //item/@category */
    public function categories(): array
    {
        $list = [];
        foreach ($this->load()->xpath('//item/@category') as $attribute) {
            $list[] = (string) $attribute;
        }
        return array_values(array_unique($list));
    }

    // ---------------------------------------------------------------
    // WRITING with DOMDocument + checking with the XSD
    // ---------------------------------------------------------------

    public function add(MenuItem $item): void
    {
        $doc = new DOMDocument();
        $doc->preserveWhiteSpace = false;   // these two lines keep the
        $doc->formatOutput = true;          // saved file nicely indented
        $doc->load($this->file);

        // The object builds its own <item> element (Exportable interface)
        $doc->documentElement->appendChild($item->toXml($doc));

        // Never save a file that breaks the rules in menu.xsd
        libxml_use_internal_errors(true);
        $valid = $doc->schemaValidate($this->schemaFile);
        $errors = libxml_get_errors();
        libxml_clear_errors();

        if (!$valid) {
            $messages = [];
            foreach ($errors as $error) {
                $messages[] = trim($error->message);
            }
            throw new RuntimeException("The XSD schema rejected this item: " . implode(' | ', $messages));
        }

        $doc->save($this->file);
    }

    /** Next free id: d6, f5 ... */
    public function nextId(string $type): string
    {
        $prefix = ($type === 'drink') ? 'd' : 'f';
        $number = 1;
        while ($this->findById($prefix . $number) !== null) {
            $number++;
        }
        return $prefix . $number;
    }

    // ---------------------------------------------------------------
    // private helpers
    // ---------------------------------------------------------------

    private function load(): SimpleXMLElement
    {
        $xml = simplexml_load_file($this->file);
        if ($xml === false) {
            throw new RuntimeException("Could not read " . basename($this->file) . ". Is the XML well-formed?");
        }
        return $xml;
    }

    // Turns one <item> node into the right OBJECT.
    // This is where XML becomes OOP.
    private function makeItem(SimpleXMLElement $node): MenuItem
    {
        $id          = (string) $node['id'];
        $name        = (string) $node->name;
        $price       = (float)  $node->price;
        $category    = (string) $node['category'];
        $description = (string) $node->description;

        if ((string) $node['type'] === 'drink') {
            $hot = ((string) $node->hot === 'true');
            return new Drink($id, $name, $price, $category, $description, $hot);
        }

        $vegetarian = ((string) $node->vegetarian === 'true');
        return new Food($id, $name, $price, $category, $description, $vegetarian);
    }
}
