-- Execute este script conectado como superusuário (ex.: postgres)
-- no banco sistema_escolar, após criar as tabelas.

GRANT USAGE ON SCHEMA public TO sistema_escolar_user;

GRANT SELECT, INSERT, UPDATE, DELETE ON ALL TABLES IN SCHEMA public TO sistema_escolar_user;

GRANT USAGE, SELECT ON ALL SEQUENCES IN SCHEMA public TO sistema_escolar_user;

ALTER DEFAULT PRIVILEGES IN SCHEMA public
    GRANT SELECT, INSERT, UPDATE, DELETE ON TABLES TO sistema_escolar_user;

ALTER DEFAULT PRIVILEGES IN SCHEMA public
    GRANT USAGE, SELECT ON SEQUENCES TO sistema_escolar_user;
