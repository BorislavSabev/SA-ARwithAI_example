# AI-Native Workflow Scenario

Reproducible assets for the closing act. Each pattern is captured as a clip.

## Pattern 1 — AI consumes analyzer output as ground truth
1. Produce machine-readable findings:
   `phpstan analyse src --error-format=json > phpstan.json`
2. Hand the agent `phpstan.json` plus the source and instruct: "Fix every
   reported error; do not change behaviour otherwise." The JSON is the oracle.

## Pattern 2 — The verify loop (analyzer as reward signal)
Loop until green:
1. Agent edits a file.
2. Run `composer analyse` (and `php public/index.php` smoke check).
3. Feed failures back to the agent. Repeat until exit 0.
Capture two or three iterations shrinking the error count.

## Pattern 3 — AI + Rector division of labour
- Mechanical/repeatable → Rector (see `rules/WrapJsonResponseRector.php`, a
  custom rule an agent authored from a plain-English spec).
- Judgment-heavy/novel → the agent directly.
Register the custom rule in `rector.php` to demo it:
`$rectorConfig->rule(\Demo\Rector\WrapJsonResponseRector::class);`
