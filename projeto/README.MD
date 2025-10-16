````markdown
# ![Bazzar Logo](./public/images/logo.png) Bazzar

## Grupo do Projeto
- **Heitor Klaine**  
- **João Vitor Lino  

## Turma
Info 3

## Título do Projeto
**Bazzar**

---

## Descrição do Projeto
O **Bazzar** é um e-commerce básico desenvolvido em **Laravel**, com foco em CRUD de produtos, gerenciamento de usuários, carrinho de compras e wishlist.  
O objetivo do projeto é criar uma plataforma funcional de vendas online, incluindo autenticação, controle de acesso e funcionalidades de busca e filtragem de produtos.

### Funcionalidades

#### Produtos
- Cadastro: imagem, nome, preço, categoria e estoque.
- Edição/Exclusão: apenas para administradores.
- Busca e filtros baseados em nomes e categorias.

#### Usuários
- Registro/Login com autenticação segura.
- Perfil do usuário: dados pessoais e histórico de compras.
- Níveis de acesso: Cliente e Administrador.

#### Carrinho de Compras
- Adicionar/remover produtos.
- Cálculo automático do total.
- Simulação de checkout (sem integração real com pagamento).
- Armazenamento temporário do carrinho.

#### Wishlist
- Favoritar produtos.
- Visualização rápida dos itens salvos.

## Setup
```bash
git clone https://github.com/seu-usuario/bazzar.git

cd bazzar

composer install
npm install
npm run dev

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bazzar
DB_USERNAME=root
DB_PASSWORD=

php artisan key:generate

php artisan migrate --seed

php artisan serve

