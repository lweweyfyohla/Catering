# CaterSource

A catering procurement & sourcing platform for event organizers: create events, browse
supplier menus, build a cart, request & compare quotes, issue purchase orders, and
track delivery/payment — rebuilt to match the CaterSource Figma design on a Laravel 13
+ Tailwind v4 stack.

## What's in this rebuild

- Full schema for `events`, `suppliers`, `menu_items`, `cart_items`, `quotations`,
  `purchase_orders`, `payments` (plus `role` added to `users`), matching the ER
  diagram/spec you provided.
- Controllers, routes and Blade views for the full flow: Auth → Dashboard → Events →
  Suppliers/Menu → Cart → Compare Quotes → Request Quote → Accept Quote (auto-creates a
  Purchase Order) → Confirm PO → Confirm Delivery → Upload Invoice → Pay Invoice → Receipt.
- UI rebuilt to match the Figma screenshots: white sidebar nav, orange accent, card +
  modal based CRUD, status pill badges, responsive layout (mobile sidebar drawer).
- Demo data seeder with the sample records from your spec (Sereywat's Wedding, Monorom
  Catering, etc.) so you can log in and see a populated app immediately.

> Note: the vendor/ folder is already included so you don't need internet access to get
> running — but you'll still need a local PHP 8.3+ / MySQL environment to serve it.

## Setup

1. **Database** — create a MySQL database named `catersource_db` (or edit `.env` to
   point at your own), then run:
   ```bash
   php artisan migrate --seed
   ```
2. **Storage** — for supplier/menu-item images and invoices to display, link the
   public storage disk:
   ```bash
   php artisan storage:link
   ```
3. **Frontend build** — Tailwind v4 is wired through Vite:
   ```bash
   npm install
   npm run dev      # local development
   npm run build     # production assets
   ```
4. **Serve**:
   ```bash
   php artisan serve
   ```

## Demo login

| Role  | Email                    | Password   |
|-------|---------------------------|------------|
| User  | sokha@gmail.com           | password   |
| Admin | admin@catersource.com     | password   |

## Notes on scope

- This project was rebuilt from a bare Laravel starter (the zip you supplied only had
  the framework skeleton + Breeze auth scaffolding, no catering business logic yet), so
  everything here is new — built directly from your PDF spec (schema, SQL, and Figma
  screenshots), since the live Figma file couldn't be fetched (Figma blocks automated
  access) and the design zip/SQL dump didn't come through in the upload.
- The visual design follows the screenshots closely (sidebar nav groups, orange accent
  `#f5641e`, card/modal patterns, status pills) but isn't pixel-identical to Figma since
  I was working from screenshots rather than the live file's design tokens. If you can
  export exact colors/spacing/type scale from Figma (Inspect panel), I can tighten this
  up further.
- Auth is hand-written (login/register/logout) against Laravel's core `Auth` facade
  rather than the Breeze package, since Breeze wasn't installed in the vendor folder and
  package installs aren't reachable from this environment — functionally equivalent,
  no extra dependency needed.
