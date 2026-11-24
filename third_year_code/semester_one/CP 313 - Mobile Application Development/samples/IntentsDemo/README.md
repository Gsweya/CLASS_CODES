# CP 313 — Activities and Intents: Practical Guide

**Course:** CP 313 Mobile Applications Development · **Type:** hands-on study guide with a runnable app (`samples/IntentsDemo`)
**Goes with:** `CP313-Lecture-Three-Study-Walkthrough` (the theory and the slide bugs) · next: [SoccerTickets](../SoccerTickets/README.md) (everything here working together in a real app)
**Code style:** basic Java, the same as the lecture slides: fields at the top, `(Button) findViewById(...)`, `new View.OnClickListener() { ... }`, no lambdas.
**Checked:** 24 Nov 2026. The app builds with no errors. It has **not been run on a device yet**, so run it and compare what you see with this guide (block H tells you what Logcat should print).
**Legend:** ➕ = beyond the slides · ⚠️ = trap that crashes the app or loses marks

**How to use this guide:** read the Map, then each block with the matching file open. Run the app and press the buttons in order 1 → 4. Do the exercises before the answer key.

---

## 1. 🗺️ MAP

| # | Block | Minutes | Exam chance |
|---|---|---:|:---:|
| A | Explicit vs implicit, in one picture | 5 | ⭐⭐⭐ |
| B | **Creating an activity** (wizard and by hand) | 10 | ⭐⭐⭐ |
| C | **Adding another activity** + the manifest | 5 | ⭐⭐⭐ |
| D | **Create an intent → start a specific activity** | 5 | ⭐⭐⭐ |
| E | **Sending and receiving data** (extras) | 15 | ⭐⭐⭐ |
| F | Getting data **back** (activity result) | 10 | ⭐⭐ |
| G | **Implicit intents** (web, dial, map, email, share) | 10 | ⭐⭐⭐ |
| H | **Connecting activities**: back stack, `finish()`, Up, lifecycle order | 10 | ⭐⭐⭐ |
| I | Errors and fixes | 5 | ⭐⭐ |

The app's main screen has exactly these sections: **1** explicit, **2** send data, **3** get data back, **4** implicit.

---

## 2. THE GUIDE

### A. Explicit vs implicit

**Like I'm 8:** an **explicit** intent is a letter with a name on it: "To: ProfileActivity". An **implicit** intent is shouting "Can someone open this web page?" and letting Android find someone who can (Chrome, Firefox…).

```
EXPLICIT (inside your app)                    IMPLICIT (any app that can do it)
MainActivity ──Intent(this, Profile.class)──▶ ProfileActivity
MainActivity ──Intent(ACTION_VIEW, "https://…")──▶ Android ──▶ Chrome / Firefox / …
```

| | Explicit | Implicit |
|---|---|---|
| Names the target class? | **Yes** | **No**: gives an **action** (+ data) |
| Who picks the screen? | you | the Android system |
| Used for | moving between **your own** activities | using **other apps** (browser, dialer, maps, email, share) |
| Code | `new Intent(MainActivity.this, ProfileActivity.class)` | `new Intent(Intent.ACTION_VIEW, Uri.parse("https://www.udom.ac.tz"))` |
| Can fail if… | the activity isn't in the manifest | no app on the phone can handle it |

### B. Creating an activity

An activity = **one screen** = 3 things: a **layout** (XML), a **Java class**, and a **line in the manifest**.

**Way 1: the Android Studio wizard (fastest, does all 3 for you)**
1. In the Project panel, right-click `app` → **New → Activity → Empty Views Activity**.
2. Activity Name: `ProfileActivity`. Layout Name: `activity_profile` (filled in for you). Language: **Java**.
3. Finish. Android Studio creates `ProfileActivity.java` and `res/layout/activity_profile.xml`, **and** adds `<activity android:name=".ProfileActivity" />` to the manifest.

**Way 2: by hand (the 4 steps from Lecture 3; know them for the exam)**

