# plugin-PublicConsultation

Plugin que realiza o gerenciamento na plataforma Mapa Cultural de links para consulta pública sobre a construção de editais.

## ✨ Informações sobre o plugin

**Contexto**: Atualmente a realização das construções dos editais da Secretaria da Cultura estão sendo realizadas pelas coordenações responsáveis junto ao jurídico. Com isso, surgiu a ideia de ao realizar a construção de um edital, receber sugestões do público em geral.

**Objetivo**: Permitir o gerenciamento (CRUD) e disponibilizar os links para as consultas públicas.

### Estrutura

![db-structure](db-structure.png)

### Endpoints

- Retorna as consultas públicas ativas `GET /consulta-publica/ativas`

## 🚀 Instalação

Instalação padrão como recomenda a [documentação](https://mapasculturais.gitbook.io/documentacao-para-desenvolvedores/formacao-para-desenvolvedores/plugins) oficial.

- 🆙 - Acessar o container da aplicação, na pasta /var/www/scripts e rodar `./db-update`
- Adicione no arquivo docker-compose do projeto base as variáveis de ambiente `SECULT_SEAL_ID` e `URL_SITE_EDITAIS`
- Na variável `SECULT_SEAL_ID` informe o ID do selo que está atribuído aos agentes que terão permissão de executar as ações (CRUD) da consulta pública
- Na variável `URL_SITE_EDITAIS` informe a URL do site onde os endpoints do plugin serão consumidos

### Observação

Somente os agentes que tiverem o selo atribuído a eles poderão realizar o gerenciamento das consultas públicas.
