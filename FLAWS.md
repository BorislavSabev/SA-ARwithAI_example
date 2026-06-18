# Intentional Flaws Inventory

Every flaw below is deliberate. Do not "fix" them outside a demo clip.

## Layer 1 — Style (PHPCS / PHP-CS-Fixer)
- `src/Core/Router.php`: mixed tabs and spaces, opening brace on same line for
  classes, `snake_case` method name (`add_route`), line over 120 chars.
- `src/Core/Container.php`: inconsistent indentation, missing method visibility.

## Layer 2 — Correctness (PHPStan)
Findings by level (verified): level 1 → 0, level 5 → 6, level 8 → 41. The level
dial is the demo: clean at 5, full strictness flood at 8.

- Scary #1 — undefined method (surfaces at level 5): `OrderService::summary()`
  calls `$customer->getEmailAdress()`; the real method is `getEmailAddress()`.
  PHPStan: `Call to an undefined method Demo\Model\Customer::getEmailAdress()`.
- Scary #2 — type mismatch (surfaces at level 5): `OrderService::totalCents()`
  declares `: int` but returns `Money::format()` which returns `string`.
  PHPStan: `totalCents() should return int but returns string`.
- Scary #3 — null dereference (surfaces at level 8): `OrderService::reprice()`
  calls `->getTotal()` on `OrderRepository::find()` which returns `?Order`,
  with no null guard. PHPStan: `Cannot call method getTotal() on Demo\Model\Order|null`.
- Dead code (surfaces at level 5): unreachable branch after `return` in
  `OrderService::status()`; unused private method `Container::legacyResolve()`;
  never-read property `Order::$id`.

Note: `OrderRepository::$orders`, `OrderService::$repository`, and `Customer`'s
properties are deliberately *typed* — without those types PHPStan infers `mixed`
and the scary bugs are silently swallowed. The remaining untyped boilerplate
(Router, Container, Money, Order) drives the level-8 "missing type" flood that
motivates the baseline/ratchet story.

## Layer 3 — Modernization targets (Rector 7.4 → 8.3)
Verified: 6 files change, ~10 rules fire. Requires `phpVersion(PHP_83)` in
`rector.php` — otherwise Rector reads `config.platform.php` (7.4) and skips every
8.x rule.

- `array()` long syntax throughout → `[]` (`LongArrayToShortArrayRector`).
- `strpos($h, $n) !== false` → `str_contains()` (`StrContainsRector`).
- `isset(...) ? ... : null` → `?? null` (`TernaryToNullCoalescingRector`).
- Constructor property promotion + `readonly` on `Customer` and `Order::$customer`
  (`ClassPropertyAssignToConstructorPromotionRector`, `ReadOnlyPropertyRector`).
  `Money` stays unpromoted (its constructor casts, so no direct assignment).
- Dead code Rector removes: `Container::legacyResolve()`, unreachable `return`,
  unused `Order::$id` (`RemoveUnusedPrivateMethodRector`,
  `RemoveUnreachableStatementRector`, `RemoveUnusedPrivatePropertyRector`).
