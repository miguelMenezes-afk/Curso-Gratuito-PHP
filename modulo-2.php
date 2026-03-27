<?php
/**
 * PHPMaster — Módulo 02
 * Arquivo único: lista do módulo + páginas de aula via querystring (?aula=1..6)
 */

$moduloNumero    = 2;
$moduloTitulo    = 'Variáveis e Tipos de Dados';
$moduloDescricao = 'Domine como o PHP armazena e manipula informações: strings, números, booleanos e mais.';

$nivelModulo = 'INICIANTE';

$tags = [
  '$variáveis',
  'Strings',
  'Int / Float',
  'Boolean',
  'Arrays',
];

// Estrutura escalável: apenas edite este array para reaproveitar em outros módulos.
$aulas = [
  ['icon' => '🔤', 'titulo' => '$variáveis'],
  ['icon' => '🧵', 'titulo' => 'Strings'],
  ['icon' => '🔢', 'titulo' => 'Int / Float'],
  ['icon' => '✅', 'titulo' => 'Boolean'],
  ['icon' => '📦', 'titulo' => 'Arrays'],
  ['icon' => '🔄', 'titulo' => 'Conversão de Tipos'],
];

// Roteamento simples: ?aula=1..6 (se não vier, mostra a lista do módulo)
$aulaAtual = isset($_GET['aula']) ? (int)$_GET['aula'] : 0;
if ($aulaAtual < 1 || $aulaAtual > count($aulas)) $aulaAtual = 0;

// Links calculados (mantém um único arquivo como fonte de verdade)
foreach ($aulas as $i => $aula) {
  $aulas[$i]['href'] = 'modulo-2.php?aula=' . ($i + 1);
}

function h(string $v): string { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }
function mod2(int $n): string { return str_pad((string)$n, 2, '0', STR_PAD_LEFT); }

function levelClass(string $nivel): string {
  $n = mb_strtoupper(trim($nivel));
  return match ($n) {
    'INICIANTE' => 'level-init',
    'BÁSICO', 'BASICO' => 'level-basic',
    'INTERMEDIÁRIO', 'INTERMEDIARIO' => 'level-inter',
    default => 'level-basic',
  };
}

// ───────────────────────────────────────────────────────────────
// Conteúdo teórico (somente Aula 01 nesta etapa)
// ───────────────────────────────────────────────────────────────
$aulaConteudo = [
  1 => [
    'titulo' => '$variáveis',
    'descricao' => $moduloDescricao,
    'topicos' => ['$variáveis', 'Strings', 'Int / Float', 'Boolean', 'Arrays'],
  ],
];

