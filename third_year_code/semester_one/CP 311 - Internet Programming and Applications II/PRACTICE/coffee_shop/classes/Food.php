<?php
// =====================================================================
// INHERITANCE: Food extends MenuItem
// =====================================================================
// A Food IS A MenuItem, plus one extra fact: is it vegetarian?

class Food extends MenuItem
{
    private bool $vegetarian;

    public function __construct(string $id, string $name, float $price, string $category, string $description, bool $vegetarian)
    {
        parent::__construct($id, $name, $price, $category, $description);
        $this->vegetarian = $vegetarian;
    }

    public function isVegetarian(): bool
    {
        return $this->vegetarian;
    }

    public function type(): string
    {
        return 'food';
    }

    public function badge(): string
    {
        if ($this->vegetarian) {
            return 'Vegetarian';
        }
        return '';   // no badge
    }

    protected function addExtraXml(DOMDocument $doc, DOMElement $item): void
    {
        $this->addChild($doc, $item, 'vegetarian', $this->vegetarian ? 'true' : 'false');
    }
}
