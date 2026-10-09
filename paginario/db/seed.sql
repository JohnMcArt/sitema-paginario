-- Dados de demonstração do Paginário.
-- Execute depois de db/script.sql. Os títulos existentes não serão duplicados.

INSERT INTO Livro (titulo, autor, ano_publicacao, editor, genero, formato, link_arquivo, capa, sinopse, classificacao_indicativa)
SELECT 'A Cartomante', 'Machado de Assis', 1884, 'Edição digital', 'Conto', 'EPUB', 'arquivos-livros/a-cartomante.epub', 'img/a-cartomante.jpg', 'Um triângulo amoroso e uma consulta a uma cartomante conduzem este conto marcado pela ironia e pela tensão psicológica.', 12
WHERE NOT EXISTS (SELECT 1 FROM Livro WHERE titulo = 'A Cartomante');

INSERT INTO Livro (titulo, autor, ano_publicacao, editor, genero, formato, link_arquivo, capa, sinopse, classificacao_indicativa)
SELECT 'A Metamorfose', 'Franz Kafka', 1915, 'Edição digital', 'Novela', 'PDF', 'arquivos-livros/a-metamorfose.pdf', 'img/a-metamorfose.jpg', 'Gregor Samsa acorda transformado em um inseto e passa a enfrentar o isolamento, a identidade e as mudanças nas relações familiares.', 12
WHERE NOT EXISTS (SELECT 1 FROM Livro WHERE titulo = 'A Metamorfose');

INSERT INTO Livro (titulo, autor, ano_publicacao, editor, genero, formato, link_arquivo, capa, sinopse, classificacao_indicativa)
SELECT 'Crime e Castigo', 'Fiódor Dostoiévski', 1866, 'Edição digital', 'Romance psicológico', 'EPUB', 'arquivos-livros/crime-e-castigo.epub', 'img/crime-e-castigo.png', 'Após cometer um crime, Raskólnikov é levado a confrontar a culpa, a moral e as consequências de suas próprias ideias.', 16
WHERE NOT EXISTS (SELECT 1 FROM Livro WHERE titulo = 'Crime e Castigo');

INSERT INTO Livro (titulo, autor, ano_publicacao, editor, genero, formato, link_arquivo, capa, sinopse, classificacao_indicativa)
SELECT 'Dom Casmurro', 'Machado de Assis', 1899, 'Edição digital', 'Romance', 'PDF', 'arquivos-livros/dom-casmurro.pdf', 'img/dom-casmurro.jpg', 'Bentinho narra sua relação com Capitu em uma história célebre pela memória subjetiva e pela dúvida que atravessa o romance.', 12
WHERE NOT EXISTS (SELECT 1 FROM Livro WHERE titulo = 'Dom Casmurro');

INSERT INTO Livro (titulo, autor, ano_publicacao, editor, genero, formato, link_arquivo, capa, sinopse, classificacao_indicativa)
SELECT 'O Cortiço', 'Aluísio Azevedo', 1890, 'Edição digital', 'Romance naturalista', 'PDF', 'arquivos-livros/o-cortico.pdf', 'img/o-cortico.jpg', 'Em um cortiço do Rio de Janeiro, diferentes personagens revelam tensões sociais, desigualdades e relações de poder.', 14
WHERE NOT EXISTS (SELECT 1 FROM Livro WHERE titulo = 'O Cortiço');

INSERT INTO Livro (titulo, autor, ano_publicacao, editor, genero, formato, link_arquivo, capa, sinopse, classificacao_indicativa)
SELECT 'Orgulho e Preconceito', 'Jane Austen', 1813, 'Edição digital', 'Romance', 'PDF', 'arquivos-livros/orgulho-e-preconceito.pdf', 'img/orgulho-e-preconceito.jpg', 'Elizabeth Bennet e Fitzwilliam Darcy desafiam primeiras impressões e convenções sociais em uma história de afeto e amadurecimento.', 10
WHERE NOT EXISTS (SELECT 1 FROM Livro WHERE titulo = 'Orgulho e Preconceito');

INSERT INTO Livro (titulo, autor, ano_publicacao, editor, genero, formato, link_arquivo, capa, sinopse, classificacao_indicativa)
SELECT 'Os Sertões', 'Euclides da Cunha', 1902, 'Edição digital', 'Literatura e não ficção', 'EPUB', 'arquivos-livros/os-sertoes.epub', 'img/os-sertoes.png', 'A obra combina relato histórico, análise social e descrição da paisagem para abordar a Guerra de Canudos e o sertão brasileiro.', 14
WHERE NOT EXISTS (SELECT 1 FROM Livro WHERE titulo = 'Os Sertões');

INSERT INTO Livro (titulo, autor, ano_publicacao, editor, genero, formato, link_arquivo, capa, sinopse, classificacao_indicativa)
SELECT 'Persuasão', 'Jane Austen', 1817, 'Edição digital', 'Romance', 'PDF', 'arquivos-livros/persuasao.pdf', 'img/persuasao.jpg', 'Anne Elliot reencontra um antigo amor e precisa lidar com o tempo, as escolhas passadas e as expectativas da sociedade.', 10
WHERE NOT EXISTS (SELECT 1 FROM Livro WHERE titulo = 'Persuasão');

INSERT INTO Livro (titulo, autor, ano_publicacao, editor, genero, formato, link_arquivo, capa, sinopse, classificacao_indicativa)
SELECT 'Senhora', 'José de Alencar', 1875, 'Edição digital', 'Romance', 'EPUB', 'arquivos-livros/senhora.epub', 'img/senhora.jpg', 'Aurélia Camargo desafia as convenções do casamento e da posição social em um romance sobre dinheiro, orgulho e sentimentos.', 12
WHERE NOT EXISTS (SELECT 1 FROM Livro WHERE titulo = 'Senhora');