**Step 1: the layout**, `res/layout/activity_profile.xml`:
```xml
<LinearLayout xmlns:android="http://schemas.android.com/apk/res/android"
    android:layout_width="match_parent"
    android:layout_height="match_parent"
    android:orientation="vertical"
    android:padding="16dp">

    <TextView
        android:id="@+id/tvWelcome"
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:textSize="22sp"
        android:textStyle="bold" />

    <TextView
        android:id="@+id/tvDetails"
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:layout_marginTop="12dp"
        android:textSize="16sp" />

    <Button
        android:id="@+id/btnBack"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:layout_marginTop="24dp"
        android:text="Back" />
</LinearLayout>
```
**Steps 2 + 3: the Java class**, which extends `AppCompatActivity` and connects the layout with `setContentView`:
```java
package com.example.intentsdemo;

import android.os.Bundle;
import androidx.appcompat.app.AppCompatActivity;

public class ProfileActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_profile);   // step 3: connect to the layout
    }
}
```
**Step 4: declare it** in `AndroidManifest.xml`, inside `<application>`:
```xml
<activity
    android:name=".ProfileActivity"
    android:label="Profile (data received)"
    android:parentActivityName=".MainActivity" />
```
⚠️ Forget step 4 and the app **crashes** the moment you try to open the screen (`ActivityNotFoundException: Unable to find explicit activity class … have you declared this activity in your AndroidManifest.xml?`).

### C. Adding another activity: the checklist

Every time you add a screen, tick all of these:
- [ ] `activity_xxx.xml` in `res/layout/`
- [ ] `XxxActivity.java` that `extends AppCompatActivity`
- [ ] `setContentView(R.layout.activity_xxx)` in its `onCreate`
- [ ] `<activity android:name=".XxxActivity" />` in the manifest
- [ ] something that **opens** it (an intent from another screen; block D)

**The manifest for this app** (all 4 screens). Only **one** activity has the MAIN/LAUNCHER intent-filter, and that one is the icon on the home screen:
```xml
<application ... android:theme="@style/Theme.App">

    <activity
        android:name=".MainActivity"
        android:exported="true"
        android:label="Intents Demo"
        android:launchMode="singleTop">
        <intent-filter>
            <action android:name="android.intent.action.MAIN" />
            <category android:name="android.intent.category.LAUNCHER" />
        </intent-filter>
    </activity>

    <activity android:name=".SecondActivity"  android:label="Second Screen"
              android:parentActivityName=".MainActivity" />
    <activity android:name=".ProfileActivity" android:label="Profile (data received)"
              android:parentActivityName=".MainActivity" />
    <activity android:name=".CollegeActivity" android:label="Choose a College"
              android:parentActivityName=".MainActivity" />
</application>
```
- `android:label` = the title shown at the top of that screen.
- `android:exported="true"` is **required** on any activity with an intent-filter (Android 12+). Other apps may start it.
- `android:parentActivityName` = where the **Up arrow** goes (block H).

### D. Create an intent and start a specific activity

**Like I'm 8:** step 1, write the letter (who it's from, who it's for). Step 2, post it.

