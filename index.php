<?php
require 'functions.php';

$mensagem = '';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagem'])) {
    try {
        $mensagem = processarUpload($_FILES['imagem']);
        $classeMsg = 'sucesso';
    } catch (Exception $e) {
        $mensagem = $e->getMessage();
        $classeMsg = 'erro';
    }
}

// Lista as imagens da pasta thumbs para exibir
$imagens = glob('thumbs/*.{jpg,png,gif}', GLOB_BRACE);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeria PHP Puro</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 2rem auto; padding: 0 1rem; }
        .form-container { background: #f4f4f4; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .galeria { display: flex; flex-wrap: wrap; gap: 10px; }
        .galeria img { border: 1px solid #ddd; border-radius: 4px; padding: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .sucesso { color: green; font-weight: bold; }
        .erro { color: red; font-weight: bold; }
        button { background: #007bff; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px;}
        button:hover { background: #0056b3; }
    </style>
</head>
<body>

<h1>Galeria de Imagens com Thumbnail</h1>

<?php if ($mensagem): ?>
    <p class="<?php echo $classeMsg; ?>"><?php echo $mensagem; ?></p>
<?php endif; ?>

<div class="form-container">
    <form action="index.php" method="POST" enctype="multipart/form-data">
        <label for="imagem">Escolha uma imagem:</label>
        <input type="file" name="imagem" id="imagem" required>
        <button type="submit">Enviar Imagem</button>
    </form>
    <p><small>Formatos: JPG, PNG, GIF. Máx: 2MB.</small></p>
</div>

<hr>

<h2>Galeria</h2>
<div class="galeria">
    <?php if (count($imagens) > 0): ?>
        <?php foreach ($imagens as $thumb): ?>
            <?php
            // Pega o caminho da imagem original trocando 'thumbs/' por 'uploads/'
            $original = str_replace('thumbs/', 'uploads/', $thumb);
            ?>
            <a href="<?php echo $original; ?>" target="_blank">
                <img src="<?php echo $thumb; ?>" alt="Imagem da galeria">
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nenhuma imagem na galeria ainda.</p>
    <?php endif; ?>
</div>

</body>
</html>