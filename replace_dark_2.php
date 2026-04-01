<?php
$dir = new RecursiveDirectoryIterator(__DIR__ . '/resources/views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/.*\.blade\.php$/', RegexIterator::GET_MATCH);

foreach($files as $file) {
    if (strpos($file[0], 'admin') !== false) continue; // skip admin
    
    $content = file_get_contents($file[0]);
    $newContent = $content;

    // missing border replacements
    $newContent = preg_replace('/border-gray-50(?!.*dark:border-)/', 'border-gray-50 dark:border-dark-border', $newContent);
    
    // hover:bg-orange-50 needs a dark hover
    $newContent = preg_replace('/hover:bg-orange-50(?!.*dark:hover:bg-)/', 'hover:bg-orange-50 dark:hover:bg-[#2A2A2A]', $newContent);
    
    // Some bg-gray-100 should be dark:bg-dark-card inside cards
    $newContent = preg_replace('/bg-gray-100(?!.*dark:bg-)/', 'bg-gray-100 dark:bg-dark-border', $newContent);
    $newContent = preg_replace('/bg-gray-200(?!.*dark:bg-)/', 'bg-gray-200 dark:bg-dark-border', $newContent);

    // Make sure we have transition-colors on the cards so they animate!
    $newContent = preg_replace('/(class="[^"]*bg-white dark:bg-dark-card[^"]*)(?<!transition-colors)(?<!transition-all)(?<!transition)([^"]*\"[^>]*>)/i', '$1 transition-colors duration-300$2', $newContent);

    if ($newContent !== $content) {
        file_put_contents($file[0], $newContent);
        echo "Updated: " . basename($file[0]) . "\n";
    }
}
echo "Done replacing part 2!\n";
