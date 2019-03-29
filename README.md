# symfony_blog_graphql_api

## À l'installation
### Création de la base de données
`php bin/console doctrine:database:create`

`php bin/console make:migration`

`php bin/console doctrine:migrations:migrate`

### Exécution des fixtures
`php bin/console doctrine:fixtures:load`

## Utilisation de l'api
### Démarrage
Démarrer le serveur : `php bin/console server:run`

Se rendre sur l'url [GraphiQL](http://127.0.0.1:8000/graphiql)

### API
Pour chaque entité :
 - Article (id, title, text, Author, Category, Comments[]) -> cascade delete sur les Comments
 - Author (id, username, Articles[]) -> cascade delete sur les Articles
 - Category (id, name, Articles[])
 - Comment (id, text, Article)

#### Queries
##### Find
Entity(id: Int!) {}

##### Get all
Entities {}

#### Mutations
##### Create
NewEntity(input: EntityInput!) {}

##### Update
UpdateEntity(id: Int!, input: EntityInput!) {}

##### Delete
DeleteEntity(id: Int!) {}