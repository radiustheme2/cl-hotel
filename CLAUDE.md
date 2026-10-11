# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

**CL Hotel** — a RadiusTheme WordPress theme (text domain `cl-hotel`) for hotel directory sites, built on top of the
**Classified Listing** plugin family (`classified-listing`, `-pro`, `-store`, `rtcl-booking`, `rtcl-agent`) plus
`cl-hotel-core` (theme companion plugin: Elementor widgets, CPT extras) and `review-schema`. The theme version lives
only in the `Version:` header of `style.css` (read at runtime by `inc/Constants.php`).

There is no build step, linter or test suite. CSS/JS are edited by hand.

## Commands

- `npm run zip` — packages the theme into `dist/<folder-name>.<style.css Version>.zip` (runs `scripts/zip.js`, which
  calls the system `zip` from the parent directory; excludes `.git`, `scripts/`, `dist/`, `package.json`, `CLAUDE.md`).
- Syntax-check a PHP file: `php -l path/to/file.php`.

## Architecture

**Bootstrap:** `functions.php` (`CLR_Hotel_Main`) → loads `lib/` (TGM plugin activation, license updater — skipped when
`RT_DEBUG` is true) → `inc/init.php`, which requires the committed Composer autoloader (`vendor/`, PSR-4
`RadiusTheme\CLHotel\` → `inc/`) and instantiates the singletons: `Constants`, `TGM_Config`, `Options`, `General`,
`Scripts`, `Layouts`, Customizer `Init`. `Listing_Functions` and `Shortcode` load **only when `class_exists('Rtcl')`**.
New classes in `inc/` are autoloaded by namespace — no registration needed.

**Settings flow:** Customizer sections live in `inc/Customizer/Settings/*.php`; every setting's default must be added to
`inc/Customizer/Default_Data.php`, because `Options::set_options()` builds `Options::$options` by iterating those
defaults through `get_theme_mod()`. Templates read `Options::$options['key']`. `Layouts` computes per-request static
values (`Options::$layout`, `$sidebar`, `$has_banner`, …) from customizer values and post meta. Typography options are
JSON strings (`json_decode(Options::$options['typo_*'], true)`), consumed in `Scripts::fonts_url()` and
`dynamic-styles/*.php`, which output inline CSS on the `cl-hotel-dynamic` handle.

**Classified Listing integration:** `inc/Listing_Functions.php` is the main place where the theme hooks into `rtcl_*`
actions/filters (loop item markup, store/agent tweaks, display options, category color meta, etc.). The plugins load
theme overrides from these folders, mirroring each plugin's own `templates/` path:
- `classified-listing/` — overrides for Classified Listing and its add-ons (`store/`, `booking/`, `agent/`, `claim/`,
  `marketplace/`, `elementor/` — overrides of the Classified Listing Elementor widget views). `classified-listing/custom/` and
  `classified-listing/store/custom/` are theme-only partials loaded via `Helper::get_custom_listing_template()` /
  `get_custom_store_template()`.
- `review-schema/` — overrides for the Review Schema plugin.

When changing an override, compare against the current plugin template version it copies, and guard calls into
plugin code (`class_exists`, `function_exists`, e.g. `rtclPro()` is only present with Pro).

**Theme templates:** standard WP files at root, partials in `template-parts/`, loaded with
`Helper::get_template_part($path, $args)` (child-theme aware; `$args` are `extract()`ed into the partial).

**Assets:** resolved via `Helper::get_css/get_js/get_vendor_css/get_vendor_js/get_img`. The frontend loads the
**unminified** files in `assets/css/` and `assets/js/` (`assets/*/minified/` is not what `get_css()`/`get_js()` serve).
`main.css` is loaded through `Helper::get_maybe_rtl_css()`, so **`assets/rtl-css/main.css` is a separate, hand-maintained
copy — mirror LTR style changes there**. Asset version is `time()` when `WP_DEBUG` is on, otherwise the theme version.

**Bundled plugins:** `inc/TGM_Config.php` lists required/recommended plugins; premium ones are installed from zips in
`plugin-bundle/` whose filenames are hard-coded in the `source` entries — update both together when bumping a bundled
plugin. `functions.php::plugin_update_notices()` holds the minimum `CL_HOTEL_CORE` version.

**Companion plugin — CL Hotel Core:** separate repo at `../cl-hotel-core/` (entry `cl-hotel-core.php`, text domain
`cl-hotel-core`, often on a different branch than the theme). It defines `CL_HOTEL_CORE` (version, checked by the
theme's update notice) and `CL_HOTEL_CORE_*` path constants; on `after_setup_theme` (priority 15) it loads CPTs/post
meta/widgets (only if `RT_FRAMEWORK_VERSION` is defined) and the Elementor widgets in `elementor/<widget>/view-*.php`
(only if `class_exists('CLR_Hotel_Main')` and Elementor is loaded). It also provides the demo importer, demo users,
social share (`rdtheme_social_share` action) and its own `assets/css/hotel-core.css` / `assets/js/hotel-core.js`.
Coupling is two-way: core calls theme classes directly (`RadiusTheme\CLHotel\Helper::get_css()`,
`reading_time_count()`, `time_elapsed_string()`, `Listing_Functions`), so renaming/removing public theme helpers
breaks the plugin; new theme code that relies on core must guard with `defined('CL_HOTEL_CORE')` / `class_exists()`.

**i18n / multilingual:** all strings use the `cl-hotel` text domain; translations in `languages/` (`cl-hotel.pot`,
`.po/.mo/.l10n.php`). `wpml-config.xml` declares translatable theme mods.

## Conventions

- Files use CRLF line endings in many places; preserve the existing endings of a file you edit.
- `readme.txt` is the theme changelog location.
