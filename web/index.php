<?php
use Michelf\Markdown;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__. '/../vendor/autoload.php';

$users=[
  ['id'=>0, 'name' => 'lorem'],
  ['id'=>1, 'name' => 'ipsum'],
  ['id'=>2, 'name' => 'foo'],
];

$app=new Silex\Application();

/*$app->get('/hello/{name}', function($name) use($app) {
  return 'Hello '.$app->escape($name);
});
*/


//mode débuggage activé
$app['debug'] = true;


//base de donnée
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array (
          'driver'    => 'pdo_mysql',
          'host'      => 'localhost',
          'dbname'    => 'api_user',
          'user'      => 'cdujardin',
          'password'  => 'Momine42997328',
          'charset'   => 'utf8',
     )
));

//home
$app->get('/', function(){
     $htmlHead = ' <!DOCTYPE html>
       <html lang="fr">
       	<head>
       		<meta charset="utf-8"/>
       		<title>Titre de la page</title>
       	</head>
       	<body>';

     $htmlTail = ' </body>
    </html>';

     $text =  file_get_contents('../README.md');
     $html = Markdown::defaultTransform($text);
     return $htmlHead . $html . $htmlTail;
   /*
   return >>>eio_custom
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

EOT;*/
});

//api
$app->get('/api/users/', function() use($app){
     $sql= "select * from user";
     $users = $app['db'] -> fetchAll($sql);
    return $app->json($users);
});

// View all about one user by id
$app->get('/api/users/{id}', function($id) use($app){
     $sql= "select * from user where id=?";
     $user = $app['db'] -> fetchAssoc($sql, [(int) $id]);
  return $app->json($user);
});

//create a new user
$app->post('/api/users/', function(Request $request) use($app){

     $firstname=$request->get('firstname');
     $lastname=$request->get('lastname');
     $email=$request->get('email');
     $birthday=$request->get('birthday');
     $github=$request->get('github');
     $sex=$request->get('sex');
     $pet=$request->get('pet');

     if ($pet == 'true'){
          $pet = true;
     } elseif ($pet == 'false') {
          $pet = false;
     }

     $app['db'] -> insert('user', [
          'firstname' => $firstname,
          'lastname' => $lastname,
          'email' => $email,
          'birthday' => $birthday,
          'github' => $github,
          'sex' => $sex,
          'pet' => $pet,
     ]);

     $app['db']->lastInsertId();

     return $lastId;

});


 /* $nextIndex = count($users);

  $users[] = [
    'id' => $nextIndex,
    'name' => $name,
  ];

  $lastId = count($users) -1;

  return $lastId;
});*/

$app->delete('/api/users/{id}', function($id) use($users){
  $resultat = $app['db']->delete('user', [
       'id' => (int) $id,
 ]);

     if ($resultat) {
               $return = 204;
     } else {
          $return = 500;
     }

  return new Response('', $return);
  
});


$app->run();
