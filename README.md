# Mzansi Homes — WordPress Theme

A premium, production-ready South African real estate WordPress theme built from scratch with custom PHP, MySQL (via WordPress), and vanilla JS.

## Features

- **Custom Post Type: Property** — with 15 custom meta fields (price, bedrooms, bathrooms, garages, floor size, erf size, address, Google Maps embed, virtual tour URL, levy, rates, reference number, and more)
- **Custom Post Type: Agent** — phone, email, WhatsApp, FFC license, languages, areas
- **3 Custom Taxonomies** — Property Type, Location (province), Status (For Sale / To Let / Sold)
- **Advanced Search & Filter** — AJAX-powered, no page reload. Filters by keyword, status, type, province, bedrooms, min/max price
- **Homepage** — hero with embedded search, featured listings, browse by type, why choose us, agents preview, blog preview, CTA banner
- **Property Archive** — grid/list toggle, sortable, paginated, AJAX filter
- **Single Property** — full details, specs bar, features/amenities, Google Maps embed, virtual tour button, enquiry form, share buttons
- **Agent Archive + Profile** — contact buttons, bio, listings by agent, inline enquiry form
- **Blog** — archive listing, single post with sidebar
- **Contact Page** — full contact form with AJAX submission, map embed, office info
- **localStorage save/favourite** — users can save properties client-side
- **ZAR currency** throughout (R formatting with `number_format`)
- **PPRA compliant** footer wording
- **Responsive** — mobile nav, touch-friendly, tested down to 320px
- **Accessibility** — skip link, aria labels, semantic HTML

## Stack

- PHP 8.0+
- WordPress 6.0+
- MySQL (via WordPress wpdb)
- Vanilla JS + jQuery (bundled with WordPress)
- CSS custom properties (no framework)
- Google Fonts: Playfair Display + DM Sans

## Installing on Hostinger

1. Log in to Hostinger hPanel → **WordPress** → open your site
2. Go to **Appearance → Themes → Add New → Upload Theme**
3. Upload `mzansi-homes.zip`
4. Click **Activate**
5. Go to **Settings → Permalinks** → select **Post name** → Save
6. Go to **Appearance → Menus** → create a menu and assign it to **Primary Navigation**

## Setting Up Content

### Taxonomy Terms to Create First

Go to **Properties → Property Types** and add:

- House, Apartment, Townhouse, Plot & Land, Commercial, Farm

Go to **Properties → Status** and add:

- For Sale, To Let, Sold, New Development

Go to **Properties → Location** and add provinces:

- Western Cape, Gauteng, KwaZulu-Natal, etc.

### Pages to Create

| Page Title | Template                                       |
| ---------- | ---------------------------------------------- |
| Home       | Front Page (set in Settings → Reading)         |
| Contact    | Contact Page (set via Page Attributes)         |
| Properties | No template needed — uses archive-property.php |
| Blog       | Set in Settings → Reading as Posts page        |

### Adding a Property

1. **Properties → Add New**
2. Fill in title (property name), content (description), featured image
3. Fill in the **Property Details** meta box: price, bedrooms, bathrooms, etc.
4. Assign **Property Type**, **Status**, and **Location** taxonomy terms
5. Publish

### Adding an Agent

1. **Agents → Add New**
2. Title = agent full name, content = bio, featured image = profile photo
3. Fill in **Agent Details**: phone, email, WhatsApp, FFC number, languages, areas
4. Publish

## AJAX Search

The search on the listings archive (`/properties/`) and homepage hero both use WordPress AJAX via `admin-ajax.php`. No plugin required.

## Contact Form

Contact forms submit via AJAX to `wp_mail()` — emails go to the WordPress admin email. To change the recipient, update `$to` in `mh_ajax_contact()` inside `functions.php`.

## Connecting Google Maps

On each property, paste a Google Maps Embed URL into the **Google Maps Embed URL** field. Get it from: `maps.google.com` → Share → Embed a map → Copy the `src` URL only.

## File Structure

```
mzansi-homes/
├── style.css              ← Theme header (required by WordPress)
├── functions.php          ← Theme setup, CPTs, meta boxes, AJAX handlers
├── header.php             ← Site header + nav
├── footer.php             ← Site footer
├── index.php              ← Fallback template
├── front-page.php         ← Homepage
├── archive-property.php   ← Property listings + filter
├── single-property.php    ← Individual property page
├── archive-agent.php      ← All agents
├── single-agent.php       ← Agent profile
├── archive.php            ← Blog listing
├── single.php             ← Blog post
├── page.php               ← Generic page
├── css/
│   ├── main.css           ← All theme styles
│   └── agent-profile.css  ← Agent-specific styles
├── js/
│   └── main.js            ← AJAX search, contact forms, mobile nav
├── template-parts/
│   ├── property-card.php
│   ├── property-placeholder.php
│   ├── agent-card.php
│   ├── agent-placeholder.php
│   ├── blog-card.php
│   └── blog-placeholder.php
└── page-templates/
    └── contact.php        ← Contact page template
```

## License

GPL v2 or later — standard WordPress theme licensing.
