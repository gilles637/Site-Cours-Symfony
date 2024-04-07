# Projet CC Framework Web 2024


GARCIA Yannick - GHALIB Assad - GACHINIARD Gilles - EL GHAZOUANI Bilal (Groupe 23)


### Question 1 :

On se place dans le dossier de notre Docker. On démarre le service Docker, puis on démarre le Docker sur lequel nous 
allons travailler : container-tp

```
• sudo service docker start
• docker restart container-tp
```

Enfin, on rentre dans notre Docker et nous allons travailler à l'intérieur à partir de maintenant et jusqu'à la fin
du Projet.

```
• docker exec -ti container-tp bash
```

Créons ensuite un projet Symfony vide : cc2024

```
• symfony new cc2024 --webapp
```

Mettons en place webpack encore et bootstrap.

```
• symfony composer require symfony/webpack-encore-bundle
• npm install
• npm install bootstrap
• npm install bootstrap-icons
```

On modifie notre app.js et notre twig.yaml en conséquence. Enfin, nous faisons :

```
• npm run dev
```

On créé notre README.md, nous le compléterons tout au long du Projet.

```
• touch README.md
```

Nous mettons en place notre environnement GIT, faisons notre premier commit et notre tag pour cette question.

```
• git init
• git add --all
• git commit -m "Question 1"
• git remote add origin https://o22103956@pdicost.univ-orleans.fr/git/scm/wc24/cc23.git
• git push -u origin master
• git tag -a Question1 -m "question 1"
• git push origin Question1
```


### Question 2 :

On modifie notre fichier .env. Nous créons ensuite l'entité Lecon :

```
• symfony console make:entity Lecon
```

Nous lui donnons deux attributs, un nom et une description, respectivement de type String et Text. On peut alors créer
notre base de donnée et la table associée :

```
• symfony console make:migration
• symfony console doctrine:migrations:migrate
```

Enfin, second commit ainsi que nouveau tag pour cette question :

```
• git add --all
• git commit -m "Question 2"
• git push -u origin master
• git tag -a Question2 -m "question 2"
• git push origin Question2
```


### Question 3 :

Commençons par installer le package fixture et créons une fixture "LeconFixtures" :

```
• symfony composer require orm-fixtures --dev
• symfony console make:fixture
```

Installons ensuite fakerphp/faker :

```
• symfony composer require fakerphp/faker
```

On implémente ensuite notre fixture en utilisant Faker, une fois terminé, on charge notre fixture dans la base de
données :

```
• symfony console doctrine:fixture:load
```

Enfin, troisième commit ainsi que nouveau tag pour cette question :

```
• git add --all
• git commit -m "Question 3"
• git push -u origin master
• git tag -a Question3 -m "question 3"
• git push origin Question3
```


### Question 4 :

Créons un CRUD pour nos leçons :

```
• symfony console make:crud Lecon
```

Nous pouvons désormais visualiser nos leçons en lançant notre Serveur et en allant
sur http://localhost:5000/lecon.

Enfin, quatrième commit ainsi que nouveau tag pour cette question :

```
• git add --all
• git commit -m "Question 4"
• git push -u origin master
• git tag -a Question4 -m "question 4"
• git push origin Question4
```


### Question 5 :

Nous allons commençer par créer un nouveau Contrôleur afin de doter notre application d'une page d'accueil au path "/" :

```
• symfony console make:controller accueil
```

Nous nous occupons ensuite de la navbar : Nous créons un répertoire layers dans nos templates et y 
ajoutons _navbar.html.twig. On personnalise ensuite ladite navbar. Enfin, nous modifions notre base.html.twig afin
de l'afficher.

Afin d'embellir notre application, nous avons également modifié plusieurs de nos twig. Le tout a été rendu plus lisible
par le découpage de parties desdits twig en layers.

Enfin, cinquième commit ainsi que nouveau tag pour cette question :

```
• git add --all
• git commit -m "Question 5"
• git push -u origin master
• git tag -a Question5 -m "question 5"
• git push origin Question5
```


### Question 6 :

On commence par installer cebe/markdown :

```
• symfony composer require cebe/markdown "~1.2.0"
• symfony composer update cebe/markdown
```

Nous modifions notre services.yaml, puis notre Contrôleur afin de parse nos descriptions. Nous installons ensuite les
extensions twig pour Markdown :

