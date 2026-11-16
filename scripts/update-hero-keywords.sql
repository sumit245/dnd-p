-- SEOptimer fix: keyword consistency. The H1 carried none of the terms the
-- title tag targets (custom ERP / CRM software); it now does. The DB value
-- overrides the PHP fallback in index.php, so this has to run on each
-- environment -- or be pasted into Admin > Settings > Hero Title.
UPDATE `site_settings`
   SET `value` = 'Custom ERP software for your operations. Custom CRM software for your sales team. Custom dashboards for your data.'
 WHERE `key_name` = 'hero_title';

UPDATE `site_settings`
   SET `value` = 'Dashandots builds custom ERP, CRM, dashboards, portals and mobile apps for growing Indian businesses in Gurugram and Delhi NCR: scoped around how you actually work, owned by you, supported after launch.'
 WHERE `key_name` = 'hero_description';
