# CreatorOS — Milestone Roadmap

Sequential, dependency-ordered. Each milestone should be shippable/demoable before starting the next — don't skip ahead. See [DESIGN_BRIEF.md](DESIGN_BRIEF.md) for the full spec each milestone implements.

Stack: Laravel 12 + Filament 3 (admin), MariaDB, Tailwind CSS v4, Alpine.js + GSAP (motion), Vite.

---

## M0 — Foundation ✅ DONE

- Laravel 12 project scaffolded, MariaDB connected, migrated.
- Filament admin panel installed, first admin user created.
- Tailwind v4, Alpine.js, GSAP installed.
- Git initialized, remote `origin` set to `iamwaris/FutureX`.
- Node.js upgraded from v18.13.0 to v24.18.0 LTS (was blocking Vite 7 / `@tailwindcss/oxide`) — resolved.

---

## M1 — Design Token Engine & Theme Foundation ✅ DONE

- `theme_settings` table + `ThemeSetting` model (singleton row via `ThemeSetting::current()`): all 9 semantic colors, text colors, heading/body fonts, radius, shadow style, animation intensity, section spacing.
- `ThemeService` renders tokens to cached CSS custom properties, served at `/theme.css` and linked from the base layout `<head>`; cache auto-flushes on save via model events.
- Tailwind v4 `@theme inline` in `resources/css/app.css` maps `bg-primary`, `text-text-primary`, `font-heading` etc. to `var(--color-*)` — resolved at runtime, not baked in at build time.
- Google Fonts `<link>` generated dynamically from the font tokens.
- Filament **Theme Builder** page (`/admin/theme-builder`): color pickers, font selects, radius/shadow/animation/spacing controls, live-refreshing preview iframe of the homepage.
- Placeholder homepage (`resources/views/home.blade.php`) proving the pipeline — will be replaced section-by-section in M2.

**Exit criteria — verified:** updating a token (tested via direct model update, simulating a Theme Builder save) flushed the cache and changed `/theme.css` output immediately with zero code changes.

---

## M2 — Core Layout, Navigation & Homepage Skeleton

- Base layout: sticky nav (Home/About/Content/Schedule/Community/Sponsors/Shop/Contact) + persistent Live indicator + Watch Live CTA.
- Footer (Contact, social links, copyright, privacy/terms, business email).
- Homepage section shells as Blade components for all 11 sections, populated with placeholder content, wired to the M1 tokens.
- Baseline motion: fade/slide/hover-lift via Alpine + GSAP on scroll-into-view.
- Mobile-first responsive pass, dark mode default with light mode toggle.

**Exit criteria:** homepage scrolls through all 11 sections responsively, dark/light both look correct, nothing hardcodes a color/font/radius outside tokens.

---

## M3 — Content Management (Filament Content Manager + Page Builder)

- Eloquent models + Filament resources: Videos/Clips, Gallery items, Events, FAQ, Blog/News posts.
- `page_sections` table (section type, order, `is_enabled`, JSON config) driving which homepage sections render and in what order — this is the Page Builder's data model.
- Filament Page Builder UI: drag-to-reorder, enable/disable toggle, duplicate section.
- Media library (Spatie Media Library + Filament plugin) for images/video uploads across all content types.

**Exit criteria:** an admin can disable the Sponsors section, reorder Schedule above Content, and upload a gallery image — all without a deploy.

---

## M4 — Live Status & Streaming Platform Integrations

- Service classes: `TwitchService`, `KickService`, `YouTubeLiveService` behind a common `LiveStatusProvider` interface.
- Scheduled job polls active platform(s) every 1–2 min, caches LIVE/OFFLINE + title/game/viewers/duration.
- Frontend Live Status section reflects cache via Livewire polling.
- Live Mode: hero/banner auto-swaps to "LIVE NOW" state driven by the same cache.

**Exit criteria:** starting a real (or sandboxed) Twitch stream flips the site to Live Mode within the poll interval without a page reload.

---

## M5 — Creator Snapshot, Stats & Community Hub

