<?php
// cpanel_deploy.php - Taruh file ini di root folder (sejajar dengan .env)
// Hapus file ini setelah deploy selesai demi keamanan!

$output = "<h2>Laravel cPanel Deployment Helper</h2>";

try {
    // 1. Clear Caches
    $output .= "<h3>1. Clearing Caches...</h3>";
    $output .= shell_exec('php artisan cache:clear') . "<br>";
    $output .= shell_exec('php artisan config:clear') . "<br>";
    $output .= shell_exec('php artisan view:clear') . "<br>";
    $output .= shell_exec('php artisan route:clear') . "<br>";

    // 2. Storage Link
    $output .= "<h3>2. Creating Storage Link...</h3>";
    // Check if link exists
    if (file_exists(__DIR__ . '/public/storage')) {
        $output .= "<b>public/storage</b> already exists. Attempting to remove it first...<br>";
        if(is_link(__DIR__ . '/public/storage')) {
            unlink(__DIR__ . '/public/storage');
        } else {
             $output .= "<b>Warning:</b> public/storage exists and is not a symlink! You might need to delete it manually via cPanel File Manager.<br>";
        }
    }
    
    // Attempt Artisan storage link
    $res = shell_exec('php artisan storage:link');
    if ($res) {
        $output .= $res . "<br>";
    } else {
        // Fallback manual symlink if artisan fails
        $target = __DIR__ . '/storage/app/public';
        $link = __DIR__ . '/public/storage';
        if (symlink($target, $link)) {
            $output .= "Manual symlink created successfully!<br>";
        } else {
            $output .= "<b>Error:</b> Failed to create storage link. Make sure your hosting allows symlinks.<br>";
        }
    }

    $output .= "<hr><h3 style='color:green'>Done!</h3>";
    $output .= "<p><b>PENTING:</b> Hapus file <code>cpanel_deploy.php</code> ini setelah selesai demi keamanan.</p>";
    $output .= "<a href='./'>Kembali ke Website</a>";

} catch (Exception $e) {
    $output .= "<b style='color:red'>Error: " . $e->getMessage() . "</b>";
}

echo $output;
