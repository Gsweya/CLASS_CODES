package com.example.shiri;

import android.content.Intent;
import android.os.Bundle;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.Spinner;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowCompat;
import androidx.core.view.WindowInsetsCompat;

/**
 * First activity: the registration form. It SENDS the form data to second_screen.
 *
 * INTENT = a message object that asks Android to do something, e.g. start an activity.
 * Data is attached to it as "extras" with putExtra(key, value).
 *
 *  - EXPLICIT intent: we name the exact class to open -> new Intent(this, second_screen.class).
 *                     Used for screens inside our own app.
 *  - IMPLICIT intent: we only describe the ACTION we want -> new Intent("some.ACTION").
 *                     Android looks through all manifests for a matching <intent-filter>
 *                     and opens that component (could be in our app or another app).
 */
public class MainActivity extends AppCompatActivity {

    private EditText etFName, etLName, etSName, etAge;
    private RadioGroup radioGender;
    private Spinner spinnerCollege;
    private CheckBox[] courseBoxes;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        WindowCompat.enableEdgeToEdge(getWindow());
        setContentView(R.layout.activity_main);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        etFName = findViewById(R.id.etFName);
        etLName = findViewById(R.id.etLName);
        etSName = findViewById(R.id.etSName);
        etAge = findViewById(R.id.etAge);
        radioGender = findViewById(R.id.radioGender);
        spinnerCollege = findViewById(R.id.spinnerCollege);
        Button btnSubmit = findViewById(R.id.btnSubmit);
        Button btnSubmitImplicit = findViewById(R.id.btnSubmitImplicit);

        courseBoxes = new CheckBox[]{
                findViewById(R.id.cbCp311),
                findViewById(R.id.cbCp313),
                findViewById(R.id.cbIa313),
                findViewById(R.id.cbEme314),
                findViewById(R.id.cbBt314)
        };

        // ================= EXPLICIT INTENT =================
        // We tell Android EXACTLY which activity to open: second_screen.class.
        // No intent-filter is needed for this; it is the normal way to move
        // between screens of the same app.
        btnSubmit.setOnClickListener(v -> {
            Intent explicitIntent = new Intent(MainActivity.this, second_screen.class);
            if (putFormData(explicitIntent)) {
                startActivity(explicitIntent);
            }
        });

        // ================= IMPLICIT INTENT =================
        // We do NOT name the class. We only give an action string. Android searches
        // every installed app's manifest for an <intent-filter> with this action and
        // finds second_screen (see AndroidManifest.xml).
        btnSubmitImplicit.setOnClickListener(v -> {
            Intent implicitIntent = new Intent(second_screen.ACTION_SHOW_DETAILS);
            if (putFormData(implicitIntent)) {
                // Safety check: make sure some activity can handle this action,
                // otherwise startActivity() would crash with ActivityNotFoundException.
                if (implicitIntent.resolveActivity(getPackageManager()) != null) {
                    startActivity(implicitIntent);
                } else {
                    Toast.makeText(this, "No app can handle this action", Toast.LENGTH_SHORT).show();
                }
            }
        });
    }

    /**
     * Validates the form and, if everything is filled in, attaches the data to the
     * given intent as extras. Works the same for explicit and implicit intents:
     * the data part of an Intent does not care how the target is chosen.
     *
     * @return true if the data was added, false if validation failed.
     */
    private boolean putFormData(Intent intent) {
        String fName = etFName.getText().toString().trim();
        String lName = etLName.getText().toString().trim();
        String sName = etSName.getText().toString().trim();
        String age = etAge.getText().toString().trim();

        if (fName.isEmpty() || lName.isEmpty() || sName.isEmpty() || age.isEmpty()) {
            Toast.makeText(this, "Please fill in all fields", Toast.LENGTH_SHORT).show();
            return false;
        }

        int genderId = radioGender.getCheckedRadioButtonId();
        if (genderId == -1) {
            Toast.makeText(this, "Please select your gender", Toast.LENGTH_SHORT).show();
            return false;
        }
        String gender = ((RadioButton) findViewById(genderId)).getText().toString();

        StringBuilder courses = new StringBuilder();
        for (CheckBox cb : courseBoxes) {
            if (cb.isChecked()) {
                if (courses.length() > 0) courses.append(", ");
                courses.append(cb.getText());
            }
        }
        if (courses.length() == 0) {
            Toast.makeText(this, "Please select at least one course", Toast.LENGTH_SHORT).show();
            return false;
        }

        String college = spinnerCollege.getSelectedItem().toString();

        // putExtra(key, value): attach each piece of data to the intent.
        // second_screen reads them back with getStringExtra / getIntExtra using the SAME keys.
        intent.putExtra(second_screen.EXTRA_FIRST_NAME, fName);
        intent.putExtra(second_screen.EXTRA_LAST_NAME, lName);
        intent.putExtra(second_screen.EXTRA_SURNAME, sName);
        intent.putExtra(second_screen.EXTRA_AGE, Integer.parseInt(age)); // sent as an int
        intent.putExtra(second_screen.EXTRA_GENDER, gender);
        intent.putExtra(second_screen.EXTRA_COURSES, courses.toString());
        intent.putExtra(second_screen.EXTRA_COLLEGE, college);
        return true;
    }
}
