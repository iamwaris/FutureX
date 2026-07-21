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

## M2 — Core Layout, Navigation & Homepage Skeleton ✅ DONE

- Base layout: sticky nav (`partials/nav.blade.php`) with Home/About/Content/Schedule/Community/Sponsors/Shop/Contact links (anchored to homepage sections until dedicated pages exist in later milestones), Live indicator placeholder, Watch Live CTA, mobile menu.
- Footer (`partials/footer.blade.php`): business email, social links, copyright, privacy/terms.
- All 11 homepage sections built as Blade partials (`resources/views/sections/*.blade.php`) behind a shared `<x-section>` wrapper component, populated with placeholder content, built entirely from M1 tokens (no hardcoded colors/fonts/radius anywhere).
- Baseline motion: `resources/js/motion.js` — IntersectionObserver scroll-reveal, GSAP magnetic buttons, count-up stats — all gated on the `animation_intensity` token and `prefers-reduced-motion`.
- Class-based dark/light mode: dark by default, toggle persists to `localStorage`, FOUC-safe (applied before first paint). Light mode overrides chrome via `:root:not(.dark)`; brand colors stay constant across modes.

**Exit criteria — verified:** homepage returns 200 with all 10 section IDs present (`hero`, `live-status`, `snapshot`, `featured-content`, `about`, `schedule`, `community`, `sponsors`, `shop`, `newsletter`), no PHP errors, responsive Tailwind classes in place at `sm`/`lg` breakpoints. Not independently verified in an actual browser (no browser/screenshot tool in this environment) — worth a manual look before M3.

---

## M3 — Content Management (Filament Content Manager + Page Builder) ✅ DONE

- Models + Filament resources: `Video` (videos/clips/shorts/VODs), `GalleryItem`, `Event`, `FaqItem`, `Post` (blog).
- `page_sections` table (key, label, order, is_enabled) driving which homepage sections render and in what order; `home.blade.php` loops over enabled/ordered records via `@includeIf` instead of a hardcoded list.
- Filament Page Builder (`/admin/page-sections`): drag-to-reorder, inline enable toggle, duplicate action.
- Spatie Media Library + `filament/spatie-laravel-media-library-plugin` for image uploads (Video thumbnails, GalleryItem images, Post featured images) via `SpatieMediaLibraryFileUpload`.

**Exit criteria — verified with real feature tests** (`AdminResourcesTest`, `PageBuilderTest`, `GalleryUploadTest`), not manual curl checks. Disabling a section removes it from the homepage, reordering changes render order, gallery image upload works end-to-end.

**Three real bugs found and fixed by writing those tests** (not caught by earlier manual spot-checks):
- `User` didn't implement Filament's `FilamentUser` contract, so Filament fell back to "allow panel access only when `APP_ENV=local`" — would have locked everyone out of `/admin` the moment this ever ran with `APP_ENV=production`.
- `ThemeSetting::current()`'s `firstOrCreate()` only inserts `id=1` and relies on DB column defaults for the rest; Eloquent never re-fetches after `create()`, so the very first request ever served against a fresh database crashed in `ThemeService::googleFontsUrl()`. Fixed by refreshing the model after creation.
- GD PHP extension was disabled, silently breaking image processing (`imageEditor()`, media conversions) — enabled alongside the earlier `intl`/`zip` fixes.

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
