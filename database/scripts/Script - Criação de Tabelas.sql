create table pessoa
(
    id int primary key auto_increment not null,
    nome varchar(150) not null,
    rg varchar(20), 
    cpf varchar(20),
    endereco text not null,
    complemento text,
    bairro varchar(100) not null,
    cidade varchar(100) not null,
    estado varchar(100) not null,
    telefone varchar(20),
    data_nascimento date not null,
    status int default 1,
    observacao text
);

create table escola
(
    id int primary key auto_increment not null,
    razao_social varchar(200) not null,
    nome_fantasia varchar(200) not null,
    codigo_escola varchar(20) not null, 
    cnpj varchar(20) not null,
    endereco text not null,
    complemento text,
    bairro varchar(100) not null,
    cidade varchar(100) not null,
    estado varchar(100) not null,
    telefone varchar(20),
    data_inauguracao date not null,
    status int default 1,
    observacao text
);

create table aluno
(
    id int primary key auto_increment not null,
    registro varchar(20) not null,
    id_pessoa int not null,
    id_escola int not null
);

ALTER TABLE aluno
ADD CONSTRAINT id_aln_pessoa_fk 
FOREIGN KEY (id_pessoa) 
REFERENCES pessoa (id) ;

ALTER TABLE aluno
ADD CONSTRAINT id_aln_escola_fk 
FOREIGN KEY (id_escola) 
REFERENCES escola (id) ;

create table cargo
(
    id int primary key auto_increment not null,
    titulo varchar(100) not null,
    descricao text not null
);

create table administrativo
(
    id int primary key auto_increment not null,
    id_pessoa int not null,
    id_escola int not null,
    id_cargo int not null
);

ALTER TABLE administrativo
ADD CONSTRAINT id_pessoa_fk 
FOREIGN KEY (id_pessoa) 
REFERENCES pessoa (id) ;

ALTER TABLE administrativo
ADD CONSTRAINT id_escola_fk 
FOREIGN KEY (id_escola) 
REFERENCES escola (id) ;

ALTER TABLE administrativo
ADD CONSTRAINT id_cargo_fk 
FOREIGN KEY (id_cargo) 
REFERENCES cargo (id) ;

create table professor
(
    id int primary key auto_increment not null,
    id_pessoa int not null,
    id_escola int not null,
    registro varchar(20) not null,
    salario decimal(10,2) not null,
    status int not null default 1,
    data_cadastro date not null,
    observacao text,
    telefone varchar(20)
);

ALTER TABLE professor
ADD CONSTRAINT id_pfr_pessoa_fk 
FOREIGN KEY (id_pessoa) 
REFERENCES pessoa (id) ;

ALTER TABLE professor
ADD CONSTRAINT id_pfr_escola_fk 
FOREIGN KEY (id_escola) 
REFERENCES escola (id) ;

create table turma
(
	id int auto_increment primary key not null,
    nome varchar(100) not null,
    descricao varchar(200) not null,
    dt_inicio date,
    dt_termino date,
    status int not null default 0,
    observacao text,
    id_escola int not null,
    id_professor int,
    foreign key(id_escola) references escola(id),
    foreign key(id_professor) references professor(id)
);

create table aluno_turma
(
	id int auto_increment primary key not null,
    id_turma int not null,
    id_aluno int not null,
    foreign key(id_turma) references turma(id),
    foreign key(id_aluno) references aluno(id)
);

create table curso
(
	id int auto_increment primary key not null,
    nome varchar(150) not null,
    descricao varchar(200) not null,
    dt_cadastro date not null,
    status int not null default 0,
    preco decimal(10,2),
    observacao text
);

create table disciplina
(
	id int auto_increment primary key not null,
    nome varchar(150) not null,
    descricao varchar(200) not null,
    dt_cadastro date not null,
    status int not null default 0,
    observacao text
);

create table tipo_conteudo
(
	id int auto_increment primary key not null,
    tipo varchar(100) not null
);

create table conteudo
(
	id int auto_increment primary key not null,
    titulo varchar(150) not null,
    descricao varchar(200) not null,
    status int default 0,
    observacao text,
    id_disciplina int not null,
    id_tipo int not null,
    foreign key(id_disciplina) references disciplina(id),
    foreign key(id_tipo) references tipo_conteudo(id)
);

create table curso_disciplina
(
	id int auto_increment primary key not null,
    id_curso int not null,
    id_disciplina int not null,
    foreign key(id_curso) references curso(id),
    foreign key(id_disciplina) references disciplina(id)
);

create table aluno_disciplina
(
	id int auto_increment primary key not null,
    id_aluno int not null,
    id_disciplina int not null,
    status int default 0,
    foreign key(id_aluno) references aluno(id),
    foreign key(id_disciplina) references disciplina(id)
);

create table aluno_curso
(
	id int auto_increment primary key not null,
    id_aluno int not null,
    id_curso int not null,
    progresso decimal(10,2),
    status int default 0,
    nota decimal(10,2),
    foreign key(id_aluno) references aluno(id),
    foreign key(id_curso) references curso(id)
);

create table turma_curso
(
	id int auto_increment primary key not null,
    id_turma int not null,
    id_curso int not null,
    foreign key(id_turma) references turma(id),
    foreign key(id_curso) references curso(id)
);