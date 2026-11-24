# CP 313 — Sample App: Soccer Tickets ⚽🎟

**Course:** CP 313 Mobile Applications Development · **Type:** worked example + study guide
**Goes with:** [IntentsDemo/README.md](../IntentsDemo/README.md) (each idea on its own) · `CP313-Lecture-Three-Study-Walkthrough` (theory)
**Code style:** basic Java, the same as the lecture slides: fields at the top, `(Button) findViewById(...)`, `new View.OnClickListener() { ... }`, no lambdas.
**Checked:** 24 Nov 2026. The app builds with no errors. It has **not been run on a device yet**, so section 8 ("Things to try") is your first test run.
**Legend:** ➕ = beyond the slides · ⚠️ = trap

**How to use this guide:** read the Map and the flow diagram, open each file as its block mentions it, run the app, then do the exercises *before* the answer key.

---

## 1. 🗺️ MAP

| # | Block | Minutes |
|---|---|---:|
| A | What the app does (5 screens) | 5 |
| B | The files and what each one is for | 5 |
| C | **Data movement**: every hand-off between screens | 15 |
| D | **Temporary storage**: `DataStore` (no database) | 10 |
| E | **Live updates**: Handler + Runnable, TextWatcher, listeners | 15 |
| F | Navigation: back stack, `finish()`, Up arrow | 5 |
| G | Exercises + answer key | 20 |

---

## 2. A — What the app does

**Like I'm 8:** it's the ticket window at the stadium inside your phone. You pick a match, write your name, choose how many tickets, check the bill, pay, and get a ticket code that you show at the gate.

```
 ┌──────────────────┐ tap match  ┌──────────────────┐ Continue ┌──────────────────┐
 │ 1 MatchList      │──────────▶ │ 2 BuyTicket      │────────▶ │ 3 Confirm        │
 │ live scores,     │ index      │ name, phone,     │ order    │ summary          │
 │ seats left       │            │ type, quantity,  │ extras   │ [Edit] [Pay]     │
 │ [My Tickets (n)] │            │ live total       │ ◀────────│                  │
 └────────┬─────────┘            └────────┬─────────┘ result   └──────────────────┘
          │ button                        │ RESULT_OK → save ticket → open it, finish()
          ▼                               ▼
 ┌──────────────────┐ tap ticket ┌──────────────────┐ Share → other apps (implicit intent)
 │ 4 MyTickets      │──────────▶ │ 5 TicketDetail   │
 │ list + total     │ index      │ code, details    │
 │ spent            │            │ [Pick up] [Share]│
 └──────────────────┘            └──────────────────┘
```

**What is "live" on screen:**
- **Match list:** the derby's minute ticks every 2 seconds, goals happen at random, seats drop as "other fans" buy, and a match switches to FULL TIME at 90'.
- **Buy screen:** the score and seats keep updating, the **total price** changes the moment you tap +/− or Regular/VIP, the **ticket preview** changes as you type your name, and a **red warning** appears (Continue is disabled) if the seats drop below your quantity while you're filling in the form.
- **Ticket screen:** the status flips to "✔ PICKED UP" the moment you tap the button, and My Tickets shows it when you go back.

---

## 3. B — The files

```
app/src/main/
├── AndroidManifest.xml          ← all 5 activities registered; the launcher; Up-arrow parents
├── java/com/example/soccertickets/
│   ├── Match.java               ← model: one match (teams, prices, seats, score, status)
│   ├── Ticket.java              ← model: one bought ticket
│   ├── DataStore.java           ← TEMPORARY storage (static lists) + live-match simulation
│   ├── MatchListActivity.java   ← screen 1 (launcher)
│   ├── BuyTicketActivity.java   ← screen 2 (form, live total, launches Confirm for a result)
│   ├── ConfirmActivity.java     ← screen 3 (answers RESULT_OK / RESULT_CANCELED)
│   ├── MyTicketsActivity.java   ← screen 4
│   └── TicketDetailActivity.java← screen 5 (pick up, share)
└── res/
    ├── layout/activity_*.xml    ← one layout per activity
    └── values/colors.xml, strings.xml, themes.xml
```
Each activity is **3 files' worth of work**: its layout XML, its Java class, and its `<activity>` line in the manifest (the 4 steps from Lecture 3).

