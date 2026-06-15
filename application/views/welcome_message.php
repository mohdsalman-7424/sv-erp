<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AstroVeda ERP – Sacred Vedic Astrology Platform</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Cinzel:wght@400;600;700&family=Mulish:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
:root{
  --saffron:#FF6B00;--saffron-deep:#D45500;--saffron-light:#FF8C3A;
  --gold:#C8931A;--gold-light:#E8B84B;--gold-pale:#FDF3DC;--gold-bright:#F5C842;
  --navy:#0B1C3A;--navy-mid:#162B52;--navy-light:#1E3D6E;
  --cream:#FBF6EF;--cream-dark:#F2EAD8;--maroon:#7B1C1C;
  --text-dark:#1A1005;--text-mid:#3D2C1A;--text-muted:#7A6A52;
  --border:rgba(200,147,26,0.25);--border-strong:rgba(200,147,26,0.55);
  --shadow-gold:0 4px 32px rgba(200,147,26,0.18);
  --r:10px;--r-lg:18px;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Mulish',sans-serif;background:var(--cream);color:var(--text-dark);overflow-x:hidden}

/* NAV */
#nav{position:fixed;top:0;left:0;right:0;z-index:1000;background:rgba(11,28,58,0.97);backdrop-filter:blur(12px);border-bottom:1px solid rgba(200,147,26,0.3);padding:0 40px;display:flex;align-items:center;justify-content:space-between;height:72px}
.nav-brand{display:flex;align-items:center;gap:12px;text-decoration:none;cursor:pointer}
.nav-logo{width:44px;height:44px;background:linear-gradient(135deg,var(--gold),var(--saffron));border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Cinzel',serif;font-size:20px;color:white;font-weight:700;box-shadow:0 0 0 3px rgba(200,147,26,0.3)}
.nav-brand-name{font-family:'Cinzel',serif;font-size:18px;font-weight:700;color:var(--gold-light);letter-spacing:1px}
.nav-brand-sub{font-size:10px;color:rgba(255,255,255,0.5);letter-spacing:2px;text-transform:uppercase}
.nav-links{display:flex;gap:4px;list-style:none;align-items:center}
.nav-links a{color:rgba(255,255,255,0.8);text-decoration:none;font-size:13px;padding:8px 13px;border-radius:6px;font-weight:500;transition:all .2s;display:block;cursor:pointer}
.nav-links a:hover,.nav-links a.active{color:var(--gold-bright);background:rgba(200,147,26,0.12)}
.nav-ctas{display:flex;gap:10px;align-items:center}
.btn-nav-outline{color:var(--gold-light);border:1px solid rgba(200,147,26,0.4);padding:8px 16px;border-radius:6px;font-size:13px;font-weight:600;background:transparent;cursor:pointer;font-family:'Mulish',sans-serif;transition:all .2s}
.btn-nav-outline:hover{background:rgba(200,147,26,0.15)}
.btn-nav-solid{background:linear-gradient(135deg,var(--saffron),var(--saffron-deep));color:white;border:none;padding:8px 18px;border-radius:6px;font-size:13px;font-weight:700;cursor:pointer;font-family:'Mulish',sans-serif;transition:all .2s;box-shadow:0 2px 12px rgba(255,107,0,.3)}
.btn-nav-solid:hover{transform:translateY(-1px)}
.hamburger{display:none;flex-direction:column;gap:5px;cursor:pointer;background:none;border:none;padding:8px}
.hamburger span{width:22px;height:2px;background:rgba(255,255,255,0.8);border-radius:2px;display:block;transition:all .3s}
.mob-menu{display:none;position:fixed;top:72px;left:0;right:0;background:rgba(11,28,58,0.98);backdrop-filter:blur(16px);border-bottom:1px solid rgba(200,147,26,0.2);z-index:999;padding:12px 16px 20px;flex-direction:column;gap:2px}
.mob-menu.open{display:flex}
.mob-link{color:rgba(255,255,255,0.8);font-size:14px;padding:11px 14px;border-radius:8px;cursor:pointer;font-weight:500;border:none;background:none;text-align:left;font-family:'Mulish',sans-serif;width:100%}
.mob-link:hover{background:rgba(200,147,26,0.1);color:var(--gold-light)}
.mob-ctas{display:flex;gap:9px;padding:12px 14px 0;border-top:1px solid rgba(200,147,26,0.15);margin-top:8px}

/* PAGE */
.page{display:none;min-height:100vh;padding-top:72px}
.page.active{display:block}

/* BUTTONS */
.btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;border:none;border-radius:8px;font-family:'Mulish',sans-serif;font-weight:700;cursor:pointer;transition:all .2s;text-decoration:none;letter-spacing:.3px}
.btn-primary{background:linear-gradient(135deg,var(--saffron),var(--saffron-deep));color:white;padding:13px 28px;font-size:14px;box-shadow:0 4px 18px rgba(255,107,0,.3)}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 6px 24px rgba(255,107,0,.45)}
.btn-secondary{background:transparent;color:var(--gold);border:1.5px solid var(--gold);padding:12px 26px;font-size:14px}
.btn-secondary:hover{background:rgba(200,147,26,0.08)}
.btn-gold{background:linear-gradient(135deg,var(--gold),var(--gold-light));color:white;padding:13px 28px;font-size:14px;box-shadow:0 4px 18px rgba(200,147,26,.3)}
.btn-gold:hover{transform:translateY(-2px)}
.btn-sm{padding:9px 18px!important;font-size:12px!important}
.btn-navy{background:var(--navy);color:white;padding:7px 14px;font-size:12px;border-radius:7px;border:none;cursor:pointer;font-family:'Mulish',sans-serif;font-weight:700;transition:all .2s}
.btn-navy:hover{background:var(--navy-light)}
.btn-danger{background:#EF4444;color:white;border:none;padding:9px;border-radius:8px;font-weight:700;cursor:pointer;font-family:'Mulish',sans-serif;font-size:12px;width:100%}

/* LAYOUT */
.section{padding:80px 0}.section-sm{padding:48px 0}
.container{max-width:1200px;margin:0 auto;padding:0 40px}
.grid-2{display:grid;grid-template-columns:1fr 1fr;gap:24px}
.grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:24px}
.grid-4{display:grid;grid-template-columns:repeat(4,1fr);gap:20px}

/* TYPOGRAPHY */
.sec-label{display:inline-flex;align-items:center;gap:7px;background:var(--gold-pale);border:1px solid var(--border);color:var(--gold);padding:5px 14px;border-radius:100px;font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:14px}
.sec-label-dark{background:rgba(200,147,26,0.15);border-color:rgba(200,147,26,0.3);color:var(--gold-light)}
.sec-title{font-family:'Playfair Display',serif;font-size:clamp(24px,3.5vw,42px);font-weight:700;color:var(--navy);line-height:1.2;margin-bottom:14px}
.sec-title em{font-style:italic;color:var(--saffron)}
.sec-title-white{color:white}
.sec-sub{font-size:16px;color:var(--text-muted);line-height:1.7;max-width:580px}
.text-center{text-align:center}.text-center .sec-sub{margin:0 auto}
.cinzel{font-family:'Cinzel',serif}

/* CARD */
.card{background:white;border:1px solid var(--border);border-radius:var(--r-lg);overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.04)}
.card-body{padding:22px}
.card-title{font-family:'Playfair Display',serif;font-size:16px;font-weight:700;color:var(--navy);margin-bottom:14px;display:flex;justify-content:space-between;align-items:center}
.card-title a{font-size:12px;font-weight:600;color:var(--gold);text-decoration:none;font-family:'Mulish',sans-serif;cursor:pointer}

/* HERO */
.hero{background:var(--navy);min-height:100vh;position:relative;overflow:hidden;display:flex;align-items:center}
.hero-bg{position:absolute;inset:0;background:radial-gradient(ellipse 800px 600px at 70% 50%,rgba(200,147,26,.1) 0%,transparent 60%),radial-gradient(ellipse 400px 400px at 5% 80%,rgba(255,107,0,.07) 0%,transparent 50%)}
.hero-stars{position:absolute;inset:0;overflow:hidden;pointer-events:none}
.star{position:absolute;border-radius:50%;background:white;animation:twinkle var(--d,3s) ease-in-out infinite alternate}
@keyframes twinkle{from{opacity:.15;transform:scale(.7)}to{opacity:1;transform:scale(1.3)}}
.hero-inner{position:relative;z-index:2;display:grid;grid-template-columns:1fr 1fr;gap:56px;align-items:center;width:100%;max-width:1200px;margin:0 auto;padding:40px}
.hero-badge{display:inline-flex;align-items:center;gap:7px;background:rgba(200,147,26,.15);border:1px solid rgba(200,147,26,.4);color:var(--gold-light);padding:7px 16px;border-radius:100px;font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:22px}
.hero-title{font-family:'Cinzel',serif;font-size:clamp(28px,4vw,58px);font-weight:700;color:white;line-height:1.1;margin-bottom:18px;letter-spacing:.5px}
.hero-title .gold{color:var(--gold-bright)}.hero-title .saf{color:var(--saffron-light)}
.hero-shloka{font-style:italic;font-size:14px;color:rgba(255,255,255,.45);margin-bottom:20px;line-height:1.8;border-left:2px solid rgba(200,147,26,.35);padding-left:14px}
.hero-desc{font-size:15px;color:rgba(255,255,255,.65);line-height:1.75;margin-bottom:32px}
.hero-btns{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:36px}
.hero-stats{display:flex;gap:28px;flex-wrap:wrap;border-top:1px solid rgba(200,147,26,.15);padding-top:28px}
.hero-stat-n{font-family:'Cinzel',serif;font-size:22px;font-weight:700;color:var(--gold-bright);display:block}
.hero-stat-l{font-size:11px;color:rgba(255,255,255,.45)}

/* KUNDLI VISUAL */
.kundli-card{background:rgba(22,43,82,.85);border:1px solid rgba(200,147,26,.3);border-radius:18px;padding:26px;backdrop-filter:blur(16px);box-shadow:0 20px 60px rgba(0,0,0,.4)}
.kundli-head{text-align:center;margin-bottom:18px}
.kundli-head h3{font-family:'Cinzel',serif;color:var(--gold-bright);font-size:16px;margin-bottom:3px}
.kundli-head p{font-size:10px;color:rgba(255,255,255,.35);letter-spacing:1px}
.kundli-chart{background:rgba(11,28,58,.6);border:1px solid rgba(200,147,26,.15);border-radius:10px;padding:10px;margin-bottom:14px}
.k-planets{display:grid;grid-template-columns:1fr 1fr;gap:6px}
.k-planet{display:flex;align-items:center;gap:7px;background:rgba(255,255,255,.04);border:1px solid rgba(200,147,26,.12);border-radius:7px;padding:6px 8px}
.k-dot{width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0}
.k-pname{font-size:10px;color:rgba(255,255,255,.45)}
.k-ppos{font-size:11px;color:rgba(255,255,255,.85);font-weight:600}

/* TICKER */
.ticker{background:var(--navy);border-top:1px solid rgba(200,147,26,.25);border-bottom:1px solid rgba(200,147,26,.25);padding:11px 0;overflow:hidden}
.ticker-wrap{display:flex;gap:56px;width:max-content;animation:ticker 38s linear infinite}
@keyframes ticker{from{transform:translateX(0)}to{transform:translateX(-50%)}}
.tick-item{display:flex;align-items:center;gap:9px;color:rgba(255,255,255,.65);font-size:13px;white-space:nowrap}
.tick-dot{width:4px;height:4px;border-radius:50%;background:var(--gold);flex-shrink:0}
.tick-gold{color:var(--gold-bright);font-weight:700}

/* FEATURES STRIP */
.feat-strip{background:white;border-bottom:1px solid var(--border)}
.feat-strip-inner{display:grid;grid-template-columns:repeat(4,1fr);max-width:1200px;margin:0 auto;padding:0 40px}
.feat-item{display:flex;align-items:center;gap:13px;padding:20px 14px;border-right:1px solid var(--border)}
.feat-item:last-child{border-right:none}
.feat-icon{width:44px;height:44px;border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0}
.feat-text h4{font-size:13px;font-weight:700;color:var(--navy);margin-bottom:2px}
.feat-text p{font-size:11px;color:var(--text-muted)}

/* PANCHANG */
.panchang-grid{background:var(--navy);border:1px solid rgba(200,147,26,.3);border-radius:var(--r-lg);padding:30px;display:grid;grid-template-columns:repeat(6,1fr);gap:16px}
.panch-item{text-align:center}
.panch-label{font-size:10px;color:rgba(255,255,255,.35);letter-spacing:1px;text-transform:uppercase;margin-bottom:5px}
.panch-val{font-family:'Cinzel',serif;font-size:16px;font-weight:700;color:var(--gold-bright)}
.panch-sub{font-size:10px;color:rgba(255,255,255,.4);margin-top:2px}

/* RASHIS */
.rashi-grid{display:grid;grid-template-columns:repeat(6,1fr);gap:13px}
.rashi-card{background:white;border:1px solid var(--border);border-radius:var(--r);padding:16px 10px;text-align:center;cursor:pointer;transition:all .22s}
.rashi-card:hover{background:var(--gold-pale);border-color:var(--gold);transform:translateY(-3px);box-shadow:var(--shadow-gold)}
.rashi-sym{font-size:28px;display:block;margin-bottom:5px}
.rashi-hi{font-size:13px;color:var(--gold);font-weight:700;margin-bottom:1px}
.rashi-en{font-family:'Cinzel',serif;font-size:11px;color:var(--navy)}

/* ASTROLOGER CARDS */
.astro-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:22px}
.astro-card{background:white;border:1px solid var(--border);border-radius:var(--r-lg);overflow:hidden;transition:all .3s;cursor:pointer}
.astro-card:hover{transform:translateY(-4px);box-shadow:var(--shadow-gold);border-color:var(--gold)}
.astro-img{height:190px;position:relative;display:flex;align-items:center;justify-content:center;overflow:hidden}
.astro-ava{width:86px;height:86px;border-radius:50%;border:3px solid var(--gold);font-family:'Cinzel',serif;font-size:30px;font-weight:700;color:var(--gold-bright);background:rgba(200,147,26,.15);display:flex;align-items:center;justify-content:center}
.astro-online{position:absolute;top:11px;right:11px;background:#22C55E;color:white;font-size:10px;font-weight:700;padding:3px 8px;border-radius:100px}
.astro-exp{position:absolute;bottom:11px;left:11px;background:rgba(11,28,58,.85);color:var(--gold-light);font-size:10px;font-weight:600;padding:3px 8px;border-radius:5px;border:1px solid rgba(200,147,26,.25)}
.astro-body{padding:16px}
.astro-name{font-family:'Playfair Display',serif;font-size:16px;font-weight:700;color:var(--navy);margin-bottom:3px}
.astro-spec{font-size:11px;color:var(--text-muted);margin-bottom:8px}
.astro-stars{color:var(--gold);font-size:12px;letter-spacing:1px}
.astro-rnum{font-size:12px;font-weight:700;color:var(--text-dark)}
.astro-rcnt{font-size:11px;color:var(--text-muted)}
.astro-footer{display:flex;justify-content:space-between;align-items:center;border-top:1px solid var(--border);padding-top:10px;margin-top:8px}
.price-tag{font-family:'Cinzel',serif;font-size:14px;font-weight:700;color:var(--saffron)}
.price-unit{font-size:11px;color:var(--text-muted)}

/* PLANS */
.plans-section{background:var(--navy);position:relative;overflow:hidden}
.plans-section::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 700px 500px at 80% 50%,rgba(200,147,26,.07) 0%,transparent 60%)}
.plans-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(230px,1fr));gap:20px;position:relative;z-index:1}
.plan-card{background:rgba(22,43,82,.7);border:1px solid rgba(200,147,26,.2);border-radius:var(--r-lg);padding:26px;position:relative;transition:all .3s}
.plan-card:hover{border-color:rgba(200,147,26,.5);transform:translateY(-4px)}
.plan-card.popular{border-color:var(--gold);background:rgba(200,147,26,.1);box-shadow:0 0 0 1px var(--gold),var(--shadow-gold)}
.plan-popular-badge{position:absolute;top:-12px;left:50%;transform:translateX(-50%);background:linear-gradient(135deg,var(--gold),var(--saffron));color:white;font-size:10px;font-weight:800;padding:4px 14px;border-radius:100px;letter-spacing:1px;text-transform:uppercase;white-space:nowrap}
.plan-icon{font-size:30px;margin-bottom:12px}
.plan-name{font-family:'Cinzel',serif;font-size:18px;font-weight:700;color:white;margin-bottom:4px}
.plan-tag{font-size:11px;color:rgba(255,255,255,.45);margin-bottom:16px}
.plan-price-row{display:flex;align-items:baseline;gap:3px;margin-bottom:3px}
.plan-curr{font-size:17px;color:var(--gold);font-weight:600}
.plan-amt{font-family:'Cinzel',serif;font-size:34px;font-weight:700;color:var(--gold-bright)}
.plan-period{font-size:11px;color:rgba(255,255,255,.35);margin-bottom:20px}
.plan-feats{list-style:none;margin-bottom:22px}
.plan-feats li{display:flex;align-items:center;gap:8px;font-size:12px;color:rgba(255,255,255,.7);padding:5px 0;border-bottom:1px solid rgba(255,255,255,.05)}
.plan-feats li::before{content:'✦';color:var(--gold);font-size:9px;flex-shrink:0}
.plan-feats li.no{opacity:.3}
.plan-feats li.no::before{content:'✕';color:#888}

/* TESTIMONIALS */
.testi-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(290px,1fr));gap:20px}
.testi-card{background:white;border:1px solid var(--border);border-radius:var(--r-lg);padding:22px}
.testi-q{font-size:48px;color:var(--gold);line-height:.5;font-family:Georgia,serif;margin-bottom:9px;display:block;opacity:.35}
.testi-text{font-style:italic;font-size:13px;color:var(--text-mid);line-height:1.8;margin-bottom:16px}
.testi-author{display:flex;align-items:center;gap:11px}
.testi-ava{width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,var(--saffron),var(--gold));display:flex;align-items:center;justify-content:center;font-weight:700;color:white;font-size:14px;flex-shrink:0}
.testi-name{font-size:13px;font-weight:700;color:var(--navy)}
.testi-loc{font-size:11px;color:var(--text-muted)}

/* TRUST BADGES */
.trust-badges{display:flex;gap:12px;flex-wrap:wrap}
.trust-badge{display:flex;align-items:center;gap:6px;background:var(--gold-pale);border:1px solid var(--border);padding:6px 13px;border-radius:100px;font-size:12px;font-weight:600;color:var(--text-mid)}

/* BLOG */
.blog-grid{display:grid;grid-template-columns:2fr 1fr 1fr;gap:20px}
.blog-card{background:white;border:1px solid var(--border);border-radius:var(--r-lg);overflow:hidden;cursor:pointer;transition:all .3s}
.blog-card:hover{transform:translateY(-3px);box-shadow:var(--shadow-gold);border-color:var(--gold)}
.blog-img{height:170px;display:flex;align-items:center;justify-content:center;font-size:44px;position:relative}
.blog-img-lg{height:230px}
.blog-tag-badge{position:absolute;top:10px;left:10px;background:var(--saffron);color:white;font-size:9px;font-weight:800;padding:3px 8px;border-radius:3px;letter-spacing:.5px;text-transform:uppercase}
.blog-body{padding:16px}
.blog-title{font-family:'Playfair Display',serif;font-size:14px;font-weight:700;color:var(--navy);margin-bottom:6px;line-height:1.4}
.blog-card.featured .blog-title{font-size:19px}
.blog-meta{font-size:11px;color:var(--text-muted);display:flex;gap:7px;flex-wrap:wrap}

