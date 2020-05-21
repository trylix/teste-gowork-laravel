<p align="center"><img src=".github/logo.png" width="400"></p>

<p  align="center">Este codigo representa a minha solução do teste proposto pela <a  href="https://www.gowork.com.br/">GoWork</a></p>

## 🚀 Sobre o projeto

Coplace é uma aplicação para gerenciamento de clientes de coworking desenvolvida como resolução ao [teste para a vaga de fullstack na empresa GoWork](https://github.com/ctg325/teste-gowork), desenvolvida com [React para o front-end](https://github.com/trylix/teste-gowork-frontend) e duas versões para o back-end, uma em [PHP com Laravel](https://github.com/trylix/teste-gowork-laravel) e outra em [NodeJS e Express](https://github.com/trylix/teste-gowork-nodejs).

Ambas versões do projeto para backend foram desenvolvidas seguindo os princípios de [TDD](https://pt.wikipedia.org/wiki/Test-driven_development). 👮🏻‍♂️

-   [Resolução do teste](#-resolução-do-teste)
-   [Tecnologias](#-tecnologias)
-   [Instalação e execução](#-instalação-e-execução)
-   [Documentação da API](#-rotas-da-api)
-   [Próxima etapa](#-próxima-etapa)

## 🤯 Resolução do teste

A aplicação hoje contempla:

✅ Cadastro de Usuários

✅ Autenticação de usuários através de email e senha

✅ Cadastro de Unidades (Escritorios)

> Foi criado o endpoint `/offices` onde o usuário pode consumir os dados das unidades já disponíveis e também cadastrar novas unidades.

✅ Cadastro de Planos de Coworking, contendo Nome do Plano, Valor Mensal

> Foi criado o endpoint `/plans` onde o usuário realiza a gestão dos planos oferecidos pela empresa.

✅ Cadastro de Clientes (Pessoa Fisica e Juridica) vinculado com Plano Contratado e Unidade

> Foi criado o endpoint `/customers` onde o usuário poderá listar seus clientes atuais e também adicionar novos.

✅ Cadastro de Funcionarios do Cliente/Pessoas que podem usar o Coworking

> Foi criado o endpoint `/employees` onde o usuário realizará a gestão de funcionários de seus clientes.

## 👀 Preview
![](.github/preview.gif)

## 🛸 Tecnologias

Esse projeto foi desenvolvido com:

-   [PHP](hhttps://www.php.net/)
-   [Laravel](https://laravel.com/)

## 🛠 Instalação e execução

**Faça um clone desse repositório**

-   Execute `composer install` para instalar o composer;
-   Execute `cp .env.example .env` e preencha o arquivo `.env` com suas variáveis ambiente;
-   Execute `php artisan key:generate` para gerar uma nova key.
-   Execute `php artisan jwt:secret` para gerar uma nova key JWT.
-   Execute `php artisan migrate` para executar as migrations do banco de dados.
-   Execute `php artisan storage:link` para criar um link público pasta storage (armazenamento de arquivos feito por upload).

**Testes**

-   Execute `php artisian test`

## 🚗 Rotas da API

### POST `/api/auth`

> Realiza a autenticação do usuário administrador
>
> | Params | Query  | Body               | Response           |
> | ------ | ------ | ------------------ | ------------------ |
> | `null` | `null` | `application/json` | `application/json` |

### GET `/api/offices`

> Realiza a listagem de unidades/escritórios

| Params | Query  | Body   | Response           |
| ------ | ------ | ------ | ------------------ |
| `null` | `null` | `null` | `application/json` |

### POST `/api/offices`

> Realiza o cadastramento de unidade/escritório

| Params | Query  | Body               | Response           |
| ------ | ------ | ------------------ | ------------------ |
| `null` | `null` | `application/json` | `application/json` |

### GET `/api/plans`

> Realiza a listagem de planos

| Params | Query  | Body   | Response           |
| ------ | ------ | ------ | ------------------ |
| `null` | `null` | `null` | `application/json` |

### POST `/api/plans`

> Realiza o cadastramento de planos

| Params | Query  | Body               | Response           |
| ------ | ------ | ------------------ | ------------------ |
| `null` | `null` | `application/json` | `application/json` |

### GET `/api/customers`

> Realiza a listagem de clientes

| Params | Query  | Body   | Response           |
| ------ | ------ | ------ | ------------------ |
| `null` | `null` | `null` | `application/json` |

### POST `/api/customers`

> Realiza o cadastramento de clientes

| Params | Query  | Body               | Response           |
| ------ | ------ | ------------------ | ------------------ |
| `null` | `null` | `application/json` | `application/json` |

### GET `/api/employees/{1}`

> Realiza a listagem de funcionários de um cliente

| Params | Query           | Body   | Response           |
| ------ | --------------- | ------ | ------------------ |
| `null` | `ID do cliente` | `null` | `application/json` |

### POST `/api/employees`

> Realiza o cadastramento de um funcionário

| Params | Query  | Body               | Response           |
| ------ | ------ | ------------------ | ------------------ |
| `null` | `null` | `application/json` | `application/json` |

### POST `/api/upload`

> Realiza o upload de um arquivo

| Params | Query  | Body                  | Response           |
| ------ | ------ | --------------------- | ------------------ |
| `null` | `null` | `multipart/form-data` | `application/json` |

## 📌 Próxima etapa

**Unidades**

-   Deleter unidade
-   Editar unidade

**Planos**

-   Deleter unidade
-   Editar unidade

**Clientes**

-   Deleter unidade
-   Editar unidade

**Funcionários**

-   Deleter unidade
-   Editar unidade

---

Feito com ♥️ by Brendenson - [Github](https://github.com/trylix) | [LinkedIn](https://www.linkedin.com/in/dobrendenson)
