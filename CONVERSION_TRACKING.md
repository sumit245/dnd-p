# Dashandots Conversion Tracking Setup

Use GTM container `GTM-TJ3ZLPNJ`.

## Custom Event Triggers

Create GTM custom-event triggers for:

- `estimate_completed`
- `contact_form_submit_success`
- `contact_form_submit_error`
- `whatsapp_click`
- `phone_click`
- `demo_click`
- `proof_card_click`
- `cta_click`

## GA4 Events

Create GA4 event tags that fire from the matching GTM triggers.

Recommended GA4 event names:

- `generate_lead` from `contact_form_submit_success`
- `estimate_completed` from `estimate_completed`
- `contact_error` from `contact_form_submit_error`
- `whatsapp_click` from `whatsapp_click`
- `phone_click` from `phone_click`
- `demo_click` from `demo_click`
- `proof_card_click` from `proof_card_click`
- `cta_click` from `cta_click`

Mark these as conversions in GA4:

- `generate_lead`
- `estimate_completed`
- `whatsapp_click`
- `phone_click`
- `demo_click`

## Event Parameters

Create data layer variables for:

- `cta_text`
- `cta_location`
- `destination`
- `page_path`
- `service`
- `project_type`
- `budget_min`
- `budget_max`
- `timeline`
- `complexity`
- `demo_slug`
- `proof_type`
- `error_type`
- `error_message`

## Microsoft Clarity

Set `MICROSOFT_CLARITY_ID` in production `.env` to enable the Clarity snippet. Leave it blank to disable.

## Verification

Use GTM Preview and verify:

- Hero estimate CTA pushes `cta_click`.
- Estimate wizard completion pushes `estimate_completed`.
- Contact form success pushes `contact_form_submit_success`.
- WhatsApp and phone links push their respective events when configured.
- Demo links push `demo_click`.
