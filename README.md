# Parity

[![Build Status]](https://travis-ci.org/IcecaveStudios/parity)
[![Test Coverage]](https://coveralls.io/r/IcecaveStudios/parity?branch=develop)
[![SemVer]](http://semver.org)

**Parity** is a deep comparison library for PHP.

The PHP language does not provide a way to reliably and strictly compare arbitrary values. The built-in comparison
operators perform often undesired type juggling, and the strict equality operator (`===`) can only compare objects by
identity.

A third option is required to strictly compare objects by their content. **Parity** aims to fill this void by using
[reflection](http://php.net/reflection) to recurse over objects and arrays comparing their elements in a strict fashion.

**Parity** also provides for classes to provide their own comparison implementations.

* Install via [Composer](http://getcomposer.org) package [icecave/parity](https://packagist.org/packages/icecave/parity)
* Read the [API documentation](http://icecavestudios.github.io/parity/artifacts/documentation/api/)

## Example

The **Parity** comparison engine is used via static methods on the `Parity` facade class. These methods accept any types
and are guaranteed to produce a deterministic comparison result. Some basic examples are shown below using integers.

```php
use Icecave\Parity\Parity;

assert(Parity::compare(1, 2) < 0);
assert(Parity::isEqualTo(1, 2) === false);
assert(Parity::isNotEqualTo(1, 2) === true);
assert(Parity::isNotEqualTo(1, 2) === true);
assert(Parity::isLessThan(1, 2) === true);
assert(Parity::isLessThanOrEqualTo(1, 2) === true);
assert(Parity::isGreaterThan(1, 2) === false);
assert(Parity::isGreaterThanOrEqualTo(1, 2) === false);
```

## Concepts

### Comparable

The core concept of **Parity** is the *comparable*. A comparable is any object that provides its own behavior for
comparison with other values. The following refinements of the comparable concept are supported by the comparison engine:

* [Restricted Comparable](src/Icecave/Parity/RestrictedComparableInterface.php): A comparable that can be queried as to which values it may be compared to.
* [Self Comparable](src/Icecave/Parity/SelfComparableInterface.php): A comparable that may only be compared to other objects of the same type.
* [Any Comparable](src/Icecave/Parity/AnyComparableInterface.php): A comparable that may be freely compared to values of any other type.

### Comparator

A *[Comparator](src/Icecave/Parity/Comparator/ComparatorInterface.php)* defines comparison behavior for values other
than itself. **Parity** provides the following comparator implementations:

* [Parity Comparator](src/Icecave/Parity/Comparator/ParityComparator.php): Implements the logic surrounding comparables mentioned in the section above.
* [Deep Comparator](src/Icecave/Parity/Comparator/DeepComparator.php): Performs deep comparison of arrays and objects. Object comparison is recursion-safe.
* [Strict PHP Comparator](src/Icecave/Parity/Comparator/StrictPhpComparator.php): Approximates PHP's strict comparison for the full suite of comparison operations.
* [PHP Comparator](src/Icecave/Parity/Comparator/PhpComparator.php): Exposes the standard PHP comparison behavior as a Parity comparator.

## Algorithm Resolution

The following process is used by `Parity::compare($A, $B)` to determine which comparison algorithm to use:

1. If `$A` is [Any Comparable](src/Icecave/Parity/AnyComparableInterface.php), use `$A->compare($B)`
2. If `$A` is [Restricted Comparable](src/Icecave/Parity/RestrictedComparableInterface.php) and `$A->canCompare($B)`, use `$A->compare($B)`
3. If `$A` is [Self Comparable](src/Icecave/Parity/SelfComparableInterface.php) and `$A->compare(...)` is implemented in `gettype($B)`, use `$A->compare($B)`

If none of the conditions above are true, the comparison is tried in reverse with $A on the right hand side and $B on
the left; the result is also inverted. If still no comparison is possible, **Parity** falls back to a strictly-typed
deep comparison.

When comparing scalar types, integers and doubles (PHP's only true numeric types) are treated as though they were the
same type, such that the expression `3 < 3.5 < 4` holds true. Numeric strings are **not** compared in this way.

<!-- references -->
[Build Status]: https://travis-ci.org/IcecaveStudios/parity.png?branch=develop
[Test Coverage]: https://coveralls.io/repos/IcecaveStudios/parity/badge.png?branch=develop
[SemVer]: http://calm-shore-6115.herokuapp.com/?label=semver&value=0.1.0&color=yellow