$paginaTitulo = $moduloTitulo;
if ($aulaAtual) {
  $paginaTitulo = 'Aula ' . mod2($aulaAtual) . ' — ' . ($aulaConteudo[$aulaAtual]['titulo'] ?? $aulas[$aulaAtual - 1]['titulo']);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PHPMaster — <?= h($paginaTitulo) ?> · Módulo <?= h(mod2($moduloNumero)) ?></title>

  <link rel="stylesheet" href="style.css">

  <style>
    /* Layout: Sidebar + Main (padrão dos módulos existentes) */
    .layout { display:block; min-height:100vh; padding-top:60px; }

    .sidebar{
      position:fixed; top:60px; left:0; bottom:0; width:280px;
      background:var(--bg2); border-right:1px solid var(--border);
      overflow-y:auto; z-index:100; padding:28px 0 60px;
    }
    .sidebar::-webkit-scrollbar{ width:4px; }
    .sidebar::-webkit-scrollbar-thumb{ background:var(--border); border-radius:4px; }

    .sidebar-header{ padding:0 22px 20px; border-bottom:1px solid var(--border); }
    .mod-badge{
      display:inline-flex; align-items:center; gap:6px;
      background:rgba(124,77,255,.15); border:1px solid rgba(124,77,255,.4);
      border-radius:50px; padding:4px 12px;
      font-family:'Space Mono',monospace; font-size:.7rem; color:var(--php);
      margin-bottom:10px;
    }
    .sidebar-header h2{
      font-family:'Syne',sans-serif; font-size:1rem; font-weight:700;
      line-height:1.3; color:var(--white);
    }

    .sidebar-nav{ padding:16px 0; }
    .sidebar-section{
      padding:8px 22px 4px;
      font-family:'Space Mono',monospace;
      font-size:.65rem; color:var(--muted);
      letter-spacing:2px; text-transform:uppercase;
    }

    /* Item clicável de aula */
    .lesson-link{
      display:flex; align-items:center; gap:12px;
      width:100%; padding:12px 22px;
      text-decoration:none; cursor:pointer;
      transition:all .2s;
      border-left:3px solid transparent;
      color:inherit;
    }
    .lesson-link:hover{ background:rgba(255,255,255,.04); border-left-color:rgba(124,77,255,.6); }
    .lesson-link.active{ background:rgba(124,77,255,.10); border-left-color:var(--php); }
    .l-icon{
      width:32px; height:32px; border-radius:8px;
      display:flex; align-items:center; justify-content:center;
      font-size:.85rem; flex-shrink:0;
      background:var(--bg3); border:1px solid var(--border);
    }
    .lesson-link.active .l-icon{ background:rgba(124,77,255,.18); border-color:rgba(124,77,255,.5); }
    .l-info{ flex:1; }
    .l-num{ font-family:'Space Mono',monospace; font-size:.65rem; color:var(--muted); }
    .l-title{ font-size:.88rem; font-weight:500; color:var(--text); margin-top:1px; }
    .lesson-link.active .l-title{ color:var(--white); font-weight:600; }
    .l-arrow{ font-size:.9rem; color:var(--accent); opacity:.8; }

    .main{ margin-left:280px; min-height:100vh; max-width:100%; overflow-x:hidden; }

    /* Tags (reuso do estilo do modulos.html) */
    .modulo-topics { display:flex; flex-wrap:wrap; gap:8px; margin-top:18px; }
    .topic-tag{
      font-size:.72rem; font-family:'Space Mono', monospace;
      background: rgba(255,255,255,.04);
      border: 1px solid var(--border);
      border-radius: 6px;
      padding: 3px 8px;
      color: var(--muted);
    }

    /* ───────────────────────────────────────────────────────────
       VIEW: Lista do módulo (já existente)
       ─────────────────────────────────────────────────────────── */
    .module-hero{
      padding:48px 6% 36px;
      background:linear-gradient(135deg, rgba(124,77,255,.06), rgba(0,229,255,.04));
      border-bottom:1px solid var(--border);
    }
    .module-hero > *{ max-width:900px; }
    .module-title{
      font-family:'Syne',sans-serif;
      font-weight:800;
      font-size:clamp(1.8rem,3vw,2.6rem);
      letter-spacing:-1px;
      margin:10px 0 10px;
    }
    .module-title em{ font-style:normal; color:var(--accent); }
    .module-desc{
      color:var(--muted);
      font-size:1.05rem;
      line-height:1.7;
      max-width:680px;
    }

    .module-body{ padding:40px 6% 80px; }
    .block-title{
      font-family:'Syne',sans-serif; font-weight:700; font-size:1.3rem;
      margin-bottom:16px; display:flex; align-items:center; gap:10px;
    }
    .block-title::before{
      content:''; width:4px; height:22px; border-radius:2px;
      background:linear-gradient(180deg,var(--php),var(--accent));
      display:block; flex-shrink:0;
    }

    .lessons-grid{
      display:grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap:14px;
      max-width:900px;
    }
    .lesson-card{
      background:var(--card);
      border:1px solid var(--border);
      border-radius:16px;
      padding:16px 16px;
      text-decoration:none;
      display:flex; align-items:center; gap:12px;
      transition:all .25s;
      color:inherit;
    }
    .lesson-card:hover{ border-color:rgba(0,229,255,.35); transform:translateY(-2px); }
    .lesson-card .meta{ display:flex; flex-direction:column; gap:2px; }
    .lesson-card .meta .n{ font-family:'Space Mono',monospace; font-size:.7rem; color:var(--muted); letter-spacing:1px; }
    .lesson-card .meta .t{ font-weight:600; color:var(--text); }

    /* ───────────────────────────────────────────────────────────
       VIEW: Aula individual (base visual alinhada com modulo-*.html)
       ─────────────────────────────────────────────────────────── */
    .lesson-hero{
      padding:48px 6% 36px;
      background:linear-gradient(135deg,rgba(124,77,255,.06),rgba(0,229,255,.04));
      border-bottom:1px solid var(--border);
    }
    .lesson-body{ padding:48px 6% 80px; }
    .lesson-hero > *,.lesson-body > *{ max-width:900px; }

    .lesson-meta{ display:flex; align-items:center; gap:12px; flex-wrap:wrap; margin-bottom:16px; }
    .lesson-num-tag{
      font-family:'Space Mono',monospace; font-size:.75rem;
      color:var(--php); background:rgba(124,77,255,.12);
      border:1px solid rgba(124,77,255,.3);
      padding:4px 10px; border-radius:50px;
    }
    .lesson-level-tag{
      font-family:'Space Mono',monospace; font-size:.72rem;
      padding:4px 10px; border-radius:50px; border:1px solid;
      letter-spacing:.5px;
    }
    .level-init  { color: var(--green);  border-color: rgba(105,255,180,.3); background: rgba(105,255,180,.08); }
    .level-basic { color: var(--accent); border-color: rgba(0,229,255,.3);   background: rgba(0,229,255,.08); }
    .level-inter { color: var(--yellow); border-color: rgba(255,209,102,.3); background: rgba(255,209,102,.08); }

    .lesson-title{
      font-family:'Syne',sans-serif;
      font-weight:800;
      font-size:clamp(1.8rem,3vw,2.6rem);
      letter-spacing:-1px;
      margin-bottom:12px;
    }
    .lesson-title em{ font-style:normal; color:var(--accent); }
    .lesson-desc{
      color:var(--muted);
      font-size:1.05rem;
      line-height:1.7;
      max-width:680px;
    }
    .content-block{ margin-bottom:40px; }

    .prose{ color:var(--muted); line-height:1.85; font-size:1rem; }
    .prose strong{ color:var(--text); font-weight:600; }
    .prose em{ color:var(--accent); font-style:normal; }
    .prose p{ margin-bottom:14px; }
    .prose ul, .prose ol{ padding-left:20px; margin-bottom:14px; }
    .prose li{ margin-bottom:8px; }

    .callout{
      border-radius:14px; padding:18px 20px; margin:22px 0;
      display:flex; gap:12px; align-items:flex-start;
      background:rgba(0,229,255,.06); border:1px solid rgba(0,229,255,.18);
    }
    .callout .icon{ font-size:1.2rem; flex-shrink:0; margin-top:1px; }
    .callout strong{ display:block; font-size:.92rem; margin-bottom:4px; color:var(--accent); }
    .callout p{ font-size:.92rem; color:var(--muted); line-height:1.6; margin:0; }

    .code-block{
      background:var(--bg2); border:1px solid var(--border);
      border-radius:14px; overflow:hidden; margin:18px 0;
    }
    .cb-header{
      background:var(--bg3); padding:11px 16px;
      display:flex; align-items:center; justify-content:space-between;
      border-bottom:1px solid var(--border);
    }
    .cb-dots{ display:flex; gap:6px; }
    .cb-dot{ width:10px; height:10px; border-radius:50%; }
    .cb-dot:nth-child(1){background:#ff5f57;}
    .cb-dot:nth-child(2){background:#febc2e;}
    .cb-dot:nth-child(3){background:#28c840;}
    .cb-lang{ font-family:'Space Mono',monospace; font-size:.72rem; color:var(--muted); }
    pre.cb-body{
      margin:0; padding:18px 16px;
      font-family:'Space Mono',monospace;
      font-size:.84rem; line-height:1.85;
      overflow-x:auto; color:var(--text);
      white-space:pre;
    }

    .section-divider{
      display:flex; align-items:center; gap:14px;
      margin:44px 0 28px;
    }
    .section-divider hr{ flex:1; border:none; border-top:1px solid var(--border); }
    .section-divider span{
      font-family:'Space Mono',monospace; font-size:.7rem;
      color:var(--muted); letter-spacing:2px; white-space:nowrap;
      text-transform:uppercase;
    }

    .future-grid{
      display:grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap:14px;
      max-width:900px;
    }
    .future-card{
      background:rgba(255,255,255,.03);
      border:1px dashed rgba(0,229,255,.22);
      border-radius:16px;
      padding:18px 18px;
    }
    .future-card .k{
      font-family:'Space Mono',monospace;
      font-size:.68rem;
      letter-spacing:2px;
      color:var(--accent);
      text-transform:uppercase;
      margin-bottom:8px;
    }
    .future-card .t{ font-weight:700; color:var(--text); margin-bottom:6px; }
    .future-card .d{ color:var(--muted); font-size:.92rem; line-height:1.6; }

    /* Mobile: sidebar vira drawer */
    .menu-toggle{
      display:none;
      background:none; border:1px solid var(--border);
      border-radius:8px; padding:7px 10px;
      cursor:pointer; color:var(--muted);
      font-size:1.1rem; line-height:1;
      transition:all .2s;
    }
    .menu-toggle:hover{ border-color:var(--accent); color:var(--accent); }

    .sidebar-overlay{
      display:none; position:fixed; inset:0;
      background:rgba(0,0,0,.6); z-index:99;
    }
    .sidebar-overlay.open{ display:block; }

    @media (max-width: 900px){
      .menu-toggle{ display:block; }
      .nav-links li:not(:last-child){ display:none; }

      .main{ margin-left:0; }
      .sidebar{
        transform:translateX(-100%);
        transition:transform .3s ease;
        width:min(280px, 85vw);
        z-index:150;
      }
      .sidebar.open{ transform:translateX(0); }

      .module-hero, .module-body,
      .lesson-hero, .lesson-body { padding-left:5%; padding-right:5%; }
    }
  </style>
</head>

<body>
  <div class="glow-blob glow-1"></div>
  <div class="glow-blob glow-2"></div>
  <canvas class="particle-canvas" id="particles"></canvas>

  <!-- NAV (reuso padrão do site) -->
  <nav>
    <a class="logo" href="index.html">PHP<span>Master</span></a>
    <ul class="nav-links">
      <li><a href="index.html">Início</a></li>
      <li><a href="motivacoes.html">Motivações</a></li>
      <li><a href="modulos.html" class="active">Módulos</a></li>
      <li><a href="contato.html" class="nav-cta">Contato</a></li>
    </ul>
    <button class="menu-toggle" id="menuToggle" aria-label="Abrir menu de aulas">☰</button>
  </nav>

  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  <div class="layout">
    <!-- SIDEBAR (lista de aulas) -->
    <aside class="sidebar" id="sidebar">
      <div class="sidebar-header">
        <div class="mod-badge">📦 MOD <?= h(mod2($moduloNumero)) ?></div>
        <h2><?= h($moduloTitulo) ?></h2>
      </div>

      <div class="sidebar-nav">
        <div class="sidebar-section">Aulas</div>

        <?php foreach ($aulas as $i => $aula): $n = $i + 1; ?>
          <a
            class="lesson-link <?= ($aulaAtual === $n) ? 'active' : '' ?>"
            href="<?= h($aula['href']) ?>"
            aria-label="Abrir Aula <?= h(mod2($n)) ?>: <?= h($aula['titulo']) ?>"
          >
            <div class="l-icon"><?= h($aula['icon']) ?></div>
            <div class="l-info">
              <div class="l-num">AULA <?= h(mod2($n)) ?></div>
              <div class="l-title"><?= h($aula['titulo']) ?></div>
            </div>
            <span class="l-arrow">→</span>
          </a>
        <?php endforeach; ?>
      </div>
    </aside>

    <main class="main">

      <?php if (!$aulaAtual): ?>
        <!-- VIEW: Página do módulo (lista) -->
        <section class="module-hero">
          <p class="section-label">// módulo <?= h(mod2($moduloNumero)) ?></p>
          <h1 class="module-title"><?= h($moduloTitulo) ?> <em>·</em> <?= h(mod2(count($aulas))) ?> aulas</h1>
          <p class="module-desc"><?= h($moduloDescricao) ?></p>

          <?php if (!empty($tags)): ?>
            <div class="modulo-topics" aria-label="Tópicos do módulo">
              <?php foreach ($tags as $tag): ?>
                <span class="topic-tag"><?= h($tag) ?></span>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </section>

        <section class="module-body">
          <h2 class="block-title">Lista de aulas</h2>

          <div class="lessons-grid">
            <?php foreach ($aulas as $i => $aula): $n = $i + 1; ?>
              <a class="lesson-card" href="<?= h($aula['href']) ?>">
                <div class="l-icon"><?= h($aula['icon']) ?></div>
                <div class="meta">
                  <div class="n">AULA <?= h(mod2($n)) ?></div>
                  <div class="t"><?= h($aula['titulo']) ?></div>
                </div>
                <span class="l-arrow">→</span>
              </a>
            <?php endforeach; ?>
          </div>
        </section>

      <?php else: ?>
        <!-- VIEW: Página de aula individual -->
        <?php
          $aulaInfo = $aulaConteudo[$aulaAtual] ?? null;
          $aulaTitulo = $aulaInfo['titulo'] ?? $aulas[$aulaAtual - 1]['titulo'];
          $aulaDescricao = $aulaInfo['descricao'] ?? 'Conteúdo desta aula será publicado em breve.';
          $aulaTopicos = $aulaInfo['topicos'] ?? [];
        ?>

        <section class="lesson-hero">
          <p class="section-label">// módulo <?= h(mod2($moduloNumero)) ?> · <?= h($moduloTitulo) ?></p>

          <div class="lesson-meta">
            <span class="lesson-num-tag">AULA <?= h(mod2($aulaAtual)) ?> / <?= h(mod2(count($aulas))) ?></span>
            <span class="lesson-level-tag <?= h(levelClass($nivelModulo)) ?>"><?= h($nivelModulo) ?></span>
          </div>

          <h1 class="lesson-title"><?= h($aulaTitulo) ?> <em>em PHP</em></h1>
          <p class="lesson-desc"><?= h($aulaDescricao) ?></p>

          <?php if (!empty($aulaTopicos)): ?>
            <div class="modulo-topics" aria-label="Tópicos principais da aula">
              <?php foreach ($aulaTopicos as $tag): ?>
                <span class="topic-tag"><?= h($tag) ?></span>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </section>

        <section class="lesson-body">
          <?php if ($aulaAtual !== 1): ?>
            <div class="content-block">
              <h2 class="block-title">Conteúdo em construção</h2>
              <div class="prose">
                <p>Esta aula ainda não foi publicada. A estrutura já está pronta (layout + navegação + seções), faltando apenas o conteúdo teórico.</p>
              </div>
            </div>

          <?php else: ?>

            <div class="content-block">
              <h2 class="block-title">O que é uma variável?</h2>
              <div class="prose">
                <p>Uma <strong>variável</strong> é um “apelido” para um valor guardado na memória. Em PHP, toda variável começa com <strong>$</strong>.</p>
                <p>Você atribui valores usando o operador <strong>=</strong>. Leia como “recebe”.</p>
              </div>

              <div class="code-block">
                <div class="cb-header">
                  <div class="cb-dots"><div class="cb-dot"></div><div class="cb-dot"></div><div class="cb-dot"></div></div>
                  <span class="cb-lang">PHP · variaveis.php</span>
                </div>
                <pre class="cb-body"><?php echo h('<?php
$nome = "Ana";
$idade = 22;

echo $nome;
echo "\n";
echo $idade;
?>'); ?></pre>
              </div>

              <div class="callout">
                <div class="icon">💡</div>
                <div>
                  <strong>Dica</strong>
                  <p>No começo, foque em entender <em>atribuição</em> (guardar um valor) e <em>leitura</em> (usar a variável).</p>
                </div>
              </div>
            </div>

            <div class="content-block">
              <h2 class="block-title">Regras de nome (boas práticas)</h2>
              <div class="prose">
                <ul>
                  <li>Comece com <strong>$</strong> e use nomes claros: <strong>$preco</strong>, <strong>$nomeUsuario</strong>.</li>
                  <li>Evite acentos e espaços: prefira <strong>$nome_completo</strong> ou <strong>$nomeCompleto</strong>.</li>
                  <li>Seja consistente no padrão do projeto (snake_case ou camelCase).</li>
                </ul>
              </div>

              <div class="code-block">
                <div class="cb-header">
                  <div class="cb-dots"><div class="cb-dot"></div><div class="cb-dot"></div><div class="cb-dot"></div></div>
                  <span class="cb-lang">PHP · nomes.php</span>
                </div>
                <pre class="cb-body"><?php echo h('<?php
$nomeCompleto = "Maria Silva";
$preco_produto = 19.90;

// Evite nomes genéricos:
$x = 10;   // ruim
$total = 10; // melhor
?>'); ?></pre>
              </div>
            </div>

            <div class="content-block">
              <h2 class="block-title">Tipos de dados: o básico que você precisa</h2>
              <div class="prose">
                <p>PHP consegue armazenar vários tipos de valores. Nesta aula vamos focar nos mais comuns:</p>
                <ul>
                  <li><strong>String</strong>: texto (ex: "Olá")</li>
                  <li><strong>Int / Float</strong>: números inteiros e decimais (ex: 10, 9.5)</li>
                  <li><strong>Boolean</strong>: verdadeiro/falso (true/false)</li>
                  <li><strong>Array</strong>: coleção de valores</li>
                </ul>
                <p>Para “enxergar” tipo e valor, use <strong>var_dump()</strong>.</p>
              </div>

              <div class="code-block">
                <div class="cb-header">
                  <div class="cb-dots"><div class="cb-dot"></div><div class="cb-dot"></div><div class="cb-dot"></div></div>
                  <span class="cb-lang">PHP · debug.php</span>
                </div>
                <pre class="cb-body"><?php echo h('<?php
$mensagem = "Oi";
$quantidade = 3;
$preco = 19.90;
$ativo = true;

var_dump($mensagem);
var_dump($quantidade);
var_dump($preco);
var_dump($ativo);
?>'); ?></pre>
              </div>
            </div>

            <div class="content-block">
              <h2 class="block-title">Strings (texto)</h2>
              <div class="prose">
                <p>Strings podem ser criadas com <strong>aspas simples</strong> ou <strong>aspas duplas</strong>.</p>
                <ul>
                  <li>Aspas simples: mais “literal” (não interpreta <code>\n</code> nem variáveis)</li>
                  <li>Aspas duplas: interpreta escapes e permite interpolação</li>
                </ul>
              </div>

              <div class="code-block">
                <div class="cb-header">
                  <div class="cb-dots"><div class="cb-dot"></div><div class="cb-dot"></div><div class="cb-dot"></div></div>
                  <span class="cb-lang">PHP · strings.php</span>
                </div>
                <pre class="cb-body"><?php echo h('<?php
$nome = "João";

echo \'Olá, $nome\';    // NÃO troca $nome
echo "\n";
echo "Olá, $nome";      // troca $nome por João
echo "\n";
echo "Linha 1\nLinha 2"; // \n funciona nas aspas duplas
?>'); ?></pre>
              </div>
            </div>

            <div class="content-block">
              <h2 class="block-title">Int e Float (números)</h2>
              <div class="prose">
                <p><strong>Int</strong> é número inteiro. <strong>Float</strong> é número com casas decimais. Operações básicas funcionam direto.</p>
                <p>Quando misturamos int e float, o resultado tende a virar float (para não perder casas decimais).</p>
              </div>

              <div class="code-block">
                <div class="cb-header">
                  <div class="cb-dots"><div class="cb-dot"></div><div class="cb-dot"></div><div class="cb-dot"></div></div>
                  <span class="cb-lang">PHP · numeros.php</span>
                </div>
                <pre class="cb-body"><?php echo h('<?php
$itens = 3;        // int
$preco = 12.50;    // float

$total = $itens * $preco; // 37.5
echo $total;
?>'); ?></pre>
              </div>

              <div class="callout">
                <div class="icon">⚠️</div>
                <div>
                  <strong>Separador decimal</strong>
                  <p>No código, use ponto: <strong>12.50</strong> (não 12,50). A vírgula é para exibição ao usuário, não para o PHP interpretar.</p>
                </div>
              </div>
            </div>

            <div class="content-block">
              <h2 class="block-title">Boolean (true / false)</h2>
              <div class="prose">
                <p>Booleans são usados para decisões e validações. Exemplos: usuário logado? pagamento aprovado? estoque disponível?</p>
              </div>

              <div class="code-block">
                <div class="cb-header">
                  <div class="cb-dots"><div class="cb-dot"></div><div class="cb-dot"></div><div class="cb-dot"></div></div>
                  <span class="cb-lang">PHP · boolean.php</span>
                </div>
                <pre class="cb-body"><?php echo h('<?php
$usuarioLogado = true;

if ($usuarioLogado) {
    echo "Bem-vindo!";
} else {
    echo "Faça login.";
}
?>'); ?></pre>
              </div>
            </div>

            <div class="content-block">
              <h2 class="block-title">Arrays (listas de valores)</h2>
              <div class="prose">
                <p>Um <strong>array</strong> guarda vários valores dentro de uma única variável. É muito usado para listas (produtos, nomes, notas...).</p>
                <p>O índice padrão começa em <strong>0</strong>.</p>
              </div>

              <div class="code-block">
                <div class="cb-header">
                  <div class="cb-dots"><div class="cb-dot"></div><div class="cb-dot"></div><div class="cb-dot"></div></div>
                  <span class="cb-lang">PHP · arrays.php</span>
                </div>
                <pre class="cb-body"><?php echo h('<?php
$frutas = ["maçã", "banana", "uva"];

echo $frutas[0]; // maçã
echo "\n";
echo $frutas[2]; // uva
?>'); ?></pre>
              </div>

              <div class="callout">
                <div class="icon">✅</div>
                <div>
                  <strong>Por que arrays importam?</strong>
                  <p>Quando você aprender <em>loops</em> (for/foreach), vai conseguir percorrer listas inteiras com poucas linhas.</p>
                </div>
              </div>
            </div>

            <div class="content-block">
              <h2 class="block-title">Conversão de tipos (casting)</h2>
              <div class="prose">
                <p>Às vezes você recebe dados como texto (ex: formulário) e precisa transformar em número, ou garantir que algo seja boolean.</p>
                <p>O PHP permite conversões explícitas com <strong>(int)</strong>, <strong>(float)</strong>, <strong>(string)</strong> e <strong>(bool)</strong>.</p>
              </div>

              <div class="code-block">
                <div class="cb-header">
                  <div class="cb-dots"><div class="cb-dot"></div><div class="cb-dot"></div><div class="cb-dot"></div></div>
                  <span class="cb-lang">PHP · casting.php</span>
                </div>
                <pre class="cb-body"><?php echo h('<?php
$idadeTexto = "20";
$idade = (int) $idadeTexto;

$precoTexto = "19.90";
$preco = (float) $precoTexto;

var_dump($idade); // int(20)
var_dump($preco); // float(19.9)
?>'); ?></pre>
              </div>
            </div>

            <div class="section-divider"><hr><span>// PRONTO PARA PRÓXIMAS ETAPAS</span><hr></div>

            <div class="future-grid">
              <div class="future-card">
                <div class="k">placeholder</div>
                <div class="t">Atividades interativas</div>
                <div class="d">Estrutura reservada para quizzes e interações (sem implementação nesta etapa).</div>
              </div>
              <div class="future-card">
                <div class="k">placeholder</div>
                <div class="t">Exercícios + gabarito</div>
                <div class="d">Seção preparada para práticas e correção (será adicionada em prompts separados).</div>
              </div>
              <div class="future-card">
                <div class="k">placeholder</div>
                <div class="t">Laboratório PHP</div>
                <div class="d">Espaço reservado para ambiente de execução de código (não implementado agora).</div>
              </div>
            </div>

          <?php endif; ?>
        </section>
      <?php endif; ?>

      <footer>
        <div class="footer-logo">PHP<span>Master</span></div>
        <p>Projeto de Extensão Curricular — Engenharia de Software</p>
        <p style="color:var(--muted);font-size:.8rem">Feito com ❤️ para a comunidade</p>
      </footer>
    </main>
  </div>

  <script src="particles.js"></script>
  <script>
    // Sidebar mobile drawer (mesmo padrão do projeto)
    (function(){
      const toggle  = document.getElementById('menuToggle');
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('sidebarOverlay');
      if (!toggle || !sidebar || !overlay) return;

      function openSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('open');
        toggle.textContent = '✕';
      }
      function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('open');
        toggle.textContent = '☰';
      }

      toggle.addEventListener('click', () => {
        sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
      });
      overlay.addEventListener('click', closeSidebar);

      // Fecha o drawer ao escolher uma aula
      document.querySelectorAll('.lesson-link').forEach(a => {
        a.addEventListener('click', () => { if (window.innerWidth <= 900) closeSidebar(); });
      });
    })();
  </script>
</body>
</html>
