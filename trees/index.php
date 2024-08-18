<?php
// Define the root directory
$rootDir = __DIR__;

function getRelativePathFromSiteRoot($rootDir = __DIR__)
{
    // Get the document root
    $documentRoot = realpath($_SERVER['DOCUMENT_ROOT']);
    
    // Get the directory of the current script
    $currentDir = $rootDir;
    
    // Get the relative path
    $relativePath = str_replace($documentRoot, '', $currentDir);
    
    // Ensure the path starts with a forward slash
    if (substr($relativePath, 0, 1) !== '/') {
        $relativePath = '/' . $relativePath;
    }
    
    return $relativePath;
}

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
        $url = $baseURL . getRelativePathFromSiteRoot() . '/' . $item;
        
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<?php displayMenu($menu); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