- Snapshot stats (followers/subs/views/years/videos/community) — manual entry fields in Filament, with optional scheduled API sync for YouTube/Twitch where available.
- Animated counter component (count-up on scroll-into-view).
- Community Hub cards: Discord (widget or manual member count), Reddit, X, Instagram, TikTok, YouTube — each shows a stat, not just an icon.
- Newsletter capture wired to Beehiiv or Mailchimp (admin picks provider + API key in Filament Integrations).

**Exit criteria:** snapshot numbers and community stats are editable from Filament and animate correctly on the live homepage.

---

## M6 — Media Kit & Sponsor Pages

Highest monetization priority — brands should be able to self-serve everything they need here.

- `/media-kit` page: bio, demographics (geo/age/gender/language), avg/peak viewers, monthly impressions, social stats, past sponsors, brand values, past campaigns.
- Downloadable PDF export of the Media Kit (Browsershot or DomPDF).
- `/sponsors` page: logo wall, case studies, campaign highlights, testimonials — all Filament-managed.
- Business Contact form (name, company, email, campaign type, budget, timeline, message, attachment) with validation, spam protection, email notification + DB record for the admin dashboard.

**Exit criteria:** a brand can view live stats, download a PDF media kit, and submit an inquiry that lands in Filament.

---

## M7 — Content Library & Gallery

- `/content` unified library: videos/clips/shorts/streams with categories, tags, search — Netflix-style grid/carousel browsing.
- `/gallery`: events/meetups/BTS media grid with lightbox.
- `/events`: calendar view of streaming events, charity streams, tournament appearances, meet-and-greets.

**Exit criteria:** all three pages pull from M3's content models, support search/filter, and stay responsive at scale (test with 100+ dummy items).

---

## M8 — Shop Integrations

- `ShopProvider` interface with adapters for Shopify, Fourthwall, WooCommerce, Gumroad, Spring.
- Admin picks the active provider(s) and credentials in Filament Integrations.
- Shop section + `/shop` page: featured products, limited drops, digital downloads, pulling live data from the active provider's API where possible (fallback to manually curated products otherwise).

**Exit criteria:** switching the active shop provider in Filament changes what renders on `/shop` without code changes.

---

## M9 — Creator Modes & Theme Presets

- Named token presets (save/load/duplicate/reset) building on M1's theme engine.
- Mode switcher in Filament: Sponsor Mode, Event Mode, Charity Mode, Seasonal Themes — each mode = a token preset + a `page_sections` configuration swap, one click to activate.
- Charity Mode adds a donation campaign banner/section.

**Exit criteria:** toggling Event Mode in Filament changes the homepage's visual theme and section priority live, and toggling back restores the previous state exactly.

---

## M10 — Admin Dashboard, Analytics & Remaining Integrations

- Filament dashboard widgets: traffic, live status, recent inquiries, newsletter growth, merch clicks, sponsor requests.
- Tracking integrations: Google Analytics, Microsoft Clarity, Meta Pixel — injected conditionally based on admin-entered IDs.
- Patreon, Ko-fi, Spotify cards wired into Community Hub / footer.

**Exit criteria:** dashboard reflects real site activity; all three tracking scripts fire only when configured.

---

## M11 — SEO, Performance, Accessibility & PWA Hardening

- Schema.org (Person/Organization, VideoObject, Event) structured data across relevant pages.
- Open Graph metadata, XML sitemap, robots.txt.
- Image optimization pipeline (responsive sizes, lazy loading, modern formats).
- WCAG AA audit and fixes; Lighthouse pass targeting 95–100 across Performance/Accessibility/Best Practices/SEO.
- PWA manifest + service worker.

**Exit criteria:** Lighthouse scores 95+ on homepage, media kit, and content library on mobile and desktop; axe/WCAG AA audit passes.

---

## M12 — Launch Prep

- Real API credentials swapped in for all integrations.
- Content populated with real creator data.
- Staging → production deployment, backups, uptime/error monitoring.
- Final cross-mode, cross-breakpoint QA pass.

**Exit criteria:** production site live at the real domain, all Creator Modes verified in production, monitoring in place.
