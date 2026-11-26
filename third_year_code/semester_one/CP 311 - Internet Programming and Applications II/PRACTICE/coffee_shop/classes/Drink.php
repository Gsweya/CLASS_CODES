<?php
// =====================================================================
// INHERITANCE: Drink extends MenuItem
// =====================================================================
// A Drink IS A MenuItem, plus one extra fact: is it hot or cold?

class Drink extends MenuItem
{
    private bool $hot;

    public function __construct(string $id, string $name, float $price, string $category, string $description, bool $hot)
    {
        parent::__construct($id, $name, $price, $category, $description);
        $this->hot = $hot;
    }

    public function isHot(): bool
    {
        return $this->hot;
    }

    // Writing the abstract methods that MenuItem demanded
    public function type(): string
    {
        return 'drink';
    }

    public function badge(): string
    {
        if ($this->hot) {
            return 'Hot';
        }
        return 'Iced';
    }

    protected function addExtraXml(DOMDocument $doc, DOMElement $item): void
    {
        $this->addChild($doc, $item, 'hot', $this->hot ? 'true' : 'false');
    }
}
