<?php
// Define the root directory
$rootDir = __DIR__;

// Function to scan directory recursively and build menu
function buildMenu($dir, $baseURL = '')
{
    $result = [];
    $items = scandir($dir);
    
    foreach ($items as $item) {
        if ($item == '.' || $item == '..' || $item == '.well-known' || $item == 'cgi-bin') {
            continue;
        }
        
        $path = $dir . DIRECTORY_SEPARATOR . $item;
        $url = $baseURL . '/' . $item;
        
        if (is_dir($path)) {
            $result[$url] = buildMenu($path, $url);
        }
    }
    
    return $result;
}

// Function to display menu as an HTML list

function displayMenu($menu)
{
    if (empty($menu)) {
        return;
    }
    
    echo '<ul class="list-group">';
    foreach ($menu as $url => $subMenu) {
        $name = basename($url);
        echo '<li class="list-group-item">';
        echo '<a href="' . htmlspecialchars($url) . '" class="text-decoration-none">' . htmlspecialchars($name) . '</a>';
        if (!empty($subMenu)) {
            echo '<button class="btn btn-link text-decoration-none py-0" data-bs-target="#' . md5($url) . '" data-bs-toggle="collapse" aria-expanded="false"><i class="bi bi-caret-down-fill"></i></button>';
            echo '<div class="collapse" id="' . md5($url) . '">';
            displayMenu($subMenu);
            echo '</div>';
        }
        echo '</li>';
    }
    echo '</ul>';
}


$menu = buildMenu($rootDir);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Basils Hexlet - js challenges</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        ul.list-group > li > .collapse > ul {
            margin-left: 20px;
        }
    </style>
    
</head>
<body>

<?php displayMenu($menu); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
