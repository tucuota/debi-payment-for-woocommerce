# Translation String Optimization

## Problems Addressed

### Problem 1: Installment Options
The original code created 13+ unique translation strings for installment options:
- "1 installment of $ %s ($ %s)"
- "2 installments of $ %s ($ %s)"
- "3 installments of $ %s ($ %s)"
- ... (and so on)

This was inefficient for translators, as they needed to translate essentially the same string 13+ times with only the number changing.

## Solution
Refactored the code to use reusable helper methods with singular/plural template strings:

### Implementation

1. **Created helper methods** in the `WC_debi` class:
   - `get_installment_text()` - For installments with interest
   - `get_installment_no_interest_text()` - For installments without interest

2. **Reduced to 4 template strings** (from 13+), then further optimized with helper methods

### Problem 2: Interest Rate Labels
The original code created 12 separate translation strings for admin interest rate labels:
- "% interest for 1 installment"
- "% interest for 2 installments"
- "% interest for 3 installments"
- ... (through 12)

This was even more inefficient since the strings were nearly identical.

## Solutions

### Solution 1: Installment Options

**Reduced to 4 template strings** (from 13+):
   - Singular: `"%d installment of $ %s ($ %s)"`
   - Plural: `"%d installments of $ %s ($ %s)"`
   - Singular (no interest): `"%d installment of $ %s (no interest)"`
   - Plural (no interest): `"%d installments of $ %s (no interest)"`

### Solution 2: Interest Rate Labels

**Reduced to 2 reusable templates** (from 12):
- Singular: `"% interest for %d installment"`  
- Plural: `"% interest for %d installments"`

Using WordPress's `_n()` function for automatic singular/plural selection:

```php
sprintf(_n('%% interest for %d installment', '%% interest for %d installments', $count, 'woocommerce-debi'), $count)
```

### Final Results

**Before:** 25+ unique translation strings  
**After:** 6 reusable templates  

### Benefits

✅ **Less work for translators** - Only 6 strings to translate instead of 25+  
✅ **Consistent formatting** - All installments use the same format  
✅ **Maintainability** - Changes to format only need to be made once  
✅ **Flexibility** - Supports singular/plural forms automatically  
✅ **Smaller .pot file** - Reduced from 171 lines to 76 lines (56% reduction)  

### Example Usage

**Before:**
```php
// 13 different translation strings
echo esc_html(sprintf(__('1 installment of $ %s ($ %s)', 'woocommerce-debi'), $quota, $amount));
echo esc_html(sprintf(__('2 installments of $ %s ($ %s)', 'woocommerce-debi'), $quota, $amount));
// ... 11 more times
```

**After:**
```php
// 1 reusable helper method
echo esc_html($this->get_installment_text(1, $quota, $amount));
echo esc_html($this->get_installment_text(2, $quota, $amount));
```

**Interest Rate Labels:**

**Before:**
```php
// 12 different translation strings
'title' => __('% interest for 1 installment', 'woocommerce-debi')
'title' => __('% interest for 2 installments', 'woocommerce-debi')
// ... 10 more times
```

**After:**
```php
// 1 reusable template
'title' => sprintf(_n('%% interest for %d installment', '%% interest for %d installments', $count, 'woocommerce-debi'), $count)
```

### How It Works

**Installment Text Helper:**
The helper method automatically:
1. Chooses the correct singular or plural form based on count
2. Formats the string with the installment count, quota amount, and final amount
3. Appends any extra text (like "- DEBIT CARD ONLY")

**Interest Rate Labels with _n():**
WordPress's `_n()` function automatically:
1. Chooses the correct singular or plural form based on the count parameter
2. Uses sprintf to insert the number into the translated string
3. The double `%%` in the format string becomes a single `%` in the output

### For Translators

When translating to your language, you now only need to translate these 6 strings:
1. `"%d installment of $ %s ($ %s)"` - For 1 installment
2. `"%d installments of $ %s ($ %s)"` - For 2+ installments  
3. `"%d installment of $ %s (no interest)"` - For 1 installment without interest
4. `"%d installments of $ %s (no interest)"` - For 2+ installments without interest
5. `"% interest for %d installment"` - For interest rate label (singular)
6. `"% interest for %d installments"` - For interest rate label (plural)

### Code Simplification

The code is now also simpler and uses a loop:
```php
// Before: 13 separate if statements with individual sprintf calls
for ($i = 0; $i <= 12; $i++) {
    // ... code ...
}
```

This is much more maintainable and DRY (Don't Repeat Yourself).

