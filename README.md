# Manrus API

API do Manrus, um aplicativo financeiro pensado para tornar o controle do dinheiro prático e colaborativo. Mais de uma pessoa pode registrar movimentações em um mesmo contexto financeiro, mantendo claro quem fez cada lançamento e permitindo acompanhar as finanças em conjunto.

## Visão do produto

O Manrus busca atender casais, famílias e outros grupos que precisam organizar despesas e receitas sem depender de uma única pessoa para manter os dados atualizados. Cada participante pode contribuir com os lançamentos e acompanhar a situação financeira compartilhada.

O aplicativo deverá oferecer:

- **Colaboração:** várias pessoas registram e consultam movimentações do mesmo contexto financeiro.
- **Rastreabilidade:** cada lançamento pode ser associado a quem o registrou.
- **Visões sintéticas e analíticas:** acompanhamento rápido dos totais e exploração detalhada por período, categoria ou participante.
- **Comparação entre contas:** por exemplo, visualizar lado a lado a conta do Vitor e a conta da Elie, além de entender o panorama compartilhado.
- **Relatórios em conversa:** uso de IA para responder perguntas financeiras em chat e gerar relatórios com base nos dados relevantes do usuário.

A experiência de IA está planejada para usar RAG (geração aumentada por recuperação), buscando informações financeiras pertinentes antes de produzir uma resposta. Assim, os relatórios poderão se apoiar nos dados do próprio usuário em vez de depender apenas de conhecimento genérico do modelo.

## Estado atual

O projeto está em desenvolvimento. No momento, a API implementa operações CRUD para usuários:

| Método | Endpoint | Operação |
| --- | --- | --- |
| `GET` | `/api/users` | Listar usuários |
| `POST` | `/api/users` | Criar usuário |
| `GET` | `/api/users/{user}` | Consultar usuário |
| `PUT` ou `PATCH` | `/api/users/{user}` | Atualizar usuário |
| `DELETE` | `/api/users/{user}` | Remover usuário |

Os recursos financeiros compartilhados, lançamentos, análises e relatórios com IA/RAG ainda fazem parte da visão do produto e não estão implementados nesta versão.

## Tecnologias

- PHP 8.3 ou superior
- Laravel 13
- Laravel Sanctum
- PHPUnit

## Desenvolvimento local

1. Instale as dependências:

	```bash
	composer install
	```

2. Configure as variáveis de ambiente em `.env`, incluindo a conexão com o banco de dados.
3. Gere a chave da aplicação e execute as migrations:

	```bash
	php artisan key:generate
	php artisan migrate
	```

4. Inicie o servidor local:

	```bash
	php artisan serve
	```

As rotas da API usam o prefixo `/api`. Para executar as verificações de estilo, análise estática e testes:

```bash
composer ci:check
```
