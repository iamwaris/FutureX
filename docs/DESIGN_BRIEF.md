# CreatorOS — Premium Streamer Website

### Master Design Brief v1.0

This is the source-of-truth product brief. Do not water it down when implementing — every milestone in [MILESTONES.md](MILESTONES.md) traces back to a section here.

---

# Vision

Design a premium Creator Operating System that serves as the central hub for a content creator's entire online presence.

This is NOT a portfolio.

This is NOT a Linktree replacement.

This is NOT a gaming website.

It is a modern digital headquarters where fans, sponsors, tournament organizers, media companies, and collaborators can instantly understand the creator and interact with their brand.

The experience should feel timeless, premium, and professional.

The website should remain visually relevant for the next 5–10 years.

---

# Core Goals

The website must accomplish five objectives:

1. Convert visitors into long-term community members.
2. Convert brands into business inquiries.
3. Present the creator as a professional business.
4. Centralize every important platform into one destination.
5. Be completely brandable from the admin panel without touching code.

---

# Design Philosophy

Less. Better.

Nothing should exist simply because it looks cool. Every component must have a purpose. The design should communicate confidence, maturity, and professionalism. Think "premium creator brand" rather than "gaming setup."

---

# Design Inspiration

Blend the design language of Apple, Linear, Vercel, Stripe, Riot Games, Arc Browser, Framer, Spotify Wrapped.

The final result should feel like a premium SaaS product with subtle gaming influences — not an over-the-top esports template.

---

# Visual Identity

## Layout

* Wide desktop layout (max-width ~1440px)
* Generous whitespace
* Strong visual rhythm
* Modular sections
* Clear content hierarchy
* Responsive with mobile-first principles

## Color System

Never hardcode colors. Use a design token system with editable variables:

* Primary Brand Color
* Secondary Accent
* Background
* Surface
* Card
* Border
* Success
* Warning
* Error
* Typography colors

Support unlimited branding changes. Examples: Esports Red, Neon Purple, Cyber Blue, Emerald Green, Orange, Pink, Monochrome.

## Typography

Typography should carry the design. Large headlines. Minimal body text.

Recommended scale:

* Hero: 72–96px
* Section Titles: 48–60px
* Card Titles: 24–32px
* Body: 18px
* Small Text: 14px

Support multiple Google Fonts through the admin panel.

## Corners

Editable. Default: 16px.

## Shadows

Very subtle. Soft elevation only. No harsh drop shadows.

## Motion

Allowed: Fade, Slide, Blur reveal, Image zoom, Hover lift, Magnetic buttons, Smooth page transitions, Animated gradients, Soft parallax.

Avoid: Flashing effects, Heavy particles, Distracting animations, RGB overload.

---

# Information Architecture

## Global Navigation

Sticky navigation. Contains: Home, About, Content, Schedule, Community, Sponsors, Shop, Contact.

Always display: Live indicator, Watch Live CTA.

---

# Homepage

The homepage should tell a complete story.

## Section 1 – Hero

Purpose: Instantly establish the creator's identity.

Includes: Large creator image or artwork, Creator logo, Name, Verification badge (optional), Short positioning statement, Primary CTA (Watch Live), Secondary CTA (Business Inquiries), Animated background, Optional video background.

## Section 2 – Live Status

Purpose: Make live content impossible to miss.

Display: LIVE / OFFLINE, Platform, Current game/category, Stream title, Viewer count, Stream duration, Next scheduled stream, Watch button.

Supports: Twitch, Kick, YouTube Live.

## Section 3 – Creator Snapshot

Quick overview: Followers, Subscribers, Total Views, Years Creating, Videos Published, Community Members. Animated counters.

## Section 4 – Featured Content

Auto-populated. Latest: YouTube, Twitch VOD, Twitch Clips, TikTok, Instagram Reels, Shorts. Pinned content supported.

## Section 5 – About

Professional introduction. Timeline format. Achievements. Career milestones. Gaming journey. Mission.

## Section 6 – Stream Schedule

Weekly calendar. Countdown. Timezone conversion. Special events. Tournament appearances.

