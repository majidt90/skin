# Aura: a minimal, fast, fully editable WooCommerce block theme

Aura is a **Full Site Editing (block) theme** for WordPress and WooCommerce. It is built for
speed and for editing in the Site Editor. Every template, header, footer, product page,
shop layout, color, font size, spacing value and button can be changed without touching code.

- **Speed first:** no jQuery, no animation libraries, one ~1.7 KB script, critical CSS inlined,
  non-critical CSS loaded without blocking render, scripts deferred, unneeded WordPress output removed.
- **Typography:** Vazirmatn (Persian and Latin), loaded from jsDelivr with `preconnect` and
  `font-display: swap`. A system-font fallback is always in the font stack.
- **RTL and Persian ready:** logical CSS properties throughout, so the layout mirrors correctly
  when WordPress runs in an RTL language.
- **Accessible:** semantic landmarks, the native skip link, visible focus styles, labelled
  navigation, and full support for `prefers-reduced-motion`.
- **English admin:** every Customizer and admin string is in English. Frontend strings are translatable (text domain `aura`).

---

## Contents

```
aura/
├── style.css              Theme header (no styles here by design)
├── theme.json             Design tokens: palette, fonts, spacing, radius, shadows, motion, buttons, inputs
├── functions.php          Setup, WooCommerce support, asset loading, includes (kept small)
├── inc/
│   ├── customizer.php     Aura Theme Options panel + bridge into theme.json
│   ├── performance.php    Bloat removal, critical CSS, non-blocking CSS, resource hints, lazy-load toggle
│   └── woocommerce.php    Product grid defaults, header item toggles, [aura_copyright] shortcode
├── templates/             15 block templates (see list below)
├── parts/
│   ├── header.html        Sticky glass header: logo, navigation, product search, account, mini cart
│   ├── footer.html        Footer columns, navigation, copyright
│   └── mini-cart.html     WooCommerce mini cart (used in the header)
├── patterns/              6 section patterns (Aura Sections category)
└── assets/
    ├── css/critical.css   Inlined in <head>
    ├── css/aura.css       Non-critical styles (loaded without blocking render)
    ├── css/editor.css     Site Editor canvas tweaks
    └── js/aura.js         Header shadow on scroll + scroll reveal (deferred, no dependencies)
```

### Templates

| Template | Used for |
|---|---|
| `index.html` | Fallback for everything else |
| `front-page.html` | Store homepage (built from patterns) |
| `home.html` | Blog index (Settings > Reading > Posts page) |
| `single.html` / `page.html` | Blog posts / pages |
| `archive.html` / `search.html` / `404.html` | Blog archives, search results, not-found page |
| `single-product.html` | Product page (gallery, summary, add to cart, details, related products) |
| `archive-product.html` | Shop page (toolbar, optional category sidebar, product grid) |
| `taxonomy-product_cat.html` / `taxonomy-product_tag.html` | Category and tag archives |
| `page-cart.html` / `page-checkout.html` | WooCommerce Cart and Checkout (Cart and Checkout blocks) |
| `page-my-account.html` | Any page with the slug `my-account` (WooCommerce account shortcode) |

---

## Install

1. Copy the `aura` folder into `wp-content/themes/` (or zip it and upload it under **Appearance > Themes > Add New**).
2. Activate **Aura**.
3. Install and activate **WooCommerce** (optional, but everything in the shop is designed for it).
4. Set up pages:
   - **Settings > Reading:** set *Homepage* to a static page called **Home** (or leave the default and use the front-page template).
   - Set *Posts page* to a page called **Journal** (optional, for `home.html`).
   - WooCommerce creates **Shop**, **Cart**, **Checkout** and **My account** automatically. Aura's templates depend on their default slugs (`shop`, `cart`, `checkout`, `my-account`). Aura's header and footer links also use these slugs.
5. Set permalinks to **Post name** (**Settings > Permalinks**).

---

## Editing everything in the Site Editor

Go to **Appearance > Editor** (the Site Editor). You can change the following without code.