---

## 4. C — Data movement (the most important block)

**Like I'm 8:** activities can't read each other's minds. To pass something on, you either **put it in the envelope** (an intent extra) or **put it in the shared cupboard** (`DataStore`) and tell the next screen which shelf to look on.

| # | From → To | What moves | How |
|---|---|---|---|
| 1 | MatchList → BuyTicket | **which match** (its position, e.g. `0`) | `putExtra(EXTRA_MATCH_INDEX, position)` → `getIntExtra(EXTRA_MATCH_INDEX, -1)` |
| 2 | BuyTicket → Confirm | **the order**: match, name, phone, type, quantity, total | 6 × `putExtra` → 4 × `getStringExtra` + 2 × `getIntExtra` |
| 3 | Confirm → BuyTicket | **the answer**: pay or edit | `setResult(RESULT_OK)` / `setResult(RESULT_CANCELED)` + `finish()` → `onActivityResult(result)` |
| 4 | BuyTicket → DataStore | **the new ticket** (an object) | `DataStore.buyTicket(...)` adds it to the static list |
| 5 | BuyTicket → TicketDetail | **which ticket** (its position) | `putExtra(EXTRA_TICKET_INDEX, size - 1)` |
| 6 | DataStore → MatchList / MyTickets | the lists | each screen reads `DataStore.matches` / `DataStore.tickets` in `onResume()` |
| 7 | TicketDetail → DataStore | "picked up" | `ticket.pickedUp = true` changes the shared object |
| 8 | TicketDetail → other apps | ticket text | **implicit** `ACTION_SEND` + `createChooser` |

**Hand-off 1: send which match** (`MatchListActivity.java`):
```java
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
```
…and **receive it** (`BuyTicketActivity.java`):
```java
matchIndex = getIntent().getIntExtra(EXTRA_MATCH_INDEX, -1);   // -1 = "nothing was sent"
if (matchIndex < 0 || matchIndex >= DataStore.matches.size()) {
    Toast.makeText(this, "Match not found", Toast.LENGTH_SHORT).show();
    finish();
    return;
}
match = DataStore.matches.get(matchIndex);
```
**Why send the index and not the whole Match?** Extras carry simple values (int, String, boolean…). The real object stays in `DataStore`, and both screens look at **the same object**. So when the simulation changes the score, the Buy screen sees it too.

**Hand-off 2 + 3: send the order, get an answer back** (`BuyTicketActivity.java`):
```java
// registered once in onCreate
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

// in the Continue button, after validation
Intent intent = new Intent(BuyTicketActivity.this, ConfirmActivity.class);
intent.putExtra(ConfirmActivity.EXTRA_MATCH, match.getTitle());
intent.putExtra(ConfirmActivity.EXTRA_NAME, name);
intent.putExtra(ConfirmActivity.EXTRA_PHONE, phone);
intent.putExtra(ConfirmActivity.EXTRA_TYPE, getTicketType());
intent.putExtra(ConfirmActivity.EXTRA_QUANTITY, quantity);
intent.putExtra(ConfirmActivity.EXTRA_TOTAL, getTotal());
confirmLauncher.launch(intent);          // NOT startActivity: we want an answer
```
`ConfirmActivity.java` reads with matching getters, then answers:
```java
btnPay.setOnClickListener(new View.OnClickListener() {
    @Override
    public void onClick(View v) {
        setResult(RESULT_OK);        // "yes, buy it"
        finish();                    // closing the screen delivers the answer
    }
});
```
⚠️ The **keys** are `public static final String` constants inside the receiving class (`ConfirmActivity.EXTRA_NAME`), so the sender and receiver can never spell them differently. That is the bug from the Lecture 3 slides ("numberOne:" vs "numberOne").

