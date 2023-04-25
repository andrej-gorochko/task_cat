<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cat Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
     <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<?
// Подключаем необходимые классы и файлы
require_once("classes/CatBook.php");
    $catBook = new CatBook('localhost', 'root', 'root', 'cats');
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $catBook->addCat($_POST['name'], $_POST['birthdate'], $_POST['breed'], $_POST['color']);
    }

    $orderBy = isset($_GET['orderBy']) ? htmlspecialchars($_GET['orderBy']) : 'name';
    $orderDir = isset($_GET['orderDir']) ? htmlspecialchars($_GET['orderDir']) : 'asc';
    $filterBy = isset($_GET['filterBy']) ? htmlspecialchars($_GET['filterBy']) : '';
    $filterValue = isset($_GET['filterValue']) ? htmlspecialchars($_GET['filterValue']) : '';
    $page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 1;

    $totalCats = $catBook->getTotalCats($filterBy, $filterValue);
    $totalPages = ceil($totalCats / 5);
    $cats = $catBook->getCats($orderBy, $orderDir, $filterBy, $filterValue, $page);
?>
<main>
<div class="container"> 

<h1>Cat Book</h1>
<h2>Add a new cat</h2>

 <!-- Add Cat form -->
 <form method="POST" class="mb-4">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="birthdate">Birthdate:</label>
            <input type="date" name="birthdate" id="birthdate" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="breed">Breed:</label>
            <input type="text" name="breed" id="breed" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="color">Color:</label>
            <input type="text" name="color" id="color" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Cat</button>
    </form>

<h2>List of cats</h2>
<form method="GET">
    <label>Order by:</label>
    <select name="orderBy">
        <option value="name" <?=$orderBy == 'name' ? 'selected' : ''; ?>>Name</option>
        <option value="birthdate" <?=$orderBy == 'birthdate' ? 'selected' : ''; ?>>Birthdate</option>
        <option value="breed" <?=$orderBy == 'breed' ? 'selected' : ''; ?>>Breed</option>
        <option value="color" <?=$orderBy == 'color' ? 'selected' : ''; ?>>Color</option>
    </select>
    <select name="orderDir">
        <option value="asc" <?=$orderDir == 'asc' ? 'selected' : ''; ?>>Ascending</option>
        <option value="desc" <?=$orderDir == 'desc' ? 'selected' : ''; ?>>Descending</option>
    </select>
    <label>Filter by:</label>
    <select name="filterBy">
        <option value=""></option>
        <option value="name" <?=$filterBy == 'name' ? 'selected' : ''; ?>>Name</option>
        <option value="birthdate" <?=$filterBy == 'birthdate' ? 'selected' : ''; ?>>Birthdate</option>
        <option value="breed" <?=$filterBy == 'breed' ? 'selected' : ''; ?>>Breed</option>
        <option value="color" <?=$filterBy == 'color' ? 'selected' : ''; ?>>Color</option>
        </select>
    <input type="text" name="filterValue" value="<?=$filterValue; ?>">
    <button type="submit">Filter</button>
</form>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Birthdate</th>
            <th>Breed</th>
            <th>Color</th>
            <th>Photo</th>
        </tr>
    </thead>
    <tbody>
        <? foreach ($cats as $cat) : ?>
            <tr>
                <td><?=$cat['name']; ?></td>
                <td><?=$cat['birthdate']; ?></td>
                <td><?=$cat['breed']; ?></td>
                <td><?=$cat['color']; ?></td>
                <td><img src="<?=$cat['photo']; ?>" alt="Cat Photo" width="300" height="300"></td>
            </tr>
        <? endforeach; ?>
    </tbody>
</table>

<? if ($totalPages > 1) : ?>
    <div>
        <form method="GET">
            <input type="hidden" name="orderBy" value="<?=$orderBy; ?>">
            <input type="hidden" name="orderDir" value="<?=$orderDir; ?>">
            <input type="hidden" name="filterBy" value="<?=$filterBy; ?>">
            <input type="hidden" name="filterValue" value="<?=$filterValue; ?>">
            <label>Page:</label>
            <input type="text" name="page" value="<?=$page; ?>" size="3">
            <button type="submit">Go</button>
        </form>
    </div>
    </main>
<? endif; ?>
</div>
</body>
</html>