```
• symfony console make:twig-extension
```

Nous modifions lesdites extensions et nous pouvons alors utiliser "markdown" dans nos twig. Nous en profitons 
pour installer une autre extension afin de tronquer nos descriptions sur l'index :

```
• symfony composer require twig/string-extra
```

On peut alors utiliser "u.truncate" dans nos twig.

Enfin, sixième commit ainsi que nouveau tag pour cette question :

```
• git add --all
• git commit -m "Question 6"
• git push -u origin master
• git tag -a Question6 -m "question 6"
• git push origin Question6
```


### Question 7 :

Nous créons notre classe User et lui ajoutons les attributs nom et prenom :

```
• symfony console make:user
• symfony console make:entity User
```

Puis notre système d'authentification :

```
• symfony console make:auth
```

Nous modifions ensuite notre SecurityController. Enfin, nous créons notre système d'inscription :

```
• symfony console make:registration-form
```

Afin que tout User ait le ROLE_PROFESSEUR par défaut, on attribue ce rôle dans le RegistrationController à la soumission
de l'inscription. On modifie notre fixture pour créer des users et gérer les mots de passe hashés. Enfin, nous 
modifions nos twig afin de rendre cohérent le processus de connexion/inscription.

On peut alors supprimer notre cache, notre database et notre migration et recharger le tout :

```
• symfony console make:migration
• symfony console doctrine:migrations:migrate
• symfony console doctrine:fixture:load
```

Enfin, septième commit ainsi que nouveau tag pour cette question :

```
• git add --all
• git commit -m "Question 7"
• git push -u origin master
• git tag -a Question7 -m "question 7"
• git push origin Question7
```


### Question 8 :

Afin de répondre à cette question, nous allons reprendre cette commande :

```
• symfony console make:entity Lecon
```

Nous pouvons ainsi ajouter et configurer la relation entre Lecon et User. Une fois fait, nous modifions notre fixture
ainsi que nos twig afin de rendre apparente et cohérente cette nouvelle relation. Nous entrons alors ces commandes à
nouveau dans le but de mettre à jour notre base de données :

```
• symfony console make:migration
• symfony console doctrine:migrations:migrate
• symfony console doctrine:fixture:load
```

Enfin, huitième commit ainsi que nouveau tag pour cette question :

```
• git add --all
• git commit -m "Question 8"
• git push -u origin master
• git tag -a Question8 -m "question 8"
• git push origin Question8
```


### Question 9 :

Pour que l'utilisateur connecté devienne le professeur à l'origine de la création d'une leçon, il suffit juste de le set
en tant que tel dans LeconController à la fonction new lorsque la nouvelle leçon est soumise.

Quant au fait de restreindre la création d'une leçon à un professeur connecté, il faut rajouter une condition dans notre
_navbar.html.twig, qui est le seul moyen d'accéder à la création d'une leçon.

Enfin, neuvième commit ainsi que nouveau tag pour cette question :

```
• git add --all
• git commit -m "Question 9"
• git push -u origin master
• git tag -a Question9 -m "question 9"
• git push origin Question9
```


### Question 10 :

Concrétement, à ce stade, avec seulement ROLE_PROFESSEUR, la seule restriction pertinente à implémenter sur notre
application, c'est que seul le professeur à l'origine d'une leçon est en mesure de l'éditer ou de la supprimer. Comme
la question précédente, c'est faisable simplement avec une condition dans le twig approprié. Ici : _show_lecon.html.twig

Enfin, dixième commit ainsi que nouveau tag pour cette question :

```
• git add --all
• git commit -m "Question 10"
• git push -u origin master
• git tag -a Question10 -m "question 10"
• git push origin Question10
```


### Question 11 :

Notre fixture a déjà été modifiée dans les questions précédentes, elle propose déjà deux utilisateurs dont les mots de
passe sont tous deux "secret".

En première amélioration de notre application à ce point, nous pouvons par exemple, implémenter les dates de création et
de modification de chaque leçon de telle sorte qu'elles s'initialisent et se mettent à jour automatiquement quand il le
faut. On commence donc par reprendre la commande suivante afin d'ajouter lesdites dates à Lecon :

```
• symfony console make:entity Lecon
```