---

## 5. D — Temporary storage: `DataStore`

**Like I'm 8:** `DataStore` is a whiteboard in the staff room. Every screen can read it and write on it. When the app is closed for good, the cleaner wipes it.

```java
public class DataStore {
    public static ArrayList<Match> matches = new ArrayList<Match>();
    public static ArrayList<Ticket> tickets = new ArrayList<Ticket>();
    ...
    static {                       // runs ONCE, the first time DataStore is used
        matches.add(new Match("Azam FC", "Singida Black Stars", "Azam Complex", "Sat 16:00",
                10000, 30000, 60, Match.UPCOMING, 0));
        ...
    }
}
```
- `static` = **one copy for the whole app**, not one per screen. That's why every activity sees the same tickets.
- **Lifetime:** the data lives as long as the app's **process**. It survives switching screens and pressing Home. It is lost when Android kills the app (swiped away, low memory) or the phone restarts.
- **Where to go next** (how to keep the data):

| Need | Use |
|---|---|
| a few settings (last name typed, dark mode) | `SharedPreferences` |
| many records on the phone | SQLite / Room |
| data shared between many users (real ticket sales!) | a server: see the note `CP313-Android-Backend-Linking` (PHP + MySQL + JSON) |

Because every screen talks only to `DataStore`, swapping it for a database later means changing **one class**, not five screens. That's why the storage is kept separate from the activities.

---

## 6. E — Live updates

**Like I'm 8:** the screen is a picture. To make it look "live", you change the data and **redraw the picture**, again and again.

**Pattern 1: a timer (Handler + Runnable)** for things that change by themselves (scores, seats):
```java
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
protected void onResume() {              // screen visible -> start ticking
    super.onResume();
    showMatches();
    handler.postDelayed(liveUpdate, 2000);
}

@Override
protected void onPause() {               // screen hidden -> stop ticking
    super.onPause();
    handler.removeCallbacks(liveUpdate);
}
```
⚠️ Forgetting `removeCallbacks` in `onPause()` keeps the timer running behind other screens, which wastes battery and updates a screen nobody sees. (This is the lifecycle from Lecture 3 in action: start in `onResume`, stop in `onPause`.)

**Pattern 2: react to the user** for things the user changes:

| User does | Listener | Code |
|---|---|---|
| types a letter | `TextWatcher` | `etName.addTextChangedListener(watcher)` → `onTextChanged(...) { updateScreen(); }` |
| picks Regular/VIP | `RadioGroup.OnCheckedChangeListener` | `onCheckedChanged(...) { updateScreen(); }` |
| taps + / − | `View.OnClickListener` | `quantity++; updateScreen();` |

**Pattern 3: one `updateScreen()` method redraws everything from the state.** All three triggers above, plus the timer, call it:
```java
private void updateScreen() {
    tvScore.setText(match.getScoreLine());
    tvSeats.setText("Seats left: " + match.seatsLeft);
    tvQuantity.setText(String.valueOf(quantity));      // setText needs text, not an int
    tvTotal.setText("Total: " + DataStore.money(getTotal()));
    ... preview ...
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
```
**Rule:** never update one TextView here and another there. Change the **state** (`quantity`, `match.seatsLeft`…), then call **one** method that draws everything. The screen can never disagree with the data.

**Lists:** the ListView shows an `ArrayList<String> rows`. To refresh it: `rows.clear()`, add the new texts, then `adapter.notifyDataSetChanged()`.

---

## 7. F — Navigation

