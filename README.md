# Carteira de Ações

**Carteira de Ações** é uma aplicação desenvolvida em Laravel para monitoramento de ações e dividendos. A aplicação integra-se à API **BRAPI** para fornecer informações em tempo real sobre o mercado financeiro, além de enviar alertas de compra e venda por e-mail com base em critérios configurados pelo usuário.

## Funcionalidades

- **Gestão de Ações**: Adicione, atualize e remova ações da sua carteira.
- **Monitoramento de Dividendos**: Acompanhe os dividendos recebidos por ativo.
- **Alertas Automáticos**: Configure alertas personalizados para compra e venda com base em metas de preço.
- **Dashboard Interativo**: Visualize o desempenho de sua carteira em gráficos e tabelas.
- **Integração com BRAPI**: Obtenha cotações em tempo real e informações detalhadas do mercado.
- **Testes Automatizados**: Cobertura de funcionalidades com **PHPUnit**.

## Tecnologias Utilizadas

- **Backend**: Laravel 11
- **Frontend**: TailwindCSS, Vite
- **Banco de Dados**: MySQL/PostgreSQL
- **Integração com API**: BRAPI
- **Testes**: PHPUnit
- **Gerenciadores de Dependências**: Composer, npm

## Pré-requisitos

Antes de iniciar o projeto, certifique-se de ter as seguintes ferramentas instaladas:

- PHP >= 8.1
- Composer
- Node.js >= 16.x
- MySQL ou PostgreSQL
- Servidor web (Apache, Nginx ou built-in do Laravel)