package com.example.shiri;

import android.content.Intent;
import android.os.Bundle;
import android.widget.Button;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowCompat;
import androidx.core.view.WindowInsetsCompat;

/**
 * Second activity: RECEIVES the data that MainActivity sends inside an Intent.
 *
 * It can be opened in two ways (see MainActivity):
 *   1. EXPLICIT intent -> MainActivity names this class directly (second_screen.class).
 *   2. IMPLICIT intent -> MainActivity only says "I want ACTION_SHOW_DETAILS"; Android
 *                         finds this activity because of the <intent-filter> in the manifest.
 * Either way, the data travels the same way: as "extras" (key/value pairs) on the Intent.
 */
public class second_screen extends AppCompatActivity {

    // Keys for the extras. Both activities use these same constants so the
    // sender (putExtra) and the receiver (getStringExtra) always match.
    public static final String EXTRA_FIRST_NAME = "com.example.shiri.EXTRA_FIRST_NAME";
    public static final String EXTRA_LAST_NAME  = "com.example.shiri.EXTRA_LAST_NAME";
    public static final String EXTRA_SURNAME    = "com.example.shiri.EXTRA_SURNAME";
    public static final String EXTRA_AGE        = "com.example.shiri.EXTRA_AGE";
    public static final String EXTRA_GENDER     = "com.example.shiri.EXTRA_GENDER";
    public static final String EXTRA_COURSES    = "com.example.shiri.EXTRA_COURSES";
    public static final String EXTRA_COLLEGE    = "com.example.shiri.EXTRA_COLLEGE";

    // Custom action string for the IMPLICIT intent. It must be identical to the
    // <action android:name="..."/> inside this activity's <intent-filter> in AndroidManifest.xml.
    public static final String ACTION_SHOW_DETAILS = "com.example.shiri.ACTION_SHOW_DETAILS";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        WindowCompat.enableEdgeToEdge(getWindow());
        setContentView(R.layout.activity_second_screen);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        TextView tvIntentType = findViewById(R.id.tvIntentType);
        TextView tvDetails = findViewById(R.id.tvDetails);
        Button btnShare = findViewById(R.id.btnShare);
        Button btnBack = findViewById(R.id.btnBack);

        // ---- 1. Get the Intent that started this activity ----
        Intent received = getIntent();

        // ---- 2. Find out HOW we were started ----
        // An implicit intent carries our custom action; an explicit one (as built in
        // MainActivity) has no action, because it names the class directly instead.
        if (ACTION_SHOW_DETAILS.equals(received.getAction())) {
            tvIntentType.setText("Opened with an IMPLICIT intent\n(action: ACTION_SHOW_DETAILS)");
        } else {
            tvIntentType.setText("Opened with an EXPLICIT intent\n(class: second_screen)");
        }

        // ---- 3. Read the extras using the same keys the sender used ----
        String fName   = received.getStringExtra(EXTRA_FIRST_NAME);
        String lName   = received.getStringExtra(EXTRA_LAST_NAME);
        String sName   = received.getStringExtra(EXTRA_SURNAME);
        int    age     = received.getIntExtra(EXTRA_AGE, 0); // 0 = default if the key is missing
        String gender  = received.getStringExtra(EXTRA_GENDER);
        String courses = received.getStringExtra(EXTRA_COURSES);
        String college = received.getStringExtra(EXTRA_COLLEGE);

        // ---- 4. Display the received data ----
        String details = "Name: " + fName + " " + lName + " " + sName
                + "\nAge: " + age
                + "\nGender: " + gender
                + "\nCourses: " + courses
                + "\nCollege: " + college;
        tvDetails.setText(details);

        // ---- IMPLICIT intent example #2: a system action ----
        // We don't say WHICH app should share the text (WhatsApp, Gmail, SMS...).
        // We only describe the job (ACTION_SEND + "text/plain") and Android shows
        // every app that has a matching intent-filter.
        btnShare.setOnClickListener(v -> {
            Intent share = new Intent(Intent.ACTION_SEND);
            share.setType("text/plain");
            share.putExtra(Intent.EXTRA_SUBJECT, "Student registration");
            share.putExtra(Intent.EXTRA_TEXT, details);
            startActivity(Intent.createChooser(share, "Share details via"));
        });

        // Close this activity and return to the form (MainActivity is still on the back stack).
        btnBack.setOnClickListener(v -> finish());
    }
}
