# Clip Capture Runbook

Run every command from the repo root. Reset with `git checkout -- src` between
clips so the flaws persist. Record terminal with your tool of choice.

| Clip                 | Layer  | Command                                                   | Capture                                                        |
|----------------------|--------|-----------------------------------------------------------|----------------------------------------------------------------|
| 1a style-before      | 1      | `composer lint`                                           | violation report                                               |
| 1b style-after       | 1      | `php-cs-fixer fix --dry-run --diff`                       | fix diff                                                       |
| 2a bugs              | 2      | `composer analyse`                                        | 3 scary bugs + dead code                                       |
| 2b level-dial        | 2      | `phpstan analyse src --level 1`; `--level 5`; `--level 8` | growing findings (0 → 6 → 41)                                  |
| 2c tests-green       | 2      | `composer test`                                           | 6 green tests on the flawed baseline (tests ≠ static analysis) |
| 3a refactor          | 3      | `composer refactor:dry`                                   | modernization diff                                             |
| 3b tests-still-green | 3      | `composer test` on `gate-passing`                         | same tests green after Rector (behavior preserved)             |
| 4a gate-fail         | 4      | branch `gate-failing` → PR to `main` (CI already live)    | red X on PR                                                    |
| 4b gate-pass         | 4      | branch `gate-passing` (CI already live)                   | green check                                                    |
| 6a ai-oracle         | 6      | `phpstan analyse src --error-format=json > phpstan.json`  | JSON ground truth                                              |
| 6b verify-loop       | 6      | iterate edit → `composer analyse`                         | shrinking error count                                          |
| 6c ai-rector         | 6      | dry-run with `WrapJsonResponseRector` registered          | custom-rule diff                                               |

For clips 4a/4b you can screenshot the existing runs (`main` = red, `gate-passing`
= green, `gate-failing` PR = red) instead of re-pushing — CI is already live on
`github.com/BorislavSabev/SA-ARwithAI_example`.

After each clip: `git checkout -- src` (and `git checkout composer.json` if the
AI autoload entry was added) to restore the flawed baseline.
