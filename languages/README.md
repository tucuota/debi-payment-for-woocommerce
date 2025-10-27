# Translation Files

This directory contains translation files for the WooCommerce Debi plugin.

## Files

- `woocommerce-debi.pot` - Template file with all strings to translate
- `woocommerce-debi-es.po` - Spanish translation source file
- `woocommerce-debi-es.mo` - Spanish compiled translation file (used by WordPress)

## How to Add Translations

### For Translators

1. Copy `woocommerce-debi.pot` to create a new language file
2. Rename it to `woocommerce-debi-[locale].po`
   - Example: `woocommerce-debi-pt_BR.po` for Brazilian Portuguese
3. Translate all `msgstr ""` entries
4. Compile to .mo file using: `msgfmt woocommerce-debi-[locale].po -o woocommerce-debi-[locale].mo`
5. Commit both .po and .mo files

### Language Codes

Use the appropriate locale code:
- `es` - Spanish (ES)
- `es_AR` - Spanish (Argentina)
- `es_MX` - Spanish (Mexico)
- `pt_BR` - Portuguese (Brazil)
- `pt_PT` - Portuguese (Portugal)
- etc.

### Updating Translations

When new strings are added to the plugin, regenerate the .pot file and update existing .po files by running:

```bash
msgmerge -U woocommerce-debi-es.po woocommerce-debi.pot
```

Then re-translate any new `msgstr ""` entries, and recompile the .mo file.

## Current Languages

- **Spanish (es)** - ✅ Complete translation included

## Usage in WordPress

The plugin will automatically use the appropriate translation based on the WordPress locale. If Spanish is set as the site language, the Spanish translation will be used automatically.

