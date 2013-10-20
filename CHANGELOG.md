# Parity Changelog

### 1.0.0-alpha.1 (2013-10-20)

* **[BC]** Removed `deep` parameter from `Parity::compare()` and related convenience methods
* **[BC]** Removed `ComparableInterface` and `Comparator`
* **[BC]** Removed `AbstractComparable` (replaced with `AbstractExtendedComparable` which does not implement any comparable interface)
* **[NEW]** Added `AnyComparableInterface` and `SelfComparableInterface`
* **[NEW]** Added `ComparatorInterface::__invoke()`
* **[NEW]** Added `StrictPhpComparator` and `PhpComparator`
* **[NEW]** Added `ParityComparator` which compares numeric types in a more natural manner
* **[IMPROVED]** Comparators are now use other comparators to handle unsupported comparisons (composition rather than extension)

### 0.1.0 (2013-05-29)

* Initial release
