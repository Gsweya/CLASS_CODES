package com.example.shiri;

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

public class MainActivity extends AppCompatActivity {

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

        EditText etFName = findViewById(R.id.etFName);
        EditText etLName = findViewById(R.id.etLName);
        EditText etSName = findViewById(R.id.etSName);
        EditText etAge = findViewById(R.id.etAge);
        RadioGroup radioGender = findViewById(R.id.radioGender);
        Spinner spinnerCollege = findViewById(R.id.spinnerCollege);
        Button btnSubmit = findViewById(R.id.btnSubmit);

        CheckBox[] courseBoxes = {
                findViewById(R.id.cbCp311),
                findViewById(R.id.cbCp313),
                findViewById(R.id.cbIa313),
                findViewById(R.id.cbEme314),
                findViewById(R.id.cbBt314)
        };

        btnSubmit.setOnClickListener(v -> {
            String fName = etFName.getText().toString().trim();
            String lName = etLName.getText().toString().trim();
            String sName = etSName.getText().toString().trim();
            String age = etAge.getText().toString().trim();

            if (fName.isEmpty() || lName.isEmpty() || sName.isEmpty() || age.isEmpty()) {
                Toast.makeText(this, "Please fill in all fields", Toast.LENGTH_SHORT).show();
                return;
            }

            int genderId = radioGender.getCheckedRadioButtonId();
            if (genderId == -1) {
                Toast.makeText(this, "Please select your gender", Toast.LENGTH_SHORT).show();
                return;
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
                return;
            }

            String college = spinnerCollege.getSelectedItem().toString();

            String message = "Name: " + fName + " " + lName + " " + sName
                    + "\nAge: " + age
                    + "\nGender: " + gender
                    + "\nCourses: " + courses
                    + "\nCollege: " + college;

            Toast.makeText(this, message, Toast.LENGTH_LONG).show();
        });
    }
}
