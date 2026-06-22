-- Colunas de auditoria na tabela curso_disciplina (PostgreSQL)
-- Execute no DBeaver conectado ao banco sistema_escolar

ALTER TABLE curso_disciplina
    ADD COLUMN IF NOT EXISTS dt_create date;

ALTER TABLE curso_disciplina
    ADD COLUMN IF NOT EXISTS dt_update date;
