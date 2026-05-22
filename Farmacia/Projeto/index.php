<?php
require_once 'config/conexao.php';

$busca = trim($_GET['busca'] ?? '');

if ($busca !== '') {
    $stmt = $conexao->prepare("SELECT * FROM produtos WHERE nome LIKE ? OR fabricante LIKE ? ORDER BY nome ASC");
    $like = "%$busca%";
    $stmt->execute([$like, $like]);
} else {
    $stmt = $conexao->query("SELECT * FROM produtos ORDER BY nome ASC");
}

$produtos = $stmt->fetchAll();
$mensagem = $_GET['msg'] ?? '';

require_once 'includes/header.php';
?>

<h1>Estoque de Produtos</h1>

<?php if ($mensagem === 'cadastrado'): ?>
    <div class="alerta alerta-sucesso">Produto cadastrado com sucesso!</div>
<?php elseif ($mensagem === 'editado'): ?>
    <div class="alerta alerta-sucesso">Produto atualizado com sucesso!</div>
<?php elseif ($mensagem === 'excluido'): ?>
    <div class="alerta alerta-sucesso">Produto removido do estoque.</div>
<?php endif; ?>

<form class="barra-busca" method="GET" action="index.php">
    <input type="text" name="busca" placeholder="Buscar por nome ou fabricante..." value="<?= $busca ?>">
</form>

<?php if (empty($produtos)): ?>
    <div class="empty-state">Nenhum produto encontrado.</div>

<?php else: ?>

    <div class="cards-grid">
        <?php foreach ($produtos as $p): ?>
        <div class="card">
            <div class="card-nome"><?= $p['nome'] ?></div>
            <div class="card-fab"><?= $p['fabricante'] ?></div>
            <div class="card-info">
                <span class="badge badge-preco">💰R$<?= number_format($p['preco'], 2, ',', '.') ?></span>
                <span class="badge badge-estoque <?= $p['estoque'] <= 10 ? 'baixo' : '' ?>">📦<?= $p['estoque'] ?> un.</span>
            </div>
            <div class="card-acoes">
                <a href="editar.php?id=<?= $p['id'] ?>" class="btn btn-editar">Editar</a>
                <a href="excluir.php?id=<?= $p['id'] ?>" class="btn btn-excluir" onclick="return confirm('Excluir este produto?')">Excluir</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="tabela-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Fabricante</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><strong><?= $p['nome'] ?></strong></td>
                    <td><?= $p['fabricante'] ?></td>
                    <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                    <td><span class="badge badge-estoque <?= $p['estoque'] <= 10 ? 'baixo' : '' ?>"><?= $p['estoque'] ?> un.</span></td>
                    <td>
                        <div class="td-acoes">
                            <a href="editar.php?id=<?= $p['id'] ?>" class="btn btn-editar">Editar</a>
                            <a href="excluir.php?id=<?= $p['id'] ?>" class="btn btn-excluir" onclick="return confirm('Excluir este produto?')">Excluir</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
