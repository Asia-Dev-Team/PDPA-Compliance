# Freepass PDPA Compliance

WordPress plugin that shows a cookie consent banner for PDPA (Thailand Personal Data Protection Act) on every page of the site. Visitors accept or decline; the choice is remembered in the browser.

## What it does

- Shows a banner at the bottom of the page with a consent message, a Privacy Policy link, and **Accept** / **Decline** buttons.
- Saves the visitor's choice in the browser's `localStorage` under the key `freepasspdpa_consent` with the value `accepted` or `declined`.
- Does not show the banner again once a choice is saved in that browser.
- Lets an administrator change all banner texts and the Privacy Policy link.

## Requirements

- WordPress with administrator access (`manage_options`).
- No server extensions or external services.

## Installation

1. Copy the plugin folder to `wp-content/plugins/`.
2. Activate **Freepass PDPA Compliance** in **Plugins**.
3. Open **Settings → Freepass PDPA** and set the texts.

## Settings

All settings are stored in one option, `freepasspdpa_options`.

| Setting | Meaning | Default |
|---|---|---|
| Consent Message | Main banner text | "We use cookies to improve your experience on our site. By clicking "Accept", you agree to our Privacy Policy." |
| Accept Button Text | Accept button label | Accept |
| Decline Button Text | Decline button label | Decline |
| Privacy Policy URL | Link target | `/privacy-policy` |
| Privacy Policy Text | Link label | Privacy Policy |

Default texts are translatable through the `freepasspdpa` text domain.

## Project structure

```
freepassPDPA.php        Plugin bootstrap: enqueue assets, pass settings to JS, settings page
js/freepasspdpa.js      Builds the banner and stores the visitor's choice
css/freepasspdpa.css    Banner styles
```

## Known limitations

- The plugin records the visitor's choice only. It does not block or remove cookies or third-party scripts when the visitor declines; other code must read `freepasspdpa_consent` to act on it.
- The choice is per browser: clearing site data or using another browser shows the banner again.
- Banner texts from the settings are inserted into the page as HTML without escaping.

## License

GPL-2.0+
