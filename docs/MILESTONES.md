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

## M4 — Live Status & Streaming Platform Integrations ✅ DONE (pending real credentials)

- `TwitchService`, `KickService`, `YouTubeLiveService` behind a common `LiveStatusProvider` interface, each built against the real documented API shape (Twitch Helix + app access token, Kick public API v1 + OAuth2 client_credentials, YouTube Data API v3 live search). `StreamingCredential` model + Filament resource (`/admin/streaming-credentials`, under an "Integrations" nav group) stores per-platform credentials, `client_secret`/`cached_access_token` encrypted at rest.
- `LiveStatusManager` tries each configured provider, caches whichever is live (or an explicit offline status) for 5 minutes. `live-status:poll` artisan command scheduled every 2 minutes in `routes/console.php`.
- Three Livewire components (`LiveStatusBanner`, `NavLiveIndicator`, `HeroLiveStatus`) read the cache and `wire:poll.30s` — the Live Status section, nav indicator, and Hero's stream-preview mockup all update without a page reload once real credentials are entered.

**Exit criteria — partially verified:** with no real API credentials, the actual "start a Twitch stream and watch it flip live" test isn't possible yet. What's verified instead, with real automated tests (`LiveStatusTest`, `LiveStatusComponentsTest`): each service correctly parses a live/offline API response via `Http::fake()`, the manager correctly skips unconfigured providers and falls back to a cached offline status, and all three Livewire components correctly render both LIVE and OFFLINE states from the cache. Re-verify against a real (or sandboxed) stream once credentials are added in Filament Integrations.

---

## M5 — Creator Snapshot, Stats & Community Hub ✅ DONE

- `SnapshotStat` singleton (same pattern as `ThemeSetting`) + Filament settings page (`/admin/snapshot-stats-settings`): followers/subscribers/total_views/years_creating/videos_published/community_members, each with an optional auto-sync toggle.
- `snapshot-stats:sync` command (scheduled daily) pulls subscribers/total_views/videos_published from YouTube Data API v3 when enabled. Twitch follower auto-sync is intentionally *not* implemented yet — it needs user OAuth (`moderator:read:followers`), not the app access token this project uses for live-status polling; the command warns clearly rather than faking a number.
- `CommunityLink` model + Filament resource (reorderable, `is_primary` flag for the spotlight card) replaces the hardcoded Discord-is-always-primary array from M2.
- `NewsletterSetting` singleton + Filament settings page under Integrations, `BeehiivService`/`MailchimpService` behind a `NewsletterManager`, and a `NewsletterForm` Livewire component replacing the client-side-only stub form from M2 — real subscribe API calls, with validation and success/error states.

**Exit criteria — verified with real tests** (`SnapshotAndCommunityTest`, `SnapshotStatsSyncTest`, `NewsletterTest`): homepage reflects `SnapshotStat`/`CommunityLink` DB values, the sync command correctly pulls only the fields with auto-sync enabled via `Http::fake()`, and the newsletter form correctly calls Beehiiv/Mailchimp and shows success/validation states. 30 tests passing total.

---

## M6 — Media Kit & Sponsor Pages ✅ DONE

Highest monetization priority — brands should be able to self-serve everything they need here.

- `MediaKit` singleton settings (bio, brand values, avg/peak viewers, monthly impressions, age/gender/language/geographic breakdowns as repeater rows) + Filament page. `/media-kit` renders it all with percentage bar charts; pulls followers from `SnapshotStat` and past partnerships from `Sponsor`.
- Downloadable PDF export via `barryvdh/laravel-dompdf` at `/media-kit/pdf` — a separate, DomPDF-safe template (no flexbox/grid/CSS-variables, which DomPDF can't render) rather than reusing the token-driven layout.
- `Sponsor` model + Filament resource (logo upload, case study, campaign highlights, testimonial, `is_featured` flag) replaces the hardcoded homepage sponsor list from M2; also powers a new dedicated `/sponsors` page with full case studies and testimonials.
- `BusinessInquiry` model + Filament resource (admin can mark read/unread, filter). `/contact` page with a `ContactForm` Livewire component: name/company/email/campaign type/budget/timeline/message/attachment, real validation, a honeypot field, and a submission-speed check (both spam signals fail *silently* — the form still shows success — rather than tipping off bots). Successful submissions email a `NewBusinessInquiryNotification`.
- Nav "Sponsors"/"Contact" and Hero's "Business Inquiries" CTA now point to these real pages instead of the M2-era anchors/mailto stopgaps.

**Exit criteria — verified with real tests** (`MediaKitTest`, `ContactFormTest`): `/media-kit` shows live DB-backed stats and demographics, the PDF downloads with `pdftotext`-verified real content, `/sponsors` lists sponsors with testimonials, and a contact submission creates a `BusinessInquiry` row + fires the notification — while a honeypot-filled or too-fast submission is confirmed to create neither. 40 tests passing total.

---

## M7 — Content Library & Gallery ✅ DONE

- Added a `tags` column to `videos` (M3 had category but no tags) + `TagsInput` in the Filament form.
- `/content`: `ContentLibrary` Livewire component — type tabs (video/clip/short/vod), category dropdown, debounced title search, all URL-bound (`#[Url]`) so filters survive a refresh/share. Netflix-style card grid, paginated.
- `/gallery`: `GalleryGrid` Livewire component — category filter, paginated grid, Alpine-driven lightbox (click to view fullsize, `Escape`/click-outside to close). Falls back to a gradient placeholder for items with no uploaded image.
- `/events`: `EventsCalendar` Livewire component — real month-grid calendar (prev/next navigation, events shown on their actual day) plus an "Upcoming" list below it.
- Model factories added for `Video`/`GalleryItem`/`Event` (none existed since M3 built these without factories). Nav's "Content" link and the footer (Gallery/Events/Media Kit) now point at these real pages instead of homepage anchors.

**Exit criteria — verified with real tests** (`ContentLibraryTest`, `GalleryTest`, `EventsCalendarTest`): search/type/category filters all confirmed to narrow results correctly, and each page was seeded with 110–120 factory-generated items and confirmed to (a) paginate correctly rather than dumping everything at once and (b) render in under 2 seconds. 52 tests passing total.

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
