# Charity Faith International (CFI)

A world-class, modern nonprofit website for **Charity Faith International** — a US-registered humanitarian and faith-based organization founded by **Evangelist Ebele Philips**.

## Live site (GitHub Pages)

**https://el-emm.github.io/CFI/**

Deploys automatically on every push to `main` via [GitHub Actions](.github/workflows/deploy-pages.yml). First-time setup: enable **Settings → Pages → Build and deployment → GitHub Actions** (already configured for this repo).

## Local preview

Open `index.html` in a browser, or serve locally:

```bash
cd CFI
python3 -m http.server 8080
# Visit http://localhost:8080
```

> Local paths match production when served from the repo root. The live site is hosted at `/CFI/` on GitHub Pages; all page links use relative URLs so they work in both environments.

## Site Structure

| Page | Path | Description |
|------|------|-------------|
| Home | `index.html` | Hero, stats, mission, programs, map, stories, founder preview, partner CTA |
| Donate | `pages/donate.html` | Fund selection, amounts, payment-ready form |
| Contact | `pages/contact.html` | Form, contact info, maps placeholder |
| Gallery | `pages/gallery.html` | Filterable media, lightbox, downloads |
| Founder | `pages/founder.html` | Evangelist Ebele Philips biography |
| Partners | `pages/partners.html` | Donate, sponsor, volunteer, church & corporate |
| Blog | `pages/blog.html` | News & impact (WordPress loop ready) |

## Brand Colors

| Name | Hex | Usage |
|------|-----|-------|
| Compassion Orange | `#FF6A00` | CTAs, donations, accents |
| Deep Charcoal | `#111111` | Headings, nav, footer |
| Soft Ivory | `#FFF8F1` | Section backgrounds |
| Hope Gold | `#F5B942` | Sparingly — counters, highlights |
| Faith Green | `#3FA66B` | Success, impact indicators |
| Warm Grey | `#5F5F5F` | Body text |
| White | `#FFFFFF` | Base |

## WordPress Migration

This static site is structured for easy conversion to a WordPress theme:

- **CSS namespace:** `cfi-*` classes in `assets/css/main.css`
- **Template parts:** `includes/header.html`, `includes/footer.html`
- **Editable blocks:** `data-wp-block`, `data-wp-loop`, `data-wp-editable` attributes mark CMS regions
- **Impact stats:** `data-target` on `.cfi-stat__number` — map to ACF or customizer
- **Donations:** `data-wp-integration` on donate form — connect GiveWP, Donorbox, Stripe, or PayPal
- **Blog:** Replace `pages/blog.html` grid with `the_loop()` and categories listed in the design brief

### Suggested WordPress Plugins

- **GiveWP** or **Donorbox** — donations
- **Contact Form 7** or **WPForms** — contact
- **Yoast SEO** or **Rank Math** — SEO
- **ACF** — impact counters, map stories, founder bio

## Assets

- Logo: `assets/images/cfi-logo.png`
- Scripts: `assets/js/main.js` (hero, counters, map, gallery, forms)
- Placeholder photography uses Unsplash — replace with official CFI media library

## SEO

- Semantic HTML5 landmarks
- Meta descriptions and Open Graph on home
- JSON-LD: `NGO`, `Person`, `ContactPage`, `DonateAction`
- Target keywords documented in project brief (Christian charity, humanitarian nonprofit, widow support, etc.)

## License

© Charity Faith International. All rights reserved.
