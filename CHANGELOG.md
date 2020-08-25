# Parity Changelog

### 3.0.0 (2020-08-25)

- **[BC]** Bump minimum PHP version to 7.2

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
