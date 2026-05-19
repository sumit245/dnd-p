<style>
  :root{--accent:#C8293E;--accent-dark:#9E1E2F;--accent-light:#FEF2F4;--bg:#FAFAF8;--surface:#fff;--surface-2:#F4F3EF;--text-1:#111;--text-2:#4A4A4A;--text-3:#6B6B6B;--border:rgba(0,0,0,.07);--border-2:rgba(0,0,0,.13);--shadow-sm:0 1px 4px rgba(0,0,0,.06);--shadow-md:0 4px 20px rgba(0,0,0,.08);--r-sm:8px;--r-md:12px;--r-xl:28px;--max:1200px;--nav-h:68px}
  *,::after,::before{box-sizing:border-box;margin:0;padding:0}
  html{font-size:16px;scroll-behavior:smooth}
  body{font-family:system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;background:var(--bg);color:var(--text-1);line-height:1.6;-webkit-font-smoothing:antialiased}
  img{max-width:100%;display:block}
  a{color:inherit;text-decoration:none}
  ul{list-style:none}
  button{font:inherit;cursor:pointer}
  .container{max-width:var(--max);margin:0 auto;padding:0 24px}
  .skip-link{position:absolute;left:16px;top:-48px;z-index:200;padding:10px 16px;border-radius:var(--r-sm);background:var(--text-1);color:#fff;font-size:14px;font-weight:600}
  .skip-link:focus-visible{top:16px}
  .navbar{position:fixed;top:0;left:0;right:0;z-index:100;height:var(--nav-h);background:rgba(250,250,248,.92);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);border-bottom:.5px solid var(--border)}
  .nav-inner{height:var(--nav-h);max-width:var(--max);margin:0 auto;padding:0 24px;display:flex;align-items:center;justify-content:space-between}
  .nav-logo{display:flex;align-items:center;gap:10px;font-weight:700;font-size:15px;letter-spacing:-.01em}
  .nav-logo picture,.footer-brand picture{display:inline-flex;align-items:center;flex-shrink:0}
  .nav-logo img{width:32px;height:32px;border-radius:4px;flex-shrink:0}
  .nav-links,.nav-actions{display:flex;align-items:center;gap:6px}
  .nav-links a,.nav-links button{font-size:14px;font-weight:500;color:var(--text-2);padding:6px 12px;border:0;background:transparent;white-space:nowrap}
  .btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:10px 20px;border-radius:var(--r-xl);font-size:14px;font-weight:600;border:0;white-space:nowrap}
  .btn-primary{background:var(--accent);color:#fff}
  .btn-outline{background:transparent;color:var(--text-1);border:1.5px solid var(--border-2)}
  .hamburger,.mobile-sticky-cta{display:none}
  .mobile-menu{display:none}
  #home{position:relative;padding-top:calc(var(--nav-h) + 60px);padding-bottom:80px;background:linear-gradient(90deg,rgba(250,250,248,.98) 0,rgba(250,250,248,.94) 38%,rgba(250,250,248,.68) 64%,rgba(250,250,248,.9) 100%),image-set(url('<?= asset_url('/assets/img/hero-corporate-bg.webp') ?>') type('image/webp'),url('<?= asset_url('/assets/img/hero-corporate-bg.png') ?>') type('image/png')) right center/cover no-repeat,var(--bg);overflow:hidden}
  .hero-grid{position:relative;z-index:1;display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center}
  .hero-tag{display:inline-flex;align-items:center;gap:8px;background:var(--accent-light);color:var(--accent);font-size:12px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;padding:6px 14px;border-radius:100px;margin-bottom:24px}
  .hero-h1{font-size:clamp(30px,4.2vw,48px);font-weight:700;letter-spacing:-.02em;line-height:1.12;margin-bottom:18px;color:var(--text-1)}
  .hero-h1 em{font-style:normal;color:var(--accent)}
  .hero-desc{font-size:16px;color:var(--text-2);line-height:1.65;margin-bottom:28px;max-width:560px}
  .hero-ctas{display:flex;flex-wrap:wrap;gap:12px;margin-bottom:40px}
  .hero-meta{display:flex;flex-wrap:wrap;gap:20px}
  .hero-diagram{position:relative;width:100%;aspect-ratio:1;max-width:480px;margin:0 auto}
  .hero-diagram svg{width:100%;height:100%}
  .svc-page,.page-wrap,.blog-listing{padding-top:calc(var(--nav-h) + 56px)}
  @media(max-width:900px){.nav-links,.nav-actions{display:none}.hamburger{display:flex;flex-direction:column;gap:5px;padding:8px;background:transparent;border:0}.hamburger span{width:22px;height:2px;background:var(--text-1);border-radius:2px}.hero-grid{grid-template-columns:1fr;gap:22px}.hero-diagram{max-width:320px;order:-1}}
  @media(max-width:768px){.container{padding:0 20px}#home{padding-top:calc(var(--nav-h) + 24px);padding-bottom:36px;background:linear-gradient(180deg,rgba(250,250,248,.96) 0,rgba(250,250,248,.95) 58%,var(--bg) 100%),image-set(url('<?= asset_url('/assets/img/hero-corporate-bg.webp') ?>') type('image/webp'),url('<?= asset_url('/assets/img/hero-corporate-bg.png') ?>') type('image/png')) 68% top/auto 52% no-repeat,var(--bg)}.hero-h1{font-size:clamp(32px,8vw,46px);line-height:1.08}.hero-desc{font-size:17px}.hero-ctas{flex-direction:column}.hero-ctas .btn{width:100%;min-height:48px}.hero-meta{display:none}}
  @media(max-width:480px){.container{padding:0 16px}.nav-inner{padding:0 16px}.nav-logo{font-size:16px}.nav-logo img{width:30px;height:30px}}
</style>
