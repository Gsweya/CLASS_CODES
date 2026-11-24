package com.example.intentsdemo;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

public class CollegeActivity extends AppCompatActivity {

    public static final String EXTRA_COLLEGE = "college";

    private RadioGroup rgColleges;
    private Button btnChoose, btnCancel;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_college);

        if (getSupportActionBar() != null) {
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        }

        rgColleges = (RadioGroup) findViewById(R.id.rgColleges);
        btnChoose = (Button) findViewById(R.id.btnChoose);
        btnCancel = (Button) findViewById(R.id.btnCancel);

        btnChoose.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                int checkedId = rgColleges.getCheckedRadioButtonId();
                if (checkedId == -1) {
                    Toast.makeText(CollegeActivity.this, "Pick a college first", Toast.LENGTH_SHORT).show();
                    return;
                }
                RadioButton chosen = (RadioButton) findViewById(checkedId);

                // ---- SEND the answer BACK ----
                Intent result = new Intent();                       // no target: it goes back to the caller
                result.putExtra(EXTRA_COLLEGE, chosen.getText().toString());
                setResult(RESULT_OK, result);                       // "OK, here is the answer"
                finish();                                           // close -> the caller receives it
            }
        });

        btnCancel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                setResult(RESULT_CANCELED);
                finish();
            }
        });
    }
}
