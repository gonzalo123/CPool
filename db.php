<?php
require 'vendor/autoload.php';

$conn = new PDO('pgsql:dbname=demo;host=vmserver', 'gonzalo', 'password');
$stmtIds = 0;
$stmts = array();

$app = new React\Espresso\Application();

$app->get('/', function ($request, $response) use($conn, &$stmtIds, &$stmts) {
        $headers = array('Content-Type' => 'application/json');
        $query = $request->getQuery();
        $out = null;
        switch ($query['action']) {
            case 'prepare':
                $stmt = $conn->prepare($query['sql']);
                $stmtIds++;
                $stmts[$stmtIds] = $stmt;
                $out = $stmtIds;
                break;
            case 'execute':
                $stmts[$query['smtId']]->execute();
                $out = $stmtIds;
                break;
            case 'fetchAll':
                $out = $stmts[$query['smtId']]->fetchAll();
                break;
            case 'closeCursor':
                $stmts[$query['smtId']]->closeCursor();
                unset($stmts[$query['smtId']]);
                break;
        }

        $response->writeHead(200, $headers);
        $response->end(json_encode($out));
});

$stack = new React\Espresso\Stack($app);
$stack->listen(1337);
echo "Server running at http://127.0.0.1:1337\n";
