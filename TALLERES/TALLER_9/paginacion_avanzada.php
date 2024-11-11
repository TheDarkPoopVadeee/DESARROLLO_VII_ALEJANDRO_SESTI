<?php
class Paginator {
    protected $pdo;
    protected $table;
    protected $perPage;
    protected $currentPage;
    protected $totalRecords;
    protected $conditions = [];
    protected $params = [];
    protected $orderBy = '';
    protected $joins = [];
    protected $fields = ['*'];
    protected $cacheKey = '';

    public function __construct(PDO $pdo, $table, $perPage = 10) {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->perPage = $perPage;
        $this->currentPage = 1;
        $this->cacheKey = "paginator_{$table}_{$perPage}_";
    }

    public function select($fields) {
        $this->fields = is_array($fields) ? $fields : func_get_args();
        return $this;
    }

    public function where($condition, $params = []) {
        $this->conditions[] = $condition;
        $this->params = array_merge($this->params, $params);
        return $this;
    }

    public function join($join) {
        $this->joins[] = $join;
        return $this;
    }

    public function orderBy($orderBy) {
        $this->orderBy = $orderBy;
        return $this;
    }

    public function setPage($page) {
        $this->currentPage = max(1, (int)$page);
        return $this;
    }

    public function getTotalRecords() {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        
        if (!empty($this->joins)) {
            $sql .= " " . implode(" ", $this->joins);
        }
        
        if (!empty($this->conditions)) {
            $sql .= " WHERE " . implode(" AND ", $this->conditions);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params);
        return $stmt->fetchColumn();
    }

    public function getResults() {
        $offset = ($this->currentPage - 1) * $this->perPage;
        
        $sql = "SELECT " . implode(", ", $this->fields) . " FROM {$this->table}";
        
        if (!empty($this->joins)) {
            $sql .= " " . implode(" ", $this->joins);
        }
        
        if (!empty($this->conditions)) {
            $sql .= " WHERE " . implode(" AND ", $this->conditions);
        }
        
        if ($this->orderBy) {
            $sql .= " ORDER BY {$this->orderBy}";
        }
        
        $sql .= " LIMIT {$this->perPage} OFFSET {$offset}";

        // Caché de resultados
        $cacheKey = $this->cacheKey . md5($sql);
        $cachedResults = $this->getCache($cacheKey);

        if ($cachedResults !== false) {
            return $cachedResults;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->setCache($cacheKey, $results);

        return $results;
    }

    public function getPageInfo() {
        $totalRecords = $this->getTotalRecords();
        $totalPages = ceil($totalRecords / $this->perPage);

        return [
            'current_page' => $this->currentPage,
            'per_page' => $this->perPage,
            'total_records' => $totalRecords,
            'total_pages' => $totalPages,
            'has_previous' => $this->currentPage > 1,
            'has_next' => $this->currentPage < $totalPages,
            'previous_page' => $this->currentPage - 1,
            'next_page' => $this->currentPage + 1,
            'first_page' => 1,
            'last_page' => $totalPages,
        ];
    }

    public function setCache($key, $data) {
        file_put_contents(__DIR__ . "/cache/{$key}.json", json_encode($data));
    }

    public function getCache($key) {
        $file = __DIR__ . "/cache/{$key}.json";
        if (file_exists($file)) {
            return json_decode(file_get_contents($file), true);
        }
        return false;
    }

    public function exportToCSV($filename = 'export.csv') {
        $results = $this->getResults();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        $output = fopen('php://output', 'w');

        // Get column headers
        if (count($results) > 0) {
            fputcsv($output, array_keys($results[0]));
        }

        // Output data
        foreach ($results as $row) {
            fputcsv($output, $row);
        }

        fclose($output);
    }
}

// Clase para paginación infinita (scroll infinito)
class InfinitePaginator extends Paginator {

    public function getResults() {
        $sql = "SELECT " . implode(", ", $this->fields) . " FROM {$this->table}";
        
        if (!empty($this->joins)) {
            $sql .= " " . implode(" ", $this->joins);
        }
        
        if (!empty($this->conditions)) {
            $sql .= " WHERE " . implode(" AND ", $this->conditions);
        }
        
        if ($this->orderBy) {
            $sql .= " ORDER BY {$this->orderBy}";
        }
        
        $sql .= " LIMIT {$this->perPage} OFFSET 0"; // Always load first 10 items for scroll

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

// Ejemplo de uso para seleccionar el número de elementos por página
$perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
$paginator = new Paginator($pdo, 'productos', $perPage);
$paginator->select('productos.*', 'categorias.nombre as categoria')
         ->join('LEFT JOIN categorias ON productos.categoria_id = categorias.id')
         ->where('productos.precio >= ?', [100])
         ->orderBy('productos.nombre ASC')
         ->setPage(isset($_GET['page']) ? $_GET['page'] : 1);

$results = $paginator->getResults();
$pageInfo = $paginator->getPageInfo();

// Exportar a CSV
if (isset($_GET['export'])) {
    $paginator->exportToCSV();
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Productos Paginados</title>
    <style>
        .pagination {
            margin: 20px 0;
            padding: 0;
            list-style: none;
            display: flex;
            gap: 10px;
        }
        .pagination li {
            padding: 5px 10px;
            border: 1px solid #ddd;
            cursor: pointer;
        }
        .pagination li.active {
            background-color: #007bff;
            color: white;
        }
        .pagination li.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .results {
            margin-bottom: 20px;
        }
        .results table {
            width: 100%;
            border-collapse: collapse;
        }
        .results th, .results td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
    </style>
</head>
<body>

    <h2>Seleccionar número de productos por página</h2>
    <form method="GET" action="">
        <label for="per_page">Productos por página:</label>
        <select name="per_page" id="per_page" onchange="this.form.submit()">
            <option value="10" <?= $perPage == 10 ? 'selected' : '' ?>>10</option>
            <option value="20" <?= $perPage == 20 ? 'selected' : '' ?>>20</option>
            <option value="50" <?= $perPage == 50 ? 'selected' : '' ?>>50</option>
        </select>
    </form>

    <div class="results">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['nombre']) ?></td>
                    <td>$<?= number_format($row['precio'], 2) ?></td>
                    <td><?= htmlspecialchars($row['categoria']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="pagination">
        <?php if ($pageInfo['has_previous']): ?>
            <a href="?page=<?= $pageInfo['previous_page'] ?>&per_page=<?= $perPage ?>">Anterior</a>
        <?php else: ?>
            <span class="disabled">Anterior</span>
        <?php endif; ?>

        <span class="current">Página <?= $pageInfo['current_page'] ?> de <?= $pageInfo['total_pages'] ?></span>

        <?php if ($pageInfo['has_next']): ?>
            <a href="?page=<?= $pageInfo['next_page'] ?>&per_page=<?= $perPage ?>">Siguiente</a>
        <?php else: ?>
            <span class="disabled">Siguiente</span>
        <?php endif; ?>
    </div>

    <a href="?export=1&per_page=<?= $perPage ?>">Exportar a CSV</a>

    <h2>Paginación infinita</h2>
    <div id="products" style="margin-bottom: 30px;">
        <!-- Aquí se cargan los productos dinámicamente con JavaScript -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let page = 1;
            let loading = false;

            function loadProducts() {
                if (loading) return;
                loading = true;
                fetch('?page=' + page + '&per_page=<?= $perPage ?>')
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('products').innerHTML += data;
                        loading = false;
                        page++;
                    });
            }

            window.addEventListener('scroll', function() {
                if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
                    loadProducts();
                }
            });

            loadProducts(); // Cargar los productos iniciales
        });
    </script>

</body>
</html>
 