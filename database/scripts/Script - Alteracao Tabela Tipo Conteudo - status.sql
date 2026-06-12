-- Coluna status na tabela tipo_conteudo (PostgreSQL)
-- Execute no DBeaver conectado ao banco sistema_escolar (como postgres ou owner da tabela)

ALTER TABLE tipo_conteudo
    ADD COLUMN IF NOT EXISTS status int NOT NULL DEFAULT 1;

COMMENT ON COLUMN tipo_conteudo.status IS '0 = Inativo, 1 = Ativo';
