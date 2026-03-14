*Exercice : Développer une mini application Laravel de type réseau social*

L’objectif est de développer une petite application Laravel similaire à un réseau social simple.

Les utilisateurs doivent pouvoir créer un compte, se connecter et se déconnecter.

Après authentification, chaque utilisateur peut créer, afficher, modifier et supprimer ses propres posts.

Les utilisateurs peuvent également liker les posts.

 *La sécurité de l’application doit être bien gérée :*

- Les routes doivent être protégées avec un middleware personnalisé que vous allez créer vous-même (ne pas utiliser les middlewares d’authentification intégrés de Laravel).
- Les actions update et delete doivent être contrôlées avec Policies, afin qu’un utilisateur puisse uniquement modifier ou supprimer ses propres posts.

Pour améliorer l’expérience utilisateur et les performances, l’utilisation de *AJAX* est optionnelle mais fortement recommandée, notamment pour des actions comme liker un post, ajouter un post ou supprimer un post sans recharger la page.