/* FOOTER */
footer{background:var(--navy);border-top:1px solid rgba(200,147,26,.2);padding:56px 0 22px}
.footer-grid{display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:36px;margin-bottom:36px}
.footer-logo{font-family:'Cinzel',serif;font-size:22px;color:var(--gold-bright);margin-bottom:11px}
.footer-desc{font-size:13px;color:rgba(255,255,255,.45);line-height:1.7;margin-bottom:16px}
.footer-social{display:flex;gap:8px}
.footer-soc-btn{width:33px;height:33px;border-radius:7px;border:1px solid rgba(200,147,26,.25);background:transparent;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.45);cursor:pointer;font-size:12px;transition:all .2s}
.footer-soc-btn:hover{border-color:var(--gold);color:var(--gold-bright)}
.footer-col-title{font-family:'Cinzel',serif;font-size:12px;font-weight:600;color:var(--gold-light);margin-bottom:13px;letter-spacing:1px}
.footer-links{list-style:none;display:flex;flex-direction:column;gap:8px}
.footer-links li a,.footer-links li span{font-size:12px;color:rgba(255,255,255,.45);text-decoration:none;cursor:pointer;transition:color .2s}
.footer-links li a:hover,.footer-links li span:hover{color:var(--gold-light)}
.footer-bottom{border-top:1px solid rgba(200,147,26,.12);padding-top:20px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px}
.footer-bottom p{font-size:11px;color:rgba(255,255,255,.3)}

/* PAGE HERO SMALL */
.page-hero-sm{background:linear-gradient(135deg,var(--navy),var(--navy-mid));padding:46px 0;text-align:center}
.page-hero-sm h1{font-family:'Cinzel',serif;font-size:clamp(22px,4vw,36px);color:white;font-weight:700;margin-bottom:7px}
.page-hero-sm p{font-size:13px;color:rgba(255,255,255,.45)}

/* FORMS */
.form-card{background:white;border:1px solid var(--border);border-radius:var(--r-lg);padding:34px;box-shadow:var(--shadow-gold)}
.form-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.form-group{display:flex;flex-direction:column;gap:5px}
.form-group.full{grid-column:1/-1}
.form-label{font-size:12px;font-weight:700;color:var(--navy);letter-spacing:.3px}
.form-label .req{color:var(--saffron)}
.form-input,.form-select,.form-textarea{border:1px solid var(--border-strong);border-radius:8px;padding:10px 13px;font-size:13px;color:var(--text-dark);font-family:'Mulish',sans-serif;background:white;transition:all .2s;outline:none;width:100%}
.form-input:focus,.form-select:focus,.form-textarea:focus{border-color:var(--gold);box-shadow:0 0 0 3px rgba(200,147,26,.1)}
.form-input::placeholder{color:#bbb}
.input-wrap{position:relative}
.input-icon{position:absolute;left:12px;top:50%;transform:translateY(-50%);font-size:14px;pointer-events:none}
.input-wrap .form-input{padding-left:38px}

/* PLANET TABLE */
.planet-table{width:100%;border-collapse:collapse}
.planet-table th{background:var(--navy);color:var(--gold-light);font-size:11px;font-weight:700;padding:9px 11px;text-align:left;letter-spacing:.4px}
.planet-table td{padding:8px 11px;font-size:12px;border-bottom:1px solid var(--border);color:var(--text-dark)}
.planet-table tr:last-child td{border-bottom:none}
.planet-table tr:hover td{background:var(--gold-pale)}

/* DASHA */
.dasha-row{display:flex;align-items:center;gap:10px;padding:9px 0;border-bottom:1px solid var(--border)}
.dasha-dot{width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:10px;flex-shrink:0}
.dasha-bar-wrap{width:72px;background:var(--cream-dark);border-radius:3px;height:4px}
.dasha-bar{height:4px;border-radius:3px;background:var(--gold)}

/* DASHBOARD */
.dash-layout{display:grid;grid-template-columns:245px 1fr;min-height:calc(100vh - 72px)}
.sidebar{background:var(--navy);border-right:1px solid rgba(200,147,26,.12);padding:22px 0;position:sticky;top:72px;height:calc(100vh - 72px);overflow-y:auto}
.sidebar-sec{font-size:10px;color:rgba(255,255,255,.25);letter-spacing:2px;text-transform:uppercase;padding:13px 20px 6px}
.sidebar-item{display:flex;align-items:center;gap:10px;padding:10px 20px;color:rgba(255,255,255,.6);font-size:13px;font-weight:500;cursor:pointer;transition:all .2s;border-left:3px solid transparent}
.sidebar-item:hover{color:white;background:rgba(255,255,255,.05)}
.sidebar-item.active{color:var(--gold-bright);background:rgba(200,147,26,.09);border-left-color:var(--gold)}
.sidebar-icon{font-size:15px;width:18px;text-align:center}
.sidebar-badge{margin-left:auto;background:var(--saffron);color:white;font-size:9px;font-weight:800;padding:2px 6px;border-radius:100px}
.dash-main{background:var(--cream);padding:26px;overflow-y:auto}
.kpi-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:15px;margin-bottom:20px}
.kpi-card{background:white;border:1px solid var(--border);border-radius:var(--r);padding:18px}
.kpi-label{font-size:10px;font-weight:700;color:var(--text-muted);letter-spacing:.5px;text-transform:uppercase;margin-bottom:6px}
.kpi-val{font-family:'Cinzel',serif;font-size:24px;font-weight:700;color:var(--navy);margin-bottom:4px}
.kpi-change{font-size:11px;font-weight:700}
.kpi-up{color:#22C55E}.kpi-down{color:#EF4444}.kpi-warn{color:var(--gold)}
.activity-item{display:flex;gap:10px;padding:9px 0;border-bottom:1px solid var(--border)}
.activity-item:last-child{border-bottom:none}
.act-dot{width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0}
.act-text{font-size:12px;color:var(--text-dark);line-height:1.5}
.act-time{font-size:10px;color:var(--text-muted);margin-top:2px}

/* AUTH */
.auth-split{display:grid;grid-template-columns:1fr 1fr;min-height:calc(100vh - 72px)}
.auth-left{background:var(--navy);position:relative;display:flex;flex-direction:column;justify-content:center;padding:56px;overflow:hidden}
.auth-left::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 500px 500px at 50% 50%,rgba(200,147,26,.1) 0%,transparent 70%)}
.auth-left-content{position:relative;z-index:1}
.auth-left h2{font-family:'Cinzel',serif;font-size:clamp(22px,3vw,34px);color:white;font-weight:700;margin-bottom:12px;line-height:1.2}
.auth-left h2 span{color:var(--gold-bright)}
.auth-left p{font-size:13px;color:rgba(255,255,255,.55);line-height:1.7}
.auth-feature{display:flex;align-items:center;gap:9px;color:rgba(255,255,255,.7);font-size:13px;margin-top:10px}
.auth-feature::before{content:'✦';color:var(--gold);font-size:10px}
.auth-right{background:var(--cream);display:flex;align-items:center;justify-content:center;padding:36px 24px}
.auth-card{width:100%;max-width:410px;background:white;border:1px solid var(--border);border-radius:var(--r-lg);padding:34px;box-shadow:var(--shadow-gold)}
.auth-logo{text-align:center;margin-bottom:20px}
.auth-logo .om{font-size:32px;color:var(--saffron);display:block}
.auth-logo h3{font-family:'Cinzel',serif;font-size:19px;color:var(--navy)}
.auth-title{font-family:'Playfair Display',serif;font-size:21px;font-weight:700;color:var(--navy);margin-bottom:4px}
.auth-sub{font-size:12px;color:var(--text-muted);margin-bottom:20px}
.social-btn{width:100%;display:flex;align-items:center;justify-content:center;gap:9px;background:white;border:1px solid var(--border-strong);padding:10px;border-radius:8px;font-size:13px;font-weight:600;color:var(--text-dark);cursor:pointer;font-family:'Mulish',sans-serif;transition:all .2s;margin-bottom:8px}
.social-btn:hover{background:var(--cream);border-color:var(--gold)}
.auth-divider{text-align:center;font-size:11px;color:var(--text-muted);margin:13px 0;position:relative}
.auth-divider::before,.auth-divider::after{content:'';position:absolute;top:50%;width:calc(50% - 16px);height:1px;background:var(--border-strong)}
.auth-divider::before{left:0}.auth-divider::after{right:0}
.auth-footer{text-align:center;margin-top:16px;font-size:12px;color:var(--text-muted)}
.auth-footer a{color:var(--saffron);font-weight:700;text-decoration:none;cursor:pointer}
.forgot-link{font-size:11px;color:var(--gold);text-decoration:none;font-weight:600}

/* CONSULTATION */
.consult-layout{display:grid;grid-template-columns:1fr 320px;gap:24px}
.chat-win{background:white;border:1px solid var(--border);border-radius:var(--r-lg);display:flex;flex-direction:column;height:560px}
.chat-head{padding:13px 16px;background:var(--navy);border-radius:var(--r-lg) var(--r-lg) 0 0;display:flex;align-items:center;gap:10px}
.chat-ava{width:40px;height:40px;border-radius:50%;background:rgba(200,147,26,.2);border:2px solid var(--gold);display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:700;color:var(--gold-bright)}
.chat-msgs{flex:1;padding:16px;overflow-y:auto;display:flex;flex-direction:column;gap:13px}
.msg-in{align-self:flex-start;max-width:72%}
.msg-out{align-self:flex-end;max-width:72%}
.msg-bubble{padding:10px 13px;border-radius:11px;font-size:13px;line-height:1.6}
.msg-in .msg-bubble{background:var(--cream);border-radius:3px 11px 11px 11px}
.msg-out .msg-bubble{background:var(--navy);color:white;border-radius:11px 3px 11px 11px}
.msg-time{font-size:10px;color:var(--text-muted);margin-top:3px}
.msg-out .msg-time{text-align:right}
.chat-bar{padding:12px 14px;border-top:1px solid var(--border);display:flex;gap:8px}
.chat-input{flex:1;border:1px solid var(--border-strong);border-radius:100px;padding:9px 16px;font-size:13px;font-family:'Mulish',sans-serif;outline:none}
.chat-input:focus{border-color:var(--gold)}
.chat-send{width:40px;height:40px;border-radius:50%;background:var(--navy);border:none;cursor:pointer;color:white;font-size:15px;flex-shrink:0;transition:all .2s}
.chat-send:hover{background:var(--saffron)}
.sidebar-card{background:white;border:1px solid var(--border);border-radius:var(--r-lg);padding:20px;margin-bottom:16px}
.sidebar-card-title{font-family:'Playfair Display',serif;font-size:14px;font-weight:700;color:var(--navy);margin-bottom:12px}
.slot-grid{display:grid;grid-template-columns:1fr 1fr;gap:7px}
.slot-btn{padding:9px;border:1px solid var(--border-strong);border-radius:7px;font-size:11px;font-weight:600;color:var(--text-dark);cursor:pointer;transition:all .2s;text-align:center;background:white}
.slot-btn.taken{opacity:.35;cursor:not-allowed;background:var(--cream-dark)}
.slot-btn.sel{background:var(--navy);color:white;border-color:var(--navy)}
.slot-btn:not(.taken):hover{border-color:var(--gold);background:var(--gold-pale)}

/* SHOP */
.shop-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:20px}
.gem-card{background:white;border:1px solid var(--border);border-radius:var(--r-lg);overflow:hidden;transition:all .3s;cursor:pointer}
.gem-card:hover{transform:translateY(-3px);box-shadow:var(--shadow-gold);border-color:var(--gold)}
.gem-img{height:160px;position:relative;display:flex;align-items:center;justify-content:center;font-size:50px}
.gem-badge-tag{position:absolute;top:8px;right:8px;background:var(--saffron);color:white;font-size:9px;font-weight:800;padding:2px 8px;border-radius:3px}
.gem-body{padding:13px}
.gem-name{font-family:'Playfair Display',serif;font-size:14px;font-weight:700;color:var(--navy);margin-bottom:2px}
.gem-planet{font-size:10px;color:var(--gold);font-weight:700;margin-bottom:6px}
.gem-desc{font-size:11px;color:var(--text-muted);line-height:1.5;margin-bottom:10px}
.gem-price-row{display:flex;justify-content:space-between;align-items:center}
.gem-price{font-family:'Cinzel',serif;font-size:16px;font-weight:700;color:var(--saffron)}
.gem-mrp{font-size:10px;color:var(--text-muted);text-decoration:line-through}

/* PROFILE */
.profile-header{background:linear-gradient(135deg,var(--navy),var(--navy-light));border-radius:var(--r-lg);padding:30px;margin-bottom:22px;display:flex;gap:22px;align-items:flex-start;border:1px solid rgba(200,147,26,.25);flex-wrap:wrap}
.profile-ava-wrap{position:relative}
.profile-ava{width:86px;height:86px;border-radius:50%;border:3px solid var(--gold);background:rgba(200,147,26,.18);display:flex;align-items:center;justify-content:center;font-family:'Cinzel',serif;font-size:30px;font-weight:700;color:var(--gold-bright)}
.profile-edit{position:absolute;bottom:0;right:0;width:26px;height:26px;border-radius:50%;background:var(--saffron);border:none;cursor:pointer;color:white;font-size:11px;display:flex;align-items:center;justify-content:center}
.profile-name-big{font-family:'Playfair Display',serif;font-size:22px;font-weight:700;color:white;margin-bottom:3px}
.profile-since{font-size:11px;color:rgba(255,255,255,.45);margin-bottom:12px}
.profile-badges{display:flex;gap:7px;flex-wrap:wrap}
.profile-badge-chip{background:rgba(200,147,26,.12);border:1px solid rgba(200,147,26,.25);color:var(--gold-light);font-size:10px;font-weight:600;padding:3px 10px;border-radius:100px}
.profile-stats{display:flex;gap:24px;margin-left:auto;flex-wrap:wrap}
.profile-stat-n{font-family:'Cinzel',serif;font-size:20px;font-weight:700;color:var(--gold-bright)}
.profile-stat-l{font-size:10px;color:rgba(255,255,255,.4)}

/* MATCHMAKING */
.match-result-grid{display:grid;grid-template-columns:1fr auto 1fr;gap:20px;align-items:start}
.match-circle{width:105px;height:105px;border-radius:50%;border:5px solid var(--gold);background:var(--navy);display:flex;flex-direction:column;align-items:center;justify-content:center;color:var(--gold-bright);align-self:center}
.match-circle-n{font-family:'Cinzel',serif;font-size:28px;font-weight:700}
.match-circle-l{font-size:9px;opacity:.55}
.match-row{display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid var(--border);font-size:11px}
.match-row:last-child{border-bottom:none}
.match-aspect{font-weight:700;color:var(--navy)}
.match-dots{flex:1;border-bottom:1px dotted var(--border-strong);margin:0 7px}
.match-bar{width:50px;height:4px;background:var(--cream-dark);border-radius:2px;overflow:hidden}
.match-fill{height:4px;border-radius:2px}
.fill-g{background:#22C55E}.fill-y{background:var(--gold)}.fill-r{background:#EF4444}

/* ABOUT */
.about-hero-sec{background:linear-gradient(135deg,var(--navy),var(--navy-mid));padding:64px 0;text-align:center}
.team-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px}
.team-card{text-align:center;background:white;border:1px solid var(--border);border-radius:var(--r-lg);padding:22px 13px}
.team-ava{width:68px;height:68px;border-radius:50%;margin:0 auto 11px;border:2px solid var(--gold);background:var(--navy);display:flex;align-items:center;justify-content:center;font-family:'Cinzel',serif;font-size:24px;color:var(--gold-bright)}
.team-name-t{font-family:'Playfair Display',serif;font-size:14px;font-weight:700;color:var(--navy);margin-bottom:2px}
.team-role-t{font-size:10px;color:var(--gold);font-weight:600}

/* FAQ */
.faq-item{background:white;border:1px solid var(--border);border-radius:var(--r);margin-bottom:9px;overflow:hidden}
.faq-q{padding:15px 18px;font-weight:700;font-size:14px;color:var(--navy);cursor:pointer;display:flex;justify-content:space-between;align-items:center;user-select:none}
.faq-a{padding:0 18px 15px;font-size:13px;color:var(--text-muted);line-height:1.7;display:none}
.faq-item.open .faq-a{display:block}
.faq-item.open .faq-q{color:var(--saffron)}
.faq-arrow{transition:transform .2s}
.faq-item.open .faq-arrow{transform:rotate(180deg)}

/* CONTACT */
.contact-info-item{display:flex;gap:13px;align-items:flex-start;margin-bottom:22px}
.contact-icon-box{width:44px;height:44px;border-radius:11px;background:var(--gold-pale);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:17px;flex-shrink:0}
.contact-label-t{font-size:10px;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:2px}
.contact-val{font-size:13px;font-weight:600;color:var(--navy)}

/* NOTIFICATION */
.notif-list{display:flex;flex-direction:column;gap:10px;max-width:680px;margin:0 auto}
.notif-item{display:flex;gap:13px;background:white;border:1px solid var(--border);border-radius:var(--r);padding:15px;transition:all .2s}
.notif-item.unread{border-left:3px solid var(--saffron)}
.notif-icon-box{width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0}
.notif-title{font-size:13px;font-weight:700;color:var(--navy);margin-bottom:3px}
.notif-desc{font-size:12px;color:var(--text-muted);line-height:1.5}
.notif-time{font-size:10px;color:var(--text-muted);margin-top:4px}
.notif-new{background:var(--saffron);color:white;font-size:8px;font-weight:800;padding:2px 6px;border-radius:100px;margin-left:6px}

/* SUCCESS */
.success-card{max-width:560px;margin:60px auto;background:white;border:1px solid var(--border);border-radius:var(--r-lg);padding:48px;text-align:center;box-shadow:var(--shadow-gold)}
.success-icon{font-size:58px;margin-bottom:16px;display:block}
.success-title{font-family:'Playfair Display',serif;font-size:28px;font-weight:700;color:var(--navy);margin-bottom:9px}
.success-desc{font-size:13px;color:var(--text-muted);line-height:1.7;margin-bottom:24px}
.order-box{background:var(--cream);border:1px solid var(--border);border-radius:var(--r);padding:20px;text-align:left;margin-bottom:24px}
.order-row{display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid var(--border);font-size:12px}
.order-row:last-child{border-bottom:none;font-weight:700;color:var(--navy);font-size:13px}

/* TAGS */
.tag{display:inline-flex;background:var(--gold-pale);border:1px solid var(--border);color:var(--gold);font-size:10px;font-weight:700;padding:2px 8px;border-radius:100px}
.tag-saf{background:rgba(255,107,0,.07);border-color:rgba(255,107,0,.18);color:var(--saffron-deep)}
.breadcrumb{display:flex;align-items:center;gap:6px;font-size:11px;color:var(--text-muted);margin-bottom:20px}
.breadcrumb .sep{color:var(--gold)}
.breadcrumb a{color:var(--text-muted);text-decoration:none;cursor:pointer}
.breadcrumb a:hover{color:var(--navy)}
.filter-chip{padding:7px 15px;border:1px solid var(--border-strong);border-radius:100px;font-size:12px;font-weight:600;color:var(--text-mid);cursor:pointer;transition:all .2s;background:white;font-family:'Mulish',sans-serif}
.filter-chip:hover,.filter-chip.active{background:var(--navy);color:white;border-color:var(--navy)}
.filter-select{padding:7px 13px;border:1px solid var(--border-strong);border-radius:8px;font-size:12px;color:var(--text-dark);font-family:'Mulish',sans-serif;background:white;cursor:pointer;outline:none}

/* QUICK NAV */
#quickNav{position:fixed;bottom:18px;right:18px;z-index:2000;display:flex;flex-direction:column;gap:5px}
#quickNav button{background:var(--navy);color:var(--gold-light);border:1px solid rgba(200,147,26,.3);padding:7px 11px;border-radius:8px;font-size:10px;cursor:pointer;font-family:'Mulish',sans-serif;font-weight:600;white-space:nowrap;text-align:left;transition:all .2s}
#quickNav button:hover{background:var(--navy-light);border-color:var(--gold)}

