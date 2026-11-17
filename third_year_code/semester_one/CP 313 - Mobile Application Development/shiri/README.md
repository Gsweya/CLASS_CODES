# shiri: Student Registration Form (Android)

**Course:** CP 313 – Mobile Application Development
**Language:** Java
**Package:** `com.example.shiri`

A single-screen Android app that shows a student registration form:

- Title: *Welcome to Android*
- Text fields: First Name, Last Name, Second Name
- Gender: Male / Female radio buttons
- Courses: CP 313, IA 313, EME 314, BT 314 checkboxes
- Submit button

The layout uses a `RelativeLayout` (`app/src/main/res/layout/activity_main.xml`). `MainActivity` enables edge-to-edge display and pads the root view for the system bars.

## Requirements

| Tool | Version used |
|------|--------------|
| Android Studio | Recent release that supports AGP 9.5 |
| Android Gradle Plugin | 9.5.1 (`gradle/libs.versions.toml`) |
| Gradle | 9.6.0 (downloaded automatically by the wrapper) |
| JDK for the Gradle daemon | 25 (`gradle/gradle-daemon-jvm.properties`, auto-provisioned via Foojay) |
| Java source/target | 11 |
| compileSdk / targetSdk | 37 |
| minSdk | 24 (Android 7.0) |

Dependencies: AppCompat, Material Components, ConstraintLayout, Activity KTX. Tests use JUnit 4, AndroidX Test and Espresso.

## Opening the project

1. Clone the repo and check out the semester branch:
   ```bash
   git clone https://github.com/Gsweya/CLASS_CODES.git
   cd CLASS_CODES
   git checkout third_year/sem_one
   ```
2. In Android Studio choose **File → Open** and select this `shiri/` folder (the one containing `settings.gradle.kts`).
3. Let Gradle sync. Android Studio creates `local.properties` with your SDK path. That file is machine-specific and is git-ignored.
4. If the sync asks for missing SDK platforms (API 37), install them from **SDK Manager**.

## Building and running

From Android Studio: pick an emulator or a connected device and press **Run ▶**.

From the terminal (inside `shiri/`):

```bash
./gradlew assembleDebug          # build the debug APK
./gradlew installDebug           # install on a connected device / running emulator
./gradlew test                   # local unit tests
./gradlew connectedAndroidTest   # instrumented tests (needs a device/emulator)
./gradlew clean                  # remove build output
```

On Windows use `gradlew.bat` instead of `./gradlew`.

The debug APK is written to `app/build/outputs/apk/debug/app-debug.apk`. It is a build output and is not committed.

If the terminal build cannot find the SDK, create `local.properties` in this folder:

```properties
sdk.dir=/path/to/Android/Sdk
```

## Project structure

```
shiri/
├── settings.gradle.kts          # project name + included modules (:app)
├── build.gradle.kts             # top-level build file
├── gradle.properties            # Gradle JVM args, configuration cache
├── gradle/
│   ├── libs.versions.toml       # version catalog (AGP + library versions)
│   ├── gradle-daemon-jvm.properties
│   └── wrapper/                 # Gradle wrapper (committed on purpose)
├── gradlew, gradlew.bat
└── app/
    ├── build.gradle.kts         # SDK levels, dependencies
    └── src/
        ├── main/
        │   ├── AndroidManifest.xml
        │   ├── java/com/example/shiri/MainActivity.java
        │   └── res/
        │       ├── layout/activity_main.xml   # the registration form
        │       ├── values/strings.xml         # form labels
        │       ├── values/colors.xml
        │       └── values/themes.xml
        ├── test/                # local unit tests
        └── androidTest/         # instrumented tests
```

## Not committed

`build/`, `app/build/`, `.gradle/`, `.idea/`, `*.iml`, `local.properties`, APK/AAB files and signing keys (`*.jks`, `*.keystore`).
