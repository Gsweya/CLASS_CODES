package com.example.soccertickets;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

public class ConfirmActivity extends AppCompatActivity {

    public static final String EXTRA_MATCH = "match";
    public static final String EXTRA_NAME = "name";
    public static final String EXTRA_PHONE = "phone";
    public static final String EXTRA_TYPE = "type";
    public static final String EXTRA_QUANTITY = "quantity";
    public static final String EXTRA_TOTAL = "total";

    private TextView tvSummary;
    private Button btnEdit, btnPay;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_confirm);

        tvSummary = (TextView) findViewById(R.id.tvSummary);
        btnEdit = (Button) findViewById(R.id.btnEdit);
        btnPay = (Button) findViewById(R.id.btnPay);

        // ---- RECEIVE the order (same keys as the sender, matching getters) ----
        Intent intent = getIntent();
        String match = intent.getStringExtra(EXTRA_MATCH);
        String name = intent.getStringExtra(EXTRA_NAME);
        String phone = intent.getStringExtra(EXTRA_PHONE);
        String type = intent.getStringExtra(EXTRA_TYPE);
        int quantity = intent.getIntExtra(EXTRA_QUANTITY, 0);
        int total = intent.getIntExtra(EXTRA_TOTAL, 0);

        tvSummary.setText("Match:     " + match + "\n"
                + "Name:      " + name + "\n"
                + "Phone:     " + phone + "\n"
                + "Tickets:   " + quantity + " x " + type + "\n"
                + "To pay:    " + DataStore.money(total));

        // ---- ANSWER back to BuyTicketActivity ----
        btnPay.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                setResult(RESULT_OK);        // "yes, buy it"
                finish();
            }
        });

        btnEdit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                setResult(RESULT_CANCELED);  // "no, go back and change it"
                finish();
            }
        });
    }
}
