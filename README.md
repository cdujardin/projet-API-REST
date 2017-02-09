#API REST



##DESCRIPTION
  Projet d'api rest développé chez PopSchool, durant la session 2016-2017.
  L'API fournit une liste d'utilisateur.

##INSTALLATION
  composer install

##STRUCTURE DE DONNÉES
user
     firstname: string
     lastname: string
     email: string
     birthday: date
     github: string
     sex:string
     pet: boolean



##UTILISATION
###GET /users/
  Renvoi la liste des utilisateurs

###GET /user/{id}
  Renvoi le détail d'un utilisateur

###POST /users/
  Ajoute un utilisateur

###PUT /users/{id}
  ajoute ou modifie un utilisateur

###DELETE /user/{id}
  supprime un utilisateur
