package com.example.soccertickets;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Looper;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.TextView;
import android.widget.Toast;

import androidx.activity.result.ActivityResult;
import androidx.activity.result.ActivityResultCallback;
import androidx.activity.result.ActivityResultLauncher;
import androidx.activity.result.contract.ActivityResultContracts;
import androidx.appcompat.app.AppCompatActivity;

public class BuyTicketActivity extends AppCompatActivity {

    public static final String EXTRA_MATCH_INDEX = "match_index";
    private static final int MAX_TICKETS = 10;

    private TextView tvMatchTitle, tvScore, tvSeats, tvQuantity, tvTotal, tvPreview, tvWarning;
    private EditText etName, etPhone;
    private RadioGroup rgType;
    private RadioButton rbRegular, rbVip;
    private Button btnMinus, btnPlus, btnContinue;

    // ---- the STATE of this screen (temporary, only while the screen is open) ----
    private int matchIndex;
    private Match match;
    private int quantity = 1;

    private ActivityResultLauncher<Intent> confirmLauncher;

    private Handler handler = new Handler(Looper.getMainLooper());
    private Runnable liveUpdate = new Runnable() {
        @Override
        public void run() {
            DataStore.updateLiveMatches();
            updateScreen();
            handler.postDelayed(this, 2000);
        }
    };

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_buy_ticket);

        if (getSupportActionBar() != null) {
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        }

        tvMatchTitle = (TextView) findViewById(R.id.tvMatchTitle);
        tvScore = (TextView) findViewById(R.id.tvScore);
        tvSeats = (TextView) findViewById(R.id.tvSeats);
        tvQuantity = (TextView) findViewById(R.id.tvQuantity);
        tvTotal = (TextView) findViewById(R.id.tvTotal);
        tvPreview = (TextView) findViewById(R.id.tvPreview);
        tvWarning = (TextView) findViewById(R.id.tvWarning);
        etName = (EditText) findViewById(R.id.etName);
        etPhone = (EditText) findViewById(R.id.etPhone);
        rgType = (RadioGroup) findViewById(R.id.rgType);
        rbRegular = (RadioButton) findViewById(R.id.rbRegular);
        rbVip = (RadioButton) findViewById(R.id.rbVip);
        btnMinus = (Button) findViewById(R.id.btnMinus);
        btnPlus = (Button) findViewById(R.id.btnPlus);
        btnContinue = (Button) findViewById(R.id.btnContinue);

        // ---- 1. RECEIVE which match was tapped ----
        matchIndex = getIntent().getIntExtra(EXTRA_MATCH_INDEX, -1);
        if (matchIndex < 0 || matchIndex >= DataStore.matches.size()) {
            Toast.makeText(this, "Match not found", Toast.LENGTH_SHORT).show();
            finish();
            return;
        }
        match = DataStore.matches.get(matchIndex);

        tvMatchTitle.setText(match.getTitle());
        rbRegular.setText("Regular  (" + DataStore.money(match.regularPrice) + ")");
        rbVip.setText("VIP  (" + DataStore.money(match.vipPrice) + ")");

        // ---- 2. LIVE updates while the user types / taps ----
        TextWatcher watcher = new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) { }

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
                updateScreen();               // every letter typed refreshes the preview
            }

            @Override
            public void afterTextChanged(Editable s) { }
        };
        etName.addTextChangedListener(watcher);
        etPhone.addTextChangedListener(watcher);

        rgType.setOnCheckedChangeListener(new RadioGroup.OnCheckedChangeListener() {
            @Override
            public void onCheckedChanged(RadioGroup group, int checkedId) {
                updateScreen();               // Regular <-> VIP changes the total
            }
        });

        btnMinus.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (quantity > 1) {
                    quantity--;
                    updateScreen();
                }
            }
        });

        btnPlus.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (quantity < MAX_TICKETS) {
                    quantity++;
                    updateScreen();
                }
            }
        });

        // ---- 3. Get the answer back from ConfirmActivity ----
        confirmLauncher = registerForActivityResult(
                new ActivityResultContracts.StartActivityForResult(),
                new ActivityResultCallback<ActivityResult>() {
                    @Override
                    public void onActivityResult(ActivityResult result) {
                        if (result.getResultCode() == RESULT_OK) {
                            saveTicket();
                        } else {
                            Toast.makeText(BuyTicketActivity.this, "Not paid. You can edit your order.", Toast.LENGTH_SHORT).show();
                        }
                    }
                });

        // ---- 4. Validate, then SEND the order to ConfirmActivity ----
        btnContinue.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String name = etName.getText().toString().trim();
                String phone = etPhone.getText().toString().trim();

                if (name.isEmpty()) {
                    etName.setError("Enter your name");
                    return;
                }
                if (phone.length() != 10 || !phone.startsWith("0")) {
                    etPhone.setError("Enter 10 digits starting with 0");
                    return;
                }
                if (!match.canBuy() || quantity > match.seatsLeft) {
                    Toast.makeText(BuyTicketActivity.this, "Not enough seats left", Toast.LENGTH_SHORT).show();
                    return;
                }

                Intent intent = new Intent(BuyTicketActivity.this, ConfirmActivity.class);
                intent.putExtra(ConfirmActivity.EXTRA_MATCH, match.getTitle());
                intent.putExtra(ConfirmActivity.EXTRA_NAME, name);
                intent.putExtra(ConfirmActivity.EXTRA_PHONE, phone);
                intent.putExtra(ConfirmActivity.EXTRA_TYPE, getTicketType());
                intent.putExtra(ConfirmActivity.EXTRA_QUANTITY, quantity);
                intent.putExtra(ConfirmActivity.EXTRA_TOTAL, getTotal());
                confirmLauncher.launch(intent);
            }
        });

        updateScreen();
    }

    @Override
    protected void onResume() {
        super.onResume();
        handler.postDelayed(liveUpdate, 2000);
    }

    @Override
    protected void onPause() {
        super.onPause();
        handler.removeCallbacks(liveUpdate);
    }

    private String getTicketType() {
        if (rbVip.isChecked()) {
            return "VIP";
        }
        return "Regular";
    }

    private int getTotal() {
        int price;
        if (rbVip.isChecked()) {
            price = match.vipPrice;
        } else {
            price = match.regularPrice;
        }
        return price * quantity;
    }

    /** ONE method redraws everything from the current state. Every change calls it. */
    private void updateScreen() {
        tvScore.setText(match.getScoreLine());
        tvSeats.setText("Seats left: " + match.seatsLeft);
        tvQuantity.setText(String.valueOf(quantity));      // setText needs text, not an int
        tvTotal.setText("Total: " + DataStore.money(getTotal()));

        String name = etName.getText().toString().trim();
        if (name.isEmpty()) {
            name = "(your name)";
        }
        tvPreview.setText("🎟  " + match.getTitle() + "\n"
                + name + "\n"
                + quantity + " x " + getTicketType() + "  ·  " + DataStore.money(getTotal()));

        // React to the live data: seats can run out while the user is still typing
        if (!match.canBuy()) {
            tvWarning.setText("Sorry, sales have closed for this match.");
            tvWarning.setVisibility(View.VISIBLE);
            btnContinue.setEnabled(false);
        } else if (quantity > match.seatsLeft) {
            tvWarning.setText("Only " + match.seatsLeft + " seats left. Reduce the number of tickets.");
            tvWarning.setVisibility(View.VISIBLE);
            btnContinue.setEnabled(false);
        } else {
            tvWarning.setVisibility(View.GONE);
            btnContinue.setEnabled(true);
        }
    }

    /** Called only after ConfirmActivity answered RESULT_OK. */
    private void saveTicket() {
        if (quantity > match.seatsLeft) {   // seats may have sold out while confirming
            Toast.makeText(this, "Sorry, the seats sold out while you were paying", Toast.LENGTH_LONG).show();
            updateScreen();
            return;
        }
        Ticket t = DataStore.buyTicket(matchIndex,
                etName.getText().toString().trim(),
                etPhone.getText().toString().trim(),
                getTicketType(), quantity, getTotal());

        Toast.makeText(this, "Paid! Your ticket code is " + t.code, Toast.LENGTH_LONG).show();

        // Go straight to the new ticket. finish() removes this form from the back stack.
        Intent intent = new Intent(this, TicketDetailActivity.class);
        intent.putExtra(TicketDetailActivity.EXTRA_TICKET_INDEX, DataStore.tickets.size() - 1);
        startActivity(intent);
        finish();
    }
}
