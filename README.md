# portifolio_upload
Projeto 9 - Upload e galeria


O que faz: Permite que usuários façam upload de imagens. O sistema deve redimensioná-las para criar "thumbnails" (miniaturas) e exibi-las em uma galeria.
Habilidades que demonstra: Manipulação de arquivos ($_FILES), processamento de imagens (com a biblioteca GD ou Imagick) e segurança em uploads.



Com certeza. Aqui está o texto completo em português, já formatado para o seu portfólio ou README, com os links diretos inclusos:

---

# Projeto 9: Upload e Galeria de Imagens em PHP Puro

### Descrição

Sistema de gerenciamento de imagens desenvolvido em PHP puro, focado em manipulação de arquivos e segurança. O projeto permite o upload de imagens, gera automaticamente miniaturas (thumbnails) utilizando a biblioteca GD e exibe o resultado em uma galeria organizada.

### Funcionalidades

* **Upload com Validação:** Verifica tipos MIME reais (segurança contra scripts maliciosos) e tamanho de arquivo.
* **Geração de Thumbnails:** Redimensionamento automático de imagens preservando proporção e transparência (PNG/GIF).
* **Organização Automática:** Criação dinâmica de diretórios (`uploads/` e `thumbs/`) caso não existam no servidor.
* **Segurança:** Renomeação de arquivos com hash único para evitar conflitos e sobrescrita.

### Estrutura do Código

* `functions.php`: Lógica de backend (validação, upload e processamento de imagem).
* `index.php`: Frontend com formulário de envio e exibição da galeria.
* `.gitignore`: Configurado para ignorar arquivos de mídia locais, mantendo o repositório limpo.

### Desafios Superados

1. **Ambiente:** Configuração da biblioteca GD no `php.ini` do servidor Apache/XAMPP.
2. **Permissões:** Implementação de verificação de diretórios para evitar erros de "No such file or directory".
3. **Git:** Limpeza de cache do Git para garantir que pastas de upload de teste não fossem versionadas.

### Links do Projeto

* **Repositório (Código Fonte):** [https://github.com/gmmaraccini/portifolio_upload](https://github.com/gmmaraccini/portifolio_upload)
* **Demonstração em Vídeo:** [https://youtu.be/WwQtyCWg8Mw](https://youtu.be/WwQtyCWg8Mw)