From `MainActivity.java`:
```java
public class MainActivity extends AppCompatActivity {

    private Button btnOpenSecond;                       // 1. declare the view

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        btnOpenSecond = (Button) findViewById(R.id.btnOpenSecond);   // 2. connect it

        btnOpenSecond.setOnClickListener(new View.OnClickListener() {  // 3. react to the click
            @Override
            public void onClick(View v) {
                // Step 1: create the intent (FROM this screen, TO SecondActivity)
                Intent intent = new Intent(MainActivity.this, SecondActivity.class);
                // Step 2: use it to start the activity
                startActivity(intent);
            }
        });
    }
}
```
- `MainActivity.this`: inside `new View.OnClickListener() { ... }`, plain `this` means **the listener**, not the activity. ⚠️ `new Intent(this, SecondActivity.class)` there **won't compile**.
- `SecondActivity.class` = the exact screen to open (that's what makes it **explicit**).

Closing a screen: `finish();` (SecondActivity's "Go back" button). The previous screen comes back.

### E. Sending and receiving data (extras)

**Like I'm 8:** extras are labelled envelopes stuck to the intent. The label (**key**) must be written exactly the same by the sender and the receiver.

**Send** (MainActivity, section 2):
```java
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
```
**Receive** (ProfileActivity):
```java
public class ProfileActivity extends AppCompatActivity {

    // KEYS as constants: sender and receiver use the SAME names, so a typo is impossible
    public static final String EXTRA_NAME = "name";
    public static final String EXTRA_AGE = "age";
    public static final String EXTRA_STUDENT = "is_student";

    private TextView tvWelcome, tvDetails;
    private Button btnBack;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_profile);

        tvWelcome = (TextView) findViewById(R.id.tvWelcome);
        tvDetails = (TextView) findViewById(R.id.tvDetails);
        btnBack = (Button) findViewById(R.id.btnBack);

        Intent intent = getIntent();                                      // the intent that opened me
        String name = intent.getStringExtra(EXTRA_NAME);                  // String  -> getStringExtra
        int age = intent.getIntExtra(EXTRA_AGE, 0);                       // int     -> getIntExtra (0 = default)
        boolean isStudent = intent.getBooleanExtra(EXTRA_STUDENT, false); // boolean -> getBooleanExtra

        tvWelcome.setText("Karibu, " + name + "!");
        String details = "Age: " + age + "\n"
                + "Student: " + (isStudent ? "Yes" : "No") + "\n"
                + "In 5 years you will be " + (age + 5) + ".";
        tvDetails.setText(details);
        ...
    }
}
```
Try it: enter **Asha**, **21**, tick the box → the Profile screen should show "Karibu, Asha!", "Age: 21", "Student: Yes", "In 5 years you will be 26."

**Put / get pairs:**

| Type | Send | Receive | Default needed? |
|---|---|---|---|
| String | `putExtra("k", "Asha")` | `getStringExtra("k")` | no (returns `null` if missing) |
| int | `putExtra("k", 21)` | `getIntExtra("k", 0)` | **yes** |
| double | `putExtra("k", 4.3)` | `getDoubleExtra("k", 0.0)` | yes |
| boolean | `putExtra("k", true)` | `getBooleanExtra("k", false)` | yes |
| long | `putExtra("k", 5L)` | `getLongExtra("k", 0L)` | yes |
| String[] | `putExtra("k", arr)` | `getStringArrayExtra("k")` | no |
| ➕ your own object | class `implements Serializable` → `putExtra("k", obj)` | `(Ticket) getSerializableExtra("k")` | no |

The default is returned when the key **isn't found**, so it's also what you get if you misspell the key.

⚠️ **The 3 classic bugs** (all three are on the Lecture 3 slides):
1. **Key mismatch:** `"numberOne:"` sent, `"numberOne"` read → `null` / default. **Fix:** constants like `EXTRA_NAME`.
2. **Type mismatch:** sent an `int`, read with `getStringExtra` → `null`. **Fix:** the getter must match the type that was sent.
3. **`setText(int)`:** `tv.setText(age)` treats `age` as a **resource id** and crashes (`Resources$NotFoundException`). **Fix:** `tv.setText(String.valueOf(age))` or `"Age: " + age`.

### F. Getting data back (activity result)

**Like I'm 8:** you send a friend to the shop with a question ("which college?"). They come back with the answer in their hand.

Three parts:

**1. The caller registers a "receiver"** in `onCreate` (MainActivity):
```java
private ActivityResultLauncher<Intent> collegeLauncher;   // field

// in onCreate:
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
```
**2. The caller opens the screen with `launch`** (not `startActivity`):
```java
btnChooseCollege.setOnClickListener(new View.OnClickListener() {
    @Override
    public void onClick(View v) {
        Intent intent = new Intent(MainActivity.this, CollegeActivity.class);
        collegeLauncher.launch(intent);
    }
});
```
**3. The opened screen answers with `setResult` + `finish`** (CollegeActivity):
```java
btnChoose.setOnClickListener(new View.OnClickListener() {
    @Override
    public void onClick(View v) {
        int checkedId = rgColleges.getCheckedRadioButtonId();
        if (checkedId == -1) {
            Toast.makeText(CollegeActivity.this, "Pick a college first", Toast.LENGTH_SHORT).show();
            return;
        }
        RadioButton chosen = (RadioButton) findViewById(checkedId);

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
```
Try it: CNMS → Choose → the main screen should show "You chose: CNMS". Cancel → "You cancelled. No college chosen."

➕ **The old way (deprecated, but still in many tutorials and past papers):**
```java
private static final int REQUEST_COLLEGE = 1;

startActivityForResult(new Intent(this, CollegeActivity.class), REQUEST_COLLEGE);

@Override
protected void onActivityResult(int requestCode, int resultCode, Intent data) {
    super.onActivityResult(requestCode, resultCode, data);
    if (requestCode == REQUEST_COLLEGE && resultCode == RESULT_OK) {
        String college = data.getStringExtra("college");
    }
}
```
The answering side (`setResult` + `finish`) is the **same** in both ways.

### G. Implicit intents

**Like I'm 8:** you don't say *who* should do it, only *what* to do. Android shows every app that can.

From `MainActivity.java`, section 4:
```java
// Open a web page
Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse("https://www.udom.ac.tz"));
openSafely(intent);

// Open the dialer with a number typed in (ACTION_DIAL needs NO permission; ACTION_CALL would)
Intent intent = new Intent(Intent.ACTION_DIAL, Uri.parse("tel:0712345678"));
openSafely(intent);

// Show a place on a map
Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse("geo:0,0?q=University+of+Dodoma"));
openSafely(intent);

// Write an email (SENDTO + "mailto:" -> only email apps answer)
Intent intent = new Intent(Intent.ACTION_SENDTO, Uri.parse("mailto:"));
intent.putExtra(Intent.EXTRA_EMAIL, new String[]{"lecturer@udom.ac.tz"});
intent.putExtra(Intent.EXTRA_SUBJECT, "CP 313 question");
intent.putExtra(Intent.EXTRA_TEXT, "Hello, I have a question about intents.");
openSafely(intent);

// Share text with ANY app (WhatsApp, SMS, Gmail...) through the "Share via" chooser
Intent intent = new Intent(Intent.ACTION_SEND);
intent.setType("text/plain");
intent.putExtra(Intent.EXTRA_TEXT, "I am learning Android intents in CP 313!");
startActivity(Intent.createChooser(intent, "Share via"));
```
The safety wrapper. If no app can handle an implicit intent, `startActivity` **crashes**, so catch it:
```java
private void openSafely(Intent intent) {
    try {
        startActivity(intent);
    } catch (ActivityNotFoundException e) {
        Toast.makeText(this, "No app found to do this", Toast.LENGTH_SHORT).show();
    }
}
```

| Action | Data (Uri) | Opens |
|---|---|---|
| `ACTION_VIEW` | `https://…` | browser |
| `ACTION_VIEW` | `geo:0,0?q=place` | maps |
| `ACTION_DIAL` | `tel:0712…` | dialer (user presses call) |
| `ACTION_SENDTO` | `mailto:` / `smsto:0712…` | email / SMS apps |
| `ACTION_SEND` | (none) + `setType("text/plain")` + `EXTRA_TEXT` | share sheet |
| ➕ `MediaStore.ACTION_IMAGE_CAPTURE` | — | camera |

### H. Connecting activities (navigation)

**Like I'm 8:** screens are a **stack of plates**. Opening a screen puts a plate on top, and Back (or `finish()`) takes the top plate off.

```
start app          tap "Open Second"        press Back / finish()
[Main]       →     [Second]          →      [Main]
                   [Main]
```
- **Back button / `finish()`** → removes the top screen.
- **Up arrow** (top-left) → goes to `android:parentActivityName`. You must also switch it on in the child activity:
  ```java
  if (getSupportActionBar() != null) {
      getSupportActionBar().setDisplayHomeAsUpEnabled(true);
  }
  ```
- `android:launchMode="singleTop"` on MainActivity: Up returns to the **same** MainActivity (your chosen college is still shown) instead of building a fresh one.
- ➕ Login → Home pattern: `startActivity(homeIntent); finish();`, so Back from Home doesn't return to the login screen.

**What Logcat should show** (Logcat tab → filter `LIFECYCLE`). This is the standard Android order. Run the app and check that yours matches:
```
-- app starts --
MainActivity onCreate
MainActivity onStart
MainActivity onResume
-- tap "Open Second Screen" --
MainActivity onPause
SecondActivity onCreate
SecondActivity onStart
SecondActivity onResume
MainActivity onStop
-- tap "Go back (finish)" --
SecondActivity onPause
MainActivity onRestart
MainActivity onStart
MainActivity onResume
SecondActivity onStop
SecondActivity onDestroy
```

Lessons from this order:
1. The **old screen pauses first** (`MainActivity onPause`), then the new one is fully created and resumed, and **only then** does the old one stop. This lets the new screen appear without a blank gap.
2. Coming back, MainActivity is **not** recreated. It goes `onRestart → onStart → onResume`, which is why your typed name is still in the box.
3. The closed screen is **destroyed** (`SecondActivity onDestroy`). Opening it again builds a new one.

### I. Errors and fixes

| You see | Cause | Fix |
|---|---|---|
| `ActivityNotFoundException: Unable to find explicit activity class` | activity not in the manifest | add `<activity android:name=".XxxActivity" />` |
| `ActivityNotFoundException: No Activity found to handle Intent` | implicit intent with no app able to answer | try/catch (`openSafely`), or `createChooser` |
| `new Intent(this, X.class)` red underline inside a listener | `this` is the listener | `MainActivity.this` |
| Received value is `null` / 0 | key spelled differently, or wrong getter type | constants for keys; matching getter |
| `Resources$NotFoundException` on `setText` | `setText(int)` | `String.valueOf(n)` |
| `NumberFormatException` | `parseInt("")` on an empty field | check `isEmpty()` first |
| Result callback never runs | used `startActivity` instead of `launcher.launch`, or forgot `finish()` | use `launch(...)`; call `setResult` **then** `finish()` |
| `LifecycleOwner … is attempting to register while current state is RESUMED` | `registerForActivityResult` called inside a click listener | call it in `onCreate` (as a field set-up) |

---

## 3. ✍️ EXERCISES (answer key below)

1. Add a fifth activity `AboutActivity` with a TextView "Made by …". List every file you touch.
2. Make MainActivity send a **double** GPA to ProfileActivity and show it with 1 decimal place.
3. In CollegeActivity, also send back **the year of study** (an int from a second RadioGroup). Read it in MainActivity.
4. Write an implicit intent that opens the **SMS app** to 0712345678 with the text "Habari".
5. Explain the order of the 6 Logcat lines when you open SecondActivity from MainActivity.
6. What is the difference between pressing **Back** and calling `finish()`? Between Back and Up?

### Answer key
1. `res/layout/activity_about.xml` (the layout), `AboutActivity.java` (`extends AppCompatActivity`, `setContentView(R.layout.activity_about)`), `AndroidManifest.xml` (`<activity android:name=".AboutActivity" android:parentActivityName=".MainActivity" />`), and a button in MainActivity with `startActivity(new Intent(MainActivity.this, AboutActivity.class));`. Or use the wizard, which does the first three.
2. Sender: `intent.putExtra("gpa", 4.35);`. Receiver: `double gpa = getIntent().getDoubleExtra("gpa", 0.0); tv.setText("GPA: " + String.format(Locale.US, "%.1f", gpa));` (shows `4.4`, rounded).
3. CollegeActivity: `result.putExtra("year", 3);` before `setResult(RESULT_OK, result)`. MainActivity callback: `int year = data.getIntExtra("year", 0);`
4. ```java
   Intent sms = new Intent(Intent.ACTION_SENDTO, Uri.parse("smsto:0712345678"));
   sms.putExtra("sms_body", "Habari");
   openSafely(sms);
   ```
5. Main `onPause` (it loses focus) → Second `onCreate` → `onStart` → `onResume` (the new screen is ready and in front) → Main `onStop` (now fully hidden). The old screen stops last.
6. Back = the system pops the top activity, and `finish()` = your code does the same thing. Back goes to **whatever screen is under** the current one in the stack. Up goes to the **declared parent** (`parentActivityName`), even if you arrived from somewhere else.

---

## 4. 🧠 ACTIVE RECALL

- Give the 2-line code to open `HomeActivity`. What does each line do?
- What are the 3 things every activity needs? What happens if the manifest line is missing?
- What are the put/get pairs for String, int and boolean? Why do number getters need a default?
- What are the 3 classic extras bugs, and their fixes?
- What are the 3 parts of getting a result back?
- Give 4 implicit intents with their action and Uri.
- What is the lifecycle order when you go from A to B and back?

---

## 5. ONE-SCREEN SUMMARY

Activity = layout XML + Java class (`extends AppCompatActivity`, `setContentView`) + `<activity>` in the manifest · one launcher (MAIN/LAUNCHER, `exported="true"`) · **explicit:** `new Intent(MainActivity.this, X.class)` + `startActivity` · **data:** `putExtra(KEY, value)` → `getIntent().getXxxExtra(KEY, default)` with key constants and a matching type · `setText(String.valueOf(n))` · **result:** `registerForActivityResult` in `onCreate` → `launcher.launch(intent)` → child `setResult(RESULT_OK, data)` + `finish()` · **implicit:** action + Uri (`ACTION_VIEW https/geo`, `ACTION_DIAL tel:`, `ACTION_SENDTO mailto:`, `ACTION_SEND` + chooser) inside try/catch · **navigation:** back stack, `finish()`, Up = `parentActivityName` + `setDisplayHomeAsUpEnabled(true)` · lifecycle A→B: A.onPause → B.onCreate/onStart/onResume → A.onStop.
