<?php

/**
 * Função para redimensionar imagem (Thumbnail)
 */
function criarThumbnail($caminhoOrigem, $caminhoDestino, $larguraMax, $alturaMax) {
    // Obter informações da imagem original
    list($larguraOrig, $alturaOrig, $tipo) = getimagesize($caminhoOrigem);

    // Calcular proporção
    $ratio = $larguraOrig / $alturaOrig;

    if ($larguraMax / $alturaMax > $ratio) {
        $larguraMax = $alturaMax * $ratio;
    } else {
        $alturaMax = $larguraMax / $ratio;
    }

    // Criar nova imagem em branco
    $novaImagem = imagecreatetruecolor($larguraMax, $alturaMax);

    // Carregar imagem original baseada no tipo
    switch ($tipo) {
        case IMAGETYPE_JPEG:
            $origem = imagecreatefromjpeg($caminhoOrigem);
            break;
        case IMAGETYPE_PNG:
            $origem = imagecreatefrompng($caminhoOrigem);
            // Manter transparência do PNG
            imagealphablending($novaImagem, false);
            imagesavealpha($novaImagem, true);
            break;
        case IMAGETYPE_GIF:
            $origem = imagecreatefromgif($caminhoOrigem);
            break;
        default:
            return false;
    }

    // Redimensionar
    imagecopyresampled($novaImagem, $origem, 0, 0, 0, 0, $larguraMax, $alturaMax, $larguraOrig, $alturaOrig);

    // Salvar no destino
    switch ($tipo) {
        case IMAGETYPE_JPEG:
            imagejpeg($novaImagem, $caminhoDestino, 90); // Qualidade 90
            break;
        case IMAGETYPE_PNG:
            imagepng($novaImagem, $caminhoDestino);
            break;
        case IMAGETYPE_GIF:
            imagegif($novaImagem, $caminhoDestino);
            break;
    }

    // Liberar memória
    imagedestroy($novaImagem);
    imagedestroy($origem);

    return true;
}

/**
 * Função para processar o upload com segurança
 */
function processarUpload($arquivo) {
    $diretorioUploads = 'uploads/';
    $diretorioThumbs = 'thumbs/';

    // 1. Validação de Erros Básicos
    if ($arquivo['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('Erro no upload do arquivo.');
    }

    // 2. Validação de Tamanho (Ex: 2MB)
    if ($arquivo['size'] > 2 * 1024 * 1024) {
        throw new Exception('Arquivo muito grande. Máximo 2MB.');
    }

    // 3. Validação de Tipo (MIME Type real, não confiar na extensão enviada pelo usuário)
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($arquivo['tmp_name']);

    $extensoesPermitidas = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif'
    ];

    if (!array_key_exists($mimeType, $extensoesPermitidas)) {
        throw new Exception('Formato de arquivo inválido.');
    }

    // 4. Sanitização e Renomeação (Segurança crítica)
    // Nunca use o nome original do arquivo para evitar sobrescrita ou execução de scripts maliciosos
    $extensao = $extensoesPermitidas[$mimeType];
    $novoNome = uniqid('img_') . '.' . $extensao;

    $destinoFinal = $diretorioUploads . $novoNome;
    $destinoThumb = $diretorioThumbs . $novoNome;

    // 5. Mover arquivo
    if (move_uploaded_file($arquivo['tmp_name'], $destinoFinal)) {
        // 6. Criar Thumbnail (200x200 max)
        criarThumbnail($destinoFinal, $destinoThumb, 200, 200);
        return "Upload realizado com sucesso!";
    } else {
        throw new Exception('Falha ao mover o arquivo.');
    }
}
?>