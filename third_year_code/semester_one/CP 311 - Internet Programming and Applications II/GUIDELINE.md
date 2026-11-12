# CP 311 Group Assignment Guideline: XML Student Information System

**Course:** CP 311 – Internet Programming and Applications II
**Topic:** XML
**Scenario:** A college wants to use XML to store and exchange student information between different computer systems.

---

## 1. What must be delivered

| Task | Requirement | Where it is done |
|------|-------------|------------------|
| 1 | `students.xml` with at least 10 students, well-formed | `students.xml` |
| 2 | Internal DTD inside the XML document | top of `students.xml` (`<!DOCTYPE students [ ... ]>`) |
| 3 | `students.php` using SimpleXML to show names, programmes and courses | `students.php` |
| 4 | Short explanation of XML data exchange (Registration System ↔ Examination System) | `README.md` |
| 5 | Presentation: show the XML, the DTD, the PHP program and its output | Section 7 below |

---

## 2. Folder and file structure

```
CP311_XML_Assignment/
├── students.xml            # Task 1 + Task 2: student data with the internal DTD
├── students.php            # Task 3: PHP SimpleXML program
├── students_output.html    # saved copy of what students.php shows in the browser
├── README.md               # Task 4: written explanation
└── GUIDELINE.md            # this file
```

`students.xml` and `students.php` **must stay in the same folder**, because the PHP file loads the XML with `__DIR__ . '/students.xml'`.

---

## 3. How to run it

### Option A: XAMPP (Windows, most common)

1. Copy the whole `CP311_XML_Assignment` folder into `C:\xampp\htdocs\`.
2. Open the XAMPP Control Panel and start **Apache**.
3. Open a browser and go to `http://localhost/CP311_XML_Assignment/students.php`.

### Option B: PHP built-in server (any OS with PHP installed)

```bash
cd CP311_XML_Assignment
php -S localhost:8000
```

Then open `http://localhost:8000/students.php`.

### Viewing the XML alone

Open `students.xml` directly in a browser (Chrome, Edge, Firefox). If it shows the collapsible tree, the document is well-formed. If there is a mistake, the browser shows the line of the error.

---

## 4. Task 1 explained: the XML document

Structure of one student:

```xml
<student regNo="T23-03-00112" gender="Male">
  <firstName>Juma</firstName>
  <lastName>Mwakalinga</lastName>
  <programme>BSc in Computer Science</programme>
  <yearOfStudy>3</yearOfStudy>
  <email>juma.mwakalinga@student.college.ac.tz</email>
  <phone>+255 712 000 101</phone>
  <courses>
    <course code="CP 311" credits="10">Internet Programming and Applications II</course>
    <course code="CP 312" credits="10">Object Oriented Systems Design</course>
    <course code="CP 313" credits="10">Mobile Applications Development</course>
  </courses>
</student>
```

How each required field is stored:

| Required field | Stored as | Why |
|----------------|-----------|-----|
| Registration number | attribute `regNo` on `<student>` | it identifies the record and must be unique |
| Gender | attribute `gender` on `<student>` | only a fixed set of values is allowed |
| First name, last name | elements `<firstName>`, `<lastName>` | the actual data of the record |
| Programme | element `<programme>` | data |
| Year of study | element `<yearOfStudy>` | data |
| Email, phone | elements `<email>`, `<phone>` | data |
| Courses (at least 3) | `<courses>` containing `<course>` elements | repeating data needs child elements |
| Course code, credits | attributes `code`, `credits` on `<course>` | extra information about the course |

**Rule of thumb to say in the presentation:** data goes in elements; information *about* the data (identifiers, codes, fixed categories) goes in attributes.

Well-formedness checklist (all satisfied):

- [x] XML declaration on the first line
- [x] One single root element: `<students>`
- [x] Every opening tag has a matching closing tag
- [x] Elements are properly nested, with no overlapping tags
- [x] All attribute values are in quotes
- [x] Tag names are case-consistent (`firstName` is not `firstname`)

---

## 5. Task 2 explained: the internal DTD

An **internal** DTD is written inside the XML file itself, between `<!DOCTYPE students [` and `]>`. That is why the declaration says `standalone="yes"`: the file needs no external file to be validated.

| DTD line | Meaning | Requirement covered |
|----------|---------|---------------------|
| `<!ELEMENT students (student+)>` | the root holds one or more students | required elements |
| `<!ELEMENT student (firstName, lastName, programme, yearOfStudy, email, phone, courses)>` | every child is required, and the commas fix the order | required elements, order of elements, student structure |
| `<!ELEMENT courses (course, course, course, course*)>` | three courses are compulsory, more are optional | course structure, "at least three courses" |
| `<!ELEMENT firstName (#PCDATA)>` | the element contains text only | element content |
| `<!ATTLIST student regNo ID #REQUIRED>` | `regNo` is compulsory and unique in the whole document | attribute |
| `<!ATTLIST student gender (Male \| Female) #REQUIRED>` | only these two values are accepted | attribute |
| `<!ATTLIST course code CDATA #REQUIRED credits CDATA #IMPLIED>` | `code` is compulsory, `credits` is optional | attribute |

