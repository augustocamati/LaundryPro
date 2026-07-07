<?php

use App\Core\Router;

$router = new Router();

// Dashboard / Home
$router->get('/', 'DashboardController@index');

// Auth & Account
$router->get('/login', 'AuthController@loginForm');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');
$router->get('/recuperar-senha', 'AuthController@recuperarForm');
$router->post('/recuperar-senha', 'AuthController@recuperar');
$router->get('/alterar-senha', 'AuthController@alterarSenhaForm');
$router->post('/alterar-senha', 'AuthController@alterarSenha');

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

// Categorias
$router->get('/categorias', 'CategoriaController@index');
$router->get('/categorias/novo', 'CategoriaController@create');
$router->post('/categorias', 'CategoriaController@store');
$router->get('/categorias/{id}/editar', 'CategoriaController@edit');
$router->post('/categorias/{id}', 'CategoriaController@update');
$router->post('/categorias/{id}/eliminar', 'CategoriaController@delete');

// Serviços
$router->get('/servicos', 'ServicoController@index');
$router->get('/servicos/novo', 'ServicoController@create');
$router->post('/servicos', 'ServicoController@store');
$router->get('/servicos/{id}/editar', 'ServicoController@edit');
$router->post('/servicos/{id}', 'ServicoController@update');
$router->post('/servicos/{id}/eliminar', 'ServicoController@delete');

// Pesquisas
$router->get('/pesquisas', 'PesquisaController@index');

// Pagamentos
$router->get('/pagamentos', 'PagamentoController@index');
$router->post('/pagamentos/registrar', 'PagamentoController@registrar');
$router->post('/pagamentos/{id}/cancelar', 'PagamentoController@cancelar');
$router->get('/pagamentos/relatorios', 'PagamentoController@relatorios');

// Pedidos
$router->get('/pedidos', 'PedidoController@index');
$router->get('/pedidos/novo', 'PedidoController@create');
$router->post('/pedidos', 'PedidoController@store');

return $router;
