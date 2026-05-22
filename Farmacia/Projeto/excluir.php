<?php
require_once 'config/conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {
    $stmt = $conexao->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: index.php?msg=excluido');
exit;
