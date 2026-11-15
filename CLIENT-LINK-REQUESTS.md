# Client credit-link requests

Drafted 15 November 2026. Nothing has been sent — these are for you to send
from your own address.

---

## The actual position, checked

I said your clients don't link to you. **Five already do**, with follow links.
I checked every client site, and which of them you link to from `/portfolio`
and the homepage:

| Client site | You link to them | They link back |
|---|---|---|
| writeeasyhub.com | yes | **yes** |
| spconstructs.com | yes | **yes** |
| skillbridgeindiatechnologies.com | yes | **yes** |
| bharatiyameritparty.org | yes | **yes** |
| smart4bharat.com | yes | **yes**, but anchored on "SMaRT" |
| feasti.com | yes | no |
| snubfoods.com | yes | no |
| inversio365.com | yes | no |
| www.rsrobotic.com | yes | no |
| vindhyashrisolutions.com | no | no |
| trustmerecycle.com | no | no |
| slldm.com | no | n/a — redirects to a login, no public page |
| tiktrucs.com | no | n/a — domain does not resolve |

So: **four reciprocal asks** (feasti, Snüb Foods, Inversio365, RS Robotics),
**two plain asks** (Vindhyashri, Trust Me Recycle), and **one fix**
(SMaRT4Bharat's anchor text).

The four reciprocal ones are the easy sends: you already link to them and get
nothing back, which is a fair thing to mention. For Vindhyashri and Trust Me
Recycle you do not currently link out, so those emails leave that line out.

## Email 1 — Vindhyashri Solutions

**Subject:** Quick favour — credit link on your site

> Hi [name],
>
> Small request, takes two minutes of your developer's time.
>
> We built the Ghumantoo bus booking platform with you. Would you be willing to
> add a credit link in your site footer? Something like:
>
> Website by [Dashandots Technology](https://dashandots.com)
>
> It helps us a lot — search engines treat a link from a real working business
> very differently from anything we can do on our own site. Happy to send the
> exact HTML, or to add it ourselves if your team would rather we did.
>
> Either way, no problem at all if it doesn't fit your design.
>
> Thanks,
> [your name]

---

## Email 2 — Snüb Foods

**Subject:** Credit link on snubfoods.com?

> Hi [name],
>
> Hope the POS is still behaving.
>
> Would you mind adding a small credit link to Dashandots in your site footer?
> One line is plenty:
>
> Built by [Dashandots Technology](https://dashandots.com)
>
> We already link to snubfoods.com from our portfolio page, so this just makes
> it mutual. It genuinely helps our visibility in search, which is the one
> thing we can't build ourselves.
>
> I can send the HTML ready to paste if that's easier.
>
> Thanks,
> [your name]

---

## Email 3 — Trust Me Recycle

**Subject:** Credit link, and a note on the app listing

> Hi [name],
>
> Two small things.
>
> First: would you add a credit link to us on trustmerecycle.com? In the footer
> is ideal:
>
> Pickup app by [Dashandots Technology](https://dashandots.com)
>
> Second, worth knowing: the TrustMeRecycle app is currently published under
> our Play Store developer account. That's fine and quite common, but if you'd
> ever prefer it under your own company account we can transfer it — better for
> your brand, and you keep the listing if you ever change developers. No rush,
> just flagging it.
>
> Thanks,
> [your name]

---

## Email 4 — Inversio365

**Subject:** Small credit link request

> Hi [name],
>
> Would you be open to adding a credit line in the Inversio365 footer?
>
> HR platform by [Dashandots Technology](https://dashandots.com)
>
> We link to you from our portfolio already. A link back from a live product
> carries real weight for us in search — far more than anything we can write on
> our own site.
>
> Happy to send the snippet, and no issue if you'd rather not.
>
> Thanks,
> [your name]

---

## Email 5 — SMaRT4Bharat (a fix, not a new link)

The link already exists, but its anchor text is the word **"SMaRT"**. Anchor
text tells Google what the destination is about, so right now that link is
telling Google that dashandots.com is about SMaRT4Bharat. Changing the words
costs nothing and makes the existing link work.

**Subject:** Tiny fix to the existing link on your site

> Hi [name],
>
> Thanks for the credit link on smart4bharat.com — spotted it and appreciate it.
>
> One tiny thing: the linked words are "SMaRT". If it's an easy edit, could the
> linked text read "Dashandots Technology" instead? Same link, same place on the
> page — it's just that the wording of a link is what tells Google what the site
> at the other end does, and right now it's pointing at us with your name.
>
> Current:  `<a href="https://dashandots.com" target="_blank">SMaRT</a>`
> Better:   `<a href="https://dashandots.com">Dashandots Technology</a>`
>
> Completely understand if the text is fixed by the template.
>
> One other thing while I have you — your server is returning 403 to some
> crawlers, including search engine audit bots. It loads fine in a browser, so
> it's likely a firewall or security plugin rule. Worth a look with whoever
> manages your hosting; it can affect how your own site gets indexed.
>
> Thanks,
> [your name]

---

## Email 6 — Feasti

**Subject:** Credit link on feasti.com?

> Hi [name],
>
> Would you add a credit line to the Feasti footer?
>
> Built by [Dashandots Technology](https://dashandots.com)
>
> We link to feasti.com from our portfolio page, so this would just make it
> mutual. A link from a live product carries real weight for us in search.
>
> Happy to send the snippet ready to paste.
>
> Thanks,
> [your name]

---

## Email 7 — RS Robotics & Automation

**Subject:** Credit link on rsrobotic.com?

> Hi [name],
>
> Quick ask. We feature RS Robotics in our portfolio and link to your site from
> it. Would you add a credit link back in your footer?
>
> ERP by [Dashandots Technology](https://dashandots.com)
>
> It takes a developer two minutes and it genuinely helps our visibility in
> search, which is the one thing we can't build on our own site.
>
> Also worth passing to whoever manages your hosting: rsrobotic.com without the
> "www" does not load at all, while www.rsrobotic.com works. Anyone typing the
> short version gets nothing. It's usually a one-line fix at the DNS or host.
>
> Thanks,
> [your name]

---

## Ready-to-paste HTML for whoever says yes

```html
<p class="credit">
  Built by <a href="https://dashandots.com" rel="noopener">Dashandots Technology</a>
</p>
```

**Do not accept a `rel="nofollow"` version** if they offer one — it passes no
authority and the whole point is lost. Equally, don't argue if they insist;
a nofollow link still sends real visitors.

---

## Two things you can do yourself, today

1. **Play Store developer profile.** `com.dashandots.lloydwfm` and
   `com.dashandots.trustmerecycle` are published under your developer account.
   The account's website field should point to `https://dashandots.com`.
   Check it is set — it's a link from Google's own domain.

2. **Two stored client URLs are dead, though neither is publicly linked.**
   `tiktrucs.com` (Truckie) has no DNS record at all, and the apex
   `rsrobotic.com` does not load — your portfolio links the working
   `www.rsrobotic.com`, so nothing is broken on the live site. Worth clearing
   the Truckie URL in the admin so it never gets rendered later.

---

## What to expect

Six asks and one fix, realistically three or four yes. That takes you from 5
client links to 8 or 9. It will not move "custom mobile app development india" — nothing
at this scale will. What it does is start the only count that matters for the
authority problem, and these are the easiest links you will ever get, because
the relationship already exists and you are already linking to them.

Send them one at a time from your own address, not as a mail-merge. The people
receiving these know you.
