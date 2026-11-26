<?php
// =====================================================================
// ABSTRACT CLASS: MenuItem
// =====================================================================
// The parent of everything the shop sells.
// We never sell a plain "MenuItem", only a Drink or a Food.
// So the class is ABSTRACT: writing  new MenuItem(...)  is an error.
//
// It also IMPLEMENTS the Exportable interface (it can become XML).

abstract class MenuItem implements Exportable
{
    // ACCESS MODIFIERS
    private string $id;             // private: nobody may change the id
    private float $price;           // private: read it with getPrice()
    protected string $name;         // protected: Drink and Food may use it
    protected string $category;
    protected string $description;

    public function __construct(string $id, string $name, float $price, string $category, string $description)
    {
        // ENCAPSULATION: the object checks its own data
        // and refuses to exist with bad values.
        $name = trim($name);
        if (strlen($name) < 2) {
            throw new InvalidArgumentException("Name must have at least 2 letters.");
        }
        if ($price <= 0) {
            throw new InvalidArgumentException("Price must be more than 0.");
        }

        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->category = $category;
        $this->description = trim($description);
    }

    // GETTERS: read-only access to the data
    public function getId(): string          { return $this->id; }
    public function getName(): string        { return $this->name; }
    public function getPrice(): float        { return $this->price; }
    public function getCategory(): string    { return $this->category; }
    public function getDescription(): string { return $this->description; }

    // ABSTRACT METHODS: every child MUST write these
    abstract public function type(): string;    // "drink" or "food"
    abstract public function badge(): string;   // small label on the menu, like "Hot"

    // From the Exportable interface: build the <item> element.
    // The parent writes the shared parts...
    public function toXml(DOMDocument $doc): DOMElement
    {
        $item = $doc->createElement('item');
        $item->setAttribute('id', $this->id);
        $item->setAttribute('type', $this->type());
        $item->setAttribute('category', $this->category);

        $this->addChild($doc, $item, 'name', $this->name);
        $this->addChild($doc, $item, 'price', (string) $this->price);
        $this->addChild($doc, $item, 'description', $this->description);

        // ...and each child adds its own extra tag (<hot> or <vegetarian>)
        $this->addExtraXml($doc, $item);

        return $item;
    }

    abstract protected function addExtraXml(DOMDocument $doc, DOMElement $item): void;

    // Small helper: <tag>value</tag>
    // createTextNode() safely handles characters like & and <
    protected function addChild(DOMDocument $doc, DOMElement $parent, string $tag, string $value): void
    {
        $child = $doc->createElement($tag);
        $child->appendChild($doc->createTextNode($value));
        $parent->appendChild($child);
    }
}
