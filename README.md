# Paginário — Biblioteca Digital

O **Paginário** é um sistema de biblioteca digital desenvolvido com **PHP, MySQL, HTML, CSS e JavaScript**. Esta versão reorganiza a interface com uma linguagem visual atual inspirada em interfaces nativas: com tipografia limpa, superfícies claras, cantos suaves, foco em acessibilidade e layout responsivo.

## O que existe no projeto

- Página inicial de apresentação do produto.
- Catálogo conectado ao MySQL, com pesquisa por título, autor ou gênero.
- Ordenação por título, autor e ano de publicação.
- Página de detalhes do livro e acesso ao arquivo digital quando cadastrado.
- Fluxos existentes de cadastro e autenticação de leitor/administrador/autor.
- Páginas de filtro por gênero, autor, editora e classificação indicativa.
- Perfil do leitor e formulário de solicitação/sugestão de livros.
- Folha de estilos compartilhada em `paginario/assets/css/theme.css`.

## Tecnologias

- PHP 8+ (recomendado)
- MySQL 8+ ou MariaDB compatível
- PDO para acesso ao banco de dados
- HTML5, CSS3 e JavaScript sem framework obrigatório

## Como executar localmente

1. Instale um ambiente PHP + MySQL, como XAMPP, Laragon ou equivalente.
2. Copie a pasta `paginario` para a pasta pública do servidor (`htdocs` no XAMPP, por exemplo).
3. No MySQL, crie o banco:

   ```sql
   CREATE DATABASE biblioteca_paginario CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

4. Importe `paginario/db/script.sql` no banco `biblioteca_paginario`.
5. (Opcional) Importe `paginario/db/seed.sql` para preencher o catálogo com os livros de demonstração incluídos no projeto.
6. Copie `paginario/.env.example` para `paginario/.env` e ajuste `DB_HOST`, `DB_NAME`, `DB_USER` e `DB_PASS`. Por padrão, o projeto usa `127.0.0.1`, banco `biblioteca_paginario`, usuário `root` e senha vazia. O arquivo `.env` local é ignorado pelo Git. **Não coloque senhas reais no GitHub.**
7. Inicie Apache e MySQL e abra `http://localhost/paginario/` (ou o caminho correspondente à pasta que você usou).

### Configurando credenciais no ambiente

O arquivo `paginario/db/conexao.php` lê primeiro as variáveis de ambiente do sistema e, quando disponíveis, completa a configuração com `paginario/.env`. Em serviços de hospedagem, prefira definir as credenciais no painel da aplicação. Nunca versione o `.env` local nem publique credenciais reais.

## Banco de dados

O esquema está em `paginario/db/script.sql`. Ele contém as entidades de usuários, administradores, autores, livros, gêneros, editoras, solicitações e relações auxiliares. Os arquivos digitais ficam em `paginario/arquivos-livros/` e as imagens em `paginario/img/`.

> O esquema cria as tabelas, mas não cria um usuário administrador. Para bancos criados com uma versão anterior do esquema, execute `ALTER TABLE Livro MODIFY sinopse TEXT NOT NULL;` antes de importar os dados de demonstração. Não use dados de teste como credenciais de produção.

## Estrutura principal

```text
paginario/
├── .env.example         # modelo de configuração local
├── assets/
│   ├── css/theme.css
│   └── js/app.js
├── controllers/          # operações CRUD organizadas por entidade
├── db/
│   ├── conexao.php       # conexão PDO via variáveis de ambiente
│   ├── script.sql        # esquema MySQL
│   └── seed.sql          # livros de demonstração opcionais
├── arquivos-livros/      # PDFs e EPUBs do acervo de demonstração
├── img/                  # capas e identidade visual
├── index.php             # landing page
├── inicio.php            # catálogo
└── detalhes_livro.php    # detalhes de uma obra
```

## Antes de publicar

- Defina credenciais de banco exclusivas para a aplicação; evite usar o usuário `root` em produção.
- Configure HTTPS e erros do PHP para não serem exibidos publicamente.
- Revise permissões de cadastro e de acesso às rotas administrativas.
- Confirme que os arquivos do acervo podem ser redistribuídos no repositório público.
- Faça testes de autenticação, formulários e operações CRUD com um banco de desenvolvimento.

## Licença

Nenhuma licença de código foi definida neste repositório. Se pretende permitir reutilização, escolha uma licença apropriada e inclua o arquivo `LICENSE`. Verifique separadamente os direitos de distribuição dos livros e imagens incluídos.
