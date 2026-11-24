# CP 313 — Sample Apps (study reference)

Small, complete Android apps written in **basic Java syntax**, the same style as the lecture slides:
- views declared as fields at the top of the class
- `(Button) findViewById(...)` with a cast
- `new View.OnClickListener() { ... }` anonymous classes (no lambdas `->`)
- plain `for` loops and `if / else`

Each project has its own **README.md study guide**. Read the guide, open the code beside it, then run the app and try the exercises.

| # | Project | What it teaches | Study guide |
|---|---|---|---|
| 1 | [IntentsDemo](IntentsDemo/) | Creating and adding activities · **explicit** intents · sending and receiving data (extras) · getting a result back · **implicit** intents (web, dial, map, email, share) · connecting screens (back stack, `finish()`, Up arrow) · lifecycle order in Logcat | [IntentsDemo/README.md](IntentsDemo/README.md) |
| 2 | [SoccerTickets](SoccerTickets/) | A 5-screen ticketing app: pick a match → fill a form → confirm → ticket → pick up / share. **Live updates** on screen (scores, seats, totals) · temporary in-memory storage (no database) · moving data between 5 activities | [SoccerTickets/README.md](SoccerTickets/README.md) |

**Suggested order:** IntentsDemo first (each idea on its own), then SoccerTickets (the same ideas working together in a real app).

Related notes (Google Drive → CP 313 → LECTURES → CLAUDE SUMMARIES 👅):
`CP313-Lecture-Three-Study-Walkthrough` (theory) · `CP313-Android-Layouts-and-Inputs` · `CP313-Android-Backend-Linking` (the next step after SoccerTickets: saving to a real database).

---

## How to open and run a sample

1. Android Studio → **File → Open** → select the project folder (e.g. `samples/SoccerTickets`). Open the project folder itself, not `samples/`.
2. Wait for **Gradle Sync** to finish. Both projects use the same Gradle (9.6.0) and libraries as `shiri`, so nothing new needs downloading (see `../REUSE_GRADLE_INSTRUCTIONS.txt`).
3. Pick an emulator or your phone at the top, then press **Run ▶**.

If a sync error says `sdk.dir` is missing, Android Studio creates `local.properties` for you on the first open. Just let it.

## What was checked

Both apps **build with no errors** (`./gradlew assembleDebug`, AGP 9.5, compileSdk 37, minSdk 24). They have **not been run on a phone or emulator yet**, so the first run is yours. If a screen behaves differently from its guide, note it down. That's good debugging practice.
