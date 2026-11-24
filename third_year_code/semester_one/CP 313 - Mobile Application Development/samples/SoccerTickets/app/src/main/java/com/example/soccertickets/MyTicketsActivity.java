package com.example.soccertickets;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import java.util.ArrayList;

public class MyTicketsActivity extends AppCompatActivity {

    private ListView lvTickets;
    private TextView tvSummary, tvEmpty;
    private ArrayList<String> rows = new ArrayList<String>();
    private ArrayAdapter<String> adapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_my_tickets);

        if (getSupportActionBar() != null) {
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        }

        lvTickets = (ListView) findViewById(R.id.lvTickets);
        tvSummary = (TextView) findViewById(R.id.tvSummary);
        tvEmpty = (TextView) findViewById(R.id.tvEmpty);

        adapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, rows);
        lvTickets.setAdapter(adapter);
        lvTickets.setEmptyView(tvEmpty);     // shows tvEmpty when the list has no rows

        lvTickets.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Intent intent = new Intent(MyTicketsActivity.this, TicketDetailActivity.class);
                intent.putExtra(TicketDetailActivity.EXTRA_TICKET_INDEX, position);
                startActivity(intent);
            }
        });
    }

    // onResume (not onCreate): runs EVERY time we come back, e.g. after picking up a ticket
    @Override
    protected void onResume() {
        super.onResume();
        rows.clear();
        for (int i = 0; i < DataStore.tickets.size(); i++) {
            rows.add(DataStore.tickets.get(i).toListText());
        }
        adapter.notifyDataSetChanged();
        tvSummary.setText(DataStore.tickets.size() + " ticket(s)  ·  total spent "
                + DataStore.money(DataStore.totalSpent()));
    }
}
