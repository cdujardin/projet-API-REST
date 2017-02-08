<?php
require_once __DIR__. './../vendor/autoload.php';

$users=[
  'lorem',
  'ipsum',
  'foo',
  'bar',
  'baz',
];

$app = new Silex\Application();

$app->get('/hello/{name}', function($name) use($app) {
  return 'Hello '.$app->escape($name);
});


$app->get('/doc', function(){
  return <<<EOT
    <!DOCTYPE html>
    <html lang="fr">
    	<head>
    		<meta charset="utf-8"/>
    		<title>Titre de la page</title>
    	</head>
    	<body>
      <pre>
        GET /
        //Source
        GET /api/users
        //Renvoi la liste des utilisateurs
        GET /api/users/{id}
        //Renvoi le détail d un utilisateur
        POST /api/users
        //Ajoute un utilisateur
        PUT /api/users/{id}
        //ajoute ou modifie un utilisateur
        DELETE /api/user/{id}
        //supprime un utilisateur
      </pre>

      </body>
    </html>

EOT;
});

$app->get('/api/users', function() use($users){
    return json_encode($users);
});

$app->run();
