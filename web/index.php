<?php

use Symfony\Component\HttpFoundation\Request;

require_once __DIR__. '/../vendor/autoload.php';

$users=[
  ['id'=>0, 'name' => 'lorem'],
  ['id'=>1, 'name' => 'ipsum'],
  ['id'=>2, 'name' => 'foo'],
];

$app = new Silex\Application();

/*$app->get('/hello/{name}', function($name) use($app) {
  return 'Hello '.$app->escape($name);
});
*/


$app['debug'] =true;
//mode débuggage activé



$app->get('/', function(){
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
        //Renvoie la doc de l'api
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

//api
$app->get('/api/users/', function() use($users){
    return json_encode($users);
});

$app->get('/api/users/{id}', function($id) use($users){
  return json_encode($users[$id]);
});

$app->post('/api/users/', function(Request $request) use($users){
  $name=$request->get('name');

  $nextIndex = count($users);

  $users[] = [
    'id' => $nextIndex,
    'name' => $name,
  ];

  $lastId = count($users) -1;

  return $lastId;
});

$app->delete('/api/users/{id}', function($id) use($users){
  unset($users[$id]);

  return new Response('', 204)
});


$app->run();
