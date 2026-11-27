# Writing Part: .html() vs .text() vs .val()

**Explain the difference between `.html()`, `.text()`, and `.val()` with practical examples from your table.**

---

All three jQuery methods retrieve or set content, but they operate on different types of elements and return different data.

### `.html()`

Gets or sets the **HTML content** (innerHTML) of an element. It includes any nested tags and markup.

**Example from our table:**
```javascript
let tableHTML = $('#studentTable tbody').html();
```
This returns the full HTML of all rows including `<tr>`, `<td>`, and `<input>` tags.

**Use it when** you want to read or write HTML structure, not just plain text.

---

### `.text()`

Gets or sets the **plain text** content of an element, stripping all HTML tags.

**Example from our table:**
```javascript
let name = $('tr:first td:eq(1)').text();
// Returns: "Alice Mushi" — no markup, just the visible text
```

**Use it when** you only care about visible text content and want to ignore any HTML markup inside the element.

---

### `.val()`

Gets or sets the **value** of form/input elements like `<input>`, `<select>`, and `<textarea>`.

**Example from our table:**
```javascript
let checkboxValue = $('.row-checkbox:first').val();
// Returns: "on" (the value attribute of the checkbox input)
```

**Use it when** working with form controls to read or set their current value. It does not work on regular `<div>` or `<td>` elements.

---

### Summary

| Method  | Works On         | Returns                | Table Example                                      |
|---------|------------------|------------------------|----------------------------------------------------|
| `.html()` | Any element    | HTML markup (with tags) | `$('tbody').html()` → all row HTML                 |
| `.text()` | Any element    | Plain text (no tags)    | `$('td:eq(1)').text()` → "Alice Mushi"             |
| `.val()`  | Form controls  | Input value             | `$('.row-checkbox').val()` → "on"                  |

In short: `.html()` deals with **markup**, `.text()` deals with **plain strings**, and `.val()` deals with **form control values**.
