package com.example.questionone;

import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;
import android.content.Intent;
import android.view.View;
import android.widget.Button;


public class MainActivity extends AppCompatActivity {
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        //  Inflate /res/layout/activity_main.xml and show it
        setContentView(R.layout.activity_main);

        // Get a Java reference to the button declared in the XML
        Button btnGoToSecond = findViewById(R.id.btnGoToSecond);

        // Anonymous inner class: an object that implements   View.onClickListener
        // Android calls its onClick() method every time the button is tapped.
        btnGoToSecond.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v){
                Intent intent = new Intent(MainActivity.this, SecondActivity.class);

                startActivity(intent);

            }
        });
    }
}