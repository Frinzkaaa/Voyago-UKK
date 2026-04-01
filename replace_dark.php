<?php
$dir = new RecursiveDirectoryIterator(__DIR__ . '/resources/views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/.*\.blade\.php$/', RegexIterator::GET_MATCH);

foreach($files as $file) {
    if (strpos($file[0], 'admin') !== false) continue; // skip admin
    
    $content = file_get_contents($file[0]);
    $newContent = $content;

    // Pattern for bg-white (but not if it already has dark:bg-dark-card or similar)
    // Actually, simple string replace might duplicate if run multiple times, 
    // but we can check if it already contains dark:!
    
    // Add dark mode classes
    $newContent = preg_replace('/bg-white(?!.*dark:bg-)/', 'bg-white dark:bg-dark-card', $newContent);
    $newContent = preg_replace('/bg-\[#F.?F.?F.?\](?!.*dark:bg-)/i', 'bg-[#FFFFFF] dark:bg-dark-card', $newContent);

    // Text colors
    $newContent = preg_replace('/text-gray-800(?!.*dark:text-)/', 'text-gray-800 dark:text-white', $newContent);
    $newContent = preg_replace('/text-gray-900(?!.*dark:text-)/', 'text-gray-900 dark:text-white', $newContent);
    $newContent = preg_replace('/text-gray-700(?!.*dark:text-)/', 'text-gray-700 dark:text-gray-300', $newContent);
    $newContent = preg_replace('/text-gray-600(?!.*dark:text-)/', 'text-gray-600 dark:text-[#A1A1AA]', $newContent);
    $newContent = preg_replace('/text-gray-500(?!.*dark:text-)/', 'text-gray-500 dark:text-[#A1A1AA]', $newContent);
    
    // Borders
    $newContent = preg_replace('/border-gray-100(?!.*dark:border-)/', 'border-gray-100 dark:border-dark-border', $newContent);
    $newContent = preg_replace('/border-gray-200(?!.*dark:border-)/', 'border-gray-200 dark:border-dark-border', $newContent);

    // Backgrounds for inputs or gray areas 
    $newContent = preg_replace('/bg-gray-50(?!.*dark:bg-)/', 'bg-gray-50 dark:bg-[#121212]', $newContent);
    $newContent = preg_replace('/bg-\[#F5F5F5\](?!.*dark:bg-)/', 'bg-[#F5F5F5] dark:bg-[#121212]', $newContent);

    if ($newContent !== $content) {
        file_put_contents($file[0], $newContent);
        echo "Updated: " . $file[0] . "\n";
    }
}
echo "Done replacing!\n";
