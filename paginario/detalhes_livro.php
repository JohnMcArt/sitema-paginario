<?php
require_once 'db/conexao.php';

function e($value): string {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    http_response_code(400);
    $erroPagina = 'O endereço não contém um identificador de livro válido.';
} else {
    $stmt = $conexao->prepare('SELECT * FROM Livro WHERE id_livro = :id LIMIT 1');
    $stmt->execute([':id' => $id]);
    $livro = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$livro) {
        http_response_code(404);
        $erroPagina = 'O livro que você procura não foi encontrado no acervo.';
    }
}

if (isset($erroPagina)) {
    $livro = null;
}

$arquivo = trim((string)($livro['link_arquivo'] ?? ''));
$arquivoSeguro = '';
if ($arquivo !== '' && (preg_match('#^https?://#i', $arquivo) || (!preg_match('#^[a-z][a-z0-9+.-]*:#i', $arquivo) && !str_starts_with($arquivo, '//') && !str_contains($arquivo, '..')))) {
    $arquivoSeguro = $arquivo;
}
$capa = trim((string)($livro['capa'] ?? '')) ?: 'img/paginario.png';
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#f5f5f7">
  <title><?= $livro ? e($livro['titulo']) . ' — Paginário' : 'Livro não encontrado — Paginário' ?></title>
  <link rel="stylesheet" href="assets/css/theme.css">
  <style>
    .detail-header{display:flex;align-items:center;justify-content:space-between;gap:20px;width:min(1180px,calc(100% - 44px));height:78px;margin:auto}.detail-brand{display:flex;align-items:center;gap:10px;color:var(--color-text);text-decoration:none;font-weight:760;font-size:19px;letter-spacing:-.5px}.detail-brand-mark{display:grid;place-items:center;width:35px;height:35px;border-radius:11px;background:linear-gradient(145deg,#5a91ff,#2861e8);color:#fff}.back-link{display:inline-flex;align-items:center;gap:8px;color:#57575e;text-decoration:none;font-size:13px;font-weight:600}.back-link:hover{color:var(--color-accent)}
    .detail-main{width:min(1120px,calc(100% - 44px));margin:18px auto 70px}.detail-breadcrumb{margin:0 0 17px;color:#83838a;font-size:12px}.detail-panel{display:grid;grid-template-columns:minmax(270px,.72fr) minmax(0,1.28fr);gap:clamp(28px,6vw,70px);padding:clamp(24px,5vw,56px);border:1px solid rgba(29,29,31,.08);border-radius:30px;background:rgba(255,255,255,.92);box-shadow:0 16px 50px rgba(20,28,45,.07)}
    .detail-cover-zone{display:flex;align-items:center;justify-content:center;min-height:400px;padding:25px;border-radius:22px;background:radial-gradient(circle at 40% 25%,#fff,#eef1f7 80%)}.detail-cover{width:auto;max-width:100%;height:min(440px,52vw);object-fit:contain;border-radius:7px;box-shadow:0 18px 38px rgba(20,28,45,.17)}
    .detail-copy{align-self:center;min-width:0;padding:10px 0}.detail-label{display:inline-flex;align-items:center;gap:8px;color:#3478f6;text-transform:uppercase;letter-spacing:1.55px;font-size:10px;font-weight:800}.detail-copy h1{margin:14px 0 7px;color:#1d1d1f;font-size:clamp(30px,4.4vw,49px);line-height:1.07;letter-spacing:-.055em}.detail-author{margin:0 0 23px;color:#77777e;font-size:15px}.detail-author strong{color:#45454b;font-weight:650}.detail-synopsis{margin:0 0 26px;color:#55555c;font-size:14px;line-height:1.85;white-space:normal}.detail-facts{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px;margin:0 0 28px}.fact{padding:13px 14px;border:1px solid #ededf1;border-radius:14px;background:#fafafd;min-width:0}.fact span{display:block;margin-bottom:4px;color:#929299;font-size:10px}.fact strong{display:block;overflow-wrap:anywhere;color:#39393f;font-size:12px;font-weight:650}.detail-actions{display:flex;flex-wrap:wrap;gap:10px}.detail-button{display:inline-flex;align-items:center;justify-content:center;gap:9px;min-height:47px;padding:0 20px;border:1px solid transparent;border-radius:999px;background:var(--color-accent);color:#fff!important;text-decoration:none;font-size:13px;font-weight:700}.detail-button:hover{background:var(--color-accent-hover);transform:translateY(-1px)}.detail-button.secondary{border-color:#e1e1e8;background:#fff;color:#4c4c53!important}.detail-button.secondary:hover{background:#f6f6f9}.detail-empty{max-width:640px;margin:90px auto;padding:38px;text-align:center;border:1px solid var(--color-line);border-radius:25px;background:#fff}.detail-empty h1{font-size:27px;letter-spacing:-.04em}.detail-empty p{color:var(--color-muted);font-size:14px}
    @media(max-width:760px){.detail-main{width:calc(100% - 30px);margin-top:8px}.detail-header{width:calc(100% - 30px);height:68px}.detail-panel{grid-template-columns:1fr;gap:25px;padding:17px;border-radius:22px}.detail-cover-zone{min-height:310px;padding:20px}.detail-cover{height:340px;max-height:65vh}.detail-copy{padding:8px 5px 10px}.detail-copy h1{font-size:34px}.detail-facts{gap:8px}.detail-facts .fact{padding:11px}.detail-empty{margin:55px 15px;padding:25px}}
  </style>
</head>
<body>
  <header class="detail-header"><a class="detail-brand" href="index.php"><span class="detail-brand-mark">P</span><span>Paginário</span></a><a class="back-link" href="inicio.php"><span aria-hidden="true">←</span> Voltar ao catálogo</a></header>
  <main class="detail-main">
    <?php if (!$livro): ?>
      <section class="detail-empty"><div class="detail-label">Acervo Paginário</div><h1>Não encontramos esse livro.</h1><p><?= e($erroPagina ?? 'O item solicitado não está disponível.') ?></p><a class="detail-button" href="inicio.php">Voltar ao catálogo <span aria-hidden="true">→</span></a></section>
    <?php else: ?>
      <p class="detail-breadcrumb">Biblioteca / Catálogo / <strong><?= e($livro['titulo']) ?></strong></p>
      <article class="detail-panel">
        <div class="detail-cover-zone"><img class="detail-cover" src="<?= e($capa) ?>" alt="Capa de <?= e($livro['titulo']) ?>"></div>
        <div class="detail-copy">
          <div class="detail-label"><span aria-hidden="true">✦</span> Detalhes da obra</div>
          <h1><?= e($livro['titulo']) ?></h1>
          <p class="detail-author">por <strong><?= e($livro['autor'] ?: 'Autor não informado') ?></strong></p>
          <p class="detail-synopsis"><?= nl2br(e($livro['sinopse'] ?: 'Ainda não há uma sinopse cadastrada para esta obra.')) ?></p>
          <div class="detail-facts">
            <div class="fact"><span>Editora</span><strong><?= e($livro['editor'] ?: 'Não informada') ?></strong></div>
            <div class="fact"><span>Ano de publicação</span><strong><?= e($livro['ano_publicacao'] ?: 'Não informado') ?></strong></div>
            <div class="fact"><span>Gênero</span><strong><?= e($livro['genero'] ?: 'Não informado') ?></strong></div>
            <div class="fact"><span>Formato</span><strong><?= e($livro['formato'] ?: 'Não informado') ?></strong></div>
            <div class="fact"><span>Classificação indicativa</span><strong><?= (int)($livro['classificacao_indicativa'] ?? 0) > 0 ? (int)$livro['classificacao_indicativa'] . ' anos ou mais' : 'Livre' ?></strong></div>
          </div>
          <div class="detail-actions">
            <?php if ($arquivoSeguro !== ''): ?><a class="detail-button" href="<?= e($arquivoSeguro) ?>" target="_blank" rel="noopener noreferrer" download>Baixar livro <span aria-hidden="true">↓</span></a><?php endif; ?>
            <a class="detail-button secondary" href="inicio.php">Continuar explorando</a>
          </div>
        </div>
      </article>
    <?php endif; ?>
  </main>
  <footer class="main-footer"><a href="politicaprivacidade.html">Privacidade</a> · <a href="politicaprivacidade.html">Termos de uso</a> · © <?= date('Y') ?> Paginário</footer>
</body>
</html>