Nous modifions alors quelque peu le code de notre entité, notamment en lui ajoutant une fonction qui se chargera de
mettre à jour les dates nouvellement implémentées. Nous en permettons ensuite l'affichage dans notre twig show. Enfin,
nous reprenons les trois commandes habituelles afin de recharger notre database :

```
• symfony console make:migration
• symfony console doctrine:migrations:migrate
• symfony console doctrine:fixture:load
```

On peut ensuite implémenter knplabs/knp-paginator-bundle afin de compacter notre index et le rendre plus lisible :

```
• symfony composer require knplabs/knp-paginator-bundle
```

Une petite modification dans notre Contrôleur ainsi que dans notre twig de l'index... (On en profite pour
faire apparaître les leçons par ordre chronologique de création décroissant) Et voilà !

Enfin, onzième commit ainsi que nouveau tag pour cette question :

```
• git add --all
• git commit -m "Question 11"
• git push -u origin master
• git tag -a Question11 -m "question 11"
• git push origin Question11
```


### Question 12 :

Afin d'implémenter cette fonction, il faut créer une relation ManyToMany entre User et Lecon en utilisant les
commandes habituelles :

```
• symfony console make:entity Lecon
• symfony console make:migration
• symfony console doctrine:migrations:migrate
• symfony console doctrine:fixture:load
```

Nous allons en premier lieu créer une nouvelle twig afin que les leçons auxquelles est inscrit un élève y soient
référencées, nous y ajoutons l'accès dans notre navbar. Afin que l'élève puisse s'inscrire à un cours, nous créons les
boutons appropriés dans le show. Nous ajoutons toutes les actions correspondantes dans notre Contrôleur. Enfin, nous
ajoutons une nouvelle méthode de query dans le Repository de nos Leçons et nous en servons pour afficher lesdites leçons
dans notre toute nouvelle twig.

Enfin, douzième commit ainsi que nouveau tag pour cette question :

```
• git add --all
• git commit -m "Question 12"
• git push -u origin master
• git tag -a Question12 -m "question 12"
• git push origin Question12
```


### Question 13 :

Nous avons déjà fait en sorte qu'un élève puisse visualiser les leçons auxquelles il est inscrit dans la question
précédente. Nous allons maintenant faire en sorte qu'un professeur puisse voir dans le show d'une leçon la liste des
élèves qui y sont inscrits, pour ce faire, nous ajoutons le nécessaire dans le show avec la restriction appropriée.

Enfin, treizième commit ainsi que nouveau tag pour cette question :

```
• git add --all
• git commit -m "Question 13"
• git push -u origin master
• git tag -a Question13 -m "question 13"
• git push origin Question13
```


### Question 14 :

Pour embellir notre application, nous pouvons par exemple implémenter des asserts sur nos entités afin de créer des
messages d'erreurs pertinents lorsque l'ont remplis des formulaires.

Nous allons également modifier notre fixture : à ce stade, nous avons deux professeurs, l'un d'eux destiné à prendre le
ROLE_ADMIN. Nous allons ajouter un User qui n'aura que le ROLE_ELEVE en prévision des questions suivantes et pour
en effet constater que les restrictions sur nos twig fonctionnent. Pensons bien-sûr à charger à nouveau notre fixture :

```
• symfony console doctrine:fixture:load
```

Enfin, quatorzième commit ainsi que nouveau tag pour cette question :

```
• git add --all
• git commit -m "Question 14"
• git push -u origin master
• git tag -a Question14 -m "question 14"
• git push origin Question14
```


### Question 15 :

Maintenant que nous distinguons nos trois rôles, nous pouvons également définir comment chacun d'entre eux peut être
attribué. Nous avons mentionné précédemment que nous produisons avec notre fixture un user de base pour chaque rôle. Une
inscription faite sur le RegisterForm par une personne non connectée créera toujours un élève. (Celà s'implémente dans
notre RegistrationController) Seul un admin sera en mesure de créer le compte d'un professeur ou d'attribuer le
ROLE_ADMIN à un professeur déjà présent.

Avant toute chose, nous faisons :

```
• symfony console make:crud User
```

Nous avons désormais un Contrôleur tout neuf pour gérer nos utilisateurs. Nous donnons un accès à son index dans notre
navbar, ceci avec la restriction que seul un admin peut y accéder. Nous modifions ensuite notre form UserType de sorte
que la création d'un nouveau Professeur par un admin fonctionne de la même façon qu'une inscription usuelle tout
en ajoutant au nouvel user le ROLE_PROFESSEUR d'emblée.

