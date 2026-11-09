# Deploy runbook — dashandots.com

Host: Hostinger (LiteSpeed, `Server: hcdn`). Repo: `sumit245/dnd-p`, branch `main`.
Document root on the server is the repo root, so the site runs the files as committed.

This runbook covers the DEP-02 deploy: everything between `972edbb` and `6006122`,
which is the HRMX content rewrite plus the audit remediation (schema, metadata,
sitemap dates, `/scripts/` lockdown, accessibility fixes).

Two things in this deploy are **not** plain file changes and will not take effect
on their own:

1. a database migration — two new columns on `portfolios`;
2. a content seed — the HRMX pricing, ownership, geofence and rollout sections
   live in `portfolios.detailed_description`, not in a template.

Order matters: files, then migration, then seed. The seed writes to the new
columns' table but not the columns themselves, so running it before the
migration is harmless; running it before the file deploy is not, because the
newer seed script is part of this deploy.

---

## 0. Before you start

- [ ] Local tree is clean and pushed: `git status` empty, `git log origin/main..HEAD` empty.
- [ ] You can reach the server (Hostinger hPanel → Git, or SSH, or File Manager).
- [ ] You know the production DB name. Locally it defaults to `dashandots_cms`;
      production reads `DB_NAME` from `.env`, which is not in the repo.
- [ ] Take the backup in step 1. The seed is idempotent but it does overwrite
      `detailed_description` on matched slugs, so a DB snapshot is the undo.

---

## 1. Back up the database

hPanel → Databases → phpMyAdmin → select the database → Export → Quick, SQL → Go.
Keep the file until the verification in step 5 passes.

With SSH available, this is faster:

```bash
mysqldump -u "$DB_USER" -p "$DB_NAME" > ~/backup-portfolios-$(date +%F).sql
```

---

## 2. Deploy the files

**Hostinger Git (preferred).** hPanel → Website → Git → *Deploy*. It pulls
`main` into the document root.

**SSH alternative:**

```bash
cd ~/public_html
git pull origin main
```

Note which you use: it decides whether sitemap `lastmod` is meaningful. The new
`sitemap.php` derives `lastmod` from `filemtime()` for file-backed pages, so a
`git pull` (which only touches changed files) gives honest dates, while a full
FTP re-upload stamps every file with the upload time and collapses them to one
date. Prefer the pull.

**Do not** deploy by uploading a zip of the working directory: that would ship
`.env` and `storage/` over the live ones.

---

## 3. Run the database migration

Adds `meta_title` and `meta_description` to `portfolios`. Both are nullable, so
this is additive and safe to run while the site serves traffic.

phpMyAdmin → database → SQL tab → paste the contents of
`scripts/migrate-portfolio-meta.sql` → Go.

Or over SSH:

```bash
cd ~/public_html
mysql -u "$DB_USER" -p "$DB_NAME" < scripts/migrate-portfolio-meta.sql
```

Confirm:

```sql
SHOW COLUMNS FROM portfolios LIKE 'meta_%';
```

Expect two rows, `varchar(70)` and `varchar(170)`, both `Null = YES`.

Already applied? MySQL answers `Duplicate column name 'meta_title'`. That is
the no-op, not a failure — carry on.

---

## 4. Run the content seed

This is what publishes the HRMX rewrite. It needs CLI access: as of this deploy
the scripts are blocked over HTTP and guarded with `PHP_SAPI !== 'cli'`, so
there is no browser route and should not be one.

```bash
cd ~/public_html
php scripts/seed-portfolio-products.php
```

It matches rows on `slug` and updates in place, printing one line per row, so it
is safe to re-run.

**No SSH on the plan?** Then the seed cannot run, and `/demo/hrmx` will deploy
with its old copy while every other fix lands. Two options, in order of
preference:

1. Enable SSH in hPanel (Advanced → SSH Access) and run the command above.
2. Export the `portfolios` rows from local and import them into production
   through phpMyAdmin — but that carries local data, so do it only if you know
   the two datasets match.

Do **not** work around it by temporarily removing the HTTP guard.

---

## 5. Verify

Work the 14-item list in `WEBSITE_AUDIT.md` §3. The fast ones, from any machine:

```bash
# one BreadcrumbList per page type
for u in / portfolio blog/ demo/hrmx services/erp-development/; do
  printf '%-28s %s\n' "/$u" "$(curl -s "https://dashandots.com/$u" | grep -c BreadcrumbList)"
done

# HRMX rewrite is live (expect a non-zero count for each)
curl -s https://dashandots.com/demo/hrmx | grep -coE 'AMC|geofenced|Mumbai|1,200'

# old homepage copy is gone (expect 0)
curl -s https://dashandots.com/ | grep -coE '450\+|about-stat-row|Get a free project estimate'

# sitemap: no stale dates, no graphics slugs (expect 0 for each)
curl -s https://dashandots.com/sitemap.php | grep -c '2026-04-26'
curl -s https://dashandots.com/sitemap.php | grep -cE 'todays-menu|detox-story|italian-pizza'

# scripts are no longer web-callable (expect 403) — see the warning below
curl -s -o /dev/null -w '%{http_code}\n' https://dashandots.com/scripts/seed-portfolio-products.php

# forms still work end to end
php scripts/smoke-test-forms.php https://dashandots.com
```

> **Run the `/scripts/` check only after step 2 has completed.**
> Until the new `.htaccess` is live, that URL executes the seed. Requesting it
> on the current production site would rewrite portfolio rows from whatever the
> server's copy of the script contains.

Then, in a browser: `/404` shows "Page not found" as its heading rather than the
faded glyph; `/blog/` card spacing is unchanged; the About section shows four
credential cards and no project/client counts; admin → edit a graphics portfolio
row → save → category is still "Graphics & Branding".

Last, run Lighthouse on `/`, `/portfolio`, `/services/erp-development/`,
`/demo/hrmx` and the top blog post, and record the numbers in
`WEBSITE_AUDIT.md` (PRF-04 has been open since May).

---

## 6. Rollback

File changes only:

```bash
cd ~/public_html
git log --oneline -5
git reset --hard <previous-commit>
```

If the seed produced content you want to undo, restore the step 1 dump:

```bash
mysql -u "$DB_USER" -p "$DB_NAME" < ~/backup-portfolios-YYYY-MM-DD.sql
```

The migration needs no rollback — two unused nullable columns are inert. If you
want them gone anyway:

```sql
ALTER TABLE portfolios DROP COLUMN meta_title, DROP COLUMN meta_description;
```

---

## 7. Known post-deploy state

Expected to still be open after this deploy, all tracked in `WEBSITE_AUDIT.md`:

- **TRU-02** — no third-party proof on the site. Waiting on client permission.
- **TRU-03** — `SITE_FOUNDER_NAME` unset, so the founder card does not render
  while the trust bar claims "Founder-led scoping". One `.env` line.
- **SCH-02** — no `FAQPage` on the six service pages. Needs copy.
- **PRF-01/02** — `srcset` not wired; `todays-menu.webp` still 302 KB.
- **DEM-07** — no public demo account, so HRMX credentials stay request-only.
- **CNT-01** — two thin blog posts, pending a grow-or-noindex decision.

Nothing above blocks the deploy.
