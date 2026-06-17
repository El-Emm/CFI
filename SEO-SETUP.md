# SEO Setup Guide — CharityFaith International

**Live site:** https://charityfaithinternational.org

This guide walks you through getting the site found on Google and other search engines. The CFI theme includes basic meta tags and Open Graph data; **Rank Math SEO** (recommended) handles the full setup on WordPress.

---

## Part 1 — Install Rank Math (WordPress)

1. **Plugins → Add New** → search **Rank Math SEO** → Install & Activate
2. Run the setup wizard:
   - **Site type:** Organization / Nonprofit
   - **Site name:** CharityFaith International
   - **Logo:** upload CFI logo
   - **Default social image:** use hero or logo (1200×630 px ideal)
3. Connect **Google Search Console** when prompted (or do it manually in Part 3)

> When Rank Math is active, the theme’s built-in SEO tags step aside automatically.

---

## Part 2 — Configure Rank Math (essential settings)

### General → Edit robots.txt
Ensure nothing blocks the site. Default should allow crawling.

### Titles & Meta → Homepage
| Field | Suggested value |
|-------|-----------------|
| **Title** | CharityFaith International \| Faith, Compassion & Humanitarian Aid |
| **Description** | CharityFaith International is a global faith-based nonprofit founded by Evangelist Ebele Philips — healthcare, education, food relief, widow empowerment, and Christian outreach in 9 nations. |

### Titles & Meta → Pages
Set unique titles and descriptions for key pages:

| Page | Focus keywords |
|------|----------------|
| Accept Jesus | accept Jesus, salvation prayer, become a Christian |
| Prayer Requests | prayer request, faith prayer team |
| Donate | donate nonprofit, humanitarian giving |
| Media Gallery | CFI photos, mission gallery, Africa outreach |
| Founder | Evangelist Ebele Philips, CFI founder |
| Contact | contact CharityFaith International |

### Sitemap
1. **Rank Math → Sitemap Settings** → enable XML sitemap
2. Your sitemap URL: `https://charityfaithinternational.org/sitemap_index.xml`
3. Include: Pages, Posts, Categories

### Local SEO (optional but valuable)
**Rank Math → Local SEO:**
- Organization name: CharityFaith International
- Address: 2727 Overlook Dr, Twinsburg, OH 44087
- Phone: +1 330-999-9170
- Email: info@charityfaithinternational.org

---

## Part 3 — Google Search Console

1. Go to [Google Search Console](https://search.google.com/search-console)
2. **Add property** → URL prefix: `https://charityfaithinternational.org`
3. Verify ownership (HTML tag via Rank Math, or DNS TXT record in Truehost)
4. After verification:
   - **Sitemaps** → submit `sitemap_index.xml`
   - **URL Inspection** → test homepage → **Request indexing**
5. Repeat URL inspection for:
   - `/accept-jesus/`
   - `/prayer-requests/`
   - `/donate/`
   - `/gallery/`

---

## Part 4 — Google Business Profile (optional)

If CFI has a physical office presence:
1. Create a [Google Business Profile](https://business.google.com)
2. Use the Twinsburg, OH address and website URL
3. Add photos from the Media Gallery

---

## Part 5 — On-page checklist (already in theme)

The theme ships with:
- Semantic HTML (`header`, `main`, `footer`, `nav`)
- JSON-LD NGO schema on the homepage
- Mobile-responsive layout
- Descriptive page templates for Accept Jesus & Prayer Requests
- `alt` text on gallery images

**You should still:**
- [ ] Write unique Rank Math descriptions for every page
- [ ] Add 1–2 blog posts per month (Impact Stories, Field Reports)
- [ ] Link between pages (e.g. Accept Jesus → Prayer Requests)
- [ ] Use real social media URLs in **Customizer → CFI Contact Info**

---

## Part 6 — Performance (helps SEO rankings)

On Truehost / WordPress:
1. Enable **SSL** (HTTPS everywhere)
2. Install a cache plugin (LiteSpeed Cache if available on Truehost)
3. Compress images before upload (theme gallery is pre-optimized)
4. Keep plugins minimal: Rank Math, GiveWP, Contact Form 7, WP Mail SMTP, Wordfence

**Target:** Lighthouse mobile score 80+ (test at [PageSpeed Insights](https://pagespeed.web.dev/))

---

## Part 7 — Prayer & salvation forms (SEO + conversion)

1. Create a **Prayer Request** form in Contact Form 7:
   - Fields: Name, Email, Phone, Prayer Request (textarea)
   - Mail to: `info@charityfaithinternational.org`
   - Subject: `New Prayer Request — CFI Website`
2. **Appearance → Customize → CFI Integrations → Prayer Request Form Shortcode**
3. Create a separate **Contact** form for general inquiries

Distinct forms help you track conversions and write better thank-you pages.

---

## Part 8 — Monitor results

| Tool | What to watch |
|------|----------------|
| Google Search Console | Impressions, clicks, indexing errors |
| Rank Math Analytics | Keyword positions |
| Google Analytics 4 | Traffic sources, top pages |

**First results:** 2–8 weeks after indexing. **Strong rankings:** 3–6 months with consistent content.

---

## Quick wins this week

1. Install Rank Math and complete the wizard
2. Submit sitemap to Google Search Console
3. Request indexing for homepage + Accept Jesus + Prayer Requests
4. Publish one **Impact Story** blog post with photos from the gallery
5. Share the site on Facebook, Instagram, and YouTube with link in bio

---

*For WordPress deployment steps, see [WORDPRESS-INSTALL.md](WORDPRESS-INSTALL.md).*