### Templates and template parts
- **Templates:** every file in the table above is editable. Select the template in the list and edit it visually. For example, change the shop toolbar, add a banner above the product grid, or remove the sidebar.
- **Header** (`parts/header.html`): logo (*Site Logo* block), site title, navigation (*Navigation* block), product search, account icon and mini cart. Drag, add or remove any block. Change the header layout by editing the *Group* settings (flex direction, justification, spacing).
- **Footer** (`parts/footer.html`): columns, link lists, the copyright text (the `[aura_copyright]` shortcode block reads the Customizer value), and the bottom bar.
- **Mini cart** (`parts/mini-cart.html`): the WooCommerce *Mini Cart* block, shown in the header.

### Navigation
Select the *Navigation* block in the header or footer and edit the links, or create a menu under **Navigation** in the Site Editor. The overlay menu on small screens is automatic.

### Patterns (sections)
Insert these from the block inserter under the **Aura Sections** category, or edit them in a template:

| Pattern | Contents |
|---|---|
| Hero - Split | Eyebrow, headline, lead text, two buttons, gradient visual (replace with an image) |
| Featured Products Grid | Product Collection block, 4 columns, latest products, "View all" button |
| Shop by Category | Product category list with counts |
| Features - Three Columns | Three feature cards |
| Testimonials | Three customer quotes |
| Call to Action - Banner | Colored banner with heading, text and a button |

### Product grid (Product Collection)
Product grids are real *Product Collection* blocks, so you can change everything about them:
- **Query:** source, number per page, ordering, filters, hand-picked products.
- **Layout:** the number of columns is set in the block's *Layout* panel. If you do not set it, the Customizer's *Products per row* value is used.
- **Product card:** the *Product Template* inside the block controls what each card shows (image, sale badge, title, price, button) and their order. Remove or reorder blocks to change the card design.

### Global Styles (colors, typography, spacing, buttons)
Open the **Styles** panel (the half-circle icon, top right in the Site Editor):
- **Colors:** the palette, text, background, links and headings. Custom colors are allowed.
- **Typography:** the font family (Vazirmatn or System UI), body size, line height and per-heading sizes.
- **Spacing:** block gap and the page padding.
- **Blocks:** styles for every block, such as buttons, images, search, navigation and quotes.
- **Elements:** site-wide styles for links, headings and buttons, including their hover states.

> **Note:** Changes made in **Styles** are saved to the site (as Global Styles) and override the
> theme defaults. Use **Styles > Reset** on any block or element to return to the Aura defaults.

---

## Customizer: Aura Theme Options

Go to **Appearance > Customize** and open the **Aura Theme Options** panel. The Site Editor (Appearance > Editor) edits templates, styles and blocks; these global switches live in the Customizer.

| Section | Option | What it does |
|---|---|---|
| Colors | Primary, Text, Background, Surface, Border | Updates the matching palette slot. Buttons, links and accents follow. |
| Typography | Base font size (px) | Sets the body text size (14 to 22 px). |
| Typography | Load Vazirmatn from the jsDelivr CDN | Off = system font stack only (no external request). |
| Layout | Content width | Width of normal content (560 to 960 px). |
| Layout | Wide container width | Width of wide blocks (960 to 1440 px). |
| Layout | Corner radius | Base radius for cards, images and inputs. Buttons and search are pill-shaped. |
| Header | Sticky header | Keeps the glass header at the top while scrolling. |
| Header | Show product search / Show cart icon | Shows or hides those items in the header. |
| Footer | Copyright text | Use `{year}` for the current year. |
| WooCommerce | Products per row | Default number of columns for shop and category grids (2 to 5). |
| WooCommerce | Show category sidebar on shop pages | Shows the category list on the left of the shop. |
| Performance | Disable animations | Turns off scroll reveal, hover motion and transitions. |
| Performance | Lazy-load images | Uses native lazy loading for images. |

Colors, the base font size, the radius and the content widths are written into theme.json at runtime, so the
Customizer's values are used everywhere, including the Site Editor.

---

## Animations

Aura's motion is subtle and CSS-first.

- **Scroll reveal:** add the CSS class `aura-reveal` to any block (**Block > Advanced > Additional CSS class**). The block fades and rises in when it scrolls into view. Patterns already use it.
- **Cards:** add the class `aura-card` to a group or column for a bordered surface that lifts slightly on hover.
- **Product cards:** images zoom slightly and titles change color on hover. This is automatic.
- **Navigation:** links get an underline that draws in on hover and focus.
- **Reduced motion:** when a visitor has *reduce motion* enabled, all of this is turned off.

