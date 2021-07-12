<?php

?>
<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>
<body>


<div class="container d-flex flex-wrap">
<div class="row row-cols-auto">
<?php

$icons = dirtree(__DIR__);
natsort($icons);
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

foreach ($icons as $k => $icon) {
    echo '<div class="col">
        <img loading="lazy" src="' . $actual_link . $icon . '" alt="' . $icon . '" style="width:128px;height:auto;">
        <p>' . $icon . '</p>
    </div>';
}

function dirtree($dir, $ignoreEmpty=false) {
    if (!$dir instanceof DirectoryIterator) {
        $dir = new DirectoryIterator((string)$dir);
    }
    $dirs  = array();
    $files = array();
    foreach ($dir as $node) {
        if ($node->isDir() && !$node->isDot()) {
            $tree = dirtree($node->getPathname(), $ignoreEmpty);
            if (!$ignoreEmpty || count($tree)) {
                $dirs[$node->getFilename()] = $tree;
            }
        } elseif ($node->isFile()) {
            $name = $node->getFilename();
            if (!str_ends_with($name, '.json')) {
                $files[] = $name;
            }
        }
    }
    asort($dirs);
    sort($files);

    return array_merge($dirs, $files);
}
?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