- **Back stack:** MatchList → BuyTicket → Confirm. Each `startActivity` pushes a screen on top, and **Back** or `finish()` pops it.
- After paying, `saveTicket()` opens TicketDetail and calls **`finish()`** on BuyTicket. So Back from the ticket goes to the **match list**, not to a form that was already paid.
- **Up arrow** (top-left): `android:parentActivityName` in the manifest + `getSupportActionBar().setDisplayHomeAsUpEnabled(true)` in the activity.
- `android:launchMode="singleTop"` on MatchList and MyTickets: Up returns to the **existing** screen instead of building a new copy.
- ConfirmActivity has **no** parent on purpose: it must answer with Edit or Pay.

---

## 8. Things to try while it runs

1. Watch the derby's minute tick and the seats drop on the match list.
2. Open the **Simba SC vs Young Africans** match. Type your name and watch the preview change letter by letter.
3. Switch Regular ↔ VIP and tap + several times. The total changes instantly.
4. Set the quantity to 10 on a match with few seats (Dodoma Jiji) and wait. The red warning appears and Continue switches off when the seats drop below 10.
5. Continue → **Edit**: you're back on the form with everything still filled in (the Toast says "Not paid").
6. Continue → **Confirm & Pay**: the ticket screen opens with a code like `TKT-1001`. Tap **Pick up**, then go to **My Tickets**.
7. Tap the finished match (Coastal Union vs KMC FC): "Ticket sales are closed".

---

## 9. ✍️ EXERCISES (answer key below)

1. Add a **third ticket type** "Student" at half the Regular price. Which files and methods change?
2. Show **"Total spent: TSh …"** on the match list screen too.
3. On the Confirm screen, add a **payment method** (M-Pesa / Tigo Pesa / Airtel Money RadioGroup), send it **back** to BuyTicket with the result, and store it in the Ticket.
4. Make the live updates run every **5** seconds instead of 2.
5. Why does MyTicketsActivity load its list in `onResume()` and not `onCreate()`?
6. What happens to the bought tickets if you swipe the app away from Recents? Why?

### Answer key
1. `activity_buy_ticket.xml`: add `<RadioButton android:id="@+id/rbStudent" .../>`. In `BuyTicketActivity`: find it, set its text in `onCreate`, then update `getTicketType()` (`if (rbStudent.isChecked()) return "Student";`) and `getTotal()` (`price = match.regularPrice / 2;`). Nothing else changes, because `updateScreen()` already uses those two methods.
2. In `MatchListActivity.showMatches()`: `tvLastUpdate.setText("● Live · last update " + time + "  ·  spent " + DataStore.money(DataStore.totalSpent()));`
3. In `ConfirmActivity`, send the answer back with data:
   ```java
   Intent answer = new Intent();
   answer.putExtra("payment", chosen.getText().toString());
   setResult(RESULT_OK, answer);
   finish();
   ```
   In BuyTicket's callback: `String payment = result.getData().getStringExtra("payment");`. Add a `paymentMethod` field to `Ticket` and pass it into `DataStore.buyTicket(...)`.
4. Change `2000` to `5000` in **both** `postDelayed` calls in each activity (`onResume` and inside `run()`). ➕ Better: one constant `public static final int REFRESH_MS = 5000;` in DataStore.
5. `onCreate` runs only once when the screen is made. When you come back from TicketDetail (after picking up), `onCreate` does **not** run again, but `onResume` does, so the list shows "PICKED UP".
6. They are lost. `DataStore` lives in memory, and swiping the app away kills its process. To keep them, save to `SharedPreferences`, SQLite/Room, or a server (see block D).

---

## 10. 🧠 ACTIVE RECALL

- Draw the 5 screens and label every arrow with what data moves and how (extra, result, DataStore, implicit intent).
- Why send an **index** instead of the Match itself?
- What are the 3 steps inside the live-update Runnable? Where do you start and stop it, and why there?
- What does `static` mean in `DataStore`, and when is the data lost?
- What 3 listeners make the Buy screen react to the user?
- Why does the app call `finish()` on BuyTicket after paying?
