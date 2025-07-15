<?php

// Script untuk mengganti 'berlangsung' menjadi 'sedang_diperiksa' di semua view files

$viewsPath = __DIR__ . '/resources/views';
$files = [];

// Collect all .blade.php files
function collectBladeFiles($dir, &$files) {
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item == '.' || $item == '..') continue;
        
        $path = $dir . '/' . $item;
        if (is_dir($path)) {
            collectBladeFiles($path, $files);
        } elseif (pathinfo($item, PATHINFO_EXTENSION) === 'php' && 
                  strpos($item, '.blade.') !== false) {
            $files[] = $path;
        }
    }
}

collectBladeFiles($viewsPath, $files);

$replacements = [
    // Status values
    "'berlangsung'" => "'sedang_diperiksa'",
    '"berlangsung"' => '"sedang_diperiksa"',
    "== 'berlangsung'" => "== 'sedang_diperiksa'",
    '== "berlangsung"' => '== "sedang_diperiksa"',
    
    // Text labels - keep as "Berlangsung" for display
    // We'll handle these separately to maintain user-friendly text
];

$displayReplacements = [
    // Keep display text as "Sedang Diperiksa" for better UX
    '>Berlangsung<' => '>Sedang Diperiksa<',
    'Berlangsung</option>' => 'Sedang Diperiksa</option>',
    'text-gray-600">Berlangsung' => 'text-gray-600">Sedang Diperiksa',
    'Konsultasi Berlangsung' => 'Konsultasi Sedang Berlangsung',
];

$totalFiles = 0;
$totalReplacements = 0;

foreach ($files as $file) {
    $content = file_get_contents($file);
    $originalContent = $content;
    
    // Apply status value replacements
    foreach ($replacements as $search => $replace) {
        $content = str_replace($search, $replace, $content);
    }
    
    // Apply display text replacements
    foreach ($displayReplacements as $search => $replace) {
        $content = str_replace($search, $replace, $content);
    }
    
    if ($content !== $originalContent) {
        file_put_contents($file, $content);
        $totalFiles++;
        $changes = count(array_keys($replacements)) + count(array_keys($displayReplacements));
        $totalReplacements += $changes;
        echo "Updated: " . str_replace(__DIR__ . '/', '', $file) . "\n";
    }
}

echo "\nSummary:\n";
echo "Files updated: $totalFiles\n";
echo "Estimated replacements: $totalReplacements\n";
echo "\nAll 'berlangsung' status has been changed to 'sedang_diperiksa'\n";
