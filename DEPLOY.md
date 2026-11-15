# Deploy runbook — dashandots.com

Host: Hostinger (LiteSpeed, `Server: hcdn`). Repo: `sumit245/dnd-p`, branch `main`.
Document root on the server is the repo root, so the site runs the files as committed.

## How deploys happen now

**Pushing to `main` deploys the site.** Hostinger's Git auto-deployment is wired
to this repo:

| setting | value |
|---|---|
| provider | GitHub (`sumit245`, installation `019e40f0-4d61-71b4-9e40-18c178ff7f40`) |
| repository | `sumit245/dnd-p` |
| branch | `main` |
| directory | document root |
| enabled | yes |

There is nothing to click. `git push origin main` and the files land.

Check or change it in hPanel → Website → Git, or over the Hostinger API:

```
hosting_get-deployment            domain=dashandots.com   # reads the settings
hosting_deploy                    # re-runs a deploy and rewrites the settings
hosting_git_delete-auto-deployment-settings               # turns auto-deploy off
```

### What a deploy does to files that are not in the repo

Observed on the 2026-11-15 deploy, not promised by the API docs, so re-check if
it matters:

- `.env` survived.
- `storage/` survived (and only holds regenerable `rate_limits/*.json`).
- Untracked **files at the document root** were deleted — including
  `9f2bcc4f25614d048f5b49f3bb15dba9.txt`, a search-console verification file,
  and several stale `*_report.md` audits.

So: anything the live site needs that is not committed must be re-uploaded after
a deploy, or committed. Keep a copy of the verification file off-server.

### History

Before 2026-11-15 the document root was **not** a git checkout — no `.git`, files
had been uploaded by hand, and prod had drifted a few hundred bytes from
`216cc02`. Earlier versions of this runbook told you to `git pull` in
`~/public_html`; that never worked, because there was no repository there. The
`hosting_deploy` call that fixed this also discarded that drift.

---

## Deploys that need more than a push

Two kinds of change do not take effect on their own.

### Database migrations

SQL lives in `scripts/*.sql`. Run it after the push, not before.

phpMyAdmin → database → SQL tab → paste the file → Go. Or over SSH:

```bash
cd ~/public_html
mysql -u "$DB_USER" -p "$DB_NAME" < scripts/migrate-portfolio-meta.sql
```

Migrations here have been additive (nullable columns), so they are safe to run
while the site serves traffic, and re-running one answers
`Duplicate column name '…'` — a no-op, not a failure.

Production reads `DB_NAME` from `.env`, which is not in the repo. Locally it
defaults to `dashandots_cms`.

### Content seeds

Some page copy lives in `portfolios.detailed_description`, not in a template, so
it ships through `scripts/seed-portfolio-products.php`.

The scripts are blocked over HTTP (`.htaccess`: `RewriteRule ^scripts/ - [F,L]`,
verified 403) and guarded with `PHP_SAPI !== 'cli'`, so this needs SSH:

```bash
cd ~/public_html
php scripts/seed-portfolio-products.php
```

It matches rows on `slug` and updates in place, printing one line per row, so it
is safe to re-run. **Back up the database first** — it overwrites
`detailed_description` on matched slugs, and the dump is the only undo:

```bash
mysqldump -u "$DB_USER" -p "$DB_NAME" > ~/backup-portfolios-$(date +%F).sql
```

No SSH on the plan? Enable it in hPanel → Advanced → SSH Access. Do **not** work
around it by removing the HTTP guard.

---

## Verify after a deploy

```bash
# pages respond
for u in "" services/manufacturing-erp/ blog/ portfolio demo/hrmx; do
  printf '%-34s %s\n' "/$u" "$(curl -s -o /dev/null -w '%{http_code}' "https://dashandots.com/$u")"
done

# DB-backed pages returning 200 means .env survived and MySQL is reachable

# page-level schema and crawl directives
curl -s https://dashandots.com/ | grep -c '#webpage'
curl -s https://dashandots.com/robots.txt | grep -c 'OAI-SearchBot'
curl -s https://dashandots.com/sitemap.php | grep -c 'manufacturing-erp'

# one BreadcrumbList per page type
for u in / portfolio blog/ demo/hrmx services/erp-development/; do
  printf '%-28s %s\n' "/$u" "$(curl -s "https://dashandots.com/$u" | grep -c BreadcrumbList)"
done

# maintenance scripts are not web-callable (expect 403)
curl -s -o /dev/null -w '%{http_code}\n' https://dashandots.com/scripts/seed-portfolio-products.php

# forms still work end to end
php scripts/smoke-test-forms.php https://dashandots.com
```

Then, in a browser: `/blog/` card spacing is unchanged; the About section shows
four credential cards and no project/client counts; admin → edit a graphics
portfolio row → save → category is still "Graphics & Branding".

Last, run Lighthouse on `/`, `/portfolio`, `/services/erp-development/`,
`/demo/hrmx` and the top blog post, and record the numbers in
`WEBSITE_AUDIT.md` (PRF-04 has been open since May).

---

## Rollback

Auto-deploy follows `main`, so rolling back means moving `main`:

```bash
git revert <bad-commit>
git push origin main
```

A `git reset --hard` + force-push also works but rewrites history; prefer the
revert. Either way the next deploy runs automatically.

If a seed produced content you want to undo, restore the dump:

```bash
mysql -u "$DB_USER" -p "$DB_NAME" < ~/backup-portfolios-YYYY-MM-DD.sql
```

A migration needs no rollback — unused nullable columns are inert. To drop them
anyway:

```sql
ALTER TABLE portfolios DROP COLUMN meta_title, DROP COLUMN meta_description;
```

---

## Known post-deploy state

Open items, all tracked in `WEBSITE_AUDIT.md`:

- **`/dnd-p/`** — a stale copy of the whole site sits in the document root and
  serves 200. Duplicate content; delete it in hPanel File Manager.
- **Search-console verification file** — deleted by the 2026-11-15 deploy, needs
  re-uploading, or commit it so deploys keep it.
- **`ErrorDocument 404 /dashandots/404.php`** — the `.htaccess` 404 path is the
  local XAMPP path, so production serves the server's default 404 page rather
  than `404.php`. Fixing it needs a host-conditional rewrite.
- **TRU-02** — no third-party proof on the site. Waiting on client permission.
- **TRU-03** — `SITE_FOUNDER_NAME` unset, so the founder card does not render
  while the trust bar claims "Founder-led scoping". One `.env` line.
- **SCH-02** — no `FAQPage` on the six service pages. Needs copy.
- **PRF-01/02** — `srcset` not wired; `todays-menu.webp` still 302 KB.
- **DEM-07** — no public demo account, so HRMX credentials stay request-only.
- **CNT-01** — two thin blog posts, pending a grow-or-noindex decision.