Do not remove the classes `aura-header-search`, `aura-header-cart` and `aura-shop-sidebar`. The Customizer toggles depend on them.

---

## Fonts

Aura loads the Vazirmatn stylesheet from jsDelivr, pinned to release `v33.003`:

```
https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css
```

- A `preconnect` hint to `cdn.jsdelivr.net` is added in `<head>`.
- Fonts use `font-display: swap`, so text is never hidden while loading.
- **Local fallback:** turn off *Load Vazirmatn from the jsDelivr CDN* in the Customizer. The system font stack is used with no external request.
- **Self-hosting:** to serve the font yourself, copy the Vazirmatn files to your host and filter the URL:

  ```php
  add_filter( 'aura_font_css_url', fn() => 'https://example.com/fonts/Vazirmatn-font-face.css' );
  ```

---

## Performance

- **Critical CSS** (`assets/css/critical.css`, about 1 KB) is inlined in `<head>`, so the header and base layout render at once.
- **Non-critical CSS** (`assets/css/aura.css`) loads with `rel="preload"` and switches to a stylesheet on load (with a `<noscript>` fallback).
- **JavaScript:** `aura.js` is about 1.7 KB, has no dependencies, and is loaded with `defer`. With *Disable animations* on, the scroll-reveal code is skipped and only the small header-shadow handler runs.
- **Removed output:** the RSD and WLW links, the generator tag, shortlinks, oEmbed discovery, emoji scripts, the `wp-embed` script, and Dashicons for logged-out visitors.
- **Images:** native lazy loading (togglable in the Customizer).
- **Design tokens:** colors, spacing, radius, motion and shadows are CSS custom properties generated from theme.json, so there is no duplicated CSS.

---

## Accessibility and RTL

- Native skip link to `#content` (provided by WordPress for block themes).
- Landmarks: `<header>`, `<main id="content">`, `<footer>`. The navigation, footer link lists and search have accessible labels.
- Visible `:focus-visible` outline on all interactive elements.
- Default text and primary colors are chosen for strong contrast (for example, primary `#4338CA` on white is about 7.9:1).
- **RTL:** WordPress sets `dir="rtl"` for Persian sites automatically. Aura uses logical properties (`inset-inline`, `padding-inline`, `margin-block`) and `:dir(rtl)` rules for the navigation underline.

---

## WooCommerce notes

- **Cart and Checkout:** templates `page-cart.html` and `page-checkout.html` contain the official Cart and Checkout blocks. Edit the notices, the page title and the layout in the Site Editor.
- **My account:** `page-my-account.html` shows the page content, which is the WooCommerce account shortcode. Styled navigation pills and buttons are included.
- **Shop sidebar:** when the Customizer switch is on, the sidebar (`aura-shop-sidebar`) shows the product category list. Add any other block to the sidebar in the Site Editor.
- **Products per row:** see *Product grid* above.

---

## Limitations and notes

- Customizer colors go into the theme palette. If you change a color in the Site Editor's **Styles** panel, that value takes precedence over the Customizer.
- The Site Editor's block preview shows Product Collection with 3 columns by default. The front end uses the Customizer value unless you set columns on the block.
- Header search and cart are hidden by the Customizer through their class names. If you remove those classes, the toggles stop working.
- No `.pot` translation template is included yet. Generate one with WP-CLI (`wp i18n make-pot`) if you translate Aura.
- Before relying on a live store, test the WooCommerce pages (product grid, mini cart, checkout) with WooCommerce 9 or later installed. These were not exercised in the development environment.
- The Vazirmatn font is loaded from jsDelivr. Check the rendered font on your server, and confirm RTL layout with the Persian (fa_IR) locale.
- The theme was checked against WordPress 7.1 and PHP 8.3. Run it on your target PHP version (7.4 or later) before launch.

---

## Development

There is no build step. Edit the files directly. If a theme.json or Customizer change does not show up right away, reload the page; WordPress caches generated global styles and the cache is refreshed on the next request.

Checks used during development:
- `theme.json` validated against the official WordPress schema.
- Every template, part and pattern parsed by WordPress block parser, with no freeform HTML.
- Customizer settings and their effect on the generated CSS checked by changing values and reloading.

## License

GPL-2.0-or-later.
