<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#f5f5f7">
  <meta name="description" content="Paginário: uma biblioteca digital para descobrir, explorar e compartilhar histórias.">
  <title>Paginário — sua próxima leitura</title>
  <link rel="stylesheet" href="assets/css/theme.css">
  <style>
    .landing-page { overflow: hidden; }
    .site-header { position: sticky; top: 0; z-index: 50; height: 76px; padding: 0 5vw; display: flex; align-items: center; justify-content: space-between; gap: 24px; background: rgba(255,255,255,.74); border-bottom: 1px solid rgba(29,29,31,.07); backdrop-filter: blur(22px); }
    .brand { display: inline-flex; gap: 11px; align-items: center; text-decoration: none; color: var(--color-text); font-size: 20px; font-weight: 750; letter-spacing: -.7px; }
    .brand-mark { width: 36px; height: 36px; display: grid; place-items: center; color: white; background: linear-gradient(145deg,#5a91ff,#2861e8); border-radius: 12px; box-shadow: 0 5px 14px rgba(52,120,246,.24); font-size: 19px; font-weight: 800; }
    .site-nav { display: flex; align-items: center; gap: 27px; }
    .site-nav a { color: #525259; text-decoration: none; font-size: 13px; font-weight: 550; }
    .site-nav a:hover { color: var(--color-accent); }
    .header-actions { display: flex; align-items: center; gap: 10px; }
    .button { display: inline-flex; min-height: 44px; justify-content: center; align-items: center; gap: 8px; padding: 0 19px; border-radius: 999px; border: 1px solid transparent; text-decoration: none; font-size: 13px; font-weight: 650; }
    .button-primary { color: #fff !important; background: var(--color-accent); box-shadow: 0 5px 14px rgba(52,120,246,.19); }
    .button-primary:hover { color: #fff !important; background: var(--color-accent-hover); transform: translateY(-1px); }
    .button-quiet { color: #333338; border-color: rgba(29,29,31,.12); background: rgba(255,255,255,.65); }
    .button-quiet:hover { background: #fff; }
    .hero { position: relative; display: grid; grid-template-columns: minmax(0,1.08fr) minmax(340px,.92fr); align-items: center; gap: 7vw; width: min(1240px,90vw); margin: 0 auto; padding: 83px 0 96px; }
    .hero::before { content:""; position:absolute; z-index:-1; width: 520px; height:520px; right:-125px; top:20px; border-radius:50%; background: radial-gradient(circle,rgba(208,220,255,.9),rgba(229,235,255,.16) 67%,transparent 70%); filter: blur(5px); }
    .eyebrow { display: inline-flex; align-items: center; gap: 8px; padding: 8px 12px; border: 1px solid #dce5ff; border-radius: 999px; color: #315eb5; background: rgba(255,255,255,.68); font-size: 11px; letter-spacing: 1.4px; font-weight: 750; }
    .eyebrow-dot { width: 7px; height:7px; border-radius:50%; background:#3478f6; box-shadow:0 0 0 4px #e4edff; }
    .hero h1 { max-width: 660px; margin: 24px 0 18px; color: #1d1d1f; font-size: clamp(43px,6vw,76px); line-height: .99; letter-spacing: -.065em; font-weight: 760; }
    .hero h1 span { color: #3478f6; }
    .hero-copy { max-width: 495px; margin: 0; color: #6e6e73; font-size: clamp(16px,1.7vw,19px); line-height: 1.7; }
    .hero-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 29px; }
    .hero-note { display:flex; gap:10px; align-items:center; margin-top:25px; color:#77777e; font-size:12px; }
    .note-icon { display:grid; place-items:center; width:23px;height:23px;border-radius:50%;background:#e4f5e9;color:#237848;font-size:13px;font-weight:800; }
    .book-stage { position:relative; min-height: 430px; display:flex; align-items:center; justify-content:center; perspective:1100px; }
    .stage-halo { position:absolute; width:360px;height:360px;border-radius:50%; background:linear-gradient(140deg,#e5ebff,#f5e9ff); filter:blur(1px); }
    .book-stack { position:relative; width: 330px; height: 380px; transform: rotateY(-7deg) rotateZ(-2deg); }
    .book { position:absolute; overflow:hidden; display:block; border-radius:10px 16px 16px 10px; border:1px solid rgba(255,255,255,.6); box-shadow: 12px 18px 34px rgba(33,43,78,.20), inset 5px 0 0 rgba(0,0,0,.06); background:#fff; }
    .book img { width:100%;height:100%;object-fit:cover;display:block; }
    .book-main { z-index:3; left:74px; top:12px; width:220px;height:318px;transform:rotate(4deg); }
    .book-left { z-index:2; left:0;top:45px;width:190px;height:280px;transform:rotate(-12deg); }
    .book-right { z-index:1;left:147px;top:68px;width:174px;height:255px;transform:rotate(13deg); }
    .floating-note { position:absolute; z-index:5; display:flex;align-items:center;gap:11px;padding:14px 17px;border:1px solid rgba(255,255,255,.85);border-radius:17px;background:rgba(255,255,255,.82);box-shadow:0 12px 40px rgba(39,49,80,.10);backdrop-filter:blur(18px); }
    .floating-note.one { top:45px;right:-5px; }.floating-note.two { left:-8px;bottom:43px; }
    .float-symbol { display:grid;place-items:center;width:38px;height:38px;border-radius:12px;background:#edf2ff;color:#326be8;font-size:20px; }
    .float-title { color:#29292e;font-weight:750;font-size:12px; }.float-sub { color:#85858b;font-size:10px;margin-top:2px; }
    .section { padding: 78px 5vw; }
    .section-inner { width:min(1120px,100%);margin:0 auto; }
    .section-kicker { text-transform:uppercase; letter-spacing:1.8px;font-size:10px;font-weight:800;color:#3478f6; }
    .section-heading { margin:10px 0 12px;font-size:clamp(30px,4vw,44px);line-height:1.1;letter-spacing:-.045em;color:#1d1d1f; }
    .section-description { max-width:560px;margin:0;color:#727278;font-size:15px;line-height:1.75; }
    .discovery { background:#fff; border-top:1px solid rgba(29,29,31,.06); border-bottom:1px solid rgba(29,29,31,.06); }
    .feature-grid { display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:17px;margin-top:34px; }
    .feature-card { padding:25px;border:1px solid #e8e8ed;border-radius:22px;background:linear-gradient(145deg,#fff,#fafaff); }
    .feature-icon { display:grid;place-items:center;width:44px;height:44px;margin-bottom:22px;border-radius:14px;background:#edf2ff;color:#326be8;font-size:21px; }
    .feature-card h3 { margin:0 0 8px;font-size:17px;letter-spacing:-.3px; }.feature-card p { margin:0;color:#77777e;font-size:13px;line-height:1.7; }
    .join-panel { display:flex;align-items:center;justify-content:space-between;gap:25px;padding:36px 40px;border-radius:28px;background:linear-gradient(115deg,#202c48,#273e68 70%,#3159a3);color:#fff;box-shadow:0 20px 50px rgba(36,54,94,.15); }
    .join-panel h2 { margin:0 0 8px;font-size:clamp(24px,3vw,34px);letter-spacing:-.045em; }.join-panel p { margin:0;color:#d3ddf2;font-size:14px;line-height:1.65; }
    .join-panel .button { flex-shrink:0;background:#fff;color:#1e3154 !important; }
    .site-footer { display:flex;justify-content:space-between;gap:20px;padding:27px 5vw;color:#88888f;font-size:11px; }
    .footer-brand { color:#36363b;font-weight:750; }
    @media(max-width:850px) { .site-nav {display:none}.hero{grid-template-columns:1fr;padding:60px 0 65px;gap:25px}.hero-copy{max-width:620px}.book-stage{min-height:390px}.feature-grid{grid-template-columns:1fr}.join-panel{align-items:flex-start;flex-direction:column;padding:28px}.hero::before{right:-200px}.site-footer{flex-direction:column;align-items:center;text-align:center} }
    @media(max-width:520px) { .site-header{height:66px;padding:0 18px}.brand{font-size:18px}.header-actions .button-quiet{display:none}.header-actions .button{min-height:40px;padding:0 15px}.hero{width:calc(100% - 38px);padding-top:48px}.hero h1{font-size:47px}.book-stage{min-height:330px;transform:scale(.86);margin:-20px -20px}.floating-note.one{right:0}.floating-note.two{left:0}.section{padding:60px 20px}.join-panel{padding:25px}.book-stack{transform:scale(.88) rotateY(-7deg) rotateZ(-2deg)} }
  </style>
</head>
<body class="landing-page">
  <header class="site-header">
    <a class="brand" href="index.php" aria-label="Paginário — página inicial"><span class="brand-mark">P</span><span>Paginário</span></a>
    <nav class="site-nav" aria-label="Navegação principal"><a href="#sobre">Sobre a biblioteca</a><a href="#experiencia">Como funciona</a><a href="politicaprivacidade.html">Privacidade</a></nav>
    <div class="header-actions"><a class="button button-quiet" href="entrar.php">Entrar</a><a class="button button-primary" href="cadastrar.php">Criar conta <span aria-hidden="true">↗</span></a></div>
  </header>

  <main>
    <section class="hero" id="sobre">
      <div class="hero-content">
        <div class="eyebrow"><span class="eyebrow-dot"></span> BIBLIOTECA DIGITAL</div>
        <h1>Uma boa história muda <span>tudo.</span></h1>
        <p class="hero-copy">Descubra clássicos, explore novos autores e encontre espaço para a próxima leitura. A sua biblioteca, do seu jeito.</p>
        <div class="hero-actions"><a class="button button-primary" href="entrar.php">Explorar biblioteca <span aria-hidden="true">→</span></a><a class="button button-quiet" href="cadastrar.php">Fazer parte</a></div>
        <div class="hero-note"><span class="note-icon" aria-hidden="true">✓</span><span>Leituras para descobrir. Histórias para levar com você.</span></div>
      </div>
      <div class="book-stage" aria-label="Seleção visual de capas de livros">
        <div class="stage-halo"></div>
        <div class="book-stack">
          <div class="book book-left"><img src="img/crime-e-castigo.png" alt="Capa de Crime e Castigo"></div>
          <div class="book book-right"><img src="img/dom-casmurro.jpg" alt="Capa de Dom Casmurro"></div>
          <div class="book book-main"><img src="img/a-metamorfose.jpg" alt="Capa de A Metamorfose"></div>
        </div>
        <div class="floating-note one"><span class="float-symbol" aria-hidden="true">✦</span><span><span class="float-title">Sempre há algo novo</span><br><span class="float-sub">Sua próxima descoberta começa aqui</span></span></div>
        <div class="floating-note two"><span class="float-symbol" aria-hidden="true">⌕</span><span><span class="float-title">Encontre sua leitura</span><br><span class="float-sub">Por título, autor ou gênero</span></span></div>
      </div>
    </section>

    <section class="section discovery" id="experiencia">
      <div class="section-inner">
        <div class="section-kicker">Feita para leitores</div>
        <h2 class="section-heading">Menos procura. Mais descoberta.</h2>
        <p class="section-description">Uma experiência simples e organizada para você navegar pelo catálogo e cuidar da sua jornada de leitura.</p>
        <div class="feature-grid">
          <article class="feature-card"><div class="feature-icon" aria-hidden="true">⌕</div><h3>Explore com facilidade</h3><p>Pesquise títulos e autores e use os filtros para chegar mais rápido ao que combina com você.</p></article>
          <article class="feature-card"><div class="feature-icon" aria-hidden="true">▤</div><h3>Conheça cada história</h3><p>Consulte sinopses, informações de publicação, gênero e classificação indicativa.</p></article>
          <article class="feature-card"><div class="feature-icon" aria-hidden="true">♡</div><h3>Faça parte da comunidade</h3><p>Crie seu acesso, acompanhe seu perfil e sugira livros para ampliar o acervo.</p></article>
        </div>
      </div>
    </section>

    <section class="section">
      <div class="section-inner join-panel"><div><h2>Abra espaço para novas histórias.</h2><p>Entre no Paginário e descubra o que vale a pena ler hoje.</p></div><a class="button" href="cadastrar.php">Criar minha conta <span aria-hidden="true">→</span></a></div>
    </section>
  </main>

  <footer class="site-footer"><span><span class="footer-brand">Paginário</span> · Biblioteca digital</span><span><a href="politicaprivacidade.html">Política de Privacidade</a> &nbsp;·&nbsp; <a href="politicaprivacidade.html">Termos de uso</a> &nbsp;·&nbsp; © <span data-current-year>2026</span></span></footer>
  <script src="assets/js/app.js" defer></script>
</body>
</html>
