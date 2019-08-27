#master-symfony

## Pour travailler sur le projet

```
#Clonage du projet

cd c:\xampp\htdocs
git clone projet
cd projet
```

On installe les dépendances

```
composer install
```

On configure la base de données dans `.env.local`.

On crée la base de données

```
php bin\console doctrine:database:create
```

On importe le shéma de la BDD :

```
php bin\console doctrine:migrations:migrate
```

## TP : Créer une entité Gategory

On va créer une nouvelle entité Category. Elle doit être liée à l'entité Product.
Un product appartient à une seule catégorie et une catégorie peut être liée à plusieurs Product.

On va créer deux nouvelles routes :

- /category/{id}  => Afficher tous les produits de la catégorie {id} ($category ->getProducts() ??)
- Créer le crud de la catégorie
    - /category/create -> On peut créer une catégorie
    - /category => on liste les catégories
    - /category/edit{id} -> On peut modifier une catégorie
    - /category/delete/{id} -> On peut supprimer une catégorie

Ne pas oublier les fixtures des catégories...