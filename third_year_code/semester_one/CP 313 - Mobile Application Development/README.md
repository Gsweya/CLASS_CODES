# CP 313 – Mobile Application Development

Android work for CP 313. Each subfolder is a separate Android Studio project.

| Project | Description | Language |
|---------|-------------|----------|
| [`shiri/`](shiri/README.md) | Student registration form: first/last/second name, gender and course selection | Java |

## Working with these projects

- Open each **project folder** (for example `shiri/`) in Android Studio, not this course folder. Android Studio needs the folder that contains `settings.gradle.kts`.
- New projects go in their own subfolder next to `shiri/`. Use the Android Studio *New Project* wizard and save it inside this course folder.
- Commit the Gradle wrapper (`gradlew`, `gradlew.bat`, `gradle/wrapper/`) so the project builds on any machine.
- Do not commit `build/`, `.gradle/`, `.idea/` or `local.properties`. The `.gitignore` files already exclude them.
