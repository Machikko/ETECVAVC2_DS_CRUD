<?php
require_once 'config/conexao.php';

$erros = [];
$id    = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) { header('Location: index.php'); exit; }

$stmt = $conexao->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch();

if (!$produto) { header('Location: index.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome       = trim($_POST['nome'] ?? '');
    $fabricante = trim($_POST['fabricante'] ?? '');
    $preco      = $_POST['preco'] ?? '';
    $estoque    = $_POST['estoque'] ?? '';

    $produto = array_merge($produto, compact('nome', 'fabricante', 'preco', 'estoque'));

    if ($nome === '')                        $erros[] = 'O nome é obrigatório.';
    if ($fabricante === '')                  $erros[] = 'O fabricante é obrigatório.';
    if (!is_numeric($preco) || $preco < 0)  $erros[] = 'Informe um preço válido.';
    if (!ctype_digit((string)$estoque))      $erros[] = 'Informe um estoque válido.';

    if (empty($erros)) {
        $stmt = $conexao->prepare("UPDATE produtos SET nome=?, fabricante=?, preco=?, estoque=? WHERE id=?");
        $stmt->execute([$nome, $fabricante, (float)$preco, (int)$estoque, $id]);
        header('Location: index.php?msg=editado');
        exit;
    }
}

require_once 'includes/header.php';
?>

<h1>Editar Produto</h1>

<?php if (!empty($erros)): ?>
    <div class="alerta alerta-erro">
        <?php foreach ($erros as $e): ?><div><?= $e ?></div><?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="form-card">
    <form method="POST" action="editar.php?id=<?= $id ?>">
        <div class="form-grid-2">
            <div class="form-group">
                <label for="nome">Nome do Produto</label>
                <input type="text" id="nome" name="nome" value="<?= $produto['nome'] ?>" required>
            </div>
            <div class="form-group">
                <label for="fabricante">Fabricante</label>
                <input type="text" id="fabricante" name="fabricante" value="<?= $produto['fabricante'] ?>" required>
            </div>
            <div class="form-group">
                <label for="preco">Preço (R$)</label>
                <input type="number" id="preco" name="preco" value="<?= $produto['preco'] ?>" step="0.01" min="0" required>
            </div>
            <div class="form-group">
                <label for="estoque">Estoque (un.)</label>
                <input type="number" id="estoque" name="estoque" value="<?= $produto['estoque'] ?>" min="0" required>
            </div>
        </div>
        <div class="form-acoes">
            <a href="index.php" class="btn btn-voltar">Cancelar</a>
            <button type="submit" class="btn-salvar">Salvar Alterações</button>
        </div>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
