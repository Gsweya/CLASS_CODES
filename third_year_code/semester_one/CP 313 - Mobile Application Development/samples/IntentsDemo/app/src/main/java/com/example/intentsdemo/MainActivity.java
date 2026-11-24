package com.example.intentsdemo;

import android.content.ActivityNotFoundException;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.activity.result.ActivityResult;
import androidx.activity.result.ActivityResultCallback;
import androidx.activity.result.ActivityResultLauncher;
import androidx.activity.result.contract.ActivityResultContracts;
import androidx.appcompat.app.AppCompatActivity;

public class MainActivity extends AppCompatActivity {

    // ---- 1. Declare the views as fields ----
    private Button btnOpenSecond, btnSendData, btnChooseCollege;
    private Button btnWebsite, btnDial, btnMap, btnEmail, btnShare;
    private EditText etName, etAge;
    private CheckBox cbStudent;
    private TextView tvCollege;

    // Used to open CollegeActivity AND receive its answer
    private ActivityResultLauncher<Intent> collegeLauncher;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        Log.d("LIFECYCLE", "MainActivity onCreate");

        // ---- 2. Connect the fields to the XML views ----
        btnOpenSecond = (Button) findViewById(R.id.btnOpenSecond);
        btnSendData = (Button) findViewById(R.id.btnSendData);
        btnChooseCollege = (Button) findViewById(R.id.btnChooseCollege);
        btnWebsite = (Button) findViewById(R.id.btnWebsite);
        btnDial = (Button) findViewById(R.id.btnDial);
        btnMap = (Button) findViewById(R.id.btnMap);
        btnEmail = (Button) findViewById(R.id.btnEmail);
        btnShare = (Button) findViewById(R.id.btnShare);
        etName = (EditText) findViewById(R.id.etName);
        etAge = (EditText) findViewById(R.id.etAge);
        cbStudent = (CheckBox) findViewById(R.id.cbStudent);
        tvCollege = (TextView) findViewById(R.id.tvCollege);

        // ---- 3. Register the "result" receiver BEFORE the screen starts ----
        collegeLauncher = registerForActivityResult(
                new ActivityResultContracts.StartActivityForResult(),
                new ActivityResultCallback<ActivityResult>() {
                    @Override
                    public void onActivityResult(ActivityResult result) {
                        if (result.getResultCode() == RESULT_OK && result.getData() != null) {
                            Intent data = result.getData();
                            String college = data.getStringExtra(CollegeActivity.EXTRA_COLLEGE);
                            tvCollege.setText("You chose: " + college);
                        } else {
                            tvCollege.setText("You cancelled. No college chosen.");
                        }
                    }
                });

        // =========== 1. EXPLICIT INTENT, no data ===========
        btnOpenSecond.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                // Step 1: create the intent (FROM this screen, TO SecondActivity)
                Intent intent = new Intent(MainActivity.this, SecondActivity.class);
                // Step 2: use it to start the activity
                startActivity(intent);
            }
        });

        // =========== 2. EXPLICIT INTENT + DATA (extras) ===========
        btnSendData.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String name = etName.getText().toString().trim();
                String ageText = etAge.getText().toString().trim();

                if (name.isEmpty() || ageText.isEmpty()) {
                    Toast.makeText(MainActivity.this, "Enter your name and age first", Toast.LENGTH_SHORT).show();
                    return;
                }
                int age = Integer.parseInt(ageText);   // safe: inputType="number" and not empty
                boolean isStudent = cbStudent.isChecked();

                Intent intent = new Intent(MainActivity.this, ProfileActivity.class);
                intent.putExtra(ProfileActivity.EXTRA_NAME, name);         // String
                intent.putExtra(ProfileActivity.EXTRA_AGE, age);           // int
                intent.putExtra(ProfileActivity.EXTRA_STUDENT, isStudent); // boolean
                startActivity(intent);
            }
        });

        // =========== 3. START AN ACTIVITY FOR A RESULT ===========
        btnChooseCollege.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(MainActivity.this, CollegeActivity.class);
                collegeLauncher.launch(intent);    // instead of startActivity(intent)
            }
        });

        // =========== 4. IMPLICIT INTENTS ===========
        btnWebsite.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse("https://www.udom.ac.tz"));
                openSafely(intent);
            }
        });

        btnDial.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                // ACTION_DIAL only opens the dialer with the number; no permission needed
                Intent intent = new Intent(Intent.ACTION_DIAL, Uri.parse("tel:0712345678"));
                openSafely(intent);
            }
        });

        btnMap.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse("geo:0,0?q=University+of+Dodoma"));
                openSafely(intent);
            }
        });

        btnEmail.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(Intent.ACTION_SENDTO, Uri.parse("mailto:"));   // only email apps
                intent.putExtra(Intent.EXTRA_EMAIL, new String[]{"lecturer@udom.ac.tz"});
                intent.putExtra(Intent.EXTRA_SUBJECT, "CP 313 question");
                intent.putExtra(Intent.EXTRA_TEXT, "Hello, I have a question about intents.");
                openSafely(intent);
            }
        });

        btnShare.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(Intent.ACTION_SEND);
                intent.setType("text/plain");
                intent.putExtra(Intent.EXTRA_TEXT, "I am learning Android intents in CP 313!");
                // createChooser always shows the "Share via" list
                startActivity(Intent.createChooser(intent, "Share via"));
            }
        });
    }

    // If no app on the phone can handle an implicit intent, startActivity() crashes.
    // try/catch turns the crash into a friendly message.
    private void openSafely(Intent intent) {
        try {
            startActivity(intent);
        } catch (ActivityNotFoundException e) {
            Toast.makeText(this, "No app found to do this", Toast.LENGTH_SHORT).show();
        }
    }

    // ---- Lifecycle logs: watch them in Logcat (filter: LIFECYCLE) ----
    @Override
    protected void onStart() {
        super.onStart();
        Log.d("LIFECYCLE", "MainActivity onStart");
    }

    @Override
    protected void onResume() {
        super.onResume();
        Log.d("LIFECYCLE", "MainActivity onResume");
    }

    @Override
    protected void onPause() {
        super.onPause();
        Log.d("LIFECYCLE", "MainActivity onPause");
    }

    @Override
    protected void onStop() {
        super.onStop();
        Log.d("LIFECYCLE", "MainActivity onStop");
    }

    @Override
    protected void onRestart() {
        super.onRestart();
        Log.d("LIFECYCLE", "MainActivity onRestart");
    }
}