/* ===== RESPONSIVE ===== */
@media(max-width:1100px){
  .hero-inner{grid-template-columns:1fr;gap:36px;padding:32px 24px}
  .hero-visual{display:none}
  .feat-strip-inner{grid-template-columns:1fr 1fr}
  .feat-item:nth-child(2){border-right:none}
  .feat-item:nth-child(3){border-top:1px solid var(--border);border-right:1px solid var(--border)}
  .feat-item:nth-child(4){border-top:1px solid var(--border);border-right:none}
  .rashi-grid{grid-template-columns:repeat(4,1fr)}
  .plans-grid{grid-template-columns:1fr 1fr}
  .blog-grid{grid-template-columns:1fr 1fr}
  .blog-card:last-child{grid-column:span 2}
  .footer-grid{grid-template-columns:1fr 1fr;gap:26px}
  .panchang-grid{grid-template-columns:repeat(3,1fr)}
  .dash-layout{grid-template-columns:220px 1fr}
  .kpi-grid{grid-template-columns:1fr 1fr}
  .grid-3{grid-template-columns:1fr 1fr}
  .team-grid{grid-template-columns:1fr 1fr}
}
@media(max-width:768px){
  #nav{padding:0 14px}
  .nav-links,.nav-ctas{display:none}
  .hamburger{display:flex}
  .container{padding:0 14px}
  .section{padding:44px 0}
  .section-sm{padding:32px 0}
  .feat-strip-inner{grid-template-columns:1fr 1fr;padding:0 14px}
  .feat-item{padding:14px 8px}
  .rashi-grid{grid-template-columns:repeat(3,1fr);gap:9px}
  .rashi-card{padding:12px 7px}
  .rashi-sym{font-size:22px}
  .astro-grid{grid-template-columns:1fr 1fr}
  .plans-grid{grid-template-columns:1fr}
  .blog-grid{grid-template-columns:1fr}
  .blog-card:last-child{grid-column:auto}
  .testi-grid{grid-template-columns:1fr}
  .footer-grid{grid-template-columns:1fr}
  .auth-split{grid-template-columns:1fr}
  .auth-left{display:none}
  .dash-layout{grid-template-columns:1fr}
  .sidebar{display:none}
  .dash-main{padding:14px}
  .kpi-grid{grid-template-columns:1fr 1fr}
  .grid-2{grid-template-columns:1fr}
  .grid-3{grid-template-columns:1fr}
  .form-grid-2{grid-template-columns:1fr}
  .form-group.full{grid-column:auto}
  .consult-layout{grid-template-columns:1fr}
  .chat-win{height:460px}
  .panchang-grid{grid-template-columns:1fr 1fr;padding:18px;gap:12px}
  .team-grid{grid-template-columns:1fr 1fr}
  .match-result-grid{grid-template-columns:1fr}
  .match-circle{margin:10px auto}
  .profile-header{flex-direction:column}
  .profile-stats{margin-left:0}
  .hero-title{font-size:clamp(26px,7vw,42px)}
  .hero-btns{flex-direction:column}
  .hero-btns .btn-primary,.hero-btns .btn-secondary{width:100%}
  .about-grid{grid-template-columns:1fr}
  .success-card{padding:26px 14px;margin:30px auto}
  #quickNav{bottom:10px;right:10px}
  #quickNav button{font-size:9px;padding:5px 8px}
}
@media(max-width:480px){
  .rashi-grid{grid-template-columns:repeat(3,1fr)}
  .astro-grid{grid-template-columns:1fr}
  .kpi-grid{grid-template-columns:1fr 1fr}
  .team-grid{grid-template-columns:1fr 1fr}
  .panchang-grid{grid-template-columns:1fr 1fr}
  .plans-grid{grid-template-columns:1fr}
  .about-stats-grid{grid-template-columns:1fr 1fr!important}
  .dash-snapshot-grid{grid-template-columns:1fr 1fr!important}
}
@media(max-width:360px){
  .rashi-grid{grid-template-columns:repeat(2,1fr)}
  .kpi-grid{grid-template-columns:1fr}
}
</style>
</head>
<body>

<!-- NAV -->
<nav id="nav">
  <div class="nav-brand" onclick="showPage('home')">
    <div class="nav-logo">ॐ</div>
    <div><div class="nav-brand-name">AstroVeda</div><div class="nav-brand-sub">Sacred ERP Platform</div></div>
  </div>
  <ul class="nav-links">
    <li><a id="nl-home" class="active" onclick="showPage('home')">Home</a></li>
    <li><a id="nl-kundli" onclick="showPage('kundli')">Kundli</a></li>
    <li><a id="nl-horoscope" onclick="showPage('horoscope')">Horoscope</a></li>
    <li><a id="nl-astrologers" onclick="showPage('astrologers')">Astrologers</a></li>
    <li><a id="nl-consultation" onclick="showPage('consultation')">Consult</a></li>
    <li><a id="nl-matchmaking" onclick="showPage('matchmaking')">Kundli Milan</a></li>
    <li><a id="nl-plans" onclick="showPage('plans')">Plans</a></li>
    <li><a id="nl-shop" onclick="showPage('shop')">Shop</a></li>
    <li><a id="nl-about" onclick="showPage('about')">About</a></li>
  </ul>
  <div class="nav-ctas">
    <button class="btn-nav-outline" onclick="showPage('login')">Login</button>
    <button class="btn-nav-solid" onclick="showPage('register')">Register Free</button>
    <button class="btn-nav-outline" onclick="showPage('dashboard')" style="border-color:rgba(200,147,26,0.5);color:var(--gold-bright)">Dashboard</button>
  </div>
  <button class="hamburger" id="hamburger" onclick="toggleMenu()">
    <span></span><span></span><span></span>
  </button>
</nav>

<!-- MOBILE MENU -->
<div class="mob-menu" id="mobMenu">
  <button class="mob-link" onclick="showPage('home');toggleMenu()">🏠 Home</button>
  <button class="mob-link" onclick="showPage('kundli');toggleMenu()">🔭 Kundli Generator</button>
  <button class="mob-link" onclick="showPage('horoscope');toggleMenu()">⭐ Daily Horoscope</button>
  <button class="mob-link" onclick="showPage('astrologers');toggleMenu()">🧘 Astrologers</button>
  <button class="mob-link" onclick="showPage('consultation');toggleMenu()">💬 Live Consultation</button>
  <button class="mob-link" onclick="showPage('matchmaking');toggleMenu()">💑 Kundli Milan</button>
  <button class="mob-link" onclick="showPage('plans');toggleMenu()">💎 Pricing Plans</button>
  <button class="mob-link" onclick="showPage('shop');toggleMenu()">🛍 Gemstone Shop</button>
  <button class="mob-link" onclick="showPage('about');toggleMenu()">ℹ About Us</button>
  <button class="mob-link" onclick="showPage('faq');toggleMenu()">❓ FAQ</button>
  <button class="mob-link" onclick="showPage('contact');toggleMenu()">📞 Contact</button>
  <div class="mob-ctas">
    <button class="btn-nav-outline" style="flex:1" onclick="showPage('login');toggleMenu()">Login</button>
    <button class="btn-nav-solid" style="flex:1" onclick="showPage('register');toggleMenu()">Register</button>
  </div>
</div>

<!-- ═══════════════════════ PAGE: HOME ═══════════════════════ -->
<div class="page active" id="page-home">

<!-- HERO -->
<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-stars" id="starField"></div>
  <div class="hero-inner">
    <div>
      <div class="hero-badge">🇮🇳 India's Most Trusted Vedic Platform</div>
      <h1 class="hero-title">Unlock Your<br><span class="gold">Sacred</span> <span class="saf">Destiny</span><br>Through Stars</h1>
      <p class="hero-shloka">"यथा पिण्डे तथा ब्रह्माण्डे"<br>As is the individual, so is the universe</p>
      <p class="hero-desc">Get authentic Janam Kundli, expert Vedic astrologer consultations,<br>and personalized cosmic guidance trusted by 2.5 million seekers.</p>
      <div class="hero-btns">
        <button class="btn btn-primary" onclick="showPage('kundli')">✦ Generate Free Kundli</button>
        <button class="btn btn-secondary" onclick="showPage('astrologers')">Talk to Astrologer</button>
      </div>
      <div class="hero-stats">
        <div><span class="hero-stat-n">2.5M+</span><span class="hero-stat-l">Happy Seekers</span></div>
        <div><span class="hero-stat-n">1,200+</span><span class="hero-stat-l">Expert Astrologers</span></div>
        <div><span class="hero-stat-n">98%</span><span class="hero-stat-l">Satisfaction</span></div>
        <div><span class="hero-stat-n">18Yr+</span><span class="hero-stat-l">Combined Exp</span></div>
      </div>
    </div>
    <div class="hero-visual" style="display:flex;justify-content:center">
      <div class="kundli-card" style="width:100%;max-width:400px">
        <div class="kundli-head"><h3>✦ Janam Kundli</h3><p>LAGNA CHART • NORTH INDIAN STYLE</p></div>
        <div class="kundli-chart">
          <svg viewBox="0 0 260 260" style="width:100%;aspect-ratio:1" xmlns="http://www.w3.org/2000/svg">
            <rect width="260" height="260" fill="none" stroke="rgba(200,147,26,0.4)" stroke-width="1.5" rx="3"/>
            <line x1="0" y1="0" x2="260" y2="260" stroke="rgba(200,147,26,0.35)" stroke-width="1"/>
            <line x1="260" y1="0" x2="0" y2="260" stroke="rgba(200,147,26,0.35)" stroke-width="1"/>
            <line x1="130" y1="0" x2="130" y2="260" stroke="rgba(200,147,26,0.2)" stroke-width="1"/>
            <line x1="0" y1="130" x2="260" y2="130" stroke="rgba(200,147,26,0.2)" stroke-width="1"/>
            <polygon points="130,0 260,130 130,260 0,130" fill="none" stroke="rgba(200,147,26,0.5)" stroke-width="1.5"/>
            <text x="130" y="58" text-anchor="middle" fill="rgba(200,147,26,0.8)" font-size="10" font-family="serif">मेष</text>
            <text x="130" y="70" text-anchor="middle" fill="rgba(255,255,255,0.5)" font-size="8">Su Me</text>
            <text x="60" y="132" text-anchor="middle" fill="rgba(200,147,26,0.8)" font-size="10" font-family="serif">वृष</text>
            <text x="200" y="132" text-anchor="middle" fill="rgba(200,147,26,0.8)" font-size="10" font-family="serif">मिथुन</text>
            <text x="200" y="144" text-anchor="middle" fill="rgba(255,255,255,0.5)" font-size="8">Ma</text>
            <text x="130" y="206" text-anchor="middle" fill="rgba(200,147,26,0.8)" font-size="10" font-family="serif">कर्क</text>
            <text x="130" y="218" text-anchor="middle" fill="rgba(255,255,255,0.5)" font-size="8">Mo</text>
            <text x="38" y="58" text-anchor="middle" fill="rgba(200,147,26,0.45)" font-size="8">धनु</text>
            <text x="222" y="58" text-anchor="middle" fill="rgba(200,147,26,0.45)" font-size="8">मकर</text>
            <text x="38" y="208" text-anchor="middle" fill="rgba(200,147,26,0.45)" font-size="8">तुला</text>
            <text x="222" y="208" text-anchor="middle" fill="rgba(200,147,26,0.45)" font-size="8">सिंह</text>
            <text x="130" y="140" text-anchor="middle" fill="rgba(200,147,26,0.25)" font-size="34" font-family="serif">ॐ</text>
          </svg>
        </div>
        <div class="k-planets">
          <div class="k-planet"><div class="k-dot" style="background:rgba(255,200,0,0.15);color:#FFD700">☀</div><div><div class="k-pname">Sun</div><div class="k-ppos">Aries 15°12'</div></div></div>
          <div class="k-planet"><div class="k-dot" style="background:rgba(180,180,255,0.15);color:#C0C0FF">☽</div><div><div class="k-pname">Moon</div><div class="k-ppos">Cancer 8°44'</div></div></div>
          <div class="k-planet"><div class="k-dot" style="background:rgba(255,80,80,0.15);color:#FF9999">♂</div><div><div class="k-pname">Mars</div><div class="k-ppos">Gemini 22°31'</div></div></div>
          <div class="k-planet"><div class="k-dot" style="background:rgba(100,200,100,0.15);color:#90EE90">☿</div><div><div class="k-pname">Mercury</div><div class="k-ppos">Aries 3°18'</div></div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- TICKER -->
<div class="ticker"><div class="ticker-wrap" id="tickerWrap"></div></div>

<!-- FEATURE STRIP -->
<div class="feat-strip">
  <div class="feat-strip-inner">
    <div class="feat-item"><div class="feat-icon" style="background:rgba(255,107,0,0.1)">🔭</div><div class="feat-text"><h4>Authentic Vedic Kundli</h4><p>North & South Indian charts</p></div></div>
    <div class="feat-item"><div class="feat-icon" style="background:rgba(200,147,26,0.1)">🎙</div><div class="feat-text"><h4>Live Consultation</h4><p>Chat, Audio & Video calls</p></div></div>
    <div class="feat-item"><div class="feat-icon" style="background:rgba(11,28,58,0.08)">🏅</div><div class="feat-text"><h4>Verified Experts</h4><p>1,200+ certified astrologers</p></div></div>
    <div class="feat-item"><div class="feat-icon" style="background:rgba(34,197,94,0.1)">🔒</div><div class="feat-text"><h4>100% Secure</h4><p>SSL + OTP protected</p></div></div>
  </div>
</div>

<!-- PANCHANG -->
<section class="section-sm" style="background:var(--navy)">
  <div class="container">
    <div class="text-center" style="margin-bottom:22px">
      <div class="sec-label sec-label-dark">✦ Aaj Ka Panchang</div>
      <h2 class="cinzel" style="color:white;font-size:clamp(18px,3vw,26px)">Today's Sacred Calendar</h2>
      <p style="color:rgba(255,255,255,0.35);font-size:12px;margin-top:4px">Saturday, 6 June 2026 · Jyeshtha Shukla Dashami</p>
    </div>
    <div class="panchang-grid">
      <div class="panch-item"><div class="panch-label">Tithi</div><div class="panch-val">Dashami</div><div class="panch-sub">Until 4:18 PM</div></div>
      <div class="panch-item"><div class="panch-label">Nakshatra</div><div class="panch-val">Rohini</div><div class="panch-sub">Until 8:44 PM</div></div>
      <div class="panch-item"><div class="panch-label">Yoga</div><div class="panch-val">Siddhi</div><div class="panch-sub">Auspicious</div></div>
      <div class="panch-item"><div class="panch-label">Karana</div><div class="panch-val">Bava</div><div class="panch-sub">Until 5:02 PM</div></div>
      <div class="panch-item"><div class="panch-label">Shubh Muhurat</div><div class="panch-val">10:30–12:15</div><div class="panch-sub">Abhijit Muhurat</div></div>
      <div class="panch-item"><div class="panch-label">Rahu Kaal</div><div class="panch-val">9:00–10:30</div><div class="panch-sub">Avoid work</div></div>
    </div>
  </div>
</section>

<!-- RASHIS -->
<section class="section" style="background:white">
  <div class="container">
    <div class="text-center" style="margin-bottom:34px">
      <div class="sec-label">✦ Daily Horoscope</div>
      <h2 class="sec-title">Choose Your <em>Rashi</em></h2>
      <p class="sec-sub" style="margin:0 auto">Select your zodiac sign for today's personalized cosmic guidance</p>
    </div>
    <div class="rashi-grid">
      <div class="rashi-card" onclick="showPage('horoscope')"><span class="rashi-sym">♈</span><div class="rashi-hi">मेष</div><div class="rashi-en">Aries</div></div>
      <div class="rashi-card" onclick="showPage('horoscope')"><span class="rashi-sym">♉</span><div class="rashi-hi">वृष</div><div class="rashi-en">Taurus</div></div>
      <div class="rashi-card" onclick="showPage('horoscope')"><span class="rashi-sym">♊</span><div class="rashi-hi">मिथुन</div><div class="rashi-en">Gemini</div></div>
      <div class="rashi-card" onclick="showPage('horoscope')"><span class="rashi-sym">♋</span><div class="rashi-hi">कर्क</div><div class="rashi-en">Cancer</div></div>
      <div class="rashi-card" onclick="showPage('horoscope')"><span class="rashi-sym">♌</span><div class="rashi-hi">सिंह</div><div class="rashi-en">Leo</div></div>
      <div class="rashi-card" onclick="showPage('horoscope')"><span class="rashi-sym">♍</span><div class="rashi-hi">कन्या</div><div class="rashi-en">Virgo</div></div>
      <div class="rashi-card" onclick="showPage('horoscope')"><span class="rashi-sym">♎</span><div class="rashi-hi">तुला</div><div class="rashi-en">Libra</div></div>
      <div class="rashi-card" onclick="showPage('horoscope')"><span class="rashi-sym">♏</span><div class="rashi-hi">वृश्चिक</div><div class="rashi-en">Scorpio</div></div>
      <div class="rashi-card" onclick="showPage('horoscope')"><span class="rashi-sym">♐</span><div class="rashi-hi">धनु</div><div class="rashi-en">Sagittarius</div></div>
      <div class="rashi-card" onclick="showPage('horoscope')"><span class="rashi-sym">♑</span><div class="rashi-hi">मकर</div><div class="rashi-en">Capricorn</div></div>
      <div class="rashi-card" onclick="showPage('horoscope')"><span class="rashi-sym">♒</span><div class="rashi-hi">कुम्भ</div><div class="rashi-en">Aquarius</div></div>
      <div class="rashi-card" onclick="showPage('horoscope')"><span class="rashi-sym">♓</span><div class="rashi-hi">मीन</div><div class="rashi-en">Pisces</div></div>
    </div>
  </div>
</section>

<!-- ASTROLOGERS -->
<section class="section" style="background:var(--cream)">
  <div class="container">
    <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:32px;flex-wrap:wrap;gap:12px">
      <div><div class="sec-label">✦ Our Experts</div><h2 class="sec-title">Meet Our <em>Certified</em> Astrologers</h2></div>
      <button class="btn btn-secondary btn-sm" onclick="showPage('astrologers')">View All Experts →</button>
    </div>
    <div class="astro-grid" id="homeAstroGrid"></div>
  </div>
</section>