## Section 7 – Community Hub

Display: Discord, Reddit, Twitter/X, Instagram, TikTok, YouTube, Newsletter. Show community statistics instead of simple icons.

## Section 8 – Sponsors

Professional logo wall. Case studies. Previous collaborations. Campaign highlights. Sponsor testimonials.

## Section 9 – Shop

Integrated merchandise. Supports: Shopify, Fourthwall, WooCommerce, Spring, Gumroad. Featured products. Limited drops. Digital downloads.

## Section 10 – Newsletter

Simple email capture. Positioned as: "Join the Inner Circle."

## Section 11 – Footer

Business focused. Contains: Contact, Social links, Copyright, Privacy, Terms, Business email.

---

# Secondary Pages

## About

Biography, Journey, Timeline, FAQ, Setup, Awards, Media mentions.

## Media Kit

The highest-value page for monetization. Should include: Biography, Audience demographics, Geographic breakdown, Age ranges, Gender distribution, Languages, Average viewers, Peak viewers, Monthly impressions, Social statistics, Previous sponsors, Brand values, Past campaigns, Downloadable PDF, Business contact.

## Content Library

Unified content hub. Includes: Videos, Clips, Shorts, Streams, Categories, Search, Tags. Netflix-style browsing experience.

## Gallery

Professional media. Events. Meetups. Conventions. Cosplay. Behind the scenes.

## Events

Calendar view. Streaming events. Charity streams. Tournament appearances. Meet-and-greets.

## Contact

Business inquiries only. Fields: Name, Company, Email, Campaign Type, Budget, Timeline, Message, Attachment.

---

# Creator Modes

The website adapts based on context.

## Live Mode

Automatically activates while streaming. Changes: Live banner, Hero CTA, Animated accents, Current stream featured.

## Sponsor Mode

Optimized for brands. Highlights: Media kit, Statistics, Sponsorships, Contact.

## Event Mode

Used for tournaments or conventions. Homepage changes automatically.

## Charity Mode

Promotes donation campaigns.

## Seasonal Themes

Optional. Halloween. Christmas. Anniversary. Launch events.

---

# Admin Panel

Everything should be editable without code.

## Dashboard

Website traffic, Live status, Recent inquiries, Newsletter growth, Merchandise clicks, Sponsor requests.

## Theme Builder

Editable: Colors, Fonts, Button styles, Radius, Shadows, Glass effects, Animation intensity, Background textures, Icons, Section spacing. Live preview.

## Page Builder

Drag-and-drop sections. Enable/disable modules. Duplicate sections. Reorder content.

## Content Manager

Manage: Homepage, About, Videos, Clips, Gallery, Blog, Events, FAQ.

## Integrations

Native integrations for: Twitch, Kick, YouTube, TikTok, Instagram, Discord, Spotify, Patreon, Ko-fi, Fourthwall, Shopify, WooCommerce, Beehiiv, Mailchimp, Google Analytics, Microsoft Clarity, Meta Pixel.

---

# Theme Engine

The platform should never rely on fixed templates. Every visual element should derive from editable design tokens.

Configurable items include: Primary color, Secondary color, Background palette, Typography, Border radius, Button style, Card style, Shadow style, Glass effect, Navigation layout, Hero layout, Footer layout, Animation intensity, Section spacing, Grid density, Icon pack, Background artwork, Decorative patterns.

A single codebase should support vastly different creator identities — from a competitive esports player to a cozy VTuber, musician, or software developer — without modifying the frontend code.

---

# Technical Standards

* Fully responsive
* Mobile-first
* Accessibility (WCAG AA)
* 95–100 Lighthouse target
* Fast page loads
* SEO optimized
* Schema.org support
* Open Graph metadata
* XML sitemap
* Optimized images
* PWA ready
* Dark mode by default with optional light mode

---

# Overall User Experience

When someone lands on the website, they should immediately feel that this creator is running a serious, modern brand. The experience should balance personality with professionalism, making it equally compelling for fans discovering the creator for the first time and for brands evaluating a potential partnership. The site should be visually memorable, technically polished, and flexible enough to evolve with the creator over time.
