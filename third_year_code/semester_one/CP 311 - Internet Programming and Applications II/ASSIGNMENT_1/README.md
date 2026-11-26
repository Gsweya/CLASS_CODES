# Task 4: XML Data Exchange

**How XML can be used to exchange student information between the Student Registration System and the Examination Management System**

The college runs two separate systems. The Student Registration System (SRS) admits students and registers them for courses. The Examination Management System (EMS) needs the same students and courses so it can prepare exam lists, record marks and produce results. The two systems may be built by different vendors, written in different programming languages and use different databases, so one cannot simply read the other's tables. XML solves this by acting as a common, neutral format that both systems understand.

## XML's role in storing data

XML stores data as plain text and describes it with tags the college defines itself, such as `<student>`, `<programme>` and `<course>`. The data is therefore:

- **Self-describing.** Each value is labelled, so `<yearOfStudy>3</yearOfStudy>` is understood without knowing the database it came from.
- **Hierarchical.** A student naturally contains courses, and XML nesting (`student → courses → course`) represents that directly.
- **Separate from presentation.** XML only carries the data. How it is displayed is left to each system, as `students.php` shows.
- **Platform independent.** A text file can be read on any operating system and by any language (PHP, Java, Python, C#).

## XML's role in exchanging data

The exchange between the two systems works in four steps:

1. **Export.** After registration closes, the SRS reads its own database and writes the student records into `students.xml`.
2. **Transfer.** The file is sent to the EMS, for example over HTTPS, through a web service, or by placing it in a shared folder.
3. **Validate.** Before using the file, the EMS checks it against the DTD. The DTD is the agreed contract between the two systems: it fixes which elements are required, their order, and that every student has a registration number and at least three courses. A file that breaks the rules is rejected instead of corrupting examination records.
4. **Import.** The EMS parses the valid file (in PHP, with SimpleXML) and loads the students and their registered courses into its own database. It then knows exactly who is eligible to sit which examination.

The same route works in the opposite direction: the EMS can export results as XML so the SRS can show them to students or use them to decide progression to the next year of study.

## Benefits for the college

- Student details are entered once in the SRS and reused, which removes double entry and typing errors.
- Either system can be upgraded or replaced without affecting the other, as long as the XML structure stays the same.
- New systems (library, accommodation, finance) can use the same file without changing the existing ones.
- Because the file is human-readable, staff can inspect it when something goes wrong.

## Conclusion

XML does not process registration or examinations itself. Its role is to **store** student information in a structured, self-describing form and to **carry** it between systems that would otherwise be incompatible. With the DTD as the shared rulebook, `students.xml` lets the Student Registration System and the Examination Management System exchange accurate student data reliably.
