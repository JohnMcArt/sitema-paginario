<?php
require_once 'db/conexao.php';
require_once 'auth.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function e($value): string {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

$termo = trim((string)($_GET['q'] ?? ''));
$ordem = (string)($_GET['ordem'] ?? 'titulo');
$ordensPermitidas = [
    'titulo' => 'L.titulo ASC',
    'recente' => 'L.ano_publicacao DESC, L.titulo ASC',
    'autor' => 'L.autor ASC, L.titulo ASC',
];
$orderBy = $ordensPermitidas[$ordem] ?? $ordensPermitidas['titulo'];

$sql = "SELECT L.id_livro, L.titulo, L.autor, L.genero, L.ano_publicacao,
               L.classificacao_indicativa, L.capa, L.formato
        FROM Livro L";
$params = [];
if ($termo !== '') {
    $sql .= " WHERE L.titulo LIKE :titulo OR L.autor LIKE :autor OR L.genero LIKE :genero";
    $busca = '%' . $termo . '%';
    $params = [':titulo' => $busca, ':autor' => $busca, ':genero' => $busca];
}
$sql .= " ORDER BY {$orderBy}";

$stmt = $conexao->prepare($sql);
$stmt->execute($params);
$livros = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total = count($livros);
$nome = trim((string)($_SESSION['user_nome'] ?? ''));
$primeiroNome = $nome !== '' ? explode(' ', $nome)[0] : 'leitor';
$avatarInicial = function_exists('mb_substr')
    ? mb_strtoupper(mb_substr($primeiroNome, 0, 1, 'UTF-8'), 'UTF-8')
    : strtoupper(substr($primeiroNome, 0, 1));
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#f5f5f7">
  <meta name="description" content="Explore o catálogo de livros do Paginário.">
  <title>Catálogo — Paginário</title>
  <link rel="stylesheet" href="assets/css/theme.css">
  <style>
    .catalog-page { min-height:100vh; }
    .catalog-header { position:sticky;top:0;z-index:40;display:flex;align-items:center;justify-content:space-between;gap:20px;padding:0 max(22px,calc((100vw - 1180px)/2));height:72px;background:rgba(255,255,255,.82);border-bottom:1px solid var(--color-line);backdrop-filter:blur(22px); }
    .catalog-brand {display:inline-flex;align-items:center;gap:10px;color:var(--color-text);font-weight:760;font-size:19px;letter-spacing:-.5px;text-decoration:none;white-space:nowrap}
    .catalog-brand-mark {display:grid;place-items:center;width:34px;height:34px;border-radius:11px;background:linear-gradient(145deg,#5a91ff,#2861e8);color:white;font-size:17px;box-shadow:0 5px 13px rgba(52,120,246,.2)}
    .catalog-nav {display:flex;align-items:center;gap:19px}.catalog-nav a{font-size:12px;color:#616168;text-decoration:none}.catalog-nav a:hover{color:var(--color-accent)}
    .catalog-account {display:flex;align-items:center;gap:11px;font-size:12px;color:var(--color-muted);white-space:nowrap}.avatar {display:grid;place-items:center;width:35px;height:35px;border-radius:50%;background:#e8efff;color:#2e61cd;font-weight:800;font-size:13px}
    .catalog-wrap {width:min(1180px,calc(100% - 44px));margin:0 auto;padding:43px 0 68px}
    .catalog-greeting {display:flex;align-items:flex-end;justify-content:space-between;gap:22px;margin-bottom:26px}
    .catalog-kicker {color:var(--color-accent);font-size:10px;font-weight:800;letter-spacing:1.6px;text-transform:uppercase}
    .catalog-greeting h1 {margin:9px 0 6px;color:var(--color-text);font-size:clamp(31px,4vw,43px);line-height:1.08;letter-spacing:-.055em}
    .catalog-greeting p {margin:0;color:var(--color-muted);font-size:14px}
    .catalog-count {flex-shrink:0;padding:10px 13px;border:1px solid var(--color-line);border-radius:14px;background:rgba(255,255,255,.65);color:var(--color-muted);font-size:12px}
    .catalog-count strong {color:var(--color-text);font-size:15px;margin-right:4px}
    .catalog-search-panel {display:grid;grid-template-columns:minmax(0,1fr) 178px auto;gap:10px;margin-bottom:20px;padding:12px;border:1px solid rgba(29,29,31,.07);border-radius:20px;background:rgba(255,255,255,.72);box-shadow:0 5px 24px rgba(20,28,45,.035)}
    .search-field {display:flex;align-items:center;gap:10px;min-width:0;padding:0 13px;border:1px solid #e5e5ea;border-radius:13px;background:#f5f5f7;color:#7b7b82}.search-field span{font-size:20px}.search-field input{width:100%;min-width:0;min-height:42px;border:0!important;background:transparent!important;padding:5px 0!important;outline:none}
    .catalog-search-panel select {width:100%;min-height:44px;background:#f5f5f7;border:1px solid #e5e5ea;border-radius:13px;padding:0 12px;color:#44444b;font-size:12px}
    .catalog-search-panel button {min-height:44px;padding:0 20px;border:0;border-radius:13px;background:var(--color-accent);color:white;font-size:12px;font-weight:700;cursor:pointer}.catalog-search-panel button:hover{background:var(--color-accent-hover)}
    .quick-links {display:flex;flex-wrap:wrap;align-items:center;gap:9px;margin:0 0 31px}.quick-links span{margin-right:5px;color:#85858b;font-size:11px}.quick-links a{padding:8px 12px;border:1px solid #e5e5ea;border-radius:999px;background:rgba(255,255,255,.65);color:#5c5c64;text-decoration:none;font-size:11px}.quick-links a:hover{border-color:#c5d5ff;background:#eef3ff;color:#2f66d8}
    .catalog-section-heading {display:flex;align-items:baseline;justify-content:space-between;gap:14px;margin-bottom:16px}.catalog-section-heading h2{margin:0;color:var(--color-text);font-size:20px;letter-spacing:-.5px}.catalog-section-heading span{color:#85858b;font-size:11px}
    .catalog-grid {display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:17px}
    .catalog-card {overflow:hidden;min-width:0;padding:12px;border:1px solid #e7e7ec;border-radius:19px;background:#fff;box-shadow:0 5px 18px rgba(20,28,45,.035);transition:transform .2s ease,box-shadow .2s ease}
    .catalog-card:hover {transform:translateY(-4px);box-shadow:0 15px 32px rgba(20,28,45,.09)}
    .catalog-card-link {display:block;color:inherit;text-decoration:none}.catalog-cover-wrap{position:relative;overflow:hidden;display:grid;place-items:center;height:230px;padding:14px;border-radius:12px;background:linear-gradient(145deg,#f3f4f7,#eaedf3)}.catalog-cover{width:auto;max-width:100%;height:100%;object-fit:contain;border-radius:5px;box-shadow:0 8px 19px rgba(20,28,45,.15);transition:transform .25s ease}.catalog-card:hover .catalog-cover{transform:scale(1.025)}
    .age-chip {position:absolute;top:9px;right:9px;padding:5px 8px;border:1px solid rgba(255,255,255,.7);border-radius:999px;background:rgba(255,255,255,.9);color:#45454c;font-size:9px;font-weight:750;backdrop-filter:blur(12px)}
    .catalog-card-body {padding:14px 3px 4px}.catalog-card h3{overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;min-height:42px;margin:0 0 5px;color:#28282d;font-size:14px;line-height:1.45;letter-spacing:-.2px}.catalog-author{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;margin:0;color:#7d7d84;font-size:11px}.catalog-meta{display:flex;align-items:center;justify-content:space-between;gap:8px;margin-top:13px;padding-top:11px;border-top:1px solid #f0f0f4;color:#898990;font-size:10px}.catalog-meta .genre{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.catalog-meta .arrow{display:grid;place-items:center;width:26px;height:26px;flex-shrink:0;border-radius:50%;background:#f1f4fb;color:#3478f6;font-size:15px}
    .empty-state {grid-column:1/-1;padding:55px 22px;text-align:center;border:1px dashed #d4d5dd;border-radius:22px;background:rgba(255,255,255,.65)}.empty-icon{display:grid;place-items:center;width:52px;height:52px;margin:0 auto 17px;border-radius:17px;background:#edf2ff;color:#3478f6;font-size:24px}.empty-state h3{margin:0 0 8px;font-size:18px}.empty-state p{margin:0;color:#77777e;font-size:13px}
    .catalog-footer{display:flex;justify-content:space-between;gap:15px;padding:24px 22px;border-top:1px solid var(--color-line);color:#8a8a91;font-size:11px}.catalog-footer a{color:#77777e;text-decoration:none}.catalog-footer a:hover{color:var(--color-accent)}
    @media(max-width:900px){.catalog-nav{display:none}.catalog-grid{grid-template-columns:repeat(3,minmax(0,1fr))}.catalog-cover-wrap{height:220px}}
    @media(max-width:620px){.catalog-header{height:65px;padding:0 18px}.catalog-account .account-name{display:none}.catalog-wrap{width:calc(100% - 32px);padding:34px 0 50px}.catalog-greeting{align-items:flex-start;flex-direction:column;gap:14px}.catalog-count{align-self:flex-start}.catalog-search-panel{grid-template-columns:1fr 1fr}.search-field{grid-column:1/-1}.catalog-search-panel button{grid-column:1/-1}.catalog-grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}.catalog-card{padding:9px;border-radius:16px}.catalog-cover-wrap{height:190px;padding:10px}.catalog-card-body{padding:11px 2px 3px}.catalog-card h3{font-size:13px;min-height:38px}.catalog-footer{flex-direction:column;align-items:center;text-align:center}}
    @media(max-width:380px){.catalog-cover-wrap{height:155px}.quick-links{gap:6px}.quick-links a{padding:7px 9px}}
  </style>
</head>
<body class="catalog-page">
  <header class="catalog-header">
    <a class="catalog-brand" href="inicio.php"><span class="catalog-brand-mark">P</span><span>Paginário</span></a>
    <nav class="catalog-nav" aria-label="Navegação do catálogo"><a href="inicio.php">Início</a><a href="genero.php">Gêneros</a><a href="autores.php">Autores</a><a href="editora.php">Editoras</a><a href="solicitacao.php">Sugerir livro</a></nav>
    <a class="catalog-account" href="meuperfil.php"><span class="avatar" aria-hidden="true"><?= e($avatarInicial) ?></span><span class="account-name"><?= e($primeiroNome) ?><br><span style="color:#929299;font-size:10px">Meu perfil ↗</span></span></a>
  </header>

  <main class="catalog-wrap">
    <section class="catalog-greeting">
      <div><div class="catalog-kicker">Seu próximo capítulo</div><h1>O que vamos ler hoje<?= $nome !== '' ? ', ' . e($primeiroNome) : '' ?>?</h1><p>Explore o acervo e encontre uma história para chamar de sua.</p></div>
      <div class="catalog-count"><strong><?= $total ?></strong> <?= $total === 1 ? 'livro encontrado' : 'livros encontrados' ?></div>
    </section>

    <form class="catalog-search-panel" method="get" action="inicio.php" role="search">
      <label class="search-field"><span aria-hidden="true">⌕</span><input type="search" name="q" value="<?= e($termo) ?>" placeholder="Busque por título, autor ou gênero..." aria-label="Buscar livros"></label>
      <select name="ordem" aria-label="Ordenar catálogo">
        <option value="titulo" <?= $ordem === 'titulo' ? 'selected' : '' ?>>Título: A–Z</option>
        <option value="autor" <?= $ordem === 'autor' ? 'selected' : '' ?>>Autor: A–Z</option>
        <option value="recente" <?= $ordem === 'recente' ? 'selected' : '' ?>>Publicação recente</option>
      </select>
      <button type="submit">Buscar livros <span aria-hidden="true">→</span></button>
    </form>

    <nav class="quick-links" aria-label="Explorar por categoria"><span>Explorar por:</span><a href="genero.php">Gêneros</a><a href="autores.php">Autores</a><a href="editora.php">Editoras</a><a href="faixaetaria.php">Classificação indicativa</a><a href="solicitacao.php">Sugerir um livro +</a></nav>

    <section aria-labelledby="books-title">
      <div class="catalog-section-heading"><h2 id="books-title"><?= $termo !== '' ? 'Resultados da busca' : 'Todos os livros' ?></h2><span><?= $termo !== '' ? 'Busca: “' . e($termo) . '”' : 'Um acervo para explorar no seu ritmo' ?></span></div>
      <div class="catalog-grid">
        <?php if (!$livros): ?>
          <div class="empty-state"><div class="empty-icon" aria-hidden="true">⌕</div><h3>Nenhum livro por aqui</h3><p>Tente outro título, autor ou gênero para encontrar o que procura.</p></div>
        <?php else: ?>
          <?php foreach ($livros as $livro): ?>
            <?php
              $capa = trim((string)($livro['capa'] ?? ''));
              if ($capa === '') $capa = 'img/paginario.png';
              $classificacao = (int)($livro['classificacao_indicativa'] ?? 0);
            ?>
            <article class="catalog-card">
              <a class="catalog-card-link" href="detalhes_livro.php?id=<?= (int)$livro['id_livro'] ?>" aria-label="Ver detalhes de <?= e($livro['titulo']) ?>">
                <div class="catalog-cover-wrap"><img class="catalog-cover" src="<?= e($capa) ?>" alt="Capa de <?= e($livro['titulo']) ?>" loading="lazy"><span class="age-chip"><?= $classificacao > 0 ? $classificacao . '+' : 'Livre' ?></span></div>
                <div class="catalog-card-body"><h3><?= e($livro['titulo']) ?></h3><p class="catalog-author"><?= e($livro['autor']) ?></p><div class="catalog-meta"><span class="genre"><?= e($livro['genero'] ?: 'Acervo geral') ?><?= !empty($livro['ano_publicacao']) ? ' · ' . (int)$livro['ano_publicacao'] : '' ?></span><span class="arrow" aria-hidden="true">↗</span></div></div>
              </a>
            </article>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </section>
  </main>

  <footer class="catalog-footer"><span><strong style="color:#45454b">Paginário</strong> · Histórias que aproximam</span><span><a href="politicaprivacidade.html">Privacidade</a> &nbsp;·&nbsp; <a href="politicaprivacidade.html">Termos de uso</a> &nbsp;·&nbsp; © <?= date('Y') ?></span></footer>
</body>
</html>
