# Sistema de Gerenciamento de Consultas Médicas
<img alt="Tamanho do repositório" src="https://img.shields.io/github/repo-size/elizalap/teste-back-end-jr-php">
<img alt="último commit" src="https://img.shields.io/github/last-commit/elizalap/teste-back-end-jr-php">

## Descrição do projeto
Este projeto faz parte de um desafio de código onde crio uma aplicação backend para gerenciar consultas médicas utilizando o framework Symfony.

O projeto permite criar, listar, atualizar e deletar registros de beneficiários, médicos, hospitais e consultas.

## 🚀 Entidades e Atributos

1. **Beneficiário**
   - `id`: Identificador único.
   - `nome`: Nome do beneficiário.
   - `email`: Email do beneficiário.
   - `data_nascimento`: Data de nascimento do beneficiário.

2. **Médico**
   - `id`: Identificador único.
   - `nome`: Nome do médico.
   - `especialidade`: Especialidade do médico.
   - `hospital`: ID do hospital ao qual o médico está associado.

3. **Hospital**
   - `id`: Identificador único.
   - `nome`: Nome do hospital.
   - `endereco`: Endereço do hospital.

4. **Consulta**
   - `id`: Identificador único.
   - `data`: Data da consulta.
   - `status`: Status da consulta (ex.: "Agendada", "Concluída").
   - `beneficiario`: ID do beneficiário.
   - `medico`: ID do médico.
   - `hospital`: ID do hospital.

## 🛠 Regras de Negócio

Aqui estão as regras implementadas:

- [x] Beneficiários devem ter 18 anos ou mais para serem cadastrados.
- [x] Cada médico precisa estar associado a um hospital existente.
- [x] Consultas que com status "Concluída" não podem ser alteradas ou excluídas.

## 💻 Como rodar o projeto

Siga esse passo a passo para colocar a aplicação para rodar na sua máquina:

#### 1. Pré-requisitos

Certifique-se de ter o seguinte instalado:

- PHP 8.0 ou superior
- Doctrine ORM
- Composer
- MySQL
- Symfony CLI (opcional)

#### 2. Clonar o repositório

```bash
git clone https://github.com/seu-usuario/nome-do-repositorio.git
cd med_appointment_backend
```

#### 3. Instalar dependências
```bash
composer install
```

#### 4. Configuração do Banco de Dados
Crie um banco de dados MySQL e configure as credenciais de acesso no arquivo .env:
```bash
DATABASE_URL="mysql://username:password@127.0.0.1:3306/nome_do_banco_de_dados"
```

#### 5. Executar migrações
```bash
php bin/console doctrine:migrations:migrate
```

#### 6. Executar a aplicação
```bash
symfony server:start
//ou symfony serve -d --no-tls
```

## ⚙️ Rotas para testar a aplicação

**Beneficiários** 
- POST /beneficiario: Criar um novo beneficiário.
- GET /beneficiario: Listar todos os beneficiários.
- PUT /beneficiario/{id}: Atualizar um beneficiário.
- DELETE /beneficiario/{id}: Deletar um beneficiário.

**Médicos**

- POST /medico: Criar um novo médico.
- GET /medico: Listar todos os médicos.
- PUT /medico/{id}: Atualizar um médico.
- DELETE /medico/{id}: Deletar um médico.

**Hospitais**

- POST /hospital: Criar um novo hospital.
- GET /hospital: Listar todos os hospitais.
- PUT /hospital/{id}: Atualizar um hospital.
- DELETE /hospital/{id}: Deletar um hospital.

**Consultas**

- POST /consulta: Criar uma nova consulta.
- GET /consulta: Listar todas as consultas.
- PUT /consulta/{id}: Atualizar uma consulta (apenas se não estiver concluída).
- DELETE /consulta/{id}: Deletar uma consulta (apenas se não estiver concluída).
