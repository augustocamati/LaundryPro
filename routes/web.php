<?php

use App\Core\Router;

$router = new Router();

// Dashboard / Home
$router->get('/', 'DashboardController@index');

// CRUD Perfis (Dependency for Usuario)
$router->get('/perfis', 'PerfilController@index');
$router->get('/perfis/novo', 'PerfilController@create');
$router->post('/perfis', 'PerfilController@store');
$router->get('/perfis/{id}/editar', 'PerfilController@edit');
$router->post('/perfis/{id}', 'PerfilController@update');
$router->post('/perfis/{id}/eliminar', 'PerfilController@delete');

// CRUD Usuários
$router->get('/usuarios', 'UsuarioController@index');
$router->get('/usuarios/novo', 'UsuarioController@create');
$router->post('/usuarios', 'UsuarioController@store');
$router->get('/usuarios/{id}/editar', 'UsuarioController@edit');
$router->post('/usuarios/{id}', 'UsuarioController@update');
$router->post('/usuarios/{id}/eliminar', 'UsuarioController@delete');

// CRUD Funcionários
$router->get('/funcionarios', 'FuncionarioController@index');
$router->get('/funcionarios/novo', 'FuncionarioController@create');
$router->post('/funcionarios', 'FuncionarioController@store');
$router->get('/funcionarios/{id}/editar', 'FuncionarioController@edit');
$router->post('/funcionarios/{id}', 'FuncionarioController@update');
$router->post('/funcionarios/{id}/eliminar', 'FuncionarioController@delete');

// CRUD Clientes
$router->get('/clientes', 'ClienteController@index');
$router->get('/clientes/novo', 'ClienteController@create');
$router->post('/clientes', 'ClienteController@store');
$router->get('/clientes/{id}/editar', 'ClienteController@edit');
$router->post('/clientes/{id}', 'ClienteController@update');
$router->post('/clientes/{id}/eliminar', 'ClienteController@delete');

return $router;
