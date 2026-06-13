<?php
namespace App\Controllers;

use App\Core\Container;
use App\Core\Database;

class SearchController extends BaseController
{
    private \PDO $db;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->db = Database::getInstance();
    }

    // GET /search
    public function index(): void
    {
        $query = trim($_GET['q'] ?? '');
        $genre = $_GET['genre'] ?? null;
        $results = [];

        // Get cinemas for filter dropdown
        $cinemas = [];
        try {
            $cinemas = $this->db->query("SELECT id, name FROM cinemas WHERE is_active = TRUE ORDER BY name")->fetchAll(\PDO::FETCH_OBJ);
        } catch (\Exception $e) {}

        if (strlen($query) > 0) {
            $sql = "SELECT * FROM movies WHERE 1=1";
            $params = [];

            $sql .= " AND (LOWER(title) LIKE :q OR LOWER(genre) LIKE :q2 OR LOWER(description) LIKE :q3)";
            $params['q']  = '%' . strtolower($query) . '%';
            $params['q2'] = '%' . strtolower($query) . '%';
            $params['q3'] = '%' . strtolower($query) . '%';

            if ($genre) {
                $sql .= " AND genre = :genre";
                $params['genre'] = $genre;
            }

            $sql .= " ORDER BY status ASC, title ASC LIMIT 20";

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            $results = $stmt->fetchAll(\PDO::FETCH_OBJ);
        }

        $this->render('search.index', [
            'query'   => $query,
            'genre'   => $genre,
            'results' => $results,
            'cinemas' => $cinemas,
            'pageTitle' => $query ? "Tìm kiếm: $query — CinemaX" : 'Tìm kiếm — CinemaX',
        ]);
    }
}
