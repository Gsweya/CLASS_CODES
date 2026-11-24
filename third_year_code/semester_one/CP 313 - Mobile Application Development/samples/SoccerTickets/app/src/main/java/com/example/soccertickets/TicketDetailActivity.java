package com.example.soccertickets;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;

public class TicketDetailActivity extends AppCompatActivity {

    public static final String EXTRA_TICKET_INDEX = "ticket_index";

    private TextView tvCode, tvDetails, tvStatus;
    private Button btnPickUp, btnShare;
    private Ticket ticket;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_ticket_detail);

        if (getSupportActionBar() != null) {
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        }

        tvCode = (TextView) findViewById(R.id.tvCode);
        tvDetails = (TextView) findViewById(R.id.tvDetails);
        tvStatus = (TextView) findViewById(R.id.tvStatus);
        btnPickUp = (Button) findViewById(R.id.btnPickUp);
        btnShare = (Button) findViewById(R.id.btnShare);

        // RECEIVE the position, then read the real Ticket object from the shared store
        int index = getIntent().getIntExtra(EXTRA_TICKET_INDEX, -1);
        if (index < 0 || index >= DataStore.tickets.size()) {
            Toast.makeText(this, "Ticket not found", Toast.LENGTH_SHORT).show();
            finish();
            return;
        }
        ticket = DataStore.tickets.get(index);

        tvCode.setText(ticket.code);
        tvDetails.setText("Match:    " + ticket.matchTitle + "\n"
                + "Name:     " + ticket.buyerName + "\n"
                + "Phone:    " + ticket.phone + "\n"
                + "Tickets:  " + ticket.quantity + " x " + ticket.type + "\n"
                + "Paid:     " + DataStore.money(ticket.total));
        showStatus();

        btnPickUp.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ticket.pickedUp = true;      // change the object in the store ...
                showStatus();                // ... and the screen updates at once
                Toast.makeText(TicketDetailActivity.this, "Enjoy the match!", Toast.LENGTH_SHORT).show();
            }
        });

        // IMPLICIT intent: let any app (WhatsApp, SMS, Gmail ...) send the ticket
        btnShare.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent share = new Intent(Intent.ACTION_SEND);
                share.setType("text/plain");
                share.putExtra(Intent.EXTRA_TEXT, "My ticket " + ticket.code + " for "
                        + ticket.matchTitle + " (" + ticket.quantity + " x " + ticket.type + ")");
                startActivity(Intent.createChooser(share, "Share ticket via"));
            }
        });
    }

    private void showStatus() {
        if (ticket.pickedUp) {
            tvStatus.setText("✔ PICKED UP");
            tvStatus.setTextColor(ContextCompat.getColor(this, R.color.pitch_green));
            btnPickUp.setEnabled(false);
        } else {
            tvStatus.setText("Not picked up yet");
            tvStatus.setTextColor(ContextCompat.getColor(this, R.color.live_red));
            btnPickUp.setEnabled(true);
        }
    }
}
