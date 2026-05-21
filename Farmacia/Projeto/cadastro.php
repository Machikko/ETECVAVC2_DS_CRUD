<?php
require_once 'config/conexao.php';

$erros = [];
$dados = ['nome' => '', 'fabricante' => '', 'preco' => '', 'estoque' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome       = trim($_POST['nome'] ?? '');
    $fabricante = trim($_POST['fabricante'] ?? '');
    $preco      = $_POST['preco'] ?? '';
    $estoque    = $_POST['estoque'] ?? '';

    $dados = compact('nome', 'fabricante', 'preco', 'estoque');

    if ($nome === '')                              $erros[] = 'O nome é obrigatório.';
    if ($fabricante === '')                        $erros[] = 'O fabricante é obrigatório.';
    if (!is_numeric($preco) || $preco < 0)        $erros[] = 'Informe um preço válido.';
    if (!ctype_digit((string)$estoque))            $erros[] = 'Informe um estoque válido.';

    if (empty($erros)) {
        $stmt = $conexao->prepare("INSERT INTO produtos (nome, fabricante, preco, estoque) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nome, $fabricante, (float)$preco, (int)$estoque]);
        header('Location: index.php?msg=cadastrado');
        exit;
    }
}

require_once 'includes/header.php';
?>

<h1>Novo Produto</h1>

<?php if (!empty($erros)): ?>
    <div class="alerta alerta-erro">
        <?php foreach ($erros as $e): ?><div><?= $e ?></div><?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="form-card">
    <form method="POST" action="cadastro.php">
        <div class="form-grid-2">
            <div class="form-group">
                <label for="nome">Nome do Produto</label>
                <input type="text" id="nome" name="nome" value="<?= $dados['nome'] ?>" placeholder="Ex: Paracetamol 750mg" required>
            </div>
            <div class="form-group">
                <label for="fabricante">Fabricante</label>
                <input type="text" id="fabricante" name="fabricante" value="<?= $dados['fabricante'] ?>" placeholder="Ex: EMS" required>
            </div>
            <div class="form-group">
                <label for="preco">Preço (R$)</label>
                <input type="number" id="preco" name="preco" value="<?= $dados['preco'] ?>" step="0.01" min="0" placeholder="0.00" required>
            </div>
            <div class="form-group">
                <label for="estoque">Estoque (un.)</label>
                <input type="number" id="estoque" name="estoque" value="<?= $dados['estoque'] ?>" min="0" placeholder="0" required>
            </div>
        </div>
        <div class="form-acoes">
            <a href="index.php" class="btn btn-voltar">Cancelar</a>
            <button type="submit" class="btn-salvar">Cadastrar Produto</button>
        </div>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
