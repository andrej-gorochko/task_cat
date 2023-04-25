<? class CatBook {
    private $db;

    public function __construct($host, $username, $password, $database) {
        $this->db = new mysqli($host, $username, $password, $database);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function addCat($name, $birthdate, $breed, $color) {
        $photoUrl = 'https://cataas.com/cat';
        $photoContent = file_get_contents($photoUrl);
        $photoResized = imagecreatetruecolor(300, 300);
        imagecopyresampled($photoResized, imagecreatefromstring($photoContent), 0, 0, 0, 0, 300, 300, imagesx(imagecreatefromstring($photoContent)), imagesy(imagecreatefromstring($photoContent)));
        ob_start();
        imagejpeg($photoResized);
        $photoData = ob_get_clean();
            // Сохраняем изображение в папке
            $filename = uniqid() . '.jpg';
            $filepath = 'img/' . $filename;
            file_put_contents($filepath, $photoData);  
        $stmt = $this->db->prepare("INSERT INTO cats (name, birthdate, breed, color, photo) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $birthdate, $breed, $color, $filepath);
        $stmt->execute();
      //  $insertedId = $this->db->insert_id;
        $stmt->close();
    }

    public function getCats($orderBy, $orderDir, $filterBy, $filterValue, $page) {
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $orderBy = in_array($orderBy, ['name', 'birthdate', 'breed', 'color']) ? $orderBy : 'name';
        $orderDir = in_array($orderDir, ['asc', 'desc']) ? $orderDir : 'asc';

        $where = '';
        if (!empty($filterBy) && !empty($filterValue)) {
            $where = "WHERE $filterBy = ?";
        }

        $stmt = $this->db->prepare("SELECT id, name, birthdate, breed, color, photo FROM cats $where ORDER BY $orderBy $orderDir LIMIT ?, ?");
        if (!empty($filterBy) && !empty($filterValue)) {
            $stmt->bind_param("si", $filterValue, $offset, $limit);
        } else {
            $stmt->bind_param("ii", $offset, $limit);
        }
        $stmt->execute();
        $result = $stmt->get_result();
    
        $cats = [];
        while ($row = $result->fetch_assoc()) {
            $cats[] = $row;
        }
    
        $stmt->close();
    
        return $cats;
    }
    
    public function getTotalCats($filterBy, $filterValue) {
        $where = '';
        if (!empty($filterBy) && !empty($filterValue)) {
            $where = "WHERE $filterBy = ?";
        }
    
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM cats $where");
        if (!empty($filterBy) && !empty($filterValue)) {
            $stmt->bind_param("s", $filterValue);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $totalCats = $result->fetch_row()[0];
        $stmt->close();
    
        return $totalCats;
    }
    
    public function close() {
        $this->db->close();
    }
        
}