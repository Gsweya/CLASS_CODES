package com.example.intentsdemo;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

public class ProfileActivity extends AppCompatActivity {

    // KEYS as constants: sender and receiver use the SAME names, so a typo is impossible
    public static final String EXTRA_NAME = "name";
    public static final String EXTRA_AGE = "age";
    public static final String EXTRA_STUDENT = "is_student";

    private TextView tvWelcome, tvDetails;
    private Button btnBack;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_profile);

        if (getSupportActionBar() != null) {
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        }

        tvWelcome = (TextView) findViewById(R.id.tvWelcome);
        tvDetails = (TextView) findViewById(R.id.tvDetails);
        btnBack = (Button) findViewById(R.id.btnBack);

        // ---- RECEIVE the data ----
        Intent intent = getIntent();                                  // the intent that opened me
        String name = intent.getStringExtra(EXTRA_NAME);              // String  -> getStringExtra
        int age = intent.getIntExtra(EXTRA_AGE, 0);                   // int     -> getIntExtra (0 = default)
        boolean isStudent = intent.getBooleanExtra(EXTRA_STUDENT, false); // boolean -> getBooleanExtra

        tvWelcome.setText("Karibu, " + name + "!");
        // setText needs TEXT: "" + age turns the number into text (setText(age) would crash)
        String details = "Age: " + age + "\n"
                + "Student: " + (isStudent ? "Yes" : "No") + "\n"
                + "In 5 years you will be " + (age + 5) + ".";
        tvDetails.setText(details);

        btnBack.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
    }
}
