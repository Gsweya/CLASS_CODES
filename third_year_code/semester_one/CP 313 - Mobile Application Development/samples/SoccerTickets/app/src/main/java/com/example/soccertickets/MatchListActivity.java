package com.example.soccertickets;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Looper;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.Locale;

public class MatchListActivity extends AppCompatActivity {

    private ListView lvMatches;
    private TextView tvLastUpdate;
    private Button btnMyTickets;

    private ArrayList<String> rows = new ArrayList<String>();   // the text shown in the list
    private ArrayAdapter<String> adapter;

    // ---- LIVE UPDATES: a Handler runs the Runnable again every 2 seconds ----
    private Handler handler = new Handler(Looper.getMainLooper());
    private Runnable liveUpdate = new Runnable() {
        @Override
        public void run() {
            DataStore.updateLiveMatches();   // 1. change the data
            showMatches();                   // 2. redraw the screen from the data
            handler.postDelayed(this, 2000); // 3. run me again in 2 seconds
        }
    };

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_match_list);

        lvMatches = (ListView) findViewById(R.id.lvMatches);
        tvLastUpdate = (TextView) findViewById(R.id.tvLastUpdate);
        btnMyTickets = (Button) findViewById(R.id.btnMyTickets);

        adapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, rows);
        lvMatches.setAdapter(adapter);

        // Tap a match -> open BuyTicketActivity and SEND which match (its position in the list)
        lvMatches.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Match match = DataStore.matches.get(position);
                if (!match.canBuy()) {
                    Toast.makeText(MatchListActivity.this, "Ticket sales are closed for this match", Toast.LENGTH_SHORT).show();
                    return;
                }
                Intent intent = new Intent(MatchListActivity.this, BuyTicketActivity.class);
                intent.putExtra(BuyTicketActivity.EXTRA_MATCH_INDEX, position);
                startActivity(intent);
            }
        });

        btnMyTickets.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(MatchListActivity.this, MyTicketsActivity.class);
                startActivity(intent);
            }
        });
    }

    // Start the live updates when the screen is visible ...
    @Override
    protected void onResume() {
        super.onResume();
        showMatches();                        // fresh data (e.g. seats after a purchase)
        handler.postDelayed(liveUpdate, 2000);
    }

    // ... and stop them when it is not (saves battery, avoids updating a hidden screen)
    @Override
    protected void onPause() {
        super.onPause();
        handler.removeCallbacks(liveUpdate);
    }

    private void showMatches() {
        rows.clear();
        for (int i = 0; i < DataStore.matches.size(); i++) {
            rows.add(DataStore.matches.get(i).toListText());
        }
        adapter.notifyDataSetChanged();       // tell the list "the data changed, redraw"

        String time = new SimpleDateFormat("HH:mm:ss", Locale.US).format(new Date());
        tvLastUpdate.setText("● Live · last update " + time);
        btnMyTickets.setText("My Tickets (" + DataStore.tickets.size() + ")");
    }
}
