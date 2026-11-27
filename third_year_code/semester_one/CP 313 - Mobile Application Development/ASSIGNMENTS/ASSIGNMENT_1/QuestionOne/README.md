# QuestionOne (CP 313, Assignment 1)

A two-screen Android app in Java:

- **MainActivity** has a button that opens **SecondActivity** with an explicit `Intent`.
- **SecondActivity** has a Back button that calls `finish()` to return to the first screen.

Source: `app/src/main/java/com/example/questionone/`. Layouts: `app/src/main/res/layout/`.

## Opening it on another PC

1. In Android Studio, go to **File → Open** and select this `QuestionOne` folder (the one that contains `settings.gradle.kts`).
2. Wait for Gradle Sync to finish. The first sync needs internet. It downloads Gradle 9.6.0, the Android libraries and, if the PC doesn't have it yet, JDK 25 for the Gradle daemon.
3. Android Studio creates `local.properties` (the SDK location) on its own. If it asks for the SDK, install **Android SDK Platform 37** from the SDK Manager.
4. Choose an emulator or a phone and press **Run ▶**.

From a terminal: `./gradlew assembleDebug` (Linux/macOS) or `gradlew.bat assembleDebug` (Windows). Set `ANDROID_HOME` to the SDK path first if there is no `local.properties`.

## Requirements

- Android Studio with Android SDK 37 installed
- minSdk 26 (Android 8.0 or newer)
- AGP 9.5.3, Gradle 9.6.0 (from the included wrapper)
