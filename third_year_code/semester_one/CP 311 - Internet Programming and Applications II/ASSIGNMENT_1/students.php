<?php
/**
 * CP 311 - Internet Programming and Applications II
 * Group Assignment: XML-based Student Information System
 * File: students.php  (Task 3: PHP SimpleXML)
 *
 * Loads students.xml with SimpleXML, validates it against its internal DTD,
 * then displays every student's name, programme and registered courses.
 */

$xmlFile = __DIR__ . '/students.xml';

// Collect XML errors ourselves instead of letting PHP print raw warnings.
libxml_use_internal_errors(true);

$students = false;
$errors   = [];

if (!file_exists($xmlFile)) {
    $errors[] = 'students.xml was not found. Keep it in the same folder as students.php.';
} else {
    // LIBXML_DTDVALID makes the parser check the document against the internal DTD.
    $students = simplexml_load_file($xmlFile, 'SimpleXMLElement', LIBXML_DTDVALID);

    foreach (libxml_get_errors() as $error) {
        $errors[] = 'Line ' . $error->line . ': ' . trim($error->message);
    }
    libxml_clear_errors();
}

/** Escape text before printing it into HTML. */
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information System - CP 311</title>
    <style>
        body      { font-family: Arial, Helvetica, sans-serif; margin: 30px; color: #222; background: #f5f6f8; }
        h1        { margin-bottom: 4px; }
        .meta     { color: #555; margin-bottom: 20px; }
        table     { border-collapse: collapse; width: 100%; background: #fff; }
        th, td    { border: 1px solid #ccc; padding: 8px 10px; text-align: left; vertical-align: top; }
        th        { background: #1f4e79; color: #fff; }
        tr:nth-child(even) td { background: #f0f4f8; }
        ul        { margin: 0; padding-left: 18px; }
        .error    { background: #fde8e8; border: 1px solid #d9534f; padding: 12px 16px; color: #a94442; }
    </style>
</head>
<body>

<h1>Student Information System</h1>

<?php if ($students === false || !empty($errors)): ?>

    <div class="error">
        <strong>students.xml could not be loaded or is not valid:</strong>
        <ul>
            <?php foreach ($errors as $message): ?>
                <li><?= e($message) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

<?php else: ?>

    <!-- Attributes of the root element are read with array syntax -->
    <p class="meta">
        <?= e($students['college']) ?> &mdash;
        Academic year <?= e($students['academicYear']) ?> &mdash;
        Total students: <?= count($students->student) ?>
    </p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Reg. No</th>
                <th>Student Name</th>
                <th>Programme</th>
                <th>Year</th>
                <th>Registered Courses</th>
            </tr>
        </thead>
        <tbody>
        <?php $number = 1; ?>
        <?php // Traverse every <student> child of the root element ?>
        <?php foreach ($students->student as $student): ?>
            <tr>
                <td><?= $number++ ?></td>
                <td><?= e($student['regNo']) ?></td>
                <td><?= e($student->firstName . ' ' . $student->lastName) ?></td>
                <td><?= e($student->programme) ?></td>
                <td><?= e($student->yearOfStudy) ?></td>
                <td>
                    <ul>
                        <?php // Nested traversal: every <course> inside <courses> ?>
                        <?php foreach ($student->courses->course as $course): ?>
                            <li><?= e($course['code']) ?> - <?= e($course) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php endif; ?>

</body>
</html>
