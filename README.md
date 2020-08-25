# Parity

[![Build Status](http://img.shields.io/travis/icecave/parity/master.svg?style=flat-square)](https://travis-ci.org/icecave/parity)
[![Code Coverage](https://img.shields.io/codecov/c/github/icecave/parity/master.svg?style=flat-square)](https://codecov.io/github/icecave/parity)
[![Latest Version](http://img.shields.io/packagist/v/icecave/parity.svg?style=flat-square&label=semver)](https://semver.org)

**Parity** is a deep comparison library for PHP.

    composer require icecave/parity

## Rationale

PHP does not provide a way to reliably and strictly compare values of heterogeneous types. Most of the built-in
comparison operators perform often undesired [type-juggling](http://php.net/manual/en/language.types.type-juggling.php).
The one exception is the [strict equality operator](http://php.net/manual/en/language.operators.comparison.php), which
has the further caveat that it can only compare objects by their identity. No type-strict mechanism is provided for
comparing objects by their properties; nor are there any type-strict versions of the relative comparison operators
(less-than, greater-than, etc).

**Parity** aims to fill the void by providing a comparison engine with the following features:

* Type-strict comparison of arrays and objects by their elements
* Recursion-safe comparison of objects
* Natural, type-strict comparison semantics for built-in types
* Powerful mechanisms for classes to customize comparison behavior

## Example

The **Parity** comparison engine is accessed via static methods on the `Parity` facade class. These methods accept any
types and are guaranteed to produce a deterministic comparison result<sup>[1](#caveat1)</sup>. Some basic examples are
shown below using integers.

```php
use Icecave\Parity\Parity;

// The compare() method provides a strcmp-style comparison, and hence can be
// used as a sorting function for operations such as usort()
assert(Parity::compare(1, 2) < 0);

// The following methods are convenience methods, implemented on top of compare().
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

* [Restricted Comparable](src/RestrictedComparable.php): A comparable that can be queried as to which values it may be compared to.
* [Self Comparable](src/SelfComparable.php): A comparable that may only be compared to other objects of exactly the same type.
* [Sub Class Comparable](src/SubClassComparable.php): A comparable that may only be compared to other objects of the same or a derived type.
* [Any Comparable](src/AnyComparable.php): A comparable that may be freely compared to values of any other type.

### Comparator

A *[Comparator](src/Comparator/Comparator.php)* defines comparison behavior for values other
than itself. **Parity** provides the following comparator implementations:

* [Parity Comparator](src/Comparator/ParityComparator.php): Implements the logic surrounding the comparable concepts described in the section above.
* [Deep Comparator](src/Comparator/DeepComparator.php): Performs deep comparison of arrays and objects. Object comparison is recursion-safe.
* [Object Identity Comparator](src/Comparator/ObjectIdentityComparator.php): Compares objects by identity.
* [Strict PHP Comparator](src/Comparator/StrictPhpComparator.php): Approximates PHP's strict comparison for the full suite of comparison operations.
* [PHP Comparator](src/Comparator/PhpComparator.php): Exposes the standard PHP comparison behavior as a Parity comparator.

## Algorithm Resolution

The following process is used by `Parity::compare($A, $B)` to determine which comparison algorithm to use:

Use `$A->compare($B)` if:

1. `$A` is [Any Comparable](src/AnyComparable.php); or
2. `$A` is [Restricted Comparable](src/RestrictedComparable.php) and `$A->canCompare($B)` returns `true`; or
3. `$A` is [Self Comparable](src/SelfComparable.php) and `$A` is exactly the same type as `$B`; or
4. `$A` is [Sub Class Comparable](src/SubClassComparable.php) and `$B` is an instance of the class where `$A->compare()` is implemented

If none of the conditions above are true, the comparison is tried in reverse with `$A` on the right hand side and `$B`
on the left; the result is also inverted. If still no comparison is possible, **Parity** falls back to a strictly-typed
deep comparison.

When comparing scalar types, integers and doubles (PHP's only true numeric types) are treated as though they were the
same type, such that the expression `3 < 3.5 < 4` holds true. Numeric strings are **not** compared in this way.

## Caveats

1. <a name="caveat1"></a>Comparison of recursive objects is not a truly deterministic operation as objects are compared
by their [object hash](http://php.net/manual/en/function.spl-object-hash.php) where deeper comparison would otherwise
result in infinite recursion.
