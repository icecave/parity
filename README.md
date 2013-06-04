# Parity

[![Build Status]](http://travis-ci.org/IcecaveStudios/parity)
[![Test Coverage]](http://icecave.com.au/parity/artifacts/tests/coverage)

**Parity** is a deep comparison library for PHP.

The PHP language does not provide a way to reliably and strictly compare arbitrary values. The built-in comparison
operators (`==`, `<`, `>`, etc) perform (sometimes misleading) type juggling, and the strict equality operator (`===`)
can only compare objects by identity.

A third option is required to strictly compare objects by their content. **Parity** aims to fill this void by using
[reflection](http://php.net/reflection) to recurse over objects and arrays comparing their elements in a strict fashion.

* Install via [Composer](http://getcomposer.org) package [icecave/parity](https://packagist.org/packages/icecave/parity)
* Read the [API documentation](http://icecavestudios.github.io/parity/artifacts/documentation/api/)

## Example

The simplest way to use **Parity** is via the convenience methods on the `Parity` class.

```php
assert(Parity::compare(1, 2) < 0);
assert(Parity::isEqualTo(1, 2) === false);
assert(Parity::isNotEqualTo(1, 2) === true);
assert(Parity::isNotEqualTo(1, 2) === true);
assert(Parity::isLessThan(1, 2) === true);
assert(Parity::isLessThanOrEqualTo(1, 2) === true);
assert(Parity::isGreaterThan(1, 2) === false);
assert(Parity::isGreaterThanOrEqualTo(1, 2) === false);
```

Classes can use provide custom comparison semantics by implementing [ComparableInterface](lib/Icecave/Parity/ComparableInterface.php)
or [ExtendedComparableInterface](lib/Icecave/Parity/ExtendedComparableInterface.php), or by extending from [AbstractComparable](lib/Icecave/Parity/AbstractComparable.php).
[ExtendedComparableTrait](lib/Icecave/Parity/ExtendedComparableTrait.php) may be used to provide the implementation of
the extended comparison methods.

<!-- references -->
[Build Status]: https://raw.github.com/IcecaveStudios/parity/gh-pages/artifacts/images/icecave/regular/build-status.png
[Test Coverage]: https://raw.github.com/IcecaveStudios/parity/gh-pages/artifacts/images/icecave/regular/coverage.png
