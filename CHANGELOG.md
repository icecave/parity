# Parity Changelog

### 3.0.1 (2021-02-04)

Please note, as of this release this project intends to support only those
versions of PHP that are listed under the "Currently Supported Versions" section
of https://www.php.net/supported-versions.php. This means that support for older
PHP versions may be dropped in minor or patch releases.

- Drop support for PHP 7.2
- Add support for PHP 8

### 3.0.0 (2020-08-25)

This release contains several backwards compatibility breaks that will effect
more advanced usage of Parity, however the common usage via `Parity::compare()`
is unchanged.

- **[BC]** Drop support for PHP 7.1
- **[BC]** Add parameter and return type hints
- **[BC]** Remove `PackageInfo` class
- **[BC]** Rename `ComparatorInterface` to `Comparator`
- **[BC]** Rename `AnyComparableInterface` to `AnyComparable`
- **[BC]** Rename `ExtendedComparableInterface` to `ExtendedComparable`
- **[BC]** Rename `SelfComparableInterface` to `SelfComparable`
- **[BC]** Rename `SubClassComparableInterface` to `SubClassComparable`
- **[BC]** Remove `AbstractExtendedComparable` class, use `ExtendedComparableTrait` instead

### 2.0.0 (2018-11-06)

- **[BC]** Drop support for PHP 5.x and PHP 7.0
- **[NEW]** Added `Parity::min[Sequence]()`, `max[Sequence]()` (thanks [@koden-km](https://github.com/jmalloc))

### 1.0.0 (2014-01-17)

* Stable release (no API changes since 1.0.0-alpha.2).

### 1.0.0-alpha.2 (2013-10-22)

- **[BC]** `SelfComparableInterface` now requires the comparison operands to be the exactly same type.
- **[NEW]** Added `SubClassComparableInterface`, similar to the previous behavior of `SelfComparableInterface`

### 1.0.0-alpha.1 (2013-10-20)

- **[BC]** Removed `deep` parameter from `Parity::compare()` and related convenience methods
- **[BC]** Removed `ComparableInterface` and `Comparator`
- **[BC]** Removed `AbstractComparable` (replaced with `AbstractExtendedComparable` which does not implement any comparable interface)
- **[NEW]** Added `AnyComparableInterface` and `SelfComparableInterface`
- **[NEW]** Added `ComparatorInterface::__invoke()`
- **[NEW]** Added `ObjectIdentityComparator`, `StrictPhpComparator` and `PhpComparator`
- **[NEW]** Added `ParityComparator` which compares numeric types in a more natural manner
- **[IMPROVED]** Comparators are now use other comparators to handle unsupported comparisons (composition rather than extension)
- **[IMPROVED]** Deep comparison no longer compares arrays by size first, allows for more natural ordering based on elements

### 0.1.0 (2013-05-29)

- Initial release