Le CRUD permet d'ors et déjà de modifier et supprimer n'importe quel utilisateur. Il s'agit alors de pouvoir attribuer
le ROLE_ADMIN à un professeur existant. Pour ce faire, nous ajoutons les méthodes appropriées dans notre AdminController.
La suite de l'implémentation se fera exclusivement dans nos twig. Nous ajoutons donc les restrictions adaptées dans
notre show... Et voilà ! Un admin peut octroyer ou retirer le ROLE_ADMIN à n'importe quel professeur !

Enfin, quinzième commit ainsi que nouveau tag pour cette question :

```
• git add --all
• git commit -m "Question 15"
• git push -u origin master
• git tag -a Question15 -m "question 15"
• git push origin Question15
```


### Question 16 :

La plupart des restrictions d'accès aux pages ayant déjà été implémentées durant les questions précédentes, quelques
ajustements à peine sur nos twig furent nécessaires afin que le site soit bien distinct pour chaque rôle d'utilisateur.

Respectivement, nous avons désormais :

• L'Utilisateur non-connecté a accès à la page d'accueil. Il peut visualiser les leçons, mais ne peut aucunement
interagir avec. Enfin, il peut s'inscrire sur le site ou s'y connecter.

• L'Élève a les mêmes accès de base que l'utilisateur non-connecté. Mais étant lui-même connecté, il ne peut pas s'inscrire sur
le site, son accès à la connexion est remplacé dans la navbar par un accès à la déconnexion. Lorsqu'il visualise les
leçons, il peut s'y inscrire. (Se désinscrire le cas échéant.) Il a également accès, dans la navbar, à la liste des leçons
auxquelles il s'est inscrit.

• Le Professeur reprend à son tour les accès dont l'élève dispose. Il ne peut cependant pas s'inscrire/se désinscrire à
des leçons ou avoir accès à la liste que possédait l'élève. Il a par contre la possibilité, dans la navbar, de créer de
nouvelles leçons. Lorsqu'il visualise les leçons, il peut voir la liste des élèves inscrits à l'une d'elles. Il peut
aussi modifier ou supprimer les leçons dont il est le créateur.

• L'Admin, enfin, est un Professeur, il a donc les mêmes accès qu'évoqué juste au-dessus. La différence principale sera
son accès à l'interface de gestion des utilisateurs dans laquelle il pourra créer de nouveaux professeurs. Leur donner
les droits d'administration. Modifier leurs informations ou tout simplement les supprimer.

Enfin, seizième commit ainsi que nouveau tag pour cette question :

```
• git add --all
• git commit -m "Question 16"
• git push -u origin master
• git tag -a Question16 -m "question 16"
• git push origin Question16
```


### Question 17 :

Afin d'embellir notre application une ultime fois. Nous nous sommes contentés de peaufiner nos twig, pour rendre le tout
plus agréable à l'œil. Nous avons notamment inséré le nom de l'utilisateur/l'invité sur la page d'accueil.

Sur le côté pratique, nous avons implémenté des onglets permettant d'afficher les utilisateurs par rôle dans 
l'interface de l'admin. Celà rendra la tâche beaucoup plus facile pour savoir qui sont les professeurs et d'autant plus
savoir lesquels ont déjà le ROLE_ADMIN. Nous en avons également profité pour implémenter paginator dans notre
AdminController comme nous l'avions déjà fait partout ailleurs.

Concernant notre fixture, nous estimons ne pas avoir plus à rajouter. Nous avons, comme mentionné plus haut, un user
pour chacun des rôles de notre application, dont deux professeurs et chacun d'entre eux se voit être le créateur d'une
dizaine de leçons. Le tout permet d'assez facilement explorer l'application et interagir avec de toutes les manières
prévues.

Ceci conclu notre production pour ce CC. Merci d'avoir accordé votre temps et votre considération à notre très humble projet.

Sur ce, dix-septième et dernier commit ainsi qu'ultime tag pour cette question :

```
• git add --all
• git commit -m "Question 17"
• git push -u origin master
• git tag -a Question17 -m "question 17"
• git push origin Question17
```



### Fin.