<!-- PLANS PREVIEW -->
<section class="section plans-section">
  <div class="container">
    <div class="text-center" style="margin-bottom:40px">
      <div class="sec-label sec-label-dark">✦ Premium Plans</div>
      <h2 class="sec-title sec-title-white">Choose Your <em>Sacred</em> Journey</h2>
      <p class="sec-sub" style="color:rgba(255,255,255,0.5);margin:0 auto">Unlock unlimited cosmic guidance with our curated subscription plans</p>
    </div>
    <div class="plans-grid" id="homePlansGrid"></div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="section" style="background:white">
  <div class="container">
    <div class="text-center" style="margin-bottom:32px">
      <div class="sec-label">✦ Real Stories</div>
      <h2 class="sec-title">What Our <em>Seekers</em> Say</h2>
      <div class="trust-badges" style="justify-content:center;margin-top:12px">
        <div class="trust-badge">🔒 SSL Secured</div>
        <div class="trust-badge">✅ Verified Astrologers</div>
        <div class="trust-badge">⭐ 4.9/5 Rated</div>
        <div class="trust-badge">🇮🇳 Made in India</div>
      </div>
    </div>
    <div class="testi-grid">
      <div class="testi-card"><span class="testi-q">"</span><p class="testi-text">I was skeptical at first, but Pt. Rajesh Sharma's predictions about my career change were remarkably accurate. The Kundli report gave me clarity I had never experienced before.</p><div class="testi-author"><div class="testi-ava">A</div><div><div class="testi-name">Arjun Mehta</div><div class="testi-loc">★★★★★ &nbsp;Mumbai, Maharashtra</div></div></div></div>
      <div class="testi-card"><span class="testi-q">"</span><p class="testi-text">Dr. Deepa Verma's guidance on my marriage helped me make the most important decision of my life. Her reading of our compatibility was spot-on and very detailed.</p><div class="testi-author"><div class="testi-ava" style="background:linear-gradient(135deg,#7C3AED,#A855F7)">P</div><div><div class="testi-name">Priya Nair</div><div class="testi-loc">★★★★★ &nbsp;Chennai, Tamil Nadu</div></div></div></div>
      <div class="testi-card"><span class="testi-q">"</span><p class="testi-text">The Panchang and Muhurat service is exceptional. We planned our business launch as per the suggested Muhurat and the results have been beyond our expectations!</p><div class="testi-author"><div class="testi-ava" style="background:linear-gradient(135deg,#059669,#10B981)">R</div><div><div class="testi-name">Ramesh Gupta</div><div class="testi-loc">★★★★★ &nbsp;Ahmedabad, Gujarat</div></div></div></div>
    </div>
  </div>
</section>

<!-- BLOG -->
<section class="section" style="background:var(--cream)">
  <div class="container">
    <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:32px;flex-wrap:wrap;gap:12px">
      <div><div class="sec-label">✦ Knowledge Center</div><h2 class="sec-title">Sacred <em>Wisdom</em> & Articles</h2></div>
      <button class="btn btn-secondary btn-sm">All Articles →</button>
    </div>
    <div class="blog-grid">
      <div class="blog-card featured"><div class="blog-img blog-img-lg" style="background:linear-gradient(135deg,#0B1C3A,#162B52)">🌙<span class="blog-tag-badge">Featured</span></div><div class="blog-body"><div class="blog-title">Understanding Your Janam Kundli: A Complete Guide for Beginners</div><div class="blog-meta"><span>Pt. Rajesh Sharma</span><span>•</span><span>8 min read</span><span>•</span><span>June 3, 2026</span></div></div></div>
      <div class="blog-card"><div class="blog-img" style="background:linear-gradient(135deg,#7C3AED,#A855F7)">🪐<span class="blog-tag-badge">Planets</span></div><div class="blog-body"><div class="blog-title">Saturn's Return and What It Means for You</div><div class="blog-meta"><span>Dr. Deepa Verma</span><span>•</span><span>5 min read</span></div></div></div>
      <div class="blog-card"><div class="blog-img" style="background:linear-gradient(135deg,#B45309,#D97706)">💍<span class="blog-tag-badge">Marriage</span></div><div class="blog-body"><div class="blog-title">Best Muhurats for Marriage in 2026</div><div class="blog-meta"><span>AstroVeda Team</span><span>•</span><span>4 min read</span></div></div></div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="container">
    <div class="footer-grid">
      <div>
        <div class="footer-logo">ॐ AstroVeda</div>
        <p class="footer-desc">India's most trusted Vedic astrology platform, connecting seekers with certified experts for authentic cosmic guidance since 2015.</p>
        <div class="footer-social">
          <button class="footer-soc-btn">f</button><button class="footer-soc-btn">𝕏</button><button class="footer-soc-btn">in</button><button class="footer-soc-btn">▶</button>
        </div>
      </div>
      <div>
        <div class="footer-col-title">Services</div>
        <ul class="footer-links">
          <li><span onclick="showPage('kundli')">Janam Kundli</span></li>
          <li><span onclick="showPage('horoscope')">Daily Horoscope</span></li>
          <li><span onclick="showPage('matchmaking')">Match Making</span></li>
          <li><span>Numerology</span></li>
          <li><span>Vastu Shastra</span></li>
        </ul>
      </div>
      <div>
        <div class="footer-col-title">Company</div>
        <ul class="footer-links">
          <li><span onclick="showPage('about')">About Us</span></li>
          <li><span onclick="showPage('contact')">Contact Us</span></li>
          <li><span onclick="showPage('faq')">FAQ</span></li>
          <li><span>Blog</span></li>
        </ul>
      </div>
      <div>
        <div class="footer-col-title">Legal</div>
        <ul class="footer-links">
          <li><span>Privacy Policy</span></li>
          <li><span>Terms of Service</span></li>
          <li><span>Refund Policy</span></li>
        </ul>
        <div style="margin-top:16px">
          <div class="footer-col-title">Contact</div>
          <ul class="footer-links"><li><span>support@astroveda.in</span></li><li><span>+91 98765 43210</span></li></ul>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© 2026 AstroVeda ERP Pvt. Ltd. All rights reserved.</p>
      <p>SSL Secured · Razorpay · UPI · Paytm</p>
    </div>
  </div>
</footer>
</div><!-- /page-home -->

<!-- ═══════════════════════ PAGE: KUNDLI ═══════════════════════ -->
<div class="page" id="page-kundli">
  <div class="page-hero-sm">
    <div class="sec-label sec-label-dark" style="margin-bottom:10px">✦ Sacred Vedic Tool</div>
    <h1>Generate Your <span style="color:var(--gold-bright)">Janam Kundli</span></h1>
    <p>Enter your birth details for a personalized Vedic birth chart</p>
  </div>
  <section class="section" style="background:var(--cream)">
    <div class="container">
      <div class="form-card" style="max-width:800px;margin:0 auto">
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:22px;padding-bottom:18px;border-bottom:1px solid var(--border)">
          <span style="font-size:26px">🔭</span>
          <div><h3 class="cinzel" style="color:var(--navy);font-size:18px">Birth Information</h3><p style="font-size:12px;color:var(--text-muted)">All fields required for accurate Kundli generation</p></div>
        </div>
        <div class="form-grid-2">
          <div class="form-group"><label class="form-label">Full Name <span class="req">*</span></label><div class="input-wrap"><span class="input-icon">👤</span><input class="form-input" type="text" placeholder="e.g. Rahul Kumar Sharma"></div></div>
          <div class="form-group"><label class="form-label">Gender <span class="req">*</span></label><select class="form-select"><option>Select Gender</option><option>Male</option><option>Female</option><option>Other</option></select></div>
          <div class="form-group"><label class="form-label">Date of Birth <span class="req">*</span></label><div class="input-wrap"><span class="input-icon">📅</span><input class="form-input" type="date" value="1995-05-15"></div></div>
          <div class="form-group"><label class="form-label">Time of Birth <span class="req">*</span></label><div class="input-wrap"><span class="input-icon">🕐</span><input class="form-input" type="time" value="06:30"></div></div>
          <div class="form-group"><label class="form-label">Country</label><select class="form-select"><option>India</option><option>USA</option><option>UK</option><option>UAE</option></select></div>
          <div class="form-group"><label class="form-label">State</label><select class="form-select"><option>Uttar Pradesh</option><option>Maharashtra</option><option>Delhi</option><option>Gujarat</option><option>Tamil Nadu</option></select></div>
          <div class="form-group full"><label class="form-label">City of Birth <span class="req">*</span></label><div class="input-wrap"><span class="input-icon">📍</span><input class="form-input" type="text" placeholder="e.g. Varanasi, Mumbai, Delhi..."></div></div>
          <div class="form-group"><label class="form-label">Chart Style</label><select class="form-select"><option>North Indian</option><option>South Indian</option></select></div>
          <div class="form-group"><label class="form-label">Language</label><select class="form-select"><option>English</option><option>Hindi</option><option>Tamil</option></select></div>
        </div>
        <div style="display:flex;gap:12px;margin-top:22px;flex-wrap:wrap">
          <button class="btn btn-primary" style="flex:1;min-width:180px" onclick="showKundliResult()">✦ Generate Kundli Now</button>
          <button class="btn btn-secondary">Upload Existing PDF</button>
        </div>
      </div>

      <!-- RESULT -->
      <div id="kundliResult" style="display:none;margin-top:32px">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;flex-wrap:wrap;gap:12px">
          <div><h3 style="font-family:'Playfair Display',serif;font-size:22px;color:var(--navy)">Kundli of <em>Rahul Kumar Sharma</em></h3><p style="font-size:12px;color:var(--text-muted)">Born: 15 May 1995 | 06:30 AM | Varanasi, UP | Aries Lagna</p></div>
          <div style="display:flex;gap:9px;flex-wrap:wrap">
            <button class="btn btn-secondary btn-sm">⬇ Download PDF</button>
            <button class="btn btn-primary btn-sm" onclick="showPage('consultation')">Get Expert Prediction</button>
          </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px" id="kundliResGrid">
          <div class="form-card" style="padding:18px">
            <div class="card-title" style="text-align:center;display:block;padding-bottom:12px;border-bottom:1px solid var(--border);margin-bottom:14px">✦ Lagna Chart (D1)</div>
            <svg viewBox="0 0 300 300" style="width:100%" xmlns="http://www.w3.org/2000/svg">
              <rect width="300" height="300" fill="#FBF6EF" stroke="#C8931A" stroke-width="1.5" rx="3"/>
              <line x1="0" y1="0" x2="300" y2="300" stroke="#C8931A" stroke-width="1.2" opacity="0.4"/>
              <line x1="300" y1="0" x2="0" y2="300" stroke="#C8931A" stroke-width="1.2" opacity="0.4"/>
              <line x1="150" y1="0" x2="150" y2="300" stroke="#C8931A" stroke-width="0.8" opacity="0.3"/>
              <line x1="0" y1="150" x2="300" y2="150" stroke="#C8931A" stroke-width="0.8" opacity="0.3"/>
              <polygon points="150,0 300,150 150,300 0,150" fill="none" stroke="#C8931A" stroke-width="1.5"/>
              <text x="150" y="60" text-anchor="middle" fill="#0B1C3A" font-size="10" font-weight="bold">1 – Asc</text>
              <text x="150" y="73" text-anchor="middle" fill="#7A6A52" font-size="9">Kumbha</text>
              <text x="150" y="84" text-anchor="middle" fill="#7B1C1C" font-size="9">Su Me</text>
              <text x="68" y="148" text-anchor="middle" fill="#0B1C3A" font-size="10" font-weight="bold">12</text>
              <text x="68" y="160" text-anchor="middle" fill="#7A6A52" font-size="9">Makara • Ve</text>
              <text x="232" y="148" text-anchor="middle" fill="#0B1C3A" font-size="10" font-weight="bold">2</text>
              <text x="232" y="160" text-anchor="middle" fill="#7A6A52" font-size="9">Meena</text>
              <text x="232" y="172" text-anchor="middle" fill="#7B1C1C" font-size="8">Ma Ju</text>
              <text x="150" y="236" text-anchor="middle" fill="#0B1C3A" font-size="10" font-weight="bold">7</text>
              <text x="150" y="249" text-anchor="middle" fill="#7A6A52" font-size="9">Simha • Mo</text>
              <text x="44" y="60" text-anchor="middle" fill="#9A8A72" font-size="8">11</text>
              <text x="256" y="60" text-anchor="middle" fill="#9A8A72" font-size="8">3</text>
              <text x="44" y="240" text-anchor="middle" fill="#9A8A72" font-size="8">9</text>
              <text x="256" y="240" text-anchor="middle" fill="#9A8A72" font-size="8">5</text>
              <text x="44" y="150" text-anchor="middle" fill="#9A8A72" font-size="8">10</text>
              <text x="256" y="150" text-anchor="middle" fill="#9A8A72" font-size="8">4</text>
              <text x="150" y="158" text-anchor="middle" fill="rgba(200,147,26,0.2)" font-size="40" font-family="serif">ॐ</text>
            </svg>
          </div>
          <div>
            <div class="form-card" style="padding:18px;margin-bottom:18px">
              <div class="card-title" style="text-align:center;display:block;padding-bottom:10px;border-bottom:1px solid var(--border);margin-bottom:12px">✦ Planet Positions</div>
              <div style="overflow-x:auto">
                <table class="planet-table">
                  <thead><tr><th>Planet</th><th>Rashi</th><th>Degree</th><th>House</th></tr></thead>
                  <tbody>
                    <tr><td>☀ Sun</td><td>Aries</td><td>15°12'</td><td>1st</td></tr>
                    <tr><td>☽ Moon</td><td>Leo</td><td>8°44'</td><td>7th</td></tr>
                    <tr><td>♂ Mars</td><td>Pisces</td><td>22°31'</td><td>2nd</td></tr>
                    <tr><td>☿ Mercury</td><td>Aries</td><td>3°18'</td><td>1st</td></tr>
                    <tr><td>♃ Jupiter</td><td>Pisces</td><td>18°55'</td><td>2nd</td></tr>
                    <tr><td>♀ Venus</td><td>Capricorn</td><td>27°40'</td><td>12th</td></tr>
                    <tr><td>♄ Saturn</td><td>Aquarius</td><td>1°22'</td><td>1st</td></tr>
                    <tr><td>☊ Rahu</td><td>Scorpio</td><td>14°08'</td><td>10th</td></tr>
                    <tr><td>☋ Ketu</td><td>Taurus</td><td>14°08'</td><td>4th</td></tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="form-card" style="padding:18px">
              <div class="card-title" style="padding-bottom:10px;border-bottom:1px solid var(--border);margin-bottom:12px">✦ Vimshottari Dasha</div>
              <div class="dasha-row"><div class="dasha-dot" style="background:rgba(255,200,0,0.15);color:#FFD700">Su</div><div style="flex:1"><div style="font-size:12px;font-weight:700;color:var(--navy)">Sun Mahadasha (Current)</div><div style="font-size:11px;color:var(--text-muted)">Jun 2024 – Jun 2030</div></div><div class="dasha-bar-wrap"><div class="dasha-bar" style="width:30%"></div></div></div>
              <div class="dasha-row"><div class="dasha-dot" style="background:rgba(180,180,255,0.15);color:#C0C0FF">Mo</div><div style="flex:1"><div style="font-size:12px;font-weight:700;color:var(--navy)">Moon Mahadasha</div><div style="font-size:11px;color:var(--text-muted)">Jun 2030 – Jun 2040</div></div><div class="dasha-bar-wrap"><div class="dasha-bar" style="width:0%"></div></div></div>
              <div class="dasha-row"><div class="dasha-dot" style="background:rgba(255,80,80,0.15);color:#FF9999">Ma</div><div style="flex:1"><div style="font-size:12px;font-weight:700;color:var(--navy)">Mars Mahadasha</div><div style="font-size:11px;color:var(--text-muted)">Jun 2040 – Jun 2047</div></div></div>
              <div style="margin-top:12px;padding-top:12px;border-top:1px solid var(--border)">
                <div style="font-size:10px;color:var(--text-muted);margin-bottom:7px;font-weight:700;text-transform:uppercase;letter-spacing:.5px">Key Yogas Detected</div>
                <div style="display:flex;flex-wrap:wrap;gap:6px"><span class="tag">Gajakesari Yoga</span><span class="tag tag-saf">Budha-Aditya Yoga</span><span class="tag">Pancha Mahapurusha</span></div>
              </div>
            </div>
          </div>
        </div>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-top:18px" id="predGrid">
          <div class="form-card" style="padding:16px"><div style="font-size:24px;margin-bottom:8px">💼</div><div class="cinzel" style="font-size:12px;font-weight:700;color:var(--navy);margin-bottom:6px">Career Outlook</div><p style="font-size:12px;color:var(--text-muted);line-height:1.6">Strong 2nd house Jupiter indicates wealth through knowledge. Teaching, consulting, or law are favorable paths.</p></div>
          <div class="form-card" style="padding:16px"><div style="font-size:24px;margin-bottom:8px">💑</div><div class="cinzel" style="font-size:12px;font-weight:700;color:var(--navy);margin-bottom:6px">Marriage Prospects</div><p style="font-size:12px;color:var(--text-muted);line-height:1.6">7th house Moon in Leo suggests a passionate partner. Marriage likely 28–32. Not Manglik. ✓</p></div>
          <div class="form-card" style="padding:16px"><div style="font-size:24px;margin-bottom:8px">💊</div><div class="cinzel" style="font-size:12px;font-weight:700;color:var(--navy);margin-bottom:6px">Health Guidance</div><p style="font-size:12px;color:var(--text-muted);line-height:1.6">Saturn in 1st house — attention to bones and joints. Regular yoga and pranayama are recommended.</p></div>
        </div>
        <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:var(--r);padding:16px;margin-top:16px;display:flex;gap:13px;align-items:flex-start;flex-wrap:wrap">
          <span style="font-size:24px">⚠️</span>
          <div style="flex:1;min-width:180px"><div style="font-weight:700;color:var(--navy);margin-bottom:4px;font-size:13px">AI-Generated Draft — Professional Review Recommended</div><p style="font-size:12px;color:var(--text-muted);line-height:1.6">These are AI-assisted preliminary observations. For accurate, personalized predictions consult a verified Vedic astrologer.</p><button class="btn btn-primary btn-sm" style="margin-top:10px" onclick="showPage('consultation')">Book Expert Consultation →</button></div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- ═══════════════════════ PAGE: HOROSCOPE ═══════════════════════ -->
<div class="page" id="page-horoscope">
  <div class="page-hero-sm"><h1>Daily Horoscope</h1><p>आज का राशिफल • Saturday, 6 June 2026</p></div>
  <section class="section" style="background:var(--cream)">
    <div class="container">
      <div style="display:grid;grid-template-columns:250px 1fr;gap:24px" id="horoLayout">
        <div>
          <div class="card" style="overflow:hidden;margin-bottom:14px">
            <div style="background:var(--navy);padding:13px 16px;font-family:'Cinzel',serif;color:var(--gold-light);font-size:13px;font-weight:600">Select Your Rashi</div>
            <div style="padding:7px" id="rashiSidebar"></div>
          </div>
          <div class="card"><div class="card-body">
            <div class="cinzel" style="font-size:13px;font-weight:600;color:var(--navy);margin-bottom:11px">Lucky Numbers</div>
            <div style="display:flex;gap:7px;flex-wrap:wrap;margin-bottom:13px">
              <span style="width:32px;height:32px;background:var(--gold-pale);border:1px solid var(--border);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--gold);font-size:12px">3</span>
              <span style="width:32px;height:32px;background:var(--gold-pale);border:1px solid var(--border);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--gold);font-size:12px">7</span>
              <span style="width:32px;height:32px;background:rgba(255,107,0,0.1);border:1px solid rgba(255,107,0,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;color:var(--saffron);font-size:12px">21</span>
            </div>
            <div class="cinzel" style="font-size:12px;font-weight:600;color:var(--navy);margin-bottom:7px">Lucky Colors</div>
            <div style="display:flex;gap:7px">
              <div style="width:32px;height:32px;border-radius:7px;background:#FF6B00;box-shadow:0 2px 6px rgba(0,0,0,0.2)"></div>
              <div style="width:32px;height:32px;border-radius:7px;background:#C8931A;box-shadow:0 2px 6px rgba(0,0,0,0.2)"></div>
            </div>
          </div></div>
        </div>
        <div class="card" style="overflow:hidden">
          <div style="background:linear-gradient(135deg,var(--navy),var(--navy-mid));padding:26px;text-align:center">
            <div style="font-size:52px;margin-bottom:9px">♈</div>
            <h2 class="cinzel" style="color:white;font-size:clamp(17px,3vw,24px);margin-bottom:4px">Aries – Mesh Rashi</h2>
            <p style="color:rgba(255,255,255,0.45);font-size:12px">मेष राशि • March 21 – April 19</p>
            <div style="display:flex;justify-content:center;gap:20px;margin-top:16px;flex-wrap:wrap">
              <div><div class="cinzel" style="font-size:20px;color:var(--gold-bright)">8.2</div><div style="font-size:10px;color:rgba(255,255,255,0.4)">Overall</div></div>
              <div style="width:1px;background:rgba(255,255,255,0.1)"></div>
              <div><div style="color:var(--gold-bright);font-size:15px">★★★★☆</div><div style="font-size:10px;color:rgba(255,255,255,0.4)">Rating</div></div>
            </div>
          </div>
          <div style="padding:22px">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:22px">
              <div style="background:var(--cream);border:1px solid var(--border);border-radius:var(--r);padding:13px"><div style="font-size:10px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:4px">💼 Career</div><div style="color:var(--gold);font-size:13px;margin-bottom:3px">★★★★★</div><p style="font-size:12px;color:var(--text-muted);line-height:1.5">Excellent day for professional growth. A senior may recognize your efforts.</p></div>
              <div style="background:var(--cream);border:1px solid var(--border);border-radius:var(--r);padding:13px"><div style="font-size:10px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:4px">💑 Love</div><div style="color:var(--gold);font-size:13px;margin-bottom:3px">★★★★☆</div><p style="font-size:12px;color:var(--text-muted);line-height:1.5">Venus brings warmth. A romantic surprise awaits singles today.</p></div>
              <div style="background:var(--cream);border:1px solid var(--border);border-radius:var(--r);padding:13px"><div style="font-size:10px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:4px">💰 Finance</div><div style="color:var(--gold);font-size:13px;margin-bottom:3px">★★★☆☆</div><p style="font-size:12px;color:var(--text-muted);line-height:1.5">Moderate day. Avoid speculative investments. Pending payment may arrive.</p></div>
              <div style="background:var(--cream);border:1px solid var(--border);border-radius:var(--r);padding:13px"><div style="font-size:10px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:4px">🏥 Health</div><div style="color:var(--gold);font-size:13px;margin-bottom:3px">★★★★☆</div><p style="font-size:12px;color:var(--text-muted);line-height:1.5">Energy levels are high. Great for exercise and outdoor activities.</p></div>
            </div>
            <div style="border-top:1px solid var(--border);padding-top:18px">
              <h4 style="font-family:'Playfair Display',serif;font-size:17px;color:var(--navy);margin-bottom:10px">Today's Detailed Reading</h4>
              <p style="font-size:13px;color:var(--text-muted);line-height:1.8;margin-bottom:12px">Dear Aries native, the Sun in your 3rd house along with Mercury creates powerful Budha-Aditya yoga, enhancing your communication skills and decision-making ability. Mars, your ruling planet in Pisces, asks you to balance energy with spiritual pursuits.</p>
              <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:var(--r);padding:13px;margin-bottom:16px">
                <div style="font-weight:700;color:var(--navy);font-size:12px;margin-bottom:6px">✦ Today's Remedies</div>
                <ul style="font-size:12px;color:var(--text-muted);line-height:1.9;padding-left:15px"><li>Offer red flowers to Lord Hanuman</li><li>Chant "Om Mangalaya Namah" 108 times</li><li>Wear red or saffron colored clothing</li></ul>
              </div>
              <button class="btn btn-primary btn-sm" onclick="showPage('consultation')">Get Personalized Reading from Expert →</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- ═══════════════════════ PAGE: ASTROLOGERS ═══════════════════════ -->
<div class="page" id="page-astrologers">
  <div class="page-hero-sm"><h1>Our Expert Astrologers</h1><p>1,200+ Verified & Certified Vedic Experts</p></div>
  <div style="background:white;border-bottom:1px solid var(--border);padding:14px 0;position:sticky;top:72px;z-index:100">
    <div class="container">
      <div style="display:flex;gap:9px;align-items:center;flex-wrap:wrap">
        <span style="font-size:12px;font-weight:700;color:var(--navy);flex-shrink:0">Filter:</span>
        <button class="filter-chip active">All</button>
        <button class="filter-chip">Vedic Jyotish</button>
        <button class="filter-chip">KP System</button>
        <button class="filter-chip">Numerology</button>
        <button class="filter-chip">Vastu</button>
        <button class="filter-chip">Tarot</button>
        <button class="filter-chip" style="background:rgba(34,197,94,0.06);border-color:rgba(34,197,94,0.3);color:#15803D">● Online Now</button>
        <select class="filter-select" style="margin-left:auto"><option>Sort: Top Rated</option><option>Price: Low–High</option><option>Most Reviews</option></select>
      </div>
    </div>
  </div>
  <section class="section" style="background:var(--cream)">
    <div class="container">
      <p style="font-size:12px;color:var(--text-muted);margin-bottom:16px">Showing <strong>8 of 1,247</strong> astrologers</p>
      <div class="astro-grid" id="fullAstroGrid"></div>
      <div style="text-align:center;margin-top:28px"><button class="btn btn-secondary">Load More Astrologers</button></div>
    </div>
  </section>
</div>

<!-- ═══════════════════════ PAGE: ASTROLOGER DETAIL ═══════════════════════ -->
<div class="page" id="page-astrologer-detail">
  <section class="section" style="background:var(--cream)">
    <div class="container">
      <div class="breadcrumb"><a onclick="showPage('astrologers')">Astrologers</a><span class="sep">/</span><span>Pt. Rajesh Sharma</span></div>
      <div style="background:var(--navy);padding:32px;border-radius:var(--r-lg);margin-bottom:22px;display:grid;grid-template-columns:auto 1fr auto;gap:22px;align-items:start;border:1px solid rgba(200,147,26,0.25)" id="astroDetailHeader">
        <div style="width:86px;height:86px;border-radius:50%;border:3px solid var(--gold);background:rgba(200,147,26,0.15);display:flex;align-items:center;justify-content:center;font-family:'Cinzel',serif;font-size:30px;font-weight:700;color:var(--gold-bright)">P</div>
        <div>
          <div style="font-family:'Playfair Display',serif;font-size:22px;color:white;font-weight:700;margin-bottom:3px">Pt. Rajesh Sharma</div>
          <div style="font-size:12px;color:rgba(255,255,255,0.5);margin-bottom:10px">Senior Vedic Astrologer • 25+ Years Experience</div>
          <div style="display:flex;align-items:center;gap:9px;margin-bottom:11px;flex-wrap:wrap">
            <span style="color:var(--gold-bright);font-size:14px">★★★★★</span>
            <span style="color:rgba(255,255,255,0.65);font-size:12px">4.9 (2,341 reviews)</span>
            <span style="color:#86EFAC;font-size:11px;font-weight:700">✓ Verified</span>
            <span style="background:#22C55E;color:white;font-size:10px;font-weight:700;padding:2px 8px;border-radius:100px">● Online</span>
          </div>
          <div style="display:flex;flex-wrap:wrap;gap:6px">
            <span style="background:rgba(200,147,26,0.12);border:1px solid rgba(200,147,26,0.22);color:var(--gold-light);font-size:10px;font-weight:600;padding:3px 10px;border-radius:100px">Vedic Jyotish</span>
            <span style="background:rgba(200,147,26,0.12);border:1px solid rgba(200,147,26,0.22);color:var(--gold-light);font-size:10px;font-weight:600;padding:3px 10px;border-radius:100px">KP System</span>
            <span style="background:rgba(200,147,26,0.12);border:1px solid rgba(200,147,26,0.22);color:var(--gold-light);font-size:10px;font-weight:600;padding:3px 10px;border-radius:100px">Numerology</span>
            <span style="background:rgba(200,147,26,0.12);border:1px solid rgba(200,147,26,0.22);color:var(--gold-light);font-size:10px;font-weight:600;padding:3px 10px;border-radius:100px">Hindi • English</span>
          </div>
        </div>
        <div style="text-align:right">
          <div class="cinzel" style="font-size:24px;color:var(--gold-bright)">₹40<span style="font-size:14px">/min</span></div>
          <div style="font-size:10px;color:rgba(255,255,255,0.4);margin-bottom:6px">Chat</div>
          <div class="cinzel" style="font-size:20px;color:var(--gold-bright)">₹60<span style="font-size:12px">/min</span></div>
          <div style="font-size:10px;color:rgba(255,255,255,0.4);margin-bottom:13px">Video</div>
          <button class="btn btn-gold btn-sm" onclick="showPage('consultation')">Book Consultation</button>
        </div>
      </div>
      <div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;align-items:start" id="astroDetailBody">
        <div>
          <div class="card card-body" style="margin-bottom:18px">
            <div class="card-title">About Pt. Rajesh Sharma</div>
            <p style="font-size:13px;color:var(--text-muted);line-height:1.8;margin-bottom:9px">Pt. Rajesh Sharma is a renowned Vedic astrologer with over 25 years of experience in Jyotish Shastra, holding a Jyotish Acharya degree from Varanasi Sanskrit University.</p>
            <p style="font-size:13px;color:var(--text-muted);line-height:1.8">Specializing in career counseling, marriage compatibility, and spiritual guidance, he has helped over 50,000 clients across India and internationally.</p>
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-top:16px">
              <div style="text-align:center;background:var(--cream);border-radius:var(--r);padding:13px"><div class="cinzel" style="font-size:18px;font-weight:700;color:var(--navy)">50K+</div><div style="font-size:10px;color:var(--text-muted)">Clients Served</div></div>
              <div style="text-align:center;background:var(--cream);border-radius:var(--r);padding:13px"><div class="cinzel" style="font-size:18px;font-weight:700;color:var(--navy)">25 Yrs</div><div style="font-size:10px;color:var(--text-muted)">Experience</div></div>
              <div style="text-align:center;background:var(--cream);border-radius:var(--r);padding:13px"><div class="cinzel" style="font-size:18px;font-weight:700;color:var(--navy)">4.9★</div><div style="font-size:10px;color:var(--text-muted)">Avg. Rating</div></div>
            </div>
          </div>
          <div class="card card-body">
            <div class="card-title">Client Reviews <a onclick="void(0)">See all 2,341 →</a></div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
              <div class="testi-card"><span class="testi-q">"</span><p class="testi-text">Incredibly accurate predictions. Highly recommend!</p><div class="testi-author"><div class="testi-ava">A</div><div><div class="testi-name">Amit Singh</div><div class="testi-loc">★★★★★ Mumbai</div></div></div></div>
              <div class="testi-card"><span class="testi-q">"</span><p class="testi-text">Best astrologer on the platform. Very detailed Kundli analysis.</p><div class="testi-author"><div class="testi-ava" style="background:linear-gradient(135deg,#7C3AED,#A855F7)">N</div><div><div class="testi-name">Neha Joshi</div><div class="testi-loc">★★★★★ Delhi</div></div></div></div>
            </div>
          </div>
        </div>
        <div>
          <div class="sidebar-card">
            <div class="sidebar-card-title">📅 Available Slots – Today</div>
            <div class="slot-grid">
              <div class="slot-btn taken">9:00 AM</div><div class="slot-btn taken">10:00 AM</div>
              <div class="slot-btn sel">11:00 AM</div><div class="slot-btn">12:00 PM</div>
              <div class="slot-btn taken">2:00 PM</div><div class="slot-btn">3:00 PM</div>
              <div class="slot-btn">4:00 PM</div><div class="slot-btn taken">5:00 PM</div>
            </div>
            <button class="btn btn-primary btn-sm" style="width:100%;margin-top:12px" onclick="showPage('consultation')">Book 11:00 AM Slot</button>
          </div>
          <div class="sidebar-card">
            <div class="sidebar-card-title">💬 Consultation Types</div>
            <div style="display:flex;flex-direction:column;gap:8px">
              <div style="display:flex;justify-content:space-between;align-items:center;padding:10px;background:var(--cream);border-radius:var(--r);border:1px solid var(--border)"><div><div style="font-weight:700;font-size:12px;color:var(--navy)">💬 Chat</div><div style="font-size:10px;color:var(--text-muted)">Real-time messaging</div></div><div class="cinzel" style="font-weight:700;color:var(--saffron);font-size:13px">₹40/min</div></div>
              <div style="display:flex;justify-content:space-between;align-items:center;padding:10px;background:var(--cream);border-radius:var(--r);border:1px solid var(--border)"><div><div style="font-weight:700;font-size:12px;color:var(--navy)">📞 Phone</div><div style="font-size:10px;color:var(--text-muted)">Voice call</div></div><div class="cinzel" style="font-weight:700;color:var(--saffron);font-size:13px">₹50/min</div></div>
              <div style="display:flex;justify-content:space-between;align-items:center;padding:10px;background:var(--gold-pale);border-radius:var(--r);border:1px solid var(--border-strong)"><div><div style="font-weight:700;font-size:12px;color:var(--navy)">🎥 Video</div><div style="font-size:10px;color:var(--text-muted)">Face-to-face</div></div><div class="cinzel" style="font-weight:700;color:var(--saffron);font-size:13px">₹60/min</div></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- ═══════════════════════ PAGE: CONSULTATION ═══════════════════════ -->
<div class="page" id="page-consultation">
  <section class="section" style="background:var(--cream)">
    <div class="container">
      <div class="breadcrumb"><a onclick="showPage('astrologers')">Astrologers</a><span class="sep">/</span><a onclick="showPage('astrologer-detail')">Pt. Rajesh Sharma</a><span class="sep">/</span><span>Consultation</span></div>
      <h2 style="font-family:'Playfair Display',serif;font-size:clamp(20px,3vw,28px);color:var(--navy);margin-bottom:20px">Live Consultation <em>Session</em></h2>
      <div class="consult-layout">
        <div class="chat-win">
          <div class="chat-head">
            <div class="chat-ava">P</div>
            <div style="flex:1"><div style="font-weight:700;color:white;font-size:14px">Pt. Rajesh Sharma</div><div style="font-size:11px;color:rgba(255,255,255,0.5)">● Active now • Vedic Jyotish Expert</div></div>
            <div style="display:flex;gap:6px">
              <button style="background:rgba(255,255,255,0.1);border:none;color:white;width:30px;height:30px;border-radius:50%;cursor:pointer;font-size:13px">📞</button>
              <button style="background:rgba(255,255,255,0.1);border:none;color:white;width:30px;height:30px;border-radius:50%;cursor:pointer;font-size:13px">🎥</button>
            </div>
          </div>
          <div class="chat-msgs">
            <div class="msg-in"><div class="msg-bubble">Namaste! I have reviewed your Kundli. You have a very strong Gajakesari Yoga. How may I help you today?</div><div class="msg-time">10:32 AM</div></div>
            <div class="msg-out"><div class="msg-bubble">Namaste Panditji! I am concerned about my career. I have been at the same position for 3 years. Will there be a change soon?</div><div class="msg-time">10:34 AM</div></div>
            <div class="msg-in"><div class="msg-bubble">Jupiter is currently transiting your 10th house of career. The next 18 months — specifically from August 2026 — will bring significant opportunities. A promotion or sector change is highly indicated.</div><div class="msg-time">10:36 AM</div></div>
            <div class="msg-out"><div class="msg-bubble">Should I consider switching companies or wait for a promotion?</div><div class="msg-time">10:37 AM</div></div>
            <div class="msg-in"><div class="msg-bubble">Your Dasha lord Sun in the 1st house gives you authority. September–November 2026 is excellent for job changes. Shall I also look at your Navamsa chart?</div><div class="msg-time">10:39 AM</div></div>
          </div>
          <div style="background:var(--cream);padding:8px 14px;font-size:11px;color:var(--text-muted);border-top:1px solid var(--border);display:flex;justify-content:space-between">
            <span>Session: <strong style="color:var(--saffron)">12:34</strong> | ₹40/min</span>
            <span>Balance: <strong style="color:var(--navy)">₹480</strong></span>
          </div>
          <div class="chat-bar">
            <button style="background:none;border:1px solid var(--border-strong);border-radius:7px;padding:7px;cursor:pointer;font-size:13px">📎</button>
            <input class="chat-input" type="text" placeholder="Type your message...">
            <button class="chat-send">➤</button>
          </div>
        </div>
        <div>
          <div class="sidebar-card">
            <div class="sidebar-card-title">📋 Session Details</div>
            <div style="display:flex;flex-direction:column;gap:8px;font-size:12px">
              <div style="display:flex;justify-content:space-between"><span style="color:var(--text-muted)">Astrologer</span><span style="font-weight:700;color:var(--navy)">Pt. Rajesh Sharma</span></div>
              <div style="display:flex;justify-content:space-between"><span style="color:var(--text-muted)">Type</span><span style="font-weight:700;color:var(--navy)">Chat Consultation</span></div>
              <div style="display:flex;justify-content:space-between"><span style="color:var(--text-muted)">Rate</span><span style="font-weight:700;color:var(--saffron)">₹40/minute</span></div>
              <div style="display:flex;justify-content:space-between"><span style="color:var(--text-muted)">Started</span><span style="font-weight:700;color:var(--navy)">10:32 AM</span></div>
              <div style="display:flex;justify-content:space-between;padding-top:8px;border-top:1px solid var(--border)"><span style="color:var(--text-muted)">Total Charged</span><span style="font-weight:800;color:var(--navy);font-family:'Cinzel',serif">₹494</span></div>
            </div>
            <button class="btn-danger" style="margin-top:11px">⏹ End Session</button>
          </div>
          <div class="sidebar-card">
            <div class="sidebar-card-title">📎 Share Your Kundli</div>
            <div style="border:2px dashed var(--border-strong);border-radius:var(--r);padding:16px;text-align:center;cursor:pointer" onclick="this.style.borderColor='var(--gold)'">
              <div style="font-size:24px;margin-bottom:6px">📄</div>
              <div style="font-size:12px;font-weight:700;color:var(--navy);margin-bottom:2px">Drop Kundli PDF here</div>
              <div style="font-size:11px;color:var(--text-muted)">or click to browse</div>
            </div>
          </div>
          <div class="sidebar-card">
            <div class="sidebar-card-title">💡 Ask About</div>
            <div style="display:flex;flex-wrap:wrap;gap:6px">
              <button class="filter-chip" style="font-size:10px;padding:5px 10px">💼 Career</button>
              <button class="filter-chip" style="font-size:10px;padding:5px 10px">💑 Marriage</button>
              <button class="filter-chip" style="font-size:10px;padding:5px 10px">💰 Finance</button>
              <button class="filter-chip" style="font-size:10px;padding:5px 10px">🏥 Health</button>
              <button class="filter-chip" style="font-size:10px;padding:5px 10px">🌍 Travel</button>
              <button class="filter-chip" style="font-size:10px;padding:5px 10px">🏠 Property</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- ═══════════════════════ PAGE: PLANS ═══════════════════════ -->
<div class="page" id="page-plans">
  <div class="page-hero-sm">
    <h1 class="cinzel">Choose Your Sacred Plan</h1>
    <p>Unlock the full power of Vedic astrology guidance</p>
    <div style="display:flex;justify-content:center;gap:9px;margin-top:16px">
      <button class="filter-chip active" style="background:white;color:var(--navy);border-color:white">Monthly</button>
      <button class="filter-chip" style="border-color:rgba(255,255,255,0.3);color:rgba(255,255,255,0.8)">Yearly <span style="background:var(--saffron);color:white;font-size:9px;padding:1px 5px;border-radius:3px;margin-left:3px">Save 30%</span></button>
    </div>
  </div>
  <section class="section plans-section">
    <div class="container">
      <div class="plans-grid" id="fullPlansGrid"></div>
      <div style="background:rgba(200,147,26,0.07);border:1px solid rgba(200,147,26,0.18);border-radius:var(--r-lg);padding:30px;margin-top:40px;text-align:center">
        <div style="font-size:28px;margin-bottom:9px">🏢</div>
        <h3 class="cinzel" style="color:white;font-size:19px;margin-bottom:6px">Enterprise / Temple Plans</h3>
        <p style="color:rgba(255,255,255,0.45);font-size:13px;max-width:460px;margin:0 auto 16px">Custom pricing for astrology businesses, temples, and large families. Includes white-label options and API access.</p>
        <button class="btn btn-gold btn-sm" onclick="showPage('contact')">Contact for Enterprise Pricing</button>
      </div>
    </div>
  </section>
</div>

<!-- ═══════════════════════ PAGE: PAYMENT SUCCESS ═══════════════════════ -->
<div class="page" id="page-payment-success">
  <section class="section" style="background:var(--cream)">
    <div class="container">
      <div class="success-card">
        <span class="success-icon">✨</span>
        <h2 class="success-title">Your Sacred Journey Begins!</h2>
        <p class="success-desc">Welcome to AstroVeda Gold Plan. You now have access to unlimited cosmic guidance, expert astrologers, and personalized predictions.</p>
        <div class="order-box">
          <div class="order-row"><span>Plan</span><span>Gold – Monthly</span></div>
          <div class="order-row"><span>Amount Paid</span><span>₹999</span></div>
          <div class="order-row"><span>Payment Method</span><span>UPI – success@icici</span></div>
          <div class="order-row"><span>Transaction ID</span><span style="font-size:10px">AV2026060612345</span></div>
          <div class="order-row"><span>Valid Until</span><span>6 July 2026</span></div>
          <div class="order-row"><span style="color:var(--saffron)">Bonus Credit</span><span style="color:var(--saffron)">₹200 added</span></div>
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap">
          <button class="btn btn-primary" style="flex:1;min-width:130px" onclick="showPage('dashboard')">Go to Dashboard</button>
          <button class="btn btn-secondary" style="flex:1;min-width:130px" onclick="showPage('kundli')">Generate Kundli</button>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- ═══════════════════════ PAGE: SHOP ═══════════════════════ -->
<div class="page" id="page-shop">
  <div class="page-hero-sm"><h1>Sacred Gemstone Shop</h1><p>Authentic, Astrologer-Recommended Gems, Rudraksha & Yantra</p></div>
  <section class="section" style="background:var(--cream)">
    <div class="container">
      <div style="display:flex;gap:8px;margin-bottom:22px;flex-wrap:wrap">
        <button class="filter-chip active">All Products</button>
        <button class="filter-chip">💎 Gemstones</button>
        <button class="filter-chip">📿 Rudraksha</button>
        <button class="filter-chip">🔷 Yantra</button>
        <button class="filter-chip">🕉 Puja Services</button>
        <button class="filter-chip">🌺 Kavach</button>
      </div>
      <div class="shop-grid" id="shopGrid"></div>
    </div>
  </section>
</div>

<!-- ═══════════════════════ PAGE: DASHBOARD ═══════════════════════ -->
<div class="page" id="page-dashboard">
  <div class="dash-layout">
    <div class="sidebar">
      <div style="padding:0 18px 16px;border-bottom:1px solid rgba(200,147,26,0.12);margin-bottom:5px">
        <div style="display:flex;align-items:center;gap:9px">
          <div style="width:38px;height:38px;border-radius:50%;background:rgba(200,147,26,0.18);border:2px solid var(--gold);display:flex;align-items:center;justify-content:center;font-family:'Cinzel',serif;font-weight:700;color:var(--gold-bright);font-size:14px">R</div>
          <div><div style="font-weight:700;color:white;font-size:13px">Rahul Sharma</div><div style="font-size:10px;color:rgba(255,255,255,0.35)">🏆 Gold Member</div></div>
        </div>
      </div>
      <div class="sidebar-sec">Main</div>
      <div class="sidebar-item active"><span class="sidebar-icon">🏠</span>Dashboard</div>
      <div class="sidebar-item" onclick="showPage('kundli')"><span class="sidebar-icon">🔭</span>My Kundli<span class="sidebar-badge">3</span></div>
      <div class="sidebar-item" onclick="showPage('horoscope')"><span class="sidebar-icon">⭐</span>Horoscope</div>
      <div class="sidebar-item" onclick="showPage('consultation')"><span class="sidebar-icon">💬</span>Consultations<span class="sidebar-badge">1</span></div>
      <div class="sidebar-item"><span class="sidebar-icon">📅</span>Appointments</div>
      <div class="sidebar-sec">Predictions</div>
      <div class="sidebar-item"><span class="sidebar-icon">💼</span>Career</div>
      <div class="sidebar-item"><span class="sidebar-icon">💑</span>Marriage</div>
      <div class="sidebar-item"><span class="sidebar-icon">💰</span>Finance</div>
      <div class="sidebar-item"><span class="sidebar-icon">🏥</span>Health</div>
      <div class="sidebar-sec">Account</div>
      <div class="sidebar-item" onclick="showPage('profile')"><span class="sidebar-icon">👤</span>My Profile</div>
      <div class="sidebar-item" onclick="showPage('plans')"><span class="sidebar-icon">💳</span>Subscription</div>
      <div class="sidebar-item"><span class="sidebar-icon">📄</span>Reports</div>
      <div class="sidebar-item" onclick="showPage('shop')"><span class="sidebar-icon">🛍</span>Orders</div>
      <div class="sidebar-item" onclick="showPage('notifications')"><span class="sidebar-icon">🔔</span>Notifications<span class="sidebar-badge">5</span></div>
      <div class="sidebar-item"><span class="sidebar-icon">⚙</span>Settings</div>
    </div>
    <div class="dash-main">
      <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:24px;flex-wrap:wrap;gap:12px">
        <div><div style="font-family:'Playfair Display',serif;font-size:24px;font-weight:700;color:var(--navy)">Namaste, Rahul Ji 🙏</div><div style="font-size:12px;color:var(--text-muted);margin-top:3px">Saturday, 6 June 2026 | Gold Plan Active</div></div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
          <button class="btn btn-secondary btn-sm" onclick="showPage('kundli')">+ New Kundli</button>
          <button class="btn btn-primary btn-sm" onclick="showPage('consultation')">Chat with Astrologer</button>
        </div>
      </div>
      <div style="background:linear-gradient(135deg,var(--navy),var(--navy-mid));border-radius:var(--r-lg);padding:20px;margin-bottom:20px;border:1px solid rgba(200,147,26,0.18)">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:13px;flex-wrap:wrap;gap:8px">
          <div class="cinzel" style="color:var(--gold-bright);font-size:13px">✦ Your Cosmic Snapshot – Today</div>
          <span class="tag" style="background:rgba(200,147,26,0.13);border-color:rgba(200,147,26,0.28);color:var(--gold-light)">♈ Aries</span>
        </div>
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px" id="dashSnap">
          <div style="text-align:center"><div style="font-size:24px;margin-bottom:4px">⭐</div><div class="cinzel" style="color:var(--gold-bright);font-size:15px">8.2/10</div><div style="font-size:10px;color:rgba(255,255,255,0.35)">Today's Score</div></div>
          <div style="text-align:center"><div style="font-size:24px;margin-bottom:4px">💼</div><div class="cinzel" style="color:var(--gold-bright);font-size:13px">Excellent</div><div style="font-size:10px;color:rgba(255,255,255,0.35)">Career Outlook</div></div>
          <div style="text-align:center"><div style="font-size:24px;margin-bottom:4px">💎</div><div style="font-size:11px;color:white;font-weight:600">Yellow Sapphire</div><div style="font-size:10px;color:rgba(255,255,255,0.35)">Recommended Gem</div></div>
          <div style="text-align:center"><div style="font-size:24px;margin-bottom:4px">📿</div><div style="font-size:11px;color:white;font-weight:600">Om Namah Shivaya</div><div style="font-size:10px;color:rgba(255,255,255,0.35)">Today's Mantra</div></div>
        </div>
      </div>
      <div class="kpi-grid">
        <div class="kpi-card"><div class="kpi-label">Kundli Generated</div><div class="kpi-val">3</div><div class="kpi-change kpi-up">↑ 1 this month</div></div>
        <div class="kpi-card"><div class="kpi-label">Consultations Done</div><div class="kpi-val">7</div><div class="kpi-change kpi-up">↑ 2 this month</div></div>
        <div class="kpi-card"><div class="kpi-label">Reports Downloaded</div><div class="kpi-val">12</div><div class="kpi-change kpi-up">↑ 4 this month</div></div>
        <div class="kpi-card"><div class="kpi-label">Plan Expiry</div><div class="kpi-val" style="font-size:17px">6 Jul 2026</div><div class="kpi-change kpi-warn">30 days left</div></div>
      </div>
      <div class="grid-2" style="margin-bottom:18px">
        <div class="card card-body">
          <div class="card-title">Recent Activity <a onclick="showPage('notifications')">View all →</a></div>
          <div class="activity-item"><div class="act-dot" style="background:rgba(255,107,0,0.1)">🔭</div><div><div class="act-text">Generated Kundli for <strong>Priya (daughter)</strong></div><div class="act-time">Today, 9:14 AM</div></div></div>
          <div class="activity-item"><div class="act-dot" style="background:rgba(200,147,26,0.1)">💬</div><div><div class="act-text">Consultation with <strong>Pt. Rajesh Sharma</strong> – 12 min</div><div class="act-time">Yesterday, 10:32 AM</div></div></div>
          <div class="activity-item"><div class="act-dot" style="background:rgba(34,197,94,0.1)">📄</div><div><div class="act-text">Downloaded <strong>Career Prediction Report</strong></div><div class="act-time">3 June, 3:45 PM</div></div></div>
          <div class="activity-item"><div class="act-dot" style="background:rgba(139,92,246,0.1)">💳</div><div><div class="act-text">Gold Plan renewed for <strong>₹999</strong></div><div class="act-time">1 June, 12:00 AM</div></div></div>
        </div>
        <div class="card card-body">
          <div class="card-title">Upcoming Appointments</div>
          <div style="display:flex;flex-direction:column;gap:10px">
            <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:var(--r);padding:11px;display:flex;gap:10px;align-items:center;flex-wrap:wrap">
              <div style="text-align:center;background:var(--navy);border-radius:7px;padding:6px 10px;color:white;flex-shrink:0"><div class="cinzel" style="font-size:16px;font-weight:700">08</div><div style="font-size:9px;opacity:.55;text-transform:uppercase">Jun</div></div>
              <div style="flex:1;min-width:100px"><div style="font-weight:700;font-size:12px;color:var(--navy)">Pt. Rajesh Sharma</div><div style="font-size:11px;color:var(--text-muted)">Video • 11:00 AM</div></div>
              <button class="btn-navy btn-sm" onclick="showPage('consultation')">Join</button>
            </div>
            <div style="background:var(--cream);border:1px solid var(--border);border-radius:var(--r);padding:11px;display:flex;gap:10px;align-items:center;flex-wrap:wrap">
              <div style="text-align:center;background:rgba(200,147,26,0.13);border-radius:7px;padding:6px 10px;color:var(--gold);flex-shrink:0"><div class="cinzel" style="font-size:16px;font-weight:700">15</div><div style="font-size:9px;opacity:.55;text-transform:uppercase">Jun</div></div>
              <div style="flex:1;min-width:100px"><div style="font-weight:700;font-size:12px;color:var(--navy)">Dr. Deepa Verma</div><div style="font-size:11px;color:var(--text-muted)">Chat • 3:00 PM</div></div>
              <button class="btn-navy btn-sm" style="background:var(--gold)">Upcoming</button>
            </div>
          </div>
        </div>
      </div>
      <div class="card card-body" style="margin-bottom:18px">
        <div class="card-title">My Kundli Charts <a onclick="showPage('kundli')">+ New Kundli →</a></div>
        <div style="display:flex;flex-direction:column;gap:8px">
          <div style="display:flex;align-items:center;gap:10px;padding:10px;background:var(--cream);border-radius:var(--r);border:1px solid var(--border);flex-wrap:wrap"><div style="width:36px;height:36px;background:var(--navy);border-radius:7px;display:flex;align-items:center;justify-content:center;color:var(--gold-bright);font-size:15px;flex-shrink:0">🔭</div><div style="flex:1;min-width:100px"><div style="font-weight:700;font-size:12px;color:var(--navy)">Rahul Kumar Sharma (Self)</div><div style="font-size:10px;color:var(--text-muted)">15 May 1995 | Varanasi | Aries Lagna</div></div><div style="display:flex;gap:5px;align-items:center;flex-wrap:wrap"><span class="tag">Primary</span><button class="btn-navy btn-sm" onclick="showKundliResult();showPage('kundli')">View</button></div></div>
          <div style="display:flex;align-items:center;gap:10px;padding:10px;background:var(--cream);border-radius:var(--r);border:1px solid var(--border);flex-wrap:wrap"><div style="width:36px;height:36px;background:rgba(124,58,237,0.13);border-radius:7px;display:flex;align-items:center;justify-content:center;color:#A855F7;font-size:15px;flex-shrink:0">🔭</div><div style="flex:1;min-width:100px"><div style="font-weight:700;font-size:12px;color:var(--navy)">Priya Sharma (Daughter)</div><div style="font-size:10px;color:var(--text-muted)">3 Jan 2020 | Delhi | Taurus Lagna</div></div><button class="btn-navy btn-sm">View</button></div>
        </div>
      </div>
      <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:10px">
        <button onclick="showPage('kundli')" style="padding:15px 8px;background:white;border:1px solid var(--border);border-radius:var(--r);cursor:pointer;text-align:center;font-family:'Mulish',sans-serif;transition:all .2s" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'"><div style="font-size:20px;margin-bottom:4px">🔭</div><div style="font-size:10px;font-weight:700;color:var(--navy)">New Kundli</div></button>
        <button onclick="showPage('horoscope')" style="padding:15px 8px;background:white;border:1px solid var(--border);border-radius:var(--r);cursor:pointer;text-align:center;font-family:'Mulish',sans-serif;transition:all .2s" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'"><div style="font-size:20px;margin-bottom:4px">⭐</div><div style="font-size:10px;font-weight:700;color:var(--navy)">Horoscope</div></button>
        <button onclick="showPage('consultation')" style="padding:15px 8px;background:white;border:1px solid var(--border);border-radius:var(--r);cursor:pointer;text-align:center;font-family:'Mulish',sans-serif;transition:all .2s" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'"><div style="font-size:20px;margin-bottom:4px">💬</div><div style="font-size:10px;font-weight:700;color:var(--navy)">Consult</div></button>
        <button onclick="showPage('matchmaking')" style="padding:15px 8px;background:white;border:1px solid var(--border);border-radius:var(--r);cursor:pointer;text-align:center;font-family:'Mulish',sans-serif;transition:all .2s" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'"><div style="font-size:20px;margin-bottom:4px">💑</div><div style="font-size:10px;font-weight:700;color:var(--navy)">Kundli Milan</div></button>
      </div>
    </div>
  </div>
</div>

<!-- ═══════════════════════ PAGE: LOGIN ═══════════════════════ -->
<div class="page" id="page-login">
  <div class="auth-split">
    <div class="auth-left">
      <div class="auth-left-content">
        <div style="font-size:42px;margin-bottom:13px">ॐ</div>
        <h2>Welcome Back to <span>AstroVeda</span></h2>
        <p>Continue your sacred journey. Your personalized Vedic guidance awaits.</p>
        <div class="auth-feature">Access all your Kundli charts</div>
        <div class="auth-feature">Continue consultations with astrologers</div>
        <div class="auth-feature">View your personalized predictions</div>
        <div class="auth-feature">Track your entire cosmic journey</div>
      </div>
    </div>
    <div class="auth-right">
      <div class="auth-card">
        <div class="auth-logo"><span class="om">ॐ</span><h3>AstroVeda</h3></div>
        <h2 class="auth-title">Sign In</h2>
        <p class="auth-sub">Enter your credentials to continue</p>
        <button class="social-btn">🇬 Sign in with Google</button>
        <button class="social-btn">📘 Sign in with Facebook</button>
        <div class="auth-divider">or sign in with email</div>
        <div class="form-group" style="margin-bottom:12px"><label class="form-label">Email or Phone</label><input class="form-input" type="text" placeholder="Enter email or mobile number"></div>
        <div class="form-group" style="margin-bottom:7px"><label class="form-label" style="display:flex;justify-content:space-between">Password <a class="forgot-link" href="#">Forgot Password?</a></label><input class="form-input" type="password" placeholder="Enter your password"></div>
        <div style="display:flex;align-items:center;gap:6px;margin-bottom:16px;font-size:12px;color:var(--text-muted)"><input type="checkbox"> Remember me on this device</div>
        <button class="btn btn-primary" style="width:100%" onclick="showPage('dashboard')">Sign In to AstroVeda</button>
        <div style="margin-top:13px;padding:12px;background:var(--cream);border:1px solid var(--border);border-radius:var(--r);text-align:center">
          <div style="font-size:11px;font-weight:700;color:var(--navy);margin-bottom:6px">OTP Login</div>
          <div style="display:flex;gap:7px"><input class="form-input" type="tel" placeholder="+91 Mobile Number" style="flex:1"><button class="btn btn-primary btn-sm" style="white-space:nowrap">Get OTP</button></div>
        </div>
        <div class="auth-footer">Don't have an account? <a onclick="showPage('register')">Register Free →</a></div>
      </div>
    </div>
  </div>
</div>

<!-- ═══════════════════════ PAGE: REGISTER ═══════════════════════ -->
<div class="page" id="page-register">
  <div class="auth-split">
    <div class="auth-left" style="background:linear-gradient(135deg,var(--maroon),var(--navy))">
      <div class="auth-left-content">
        <div style="font-size:42px;margin-bottom:13px">🌙</div>
        <h2>Begin Your <span>Cosmic Journey</span></h2>
        <p>Join 2.5 million seekers who trust AstroVeda for authentic Vedic guidance.</p>
        <div class="auth-feature">Free Janam Kundli – No credit card needed</div>
        <div class="auth-feature">AI-assisted birth chart analysis</div>
        <div class="auth-feature">Access 1,200+ verified astrologers</div>
        <div class="auth-feature">Daily personalized horoscope</div>
        <div style="margin-top:24px;background:rgba(200,147,26,0.1);border:1px solid rgba(200,147,26,0.2);border-radius:var(--r);padding:13px">
          <div style="color:var(--gold-bright);font-weight:700;font-size:13px;margin-bottom:3px">🎁 Welcome Gift</div>
          <div style="color:rgba(255,255,255,0.65);font-size:12px">Get ₹200 consultation credit FREE on registration!</div>
        </div>
      </div>
    </div>
    <div class="auth-right">
      <div class="auth-card">
        <div class="auth-logo"><span class="om">ॐ</span><h3>AstroVeda</h3></div>
        <h2 class="auth-title">Create Free Account</h2>
        <p class="auth-sub">Start your Vedic journey today</p>
        <button class="social-btn">🇬 Continue with Google</button>
        <div class="auth-divider">or register with email</div>
        <div class="form-grid-2" style="margin-bottom:11px">
          <div class="form-group"><label class="form-label">First Name</label><input class="form-input" placeholder="Rahul"></div>
          <div class="form-group"><label class="form-label">Last Name</label><input class="form-input" placeholder="Sharma"></div>
        </div>
        <div class="form-group" style="margin-bottom:11px"><label class="form-label">Mobile <span class="req">*</span></label><input class="form-input" type="tel" placeholder="+91 98765 43210"></div>
        <div class="form-group" style="margin-bottom:11px"><label class="form-label">Email Address</label><input class="form-input" type="email" placeholder="rahul@example.com"></div>
        <div class="form-group" style="margin-bottom:13px"><label class="form-label">Create Password</label><input class="form-input" type="password" placeholder="Minimum 8 characters"></div>
        <div style="font-size:12px;color:var(--text-muted);margin-bottom:14px;line-height:1.6"><input type="checkbox" checked style="margin-right:5px"> I agree to the <a href="#" style="color:var(--saffron)">Terms of Service</a> and <a href="#" style="color:var(--saffron)">Privacy Policy</a></div>
        <button class="btn btn-primary" style="width:100%" onclick="showPage('dashboard')">✦ Create Free Account</button>
        <div class="auth-footer">Already have an account? <a onclick="showPage('login')">Sign In →</a></div>
      </div>
    </div>
  </div>
</div>

<!-- ═══════════════════════ PAGE: PROFILE ═══════════════════════ -->
<div class="page" id="page-profile">
  <section class="section" style="background:var(--cream)">
    <div class="container">
      <div class="profile-header">
        <div class="profile-ava-wrap"><div class="profile-ava">R</div><button class="profile-edit">✏</button></div>
        <div style="flex:1">
          <div class="profile-name-big">Rahul Kumar Sharma</div>
          <div class="profile-since">Member since January 2023 · Gold Plan Active</div>
          <div class="profile-badges"><span class="profile-badge-chip">🏆 Gold Member</span><span class="profile-badge-chip">✅ KYC Verified</span><span class="profile-badge-chip">⭐ 7 Consultations</span></div>
        </div>
        <div class="profile-stats">
          <div style="text-align:center"><div class="profile-stat-n">3</div><div class="profile-stat-l">Kundli Charts</div></div>
          <div style="text-align:center"><div class="profile-stat-n">7</div><div class="profile-stat-l">Consultations</div></div>
          <div style="text-align:center"><div class="profile-stat-n">12</div><div class="profile-stat-l">Reports</div></div>
        </div>
      </div>
      <div class="grid-2">
        <div class="card card-body">
          <div class="card-title">Personal Information</div>
          <div class="form-grid-2">
            <div class="form-group"><label class="form-label">First Name</label><input class="form-input" value="Rahul"></div>
            <div class="form-group"><label class="form-label">Last Name</label><input class="form-input" value="Sharma"></div>
            <div class="form-group"><label class="form-label">Date of Birth</label><input class="form-input" type="date" value="1995-05-15"></div>
            <div class="form-group"><label class="form-label">Gender</label><select class="form-select"><option>Male</option><option>Female</option></select></div>
            <div class="form-group full"><label class="form-label">Mobile</label><input class="form-input" value="+91 98765 43210"></div>
            <div class="form-group full"><label class="form-label">Email</label><input class="form-input" value="rahul@example.com"></div>
            <div class="form-group full"><label class="form-label">City</label><input class="form-input" value="New Delhi, India"></div>
          </div>
          <button class="btn btn-primary btn-sm" style="margin-top:16px">Save Changes</button>
        </div>
        <div>
          <div class="card card-body" style="margin-bottom:16px">
            <div class="card-title">Subscription</div>
            <div style="background:linear-gradient(135deg,var(--navy),var(--navy-mid));border-radius:var(--r);padding:16px;margin-bottom:12px">
              <div class="cinzel" style="color:var(--gold-bright);font-size:16px;margin-bottom:3px">🏆 Gold Plan</div>
              <div style="color:rgba(255,255,255,0.45);font-size:11px">Active until 6 July 2026 (30 days left)</div>
              <div style="height:4px;background:rgba(255,255,255,0.08);border-radius:2px;margin-top:10px"><div style="width:50%;height:4px;background:var(--gold);border-radius:2px"></div></div>
            </div>
            <button class="btn btn-gold btn-sm" style="width:100%" onclick="showPage('plans')">Upgrade to Platinum</button>
          </div>
          <div class="card card-body">
            <div class="card-title">Change Password</div>
            <div class="form-group" style="margin-bottom:10px"><label class="form-label">Current Password</label><input class="form-input" type="password" placeholder="••••••••"></div>
            <div class="form-group" style="margin-bottom:10px"><label class="form-label">New Password</label><input class="form-input" type="password" placeholder="••••••••"></div>
            <div class="form-group" style="margin-bottom:13px"><label class="form-label">Confirm Password</label><input class="form-input" type="password" placeholder="••••••••"></div>
            <button class="btn btn-secondary btn-sm">Update Password</button>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- ═══════════════════════ PAGE: MATCHMAKING ═══════════════════════ -->
<div class="page" id="page-matchmaking">
  <div class="page-hero-sm"><h1>Kundli Milan</h1><p>कुण्डली मिलान • Vedic Marriage Compatibility Analysis</p></div>
  <section class="section" style="background:var(--cream)">
    <div class="container">
      <div class="grid-2" style="margin-bottom:26px">
        <div class="form-card">
          <h3 class="cinzel" style="font-size:15px;color:var(--navy);margin-bottom:16px">🤵 Boy's Details</h3>
          <div class="form-group" style="margin-bottom:11px"><label class="form-label">Name</label><input class="form-input" value="Rahul Kumar Sharma"></div>
          <div class="form-group" style="margin-bottom:11px"><label class="form-label">Date of Birth</label><input class="form-input" type="date" value="1995-05-15"></div>
          <div class="form-group" style="margin-bottom:11px"><label class="form-label">Time of Birth</label><input class="form-input" type="time" value="06:30"></div>
          <div class="form-group"><label class="form-label">Place of Birth</label><input class="form-input" value="Varanasi, UP"></div>
        </div>
        <div class="form-card">
          <h3 class="cinzel" style="font-size:15px;color:var(--navy);margin-bottom:16px">👰 Girl's Details</h3>
          <div class="form-group" style="margin-bottom:11px"><label class="form-label">Name</label><input class="form-input" value="Priyanka Gupta"></div>
          <div class="form-group" style="margin-bottom:11px"><label class="form-label">Date of Birth</label><input class="form-input" type="date" value="1997-08-22"></div>
          <div class="form-group" style="margin-bottom:11px"><label class="form-label">Time of Birth</label><input class="form-input" type="time" value="14:15"></div>
          <div class="form-group"><label class="form-label">Place of Birth</label><input class="form-input" value="Lucknow, UP"></div>
        </div>
      </div>
      <div style="text-align:center;margin-bottom:32px"><button class="btn btn-primary">✦ Analyze Compatibility Now</button></div>
      <div class="form-card">
        <div class="cinzel" style="font-size:15px;font-weight:600;color:var(--navy);text-align:center;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid var(--border)">✦ Kundli Milan Report – Rahul & Priyanka</div>
        <div class="match-result-grid">
          <div>
            <div style="text-align:center;margin-bottom:16px"><div class="cinzel" style="font-size:15px;color:var(--navy)">Rahul Kumar Sharma</div><div style="font-size:11px;color:var(--text-muted)">Aries Lagna • Moon in Aries</div></div>
            <div class="match-row"><span class="match-aspect">Varna (1)</span><div class="match-dots"></div><div class="match-bar"><div class="match-fill fill-g" style="width:100%"></div></div></div>
            <div class="match-row"><span class="match-aspect">Vashya (2)</span><div class="match-dots"></div><div class="match-bar"><div class="match-fill fill-g" style="width:80%"></div></div></div>
            <div class="match-row"><span class="match-aspect">Tara (3)</span><div class="match-dots"></div><div class="match-bar"><div class="match-fill fill-y" style="width:66%"></div></div></div>
            <div class="match-row"><span class="match-aspect">Yoni (4)</span><div class="match-dots"></div><div class="match-bar"><div class="match-fill fill-g" style="width:75%"></div></div></div>
            <div class="match-row"><span class="match-aspect">Maitri (5)</span><div class="match-dots"></div><div class="match-bar"><div class="match-fill fill-y" style="width:60%"></div></div></div>
            <div class="match-row"><span class="match-aspect">Gan (6)</span><div class="match-dots"></div><div class="match-bar"><div class="match-fill fill-g" style="width:100%"></div></div></div>
            <div class="match-row"><span class="match-aspect">Bhakut (7)</span><div class="match-dots"></div><div class="match-bar"><div class="match-fill fill-r" style="width:42%"></div></div></div>
            <div class="match-row"><span class="match-aspect">Nadi (8)</span><div class="match-dots"></div><div class="match-bar"><div class="match-fill fill-g" style="width:100%"></div></div></div>
          </div>
          <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:13px">
            <div class="match-circle"><span class="match-circle-n">28</span><span class="match-circle-l">/ 36 Gunas</span></div>
            <div style="background:rgba(34,197,94,0.08);border:1px solid rgba(34,197,94,0.28);border-radius:var(--r);padding:8px 13px;text-align:center"><div style="color:#22C55E;font-weight:700;font-size:12px">✓ Compatible</div><div style="font-size:11px;color:var(--text-muted);margin-top:1px">Excellent Match</div></div>
          </div>
          <div>
            <div style="text-align:center;margin-bottom:16px"><div class="cinzel" style="font-size:15px;color:var(--navy)">Priyanka Gupta</div><div style="font-size:11px;color:var(--text-muted)">Scorpio Lagna • Moon in Taurus</div></div>
            <div style="background:var(--gold-pale);border:1px solid var(--border);border-radius:var(--r);padding:13px;margin-bottom:12px"><div style="font-weight:700;font-size:12px;color:var(--navy);margin-bottom:6px">✦ Summary</div><p style="font-size:12px;color:var(--text-muted);line-height:1.6">28/36 Gunas matched — excellent score. Strong emotional bonding, mutual respect, compatible life goals. Nadi Dosha absent — highly auspicious.</p></div>
            <div style="background:rgba(34,197,94,0.05);border:1px solid rgba(34,197,94,0.18);border-radius:var(--r);padding:11px"><div style="font-size:10px;font-weight:700;color:#15803D;margin-bottom:4px">Manglik Status</div><div style="font-size:12px;color:var(--text-muted)">Boy: Not Manglik ✓<br>Girl: Manglik (Anshik) – Minor effect, remedies available</div></div>
          </div>
        </div>
        <div style="text-align:center;margin-top:20px;padding-top:20px;border-top:1px solid var(--border);display:flex;gap:10px;justify-content:center;flex-wrap:wrap">
          <button class="btn btn-primary btn-sm" onclick="showPage('consultation')">Get Expert Consultation →</button>
          <button class="btn btn-secondary btn-sm">Download Full Report (PDF)</button>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- ═══════════════════════ PAGE: ABOUT ═══════════════════════ -->
<div class="page" id="page-about">
  <div class="about-hero-sec">
    <div class="container">
      <div class="sec-label sec-label-dark" style="margin-bottom:12px">✦ Our Story</div>
      <h1 class="sec-title sec-title-white cinzel" style="font-size:clamp(22px,4vw,40px)">Bridging Ancient Wisdom<br>with Modern Seekers</h1>
      <p style="color:rgba(255,255,255,0.45);font-size:14px;max-width:520px;margin:12px auto 0;line-height:1.7">Founded in 2015 by Vedic scholars and technologists, AstroVeda ERP is India's most trusted digital astrology platform.</p>
    </div>
  </div>
  <section class="section" style="background:white">
    <div class="container">
      <div class="grid-2" style="gap:56px;align-items:center">
        <div>
          <div class="sec-label">✦ Our Mission</div>
          <h2 class="sec-title">Making Vedic Wisdom <em>Accessible</em> to All</h2>
          <p style="font-size:14px;color:var(--text-muted);line-height:1.8;margin-bottom:14px">AstroVeda was born from a simple belief: the ancient science of Jyotish holds profound insights that can guide modern life's most important decisions.</p>
          <p style="font-size:14px;color:var(--text-muted);line-height:1.8;margin-bottom:22px">We combine thousands of years of Vedic knowledge with cutting-edge technology to make authentic astrological guidance available to every seeker, anywhere in India and beyond.</p>
          <div class="trust-badges"><div class="trust-badge">🏆 Award-winning Platform</div><div class="trust-badge">🇮🇳 Made in India</div><div class="trust-badge">2.5M+ Users</div></div>
        </div>
        <div style="height:320px;background:var(--cream-dark);border-radius:var(--r-lg);border:1px solid var(--border);display:flex;flex-direction:column;align-items:center;justify-content:center;font-size:60px;gap:10px">🌙<span style="font-size:14px;color:var(--text-muted)">Our Varanasi Office</span></div>
      </div>
    </div>
  </section>
  <section class="section" style="background:var(--cream)">
    <div class="container">
      <div class="text-center" style="margin-bottom:32px"><div class="sec-label">✦ Leadership</div><h2 class="sec-title">The <em>Minds</em> Behind AstroVeda</h2></div>
      <div class="team-grid">
        <div class="team-card"><div class="team-ava">A</div><div class="team-name-t">Dr. Arvind Mishra</div><div class="team-role-t">Founder & Chief Jyotishi</div></div>
        <div class="team-card"><div class="team-ava" style="background:rgba(124,58,237,0.18);color:#A855F7">S</div><div class="team-name-t">Sneha Kapoor</div><div class="team-role-t">Chief Technology Officer</div></div>
        <div class="team-card"><div class="team-ava" style="background:rgba(5,150,105,0.18);color:#10B981">R</div><div class="team-name-t">Raghav Pillai</div><div class="team-role-t">Head of Astrologer Relations</div></div>
        <div class="team-card"><div class="team-ava" style="background:rgba(255,107,0,0.18);color:var(--saffron)">M</div><div class="team-name-t">Manisha Singh</div><div class="team-role-t">Director of Operations</div></div>
      </div>
    </div>
  </section>
  <section class="section-sm" style="background:var(--navy)">
    <div class="container">
      <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:20px;text-align:center" id="aboutStats">
        <div><div class="cinzel" style="font-size:32px;font-weight:700;color:var(--gold-bright)">2.5M+</div><div style="color:rgba(255,255,255,0.45);font-size:12px;margin-top:4px">Happy Seekers</div></div>
        <div><div class="cinzel" style="font-size:32px;font-weight:700;color:var(--gold-bright)">1,200+</div><div style="color:rgba(255,255,255,0.45);font-size:12px;margin-top:4px">Expert Astrologers</div></div>
        <div><div class="cinzel" style="font-size:32px;font-weight:700;color:var(--gold-bright)">50M+</div><div style="color:rgba(255,255,255,0.45);font-size:12px;margin-top:4px">Kundlis Generated</div></div>
        <div><div class="cinzel" style="font-size:32px;font-weight:700;color:var(--gold-bright)">4.9★</div><div style="color:rgba(255,255,255,0.45);font-size:12px;margin-top:4px">Average Rating</div></div>
      </div>
    </div>
  </section>
</div>

<!-- ═══════════════════════ PAGE: FAQ ═══════════════════════ -->
<div class="page" id="page-faq">
  <div class="page-hero-sm"><h1>Frequently Asked Questions</h1><p>Everything you need to know about AstroVeda</p></div>
  <section class="section" style="background:var(--cream)">
    <div class="container" style="max-width:740px">
      <div style="margin-bottom:20px"><div class="sec-label">✦ Getting Started</div></div>
      <div class="faq-item open"><div class="faq-q" onclick="toggleFaq(this)">What is AstroVeda ERP? <span class="faq-arrow">▼</span></div><div class="faq-a">AstroVeda ERP is India's most comprehensive digital Vedic astrology platform. We provide authentic Janam Kundli generation, expert astrologer consultations, daily horoscopes, Panchang, match-making analysis, and spiritual e-commerce — all in one trusted platform.</div></div>
      <div class="faq-item"><div class="faq-q" onclick="toggleFaq(this)">How accurate is the Kundli generated? <span class="faq-arrow">▼</span></div><div class="faq-a">Our Kundli is generated using the same Swiss Ephemeris calculations used by professional Vedic astrologers, with precision to the arc-minute level. Accuracy depends entirely on the accuracy of your birth details, especially the time of birth.</div></div>
      <div class="faq-item"><div class="faq-q" onclick="toggleFaq(this)">Are the astrologers on AstroVeda genuine and certified? <span class="faq-arrow">▼</span></div><div class="faq-a">Yes! All astrologers on AstroVeda go through a rigorous verification process including certification checks, a practical assessment test, and a probationary period. We only onboard astrologers with proven expertise and ethical practices.</div></div>
      <div class="faq-item"><div class="faq-q" onclick="toggleFaq(this)">What payment methods are accepted? <span class="faq-arrow">▼</span></div><div class="faq-a">We accept all major payment methods including UPI (GPay, PhonePe, Paytm), Credit/Debit Cards, Net Banking, and EMI options. All transactions are processed through Razorpay's secure payment gateway with SSL encryption.</div></div>
      <div class="faq-item"><div class="faq-q" onclick="toggleFaq(this)">Can I get a refund? <span class="faq-arrow">▼</span></div><div class="faq-a">We offer a 7-day money-back guarantee on subscription plans if you are not satisfied. Consultation charges are non-refundable once the session has started. Our support team reviews disputed cases individually.</div></div>
      <div class="faq-item"><div class="faq-q" onclick="toggleFaq(this)">How does chat consultation work? <span class="faq-arrow">▼</span></div><div class="faq-a">Select an available astrologer, start the session, and chat in real-time. Sessions are charged per minute. You can also share your Kundli PDF during the session. All sessions are fully encrypted for privacy.</div></div>
      <div class="faq-item"><div class="faq-q" onclick="toggleFaq(this)">Is my personal data and Kundli safe? <span class="faq-arrow">▼</span></div><div class="faq-a">Absolutely. AstroVeda follows strict data privacy standards compliant with India's Personal Data Protection guidelines. Your data is encrypted and stored securely on AWS servers. We never sell or share your personal data with third parties.</div></div>
      <div class="faq-item"><div class="faq-q" onclick="toggleFaq(this)">How do I become an astrologer on AstroVeda? <span class="faq-arrow">▼</span></div><div class="faq-a">Click "Become an Astrologer" in the footer and submit your application with your credentials and experience. Our team will review and conduct a skills assessment. The entire process takes 7–14 days.</div></div>
    </div>
  </section>
</div>

<!-- ═══════════════════════ PAGE: CONTACT ═══════════════════════ -->
<div class="page" id="page-contact">
  <div class="page-hero-sm"><h1>Contact Us</h1><p>Our support team is here to help you</p></div>
  <section class="section" style="background:var(--cream)">
    <div class="container">
      <div class="grid-2" style="gap:44px;align-items:start">
        <div>
          <div class="sec-label">✦ Get In Touch</div>
          <h2 class="sec-title">We're Here to <em>Help</em></h2>
          <p style="font-size:14px;color:var(--text-muted);line-height:1.7;margin-bottom:28px">Whether you have questions about our services, need help with your account, or want to become an astrologer on our platform — we'd love to hear from you.</p>
          <div class="contact-info-item"><div class="contact-icon-box">📞</div><div><div class="contact-label-t">Phone Support</div><div class="contact-val">+91 98765 43210</div><div style="font-size:11px;color:var(--text-muted);margin-top:2px">Mon–Sat, 9 AM – 9 PM IST</div></div></div>
          <div class="contact-info-item"><div class="contact-icon-box">✉️</div><div><div class="contact-label-t">Email Support</div><div class="contact-val">support@astroveda.in</div><div style="font-size:11px;color:var(--text-muted);margin-top:2px">Response within 24 hours</div></div></div>
          <div class="contact-info-item"><div class="contact-icon-box">💬</div><div><div class="contact-label-t">WhatsApp</div><div class="contact-val">+91 98765 43210</div><div style="font-size:11px;color:var(--text-muted);margin-top:2px">Quick queries via WhatsApp</div></div></div>
          <div class="contact-info-item"><div class="contact-icon-box">📍</div><div><div class="contact-label-t">Head Office</div><div class="contact-val">AstroVeda Technologies Pvt. Ltd.</div><div style="font-size:11px;color:var(--text-muted);margin-top:2px">B-204, Cyber City, Gurugram, Haryana 122002</div></div></div>
        </div>
        <div class="form-card">
          <h3 class="cinzel" style="font-size:16px;color:var(--navy);margin-bottom:16px">Send Us a Message</h3>
          <div class="form-group" style="margin-bottom:13px"><label class="form-label">Your Name</label><input class="form-input" placeholder="Full Name"></div>
          <div class="form-group" style="margin-bottom:13px"><label class="form-label">Email Address</label><input class="form-input" type="email" placeholder="email@example.com"></div>
          <div class="form-group" style="margin-bottom:13px"><label class="form-label">Subject</label><select class="form-select"><option>Select a topic</option><option>Account & Billing</option><option>Kundli Issues</option><option>Astrologer Complaint</option><option>Become an Astrologer</option><option>Partnership</option></select></div>
          <div class="form-group" style="margin-bottom:16px"><label class="form-label">Message</label><textarea class="form-input form-textarea" rows="5" placeholder="Describe your query in detail..."></textarea></div>
          <button class="btn btn-primary" style="width:100%">Send Message ✦</button>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- ═══════════════════════ PAGE: NOTIFICATIONS ═══════════════════════ -->
<div class="page" id="page-notifications">
  <div class="page-hero-sm"><h1>Notifications</h1><p>Stay updated with your cosmic journey</p></div>
  <section class="section" style="background:var(--cream)">
    <div class="container">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;max-width:680px;margin-left:auto;margin-right:auto">
        <div style="font-size:12px;color:var(--text-muted)">5 unread notifications</div>
        <button style="background:none;border:none;color:var(--gold);font-weight:600;font-size:12px;cursor:pointer;font-family:'Mulish',sans-serif">Mark all as read</button>
      </div>
      <div class="notif-list">
        <div class="notif-item unread"><div class="notif-icon-box" style="background:rgba(255,107,0,0.1)">🔔</div><div style="flex:1"><div class="notif-title">Appointment Reminder <span class="notif-new">NEW</span></div><div class="notif-desc">Your video consultation with Pt. Rajesh Sharma is tomorrow at 11:00 AM. Share your Kundli before the session.</div><div class="notif-time">2 hours ago</div></div></div>
        <div class="notif-item unread"><div class="notif-icon-box" style="background:rgba(200,147,26,0.1)">⭐</div><div style="flex:1"><div class="notif-title">Daily Horoscope Ready <span class="notif-new">NEW</span></div><div class="notif-desc">Your Aries horoscope for today (6 June) is available. Overall score: 8.2/10 — an excellent day for career decisions.</div><div class="notif-time">6 hours ago</div></div></div>
        <div class="notif-item unread"><div class="notif-icon-box" style="background:rgba(34,197,94,0.1)">💳</div><div style="flex:1"><div class="notif-title">Payment Successful <span class="notif-new">NEW</span></div><div class="notif-desc">Your Gold Plan has been successfully renewed for ₹999. Active until 6 July 2026.</div><div class="notif-time">5 days ago</div></div></div>
        <div class="notif-item"><div class="notif-icon-box" style="background:rgba(139,92,246,0.1)">📄</div><div style="flex:1"><div class="notif-title">Kundli Report Ready</div><div class="notif-desc">Your Career Prediction Report for Rahul Kumar Sharma is ready for download. 5-year career analysis included.</div><div class="notif-time">3 June, 3:45 PM</div></div></div>
        <div class="notif-item"><div class="notif-icon-box" style="background:rgba(255,107,0,0.1)">🎁</div><div style="flex:1"><div class="notif-title">Special Offer – Gemstone Discount</div><div class="notif-desc">As a Gold member, get 15% off on all gemstones this week. Yellow Sapphire recommended based on your Kundli.</div><div class="notif-time">1 June</div></div></div>
      </div>
    </div>
  </section>
</div>

<!-- QUICK NAV -->
<div id="quickNav">
  <button onclick="showPage('matchmaking')">💑 Kundli Milan</button>
  <button onclick="showPage('payment-success')">✨ Payment</button>
  <button onclick="showPage('profile')">👤 Profile</button>
  <button onclick="showPage('notifications')">🔔 Notifs</button>
  <button onclick="showPage('faq')">❓ FAQ</button>
  <button onclick="showPage('contact')">📞 Contact</button>
</div>

<script>
// ══════════════════ DATA ══════════════════
var ASTROS = [
  {n:"Pt. Rajesh Sharma",s:"Vedic Jyotish · KP System",r:"4.9",c:"2,341",p:"₹40",e:"25 Yrs",online:true,init:"P",bg:"linear-gradient(135deg,#0B1C3A,#162B52)"},
  {n:"Dr. Deepa Verma",s:"Jyotish · Vastu · Gemology",r:"4.8",c:"1,876",p:"₹55",e:"18 Yrs",online:true,init:"D",bg:"linear-gradient(135deg,#2D1B69,#11075E)"},
  {n:"Acharya Mahesh Ji",s:"Muhurta · Horary · Prashna",r:"5.0",c:"4,102",p:"₹80",e:"32 Yrs",online:false,init:"A",bg:"linear-gradient(135deg,#1B3A2D,#0D3320)"},
  {n:"Sadhvi Priya Devi",s:"Tarot · Angel Cards · Spiritual",r:"4.7",c:"982",p:"₹30",e:"12 Yrs",online:true,init:"S",bg:"linear-gradient(135deg,#3A1B1B,#5C2020)"},
  {n:"Pt. Suresh Dubey",s:"Vedic · Numerology · Palmistry",r:"4.6",c:"1,234",p:"₹35",e:"20 Yrs",online:false,init:"S",bg:"linear-gradient(135deg,#1B2D3A,#0D2033)"},
  {n:"Dr. Kavitha Menon",s:"KP System · Tamil Jyotish",r:"4.9",c:"3,456",p:"₹60",e:"28 Yrs",online:true,init:"K",bg:"linear-gradient(135deg,#2D2D1B,#3A350D)"},
  {n:"Jyotish Acharya Ravi",s:"Vedic · Lal Kitab · Vastu",r:"4.7",c:"567",p:"₹25",e:"8 Yrs",online:true,init:"R",bg:"linear-gradient(135deg,#2D1B2D,#1B0D1B)"},
  {n:"Pandit Vikram Nair",s:"Kerala Jyotish · Prasna",r:"4.8",c:"2,100",p:"₹50",e:"22 Yrs",online:false,init:"V",bg:"linear-gradient(135deg,#1B1B3A,#0D0D20)"}
];

var PLANS = [
  {icon:"🌙",name:"Free",tag:"Begin your journey",curr:"₹",amt:"0",period:"Forever free",feats:["Basic Janam Kundli","1 Report/month","Daily Horoscope","Panchang Access"],no:["Astrologer Chat","PDF Download"],btn:"btn-secondary",label:"Get Started Free",page:"register"},
  {icon:"⭐",name:"Silver",tag:"For regular seekers",curr:"₹",amt:"499",period:"per month",feats:["Full Janam Kundli","5 Detailed Reports","Career Prediction","Marriage Compatibility","Chat Consultation 2hrs"],no:["Video Consultation"],btn:"btn-secondary",label:"Choose Silver",page:"payment-success"},
  {icon:"🏆",name:"Gold",tag:"Complete guidance",curr:"₹",amt:"999",period:"per month",feats:["Unlimited Reports","All Predictions","Priority Chat 10hrs","Phone Consultation 3hrs","Matchmaking Report","AI Kundli Summary"],no:[],btn:"btn-gold",label:"Choose Gold",page:"payment-success",popular:true},
  {icon:"💎",name:"Platinum",tag:"Ultimate experience",curr:"₹",amt:"2,499",period:"per month",feats:["Dedicated Astrologer","Unlimited Video Calls","5-Member Family Kundli","Personalized Remedies","24/7 Priority Support","Monthly PDF Reports"],no:[],btn:"btn-primary",label:"Choose Platinum",page:"payment-success"}
];

var GEMS = [
  {img:"💛",bg:"linear-gradient(135deg,#FEF3C7,#FCD34D)",badge:"Bestseller",name:"Yellow Sapphire (Pukhraj)",planet:"✦ Jupiter Planet Stone",desc:"Enhances wisdom, wealth & marriage prospects. Natural Ceylon origin, 4.5 carats.",price:"₹12,500",mrp:"₹18,000"},
  {img:"💜",bg:"linear-gradient(135deg,#EDE9FE,#DDD6FE)",badge:"Certified",name:"Amethyst (Kathela)",planet:"✦ Saturn Planet Stone",desc:"Brings discipline, focus and spiritual awakening. Natural origin, 5 carats.",price:"₹3,200",mrp:"₹4,500"},
  {img:"💚",bg:"linear-gradient(135deg,#ECFDF5,#A7F3D0)",badge:"Natural",name:"Emerald (Panna)",planet:"✦ Mercury Planet Stone",desc:"Boosts intellect, communication & business success. Colombian origin, 3.5 carats.",price:"₹28,000",mrp:"₹40,000"},
  {img:"❤️",bg:"linear-gradient(135deg,#FEF2F2,#FECACA)",badge:"",name:"Red Coral (Moonga)",planet:"✦ Mars Planet Stone",desc:"Builds courage, stamina & leadership. Italian Ox Blood Coral, 6 carats.",price:"₹5,500",mrp:"₹8,000"},
  {img:"💙",bg:"linear-gradient(135deg,#F0F9FF,#BAE6FD)",badge:"",name:"Blue Sapphire (Neelam)",planet:"✦ Saturn Planet Stone",desc:"Powerful Saturn gem for discipline & success. Test recommended. 3 carats.",price:"₹45,000",mrp:"₹65,000"},
  {img:"📿",bg:"linear-gradient(135deg,#FFFBEB,#FDE68A)",badge:"Popular",name:"Panchmukhi Rudraksha",planet:"✦ Lord Shiva's Blessing",desc:"5-faced Rudraksha from Nepal. Calms mind, enhances concentration & health.",price:"₹1,800",mrp:"₹2,500"},
  {img:"🧡",bg:"linear-gradient(135deg,#FFF7ED,#FED7AA)",badge:"",name:"Hessonite (Gomed)",planet:"✦ Rahu Planet Stone",desc:"Stabilizes Rahu effects, improves focus & career. Ceylon origin.",price:"₹4,800",mrp:"₹7,000"},
  {img:"🔷",bg:"linear-gradient(135deg,#F0FFF4,#C6F6D5)",badge:"",name:"Shree Yantra (Gold Plated)",planet:"✦ Goddess Lakshmi",desc:"Sacred geometry for wealth, prosperity and removing obstacles. Energized.",price:"₹2,100",mrp:"₹3,200"}
];

// ══════════════════ PAGE ROUTING ══════════════════
function showPage(id) {
  document.querySelectorAll('.page').forEach(function(p){ p.classList.remove('active'); });
  var pg = document.getElementById('page-'+id);
  if (pg) { pg.classList.add('active'); window.scrollTo(0,0); }
  // nav highlight
  document.querySelectorAll('.nav-links a').forEach(function(a){ a.classList.remove('active'); });
  var nl = document.getElementById('nl-'+id);
  if (nl) nl.classList.add('active');
  // close mobile menu
  document.getElementById('mobMenu').classList.remove('open');
  // hide kundli result when navigating to kundli fresh
  if (id === 'kundli') {
    var kr = document.getElementById('kundliResult');
    if (kr) kr.style.display = 'none';
  }
}

function toggleMenu() {
  document.getElementById('mobMenu').classList.toggle('open');
}

function showKundliResult() {
  var r = document.getElementById('kundliResult');
  if (r) {
    r.style.display = 'block';
    setTimeout(function(){ r.scrollIntoView({behavior:'smooth',block:'start'}); }, 100);
  }
}

function toggleFaq(el) {
  el.parentElement.classList.toggle('open');
}

// ══════════════════ STARS ══════════════════
(function() {
  var sf = document.getElementById('starField');
  if (!sf) return;
  for (var i = 0; i < 80; i++) {
    var s = document.createElement('div');
    s.className = 'star';
    var sz = Math.random() * 2.5 + 0.8;
    s.style.cssText = 'width:'+sz+'px;height:'+sz+'px;top:'+(Math.random()*100)+'%;left:'+(Math.random()*100)+'%;--d:'+(2+Math.random()*4)+'s;animation-delay:'+(Math.random()*4)+'s;';
    sf.appendChild(s);
  }
})();

// ══════════════════ TICKER ══════════════════
(function() {
  var tw = document.getElementById('tickerWrap');
  if (!tw) return;
  var items = [
    '<span class="tick-gold">Today\'s Panchang:</span> Tithi – Dashami | Nakshatra – Rohini',
    'Shubh Muhurat: 10:30 AM – 12:15 PM (Abhijit)',
    '<span class="tick-gold">Aries:</span> Career breakthroughs highly likely today',
    'Sade Sati ending for Scorpio natives in late 2025',
    '<span class="tick-gold">Mercury Direct</span> from June 11 – Excellent for communication',
    'Guru Purnima: July 21 – Auspicious for new beginnings',
    '<span class="tick-gold">Jupiter</span> in Gemini favours travel & education',
    'Chandra Grahan: August 18 – Avoid auspicious activities'
  ];
  var all = items.concat(items);
  tw.innerHTML = all.map(function(t){ return '<div class="tick-item"><div class="tick-dot"></div>'+t+'</div>'; }).join('');
})();

// ══════════════════ BUILD ASTRO CARD ══════════════════
function buildAstroCard(a, targetPage) {
  return '<div class="astro-card" onclick="showPage(\''+(targetPage||'astrologer-detail')+'\')">'
    +'<div class="astro-img" style="background:'+a.bg+'">'
    +'<div class="astro-ava">'+a.init+'</div>'
    +(a.online ? '<span class="astro-online">● Online</span>' : '')
    +'<span class="astro-exp">'+a.e+' Exp</span>'
    +'</div>'
    +'<div class="astro-body">'
    +'<div class="astro-name">'+a.n+'</div>'
    +'<div class="astro-spec">'+a.s+'</div>'
    +'<div style="display:flex;align-items:center;gap:6px;margin-bottom:8px">'
    +'<span class="astro-stars">★★★★'+(parseFloat(a.r)>=5?'★':'☆')+'</span>'
    +'<span class="astro-rnum">'+a.r+'</span>'
    +'<span class="astro-rcnt">('+a.c+')</span>'
    +'</div>'
    +'<div class="astro-footer">'
    +'<div><span class="price-tag">'+a.p+'</span><span class="price-unit">/min</span></div>'
    +'<button class="btn-navy" onclick="event.stopPropagation();showPage(\'consultation\')">Consult Now</button>'
    +'</div></div></div>';
}

// HOME astro grid
var hag = document.getElementById('homeAstroGrid');
if (hag) hag.innerHTML = ASTROS.slice(0,4).map(function(a){ return buildAstroCard(a,'astrologer-detail'); }).join('');

// FULL astro grid
var fag = document.getElementById('fullAstroGrid');
if (fag) fag.innerHTML = ASTROS.map(function(a){ return buildAstroCard(a,'astrologer-detail'); }).join('');

// ══════════════════ BUILD PLAN CARD ══════════════════
function buildPlanCard(p) {
  var feats = p.feats.map(function(f){ return '<li>'+f+'</li>'; }).join('');
  var nope  = p.no.map(function(f){ return '<li class="no">'+f+'</li>'; }).join('');
  var badge = p.popular ? '<div class="plan-popular-badge">🔥 Most Popular</div>' : '';
  return '<div class="plan-card'+(p.popular?' popular':'')+'">'
    +badge
    +'<div class="plan-icon">'+p.icon+'</div>'
    +'<div class="plan-name">'+p.name+'</div>'
    +'<div class="plan-tag">'+p.tag+'</div>'
    +'<div class="plan-price-row"><span class="plan-curr">'+p.curr+'</span><span class="plan-amt">'+p.amt+'</span></div>'
    +'<div class="plan-period">'+p.period+'</div>'
    +'<ul class="plan-feats">'+feats+nope+'</ul>'
    +'<button class="btn '+p.btn+'" style="width:100%" onclick="showPage(\''+p.page+'\')">'+p.label+'</button>'
    +'</div>';
}

var hpg = document.getElementById('homePlansGrid');
if (hpg) hpg.innerHTML = PLANS.map(buildPlanCard).join('');

var fpg = document.getElementById('fullPlansGrid');
if (fpg) fpg.innerHTML = PLANS.map(buildPlanCard).join('');

// ══════════════════ BUILD GEM CARD ══════════════════
var sg = document.getElementById('shopGrid');
if (sg) {
  sg.innerHTML = GEMS.map(function(g){
    return '<div class="gem-card">'
      +'<div class="gem-img" style="background:'+g.bg+'">'+g.img
      +(g.badge ? '<span class="gem-badge-tag">'+g.badge+'</span>' : '')
      +'</div>'
      +'<div class="gem-body">'
      +'<div class="gem-name">'+g.name+'</div>'
      +'<div class="gem-planet">'+g.planet+'</div>'
      +'<div class="gem-desc">'+g.desc+'</div>'
      +'<div class="gem-price-row"><div><div class="gem-price">'+g.price+'</div><div class="gem-mrp">MRP: '+g.mrp+'</div></div>'
      +'<button class="btn-navy btn-sm">Add to Cart</button>'
      +'</div></div></div>';
  }).join('');
}

// ══════════════════ RASHI SIDEBAR ══════════════════
var RASHIS = [
  {s:"♈",h:"मेष",e:"Aries"},{s:"♉",h:"वृष",e:"Taurus"},{s:"♊",h:"मिथुन",e:"Gemini"},
  {s:"♋",h:"कर्क",e:"Cancer"},{s:"♌",h:"सिंह",e:"Leo"},{s:"♍",h:"कन्या",e:"Virgo"},
  {s:"♎",h:"तुला",e:"Libra"},{s:"♏",h:"वृश्चिक",e:"Scorpio"},{s:"♐",h:"धनु",e:"Sagittarius"},
  {s:"♑",h:"मकर",e:"Capricorn"},{s:"♒",h:"कुम्भ",e:"Aquarius"},{s:"♓",h:"मीन",e:"Pisces"}
];
var rsb = document.getElementById('rashiSidebar');
if (rsb) {
  rsb.innerHTML = RASHIS.map(function(r, i){
    return '<div style="display:flex;align-items:center;gap:8px;padding:7px 10px;border-radius:7px;cursor:pointer;transition:all .15s;'+(i===0?'background:var(--gold-pale)':'')+'" '
      +'onmouseenter="this.style.background=\'var(--cream-dark)\'" '
      +'onmouseleave="this.style.background=\''+(i===0?'var(--gold-pale)':'transparent')+'\'"> '
      +'<span style="font-size:17px">'+r.s+'</span>'
      +'<span style="font-size:13px;color:var(--gold);font-weight:700">'+r.h+'</span>'
      +'<span style="font-size:11px;color:var(--text-muted);margin-left:auto">'+r.e+'</span>'
      +'</div>';
  }).join('');
}

// ══════════════════ FILTER CHIPS ══════════════════
document.addEventListener('click', function(e) {
  if (e.target.classList.contains('filter-chip')) {
    var parent = e.target.parentElement;
    parent.querySelectorAll('.filter-chip').forEach(function(b){ b.classList.remove('active'); });
    e.target.classList.add('active');
  }
});

// ══════════════════ RESPONSIVE FIXES ══════════════════
function applyResponsive() {
  var w = window.innerWidth;
  var hl = document.getElementById('horoLayout');
  if (hl) hl.style.gridTemplateColumns = w < 768 ? '1fr' : '250px 1fr';

  var adh = document.getElementById('astroDetailHeader');
  if (adh) adh.style.gridTemplateColumns = w < 680 ? '1fr' : 'auto 1fr auto';

  var adb = document.getElementById('astroDetailBody');
  if (adb) adb.style.gridTemplateColumns = w < 768 ? '1fr' : '2fr 1fr';

  var kr = document.getElementById('kundliResGrid');
  if (kr) kr.style.gridTemplateColumns = w < 768 ? '1fr' : '1fr 1fr';

  var pg = document.getElementById('predGrid');
  if (pg) pg.style.gridTemplateColumns = w < 600 ? '1fr' : w < 900 ? '1fr 1fr' : '1fr 1fr 1fr';

  var ds = document.getElementById('dashSnap');
  if (ds) ds.style.gridTemplateColumns = w < 500 ? '1fr 1fr' : 'repeat(4,1fr)';

  var as = document.getElementById('aboutStats');
  if (as) as.style.gridTemplateColumns = w < 480 ? '1fr 1fr' : 'repeat(4,1fr)';
}
window.addEventListener('resize', applyResponsive);
applyResponsive();

console.log('%c✦ AstroVeda ERP — 16 Pages, Fully Responsive ✦','color:#C8931A;font-size:14px;font-weight:bold');
</script>
</body>
</html>
