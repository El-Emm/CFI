# WordPress Launch Guide — CharityFaith International

**Domain:** [charityfaithinternational.org](https://charityfaithinternational.org)  
**Hosting:** [Truehost Kenya](https://truehost.co.ke)  
**Theme folder:** `wordpress-theme/cfi`

---

## Part 1 — Prepare the theme zip (on your computer)

From the project folder:

```bash
cd /Users/el/Desktop/CFI
chmod +x scripts/build-theme.sh scripts/package-theme.sh
./scripts/package-theme.sh
```

This creates **`wordpress-theme/cfi.zip`** (~40 MB with media). Upload that zip to Truehost.

> After any site or media changes, re-run `./scripts/package-theme.sh` before uploading again.

---

## Part 2 — Install WordPress on Truehost

### A. Log in to Truehost
1. Go to [https://truehost.co.ke](https://truehost.co.ke) and sign in to your client area.
2. Open **cPanel** for the hosting account linked to `charityfaithinternational.org`.

### B. Install WordPress (if not already installed)
1. In cPanel, open **Softaculous** or **WordPress Toolkit** / **Install WordPress**.
2. Choose domain: **`charityfaithinternational.org`**
3. Set:
   - **Site name:** `CharityFaith International`
   - **Admin username:** (choose something other than `admin`)
   - **Strong password** — save it in a password manager
   - **Admin email:** `info@charityfaithinternational.org`
4. Complete installation and note your **wp-admin URL**:  
   `https://charityfaithinternational.org/wp-admin`

### C. Point the domain (if WordPress is new)
In Truehost DNS / domain settings, ensure:
- **A record** for `@` points to your hosting server IP
- **A or CNAME** for `www` points to the same host

Wait up to 24 hours for DNS propagation (often much faster).

### D. Enable SSL
1. In cPanel → **SSL/TLS Status** or **Let’s Encrypt**
2. Issue certificate for `charityfaithinternational.org` and `www`
3. In WordPress: **Settings → General** — set both URLs to `https://charityfaithinternational.org`

---

## Part 3 — Upload the CFI theme

### Method A — cPanel File Manager (recommended)

1. cPanel → **File Manager**
2. Navigate to: `public_html/wp-content/themes/`
3. Click **Upload** → select `cfi.zip` from your computer
4. After upload, **Extract** the zip in `themes/`
5. Confirm folder exists: `public_html/wp-content/themes/cfi/`
6. Delete `cfi.zip` from the server (optional, saves space)

### Method B — FTP (FileZilla)
1. Connect with FTP credentials from Truehost cPanel
2. Upload the entire `cfi` folder to `/public_html/wp-content/themes/cfi/`

### Activate the theme
1. WordPress admin → **Appearance → Themes**
2. Find **CharityFaith International** → **Activate**

On activation, the theme automatically creates pages:
- Donate, Contact, Media Gallery, Founder, Partner With Us, News & Impact

---

## Part 4 — Configure WordPress settings

### Reading settings
1. **Settings → Reading**
2. **Your homepage displays:** A static page
3. **Homepage:** `Home` (created by theme)
4. **Posts page:** `News & Impact`
5. Save

### Permalinks
1. **Settings → Permalinks**
2. Select **Post name** → Save

### Site identity
1. **Appearance → Customize → Site Identity**
2. **Tagline:** `Transforming Lives Through Faith, Compassion, and Action`
3. Upload logo if desired (optional — theme includes CFI logo)

### CFI Customizer sections
**Appearance → Customize:**

| Section | What to set |
|---------|-------------|
| **CFI Contact Info** | Email, phones, address, social URLs |
| **CFI Impact Statistics** | Lives impacted, countries, etc. |
| **CFI Homepage Hero** | Headline and subheadline |
| **CFI Integrations** | GiveWP + contact form shortcodes |

---

## Part 5 — Install recommended plugins

In **Plugins → Add New**, install and activate:

| Plugin | Purpose |
|--------|---------|
| **GiveWP** | Donations (Stripe / PayPal) |
| **Contact Form 7** or **WPForms** | Contact form |
| **Rank Math SEO** or **Yoast SEO** | SEO & sitemap |
| **WP Mail SMTP** | Reliable email delivery |
| **Wordfence Security** | Firewall & login protection |

### GiveWP setup
1. Install **GiveWP** → run setup wizard
2. Create a donation form with funds (General, Healthcare, Education, Food, Widow, Shelter)
3. Connect **Stripe** and/or **PayPal**
4. Copy shortcode, e.g. `[give_form id="123"]`
5. **Customize → CFI Integrations → GiveWP Donation Shortcode** — paste shortcode

### Contact form setup
1. Create form with: Name, Email, Subject, Message
2. Set mail recipient: `info@charityfaithinternational.org`
3. Copy shortcode → **Customize → CFI Integrations → Contact Form Shortcode**

### Blog categories
Create under **Posts → Categories:**
- Impact Stories
- Field Reports
- Events
- Crusades
- Community Development
- Announcements

---

## Part 6 — Verify the site

Check each URL:

| Page | URL |
|------|-----|
| Home | `https://charityfaithinternational.org/` |
| Donate | `/donate/` |
| Contact | `/contact/` |
| Gallery | `/gallery/` |
| Founder | `/founder/` |
| Partners | `/partners/` |
| News | `/news/` |

Test:
- [ ] Hero slideshow
- [ ] Impact counters animate
- [ ] Map country clicks → gallery filter links
- [ ] Gallery filters (country + program) and lightbox

---

## Part 6b — Uploading field photos & videos (Media Gallery)

The theme adds **Field Media** in the WordPress admin (`Field Media` in the left menu). Each item is tagged with a **Country** and **Program / Cause**, which powers the filters on the Media Gallery page.

### Add a photo

1. Go to **Field Media → Add Media**
2. Enter a short title (used for accessibility / alt text)
3. Set **Featured Image** — this is the image shown in the gallery grid
4. Under **Countries**, select one country (e.g. Zimbabwe)
5. Under **Programs / Causes**, select one program (e.g. Crusades, Food Distribution)
6. Leave **Media type** as **Image**
7. Click **Publish**

### Add a video

1. **Field Media → Add Media**
2. Set **Featured Image** — poster frame shown in the grid (required)
3. Choose **Country** and **Program / Cause**
4. Set **Media type** to **Video**
5. Click **Select / Upload Video** and choose an MP4 from the Media Library (or upload a new one)
6. **Publish**

### Tips

- One country + one program per item keeps filters accurate
- After publishing, open **Media Gallery** on the site — filters update immediately (no zip re-upload needed)
- On first theme activation, existing bundled photos are imported automatically into Field Media
- To hide an item, move it to **Trash** or switch to **Draft**

### Folder layout (developers / bulk imports)

When regenerating assets locally with `python3 scripts/optimize-media.py`, images are stored as:

```
assets/media/gallery/{country}/{program}/thumb/
assets/media/gallery/{country}/{program}/full/
```

Videos remain in `assets/media/videos/`. The manifest is written to `assets/data/gallery.json`.

---

## Part 7 — Go live checklist

- [ ] SSL padlock shows on all pages
- [ ] `www` redirects to non-www (or vice versa) — set in cPanel Redirects
- [ ] Google Search Console property added
- [ ] Submit sitemap: `https://charityfaithinternational.org/sitemap_index.xml` (Rank Math)
- [ ] Privacy Policy page created (required for donations)
- [ ] Replace GitHub Pages demo link with live domain when ready

---

## Updating the theme later

1. Edit files locally in `wordpress-theme/cfi/`
2. Run `./scripts/package-theme.sh`
3. Upload new `cfi.zip` to Truehost
4. Extract over `wp-content/themes/cfi/` (backup first)
5. Or use FTP to upload only changed files

**Tip:** Before overwriting, zip the live theme folder on the server as backup.

---

## Troubleshooting (Truehost)

| Issue | Fix |
|-------|-----|
| **White screen** | Enable `WP_DEBUG` in `wp-config.php`; check PHP version ≥ 7.4 in cPanel |
| **Gallery empty** | Open browser devtools → Network; confirm `/wp-json/cfi/v1/gallery` returns items. Re-save permalinks. Check Field Media posts are **Published** with Country + Program assigned. |
| **Styles missing** | Re-activate theme; clear LiteSpeed/cache plugin |
| **Upload zip too large** | Increase `upload_max_filesize` in cPanel → MultiPHP INI, or upload via FTP |
| **Emails not sending** | Configure WP Mail SMTP with Gmail or SendGrid |
| **404 on pages** | Settings → Permalinks → Save again |

---

## Support contacts

- **Truehost support:** via client area / live chat  
- **Theme files:** [GitHub — CFI repo](https://github.com/El-Emm/CFI)  
- **Client email:** info@charityfaithinternational.org

---

*Theme version 1.0.0 — CharityFaith International*
