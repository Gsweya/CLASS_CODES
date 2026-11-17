# CLASS_CODES

My university coursework, organised by **year → semester → course**.
Each course folder holds the lab work, assignments, class sessions and practice code for that course.

## Repository layout

```
CLASS_CODES/
├── .gitignore                  # global ignores (build output, IDE files, archives, binaries)
├── README.md                   # you are here
├── second_year_code/
│   ├── semester_one/           # CN 211, CP 211, CP 213, CP 215, CS 215
│   └── semester_two/           # CP 221, CP 222, CP 224, CP 226, CG 222 (see the second_yr/sem_two branch)
└── third_year_code/
    ├── .gitignore              # Android / Gradle / PHP ignores for this year
    ├── README.md               # course index for third year
    └── semester_one/
        ├── CP 311 - Internet Programming and Applications II/
        └── CP 313 - Mobile Application Development/
```

See [`third_year_code/README.md`](third_year_code/README.md) for the current year's courses and how to run each project.

## Branches

Work for each semester lives on its own branch and is merged into `main` through a pull request when the semester is done.

| Branch                 | Contents                                    |
|------------------------|---------------------------------------------|
| `main`                 | Stable, merged work from finished semesters |
| `second_yr/sem_two`    | Second year, semester two                   |
| `third_year/sem_one`   | Third year, semester one (current)          |

Typical workflow:

```bash
git checkout third_year/sem_one     # work on the current semester
git pull                            # get the latest changes
# ... add / change files ...
git add "third_year_code/semester_one/<course folder>"
git commit -m "CP 313: <what you did>"
git push
```

## Naming conventions

- Year folders: `<ordinal>_year_code` (e.g. `third_year_code`).
- Semester folders: `semester_one`, `semester_two`.
- Course folders: `<COURSE CODE> - <Course Name>` (e.g. `CP 313 - Mobile Application Development`).
- Inside a course: one folder per assignment, lab or project, with its own `README.md` when it needs setup steps.

## What is not committed

The `.gitignore` files keep generated and machine-specific files out of the repo:

- Build output: `build/`, `dist/`, `.gradle/`, `*.class`, `*.exe`, `*.apk`, `*.aab`
- IDE and editor folders: `.idea/`, `.vscode/`, `*.iml`
- Local config and secrets: `local.properties`, `.env*`, `*.keystore`, `*.jks`, `google-services.json`
- Archives and installers: `*.zip`, `*.tar.gz`, `*.rpm`
- Dependency folders: `node_modules/`, `vendor/`

If a folder like `build/` shows up in `git status`, check the ignore rules rather than committing it.
