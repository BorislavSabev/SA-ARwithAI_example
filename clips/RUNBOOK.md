# Clip Capture Runbook

Run every command from `example-repo/`. Reset with `git checkout -- src` between
clips so the flaws persist. Record terminal with your tool of choice.

| Clip | Layer | Command | Capture |
|------|-------|---------|---------|
| 1a style-before | 1 | `composer lint` | violation report |
| 1b style-after | 1 | `php-cs-fixer fix --dry-run --diff` | fix diff |
| 2a bugs | 2 | `composer analyse` | 3 scary bugs + dead code |
| 2b level-dial | 2 | `phpstan analyse src --level 1`; `--level 5`; `--level 8` | growing findings (0 → 6 → 41) |
| 3a refactor | 3 | `composer refactor:dry` | modernization diff |
| 4a gate-fail | 4 | push branch `demo/gate-failing` | red X on PR |
| 4b gate-pass | 4 | push branch `demo/gate-passing` | green check |
| 6a ai-oracle | 6 | `phpstan analyse src --error-format=json > phpstan.json` | JSON ground truth |
| 6b verify-loop | 6 | iterate edit → `composer analyse` | shrinking error count |
| 6c ai-rector | 6 | dry-run with `WrapJsonResponseRector` registered | custom-rule diff |

After each clip: `git checkout -- src` (and `git checkout composer.json` if the
AI autoload entry was added) to restore the flawed baseline.