Symbols to remember:

| Symbol | Meaning |
|--------|---------|
| `,` | in this exact order |
| `+` | one or more |
| `*` | zero or more |
| `?` | optional (zero or one) |
| `\|` | either one or the other |
| `#PCDATA` | parsed character data (text) |
| `#REQUIRED` / `#IMPLIED` | attribute is compulsory / optional |

**Well-formed vs valid:** *well-formed* means the XML syntax rules are followed. *Valid* means the document is well-formed **and** obeys its DTD. `students.xml` is both.

How the DTD is actually used: `students.php` loads the file with the `LIBXML_DTDVALID` option, so the document is checked against the DTD every time the page opens. To validate from the command line instead:

```bash
xmllint --noout --valid students.xml
```

No output means the document is valid.

---

## 6. Task 3 explained: `students.php`

| Requirement | Code that does it |
|-------------|-------------------|
| Loads `students.xml` | `simplexml_load_file($xmlFile, 'SimpleXMLElement', LIBXML_DTDVALID)` |
| Displays all student names | `$student->firstName . ' ' . $student->lastName` |
| Displays each student's programme | `$student->programme` |
| Displays the courses of each student | `foreach ($student->courses->course as $course)` |
| Uses SimpleXML to traverse | outer `foreach ($students->student as $student)` plus the inner course loop |

SimpleXML in three rules:

1. **Child elements** are read with the arrow: `$student->programme`
2. **Attributes** are read like an array: `$student['regNo']`, `$course['code']`
3. **Repeated elements** are looped with `foreach`

Other points worth mentioning:

- `libxml_use_internal_errors(true)` collects XML errors so the page shows a clean message instead of raw PHP warnings.
- `htmlspecialchars()` (the `e()` helper) escapes the data before printing it, so characters such as `<` or `&` cannot break the page.
- `count($students->student)` gives the total number of students.

Expected output: a heading, a line with the college name, academic year and "Total students: 10", then a table with the columns **#, Reg. No, Student Name, Programme, Year, Registered Courses**, one row per student.

---

## 7. Presentation plan (Task 5)

| Step | What to show | What to say |
|------|--------------|-------------|
| 1 | The scenario | Two college systems need to share the same student data |
| 2 | `students.xml` in an editor | Root element, one student record, elements vs attributes, well-formedness rules |
| 3 | The DTD at the top of the file | Required elements, order, three-course rule, the attributes |
| 4 | `students.php` in an editor | Loading the file, the two `foreach` loops, how attributes are read |
| 5 | The browser at `students.php` | The table of 10 students produced from the XML |
| 6 | Live validation demo | See below |
| 7 | Data exchange | Summarise `README.md`: export, transfer, validate, import |

**Live validation demo (strong finish):** delete one `<course>` line from a student who has only three, save, and refresh the browser. The page shows an error naming the line, because the document no longer follows the DTD. Undo the change and refresh, and the table returns. This proves the DTD is really enforcing the structure. Other quick breaks to try: change `gender="Male"` to `gender="M"`, or give two students the same `regNo`.

Suggested split for a group: one member presents the XML, one the DTD, one the PHP code and output, one the data exchange explanation.

---

## 8. Before you submit

- [ ] Replace the sample students with your own data if your lecturer expects real group details (keep at least 10 students and 3 courses each).
- [ ] Change the `college` attribute on `<students>` to your college's name.
- [ ] Keep every `regNo` unique and starting with a letter (an `ID` value cannot start with a digit).
- [ ] Add your group number, member names and registration numbers to the comment at the top of `students.xml` and `students.php`.
- [ ] Open `students.php` in the browser and confirm the table shows all students with no error box.
- [ ] Take a screenshot of the output for the report or slides.
- [ ] Put the Task 4 explanation into whatever format the lecturer asked for (Word, PDF or slides).

---

## 9. Likely questions and short answers

**Why XML and not just a database?** A database stores data for one system. XML is a neutral text format that any system can read, so it is used to move data between systems.

**Difference between an internal and external DTD?** Internal is written inside the XML file. External is a separate `.dtd` file referenced with `<!DOCTYPE students SYSTEM "students.dtd">`, which lets many XML files share one set of rules.

**Why is `regNo` an attribute?** It is an identifier for the record, and declaring it as type `ID` makes the parser reject duplicates.

**What can a DTD not do?** It cannot check data types, for example that the year is a number or that the email has a valid format. XML Schema (XSD) is used for that.

**Why SimpleXML?** It turns the XML into PHP objects, so the document can be read with simple `->` and `foreach` instead of long parsing code.
