<?php
// Connexion à la base de données
try {
	$db = new PDO('mysql:host=localhost;dbname=test', 'root', '');
} catch (Exception $e) {
	die("Impossible de se connecter à la base de données");
}

$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

// Autoloader
spl_autoload_register('autoload');
function autoload($class){
	return 'class/' . str_replace('\\', '/', $class) . '.php';
}

// Routing

if (!isset($_GET['p'])) {
	# code...
	$_GET['p'] = 'home';
}

if (!preg_match('/^([a-z0-9A-Z]+\.?)+$/', $_GET['p'])) {
	# code...
	$page = 'errors/404';
}else {
	$page = implode('/', explode('.', $_GET['p']));
}

// Génération de la vue

if (file_exists('views/' . $page . '.php')) {
	# code...
	ob_start();
	try {
		require 'views/' . $page . '.php';
	} catch (Exception $e) {
		require 'views/errors/404.php';
	}
	$content = ob_get_clean();
}else {
	ob_start();
	require 'views/errors/404.php';
	$content = ob_get_clean();
}

require 'views/layouts/default.php';