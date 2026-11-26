<?php
// =====================================================================
// INTERFACE: Exportable
// =====================================================================
// A promise: "I know how to turn myself into an XML element."
//
// Two very different classes keep this promise:
//   - MenuItem (and so Drink and Food)  -> <item> ... </item>
//   - Order                             -> <order> ... </order>
//
// The repositories can then save ANY Exportable object into an XML
// file the same way:  $root->appendChild($object->toXml($doc));

interface Exportable
{
    public function toXml(DOMDocument $doc): DOMElement;
}
