<?php
// =====================================================================
// ENCAPSULATION: Cart
// =====================================================================
// The shopping cart lives in the PHP session (so it survives page reloads).
//
// The list of items is PRIVATE. Pages can't write $_SESSION['cart'] themselves.
// They must use add(), remove() and clear(), and those methods check the rules:
//   - quantity must be between 1 and 10
//   - one item can't go above 10 in total

class Cart
{
    private const MAX_PER_ITEM = 10;

    // [ item id => quantity ],  for example  ['d1' => 2, 'f1' => 1]
    private array $lines;

    public function __construct()
    {
        // Load the cart saved in the session, or start empty
        $this->lines = $_SESSION['cart'] ?? [];
    }

    public function add(string $itemId, int $qty): void
    {
        if ($qty < 1 || $qty > self::MAX_PER_ITEM) {
            throw new InvalidArgumentException("Quantity must be between 1 and " . self::MAX_PER_ITEM . ".");
        }

        $current = $this->lines[$itemId] ?? 0;
        if ($current + $qty > self::MAX_PER_ITEM) {
            throw new InvalidArgumentException("You can have at most " . self::MAX_PER_ITEM . " of one item.");
        }

        $this->lines[$itemId] = $current + $qty;
        $this->save();
    }

    public function remove(string $itemId): void
    {
        unset($this->lines[$itemId]);
        $this->save();
    }

    public function clear(): void
    {
        $this->lines = [];
        $this->save();
    }

    // Returns a COPY of the array, so callers can't change our private data
    public function getLines(): array
    {
        return $this->lines;
    }

    public function isEmpty(): bool
    {
        return count($this->lines) === 0;
    }

    public function countItems(): int
    {
        return array_sum($this->lines);
    }

    // private: only the cart itself decides when to save
    private function save(): void
    {
        $_SESSION['cart'] = $this->lines;
    }
}
