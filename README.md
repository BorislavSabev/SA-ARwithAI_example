# Order Processing — Static Analysis Demo Repo

**This is a teaching artifact, not production code.** Every file contains
*intentional, documented flaws* (see `FLAWS.md`) so that PHPCS, PHPStan, and
Rector each produce a visibly satisfying before/after when run against it.

It backs a talk on static analysis & automated refactoring in the era of
AI-assisted coding. Target source version is PHP 7.4; the Rector demo upgrades
it to PHP 8.3.

## Run the pipeline

```bash
composer install
composer lint          # PHPCS — style violations
composer analyse       # PHPStan — real bugs
composer refactor:dry  # Rector — modernization diff (no writes)
```

Check out the workflow example in `.github/`.

## Presentation deck
See `docs/` for the presentation and demo clips.

## Want to learn more?
Want to learn more about deterministic guardrails for AI-assisted development workflows? [Follow me](https://github.com/BorislavSabev) and let's connect!

Have a problem you'd want to resolve? [DM me](https://www.linkedin.com/in/borkata/), I love helping out.
