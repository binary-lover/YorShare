<?php
function get_current_path() {
    $base_dir = realpath(SHARED_ROOT);
    $request_path = isset($_GET['path']) ? trim($_GET['path'], '/') : '';
    
    $full_path = realpath($base_dir . '/' . $request_path);
    if ($full_path === false || strpos($full_path, $base_dir) !== 0) {
        return $base_dir;
    }
    return $full_path;
}

function get_files_list($path) {
    $files = [];
    $items = scandir($path);
    
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        
        $item_path = $path . '/' . $item;
        $relative_path = substr($item_path, strlen(realpath(SHARED_ROOT)) + 1);
        
        $files[] = [
            'name' => $item,
            'path' => $relative_path,
            'type' => is_dir($item_path) ? 'dir' : 'file',
            'size' => is_dir($item_path) ? 0 : filesize($item_path),
            'modified' => filemtime($item_path),
            'extension' => strtolower(pathinfo($item, PATHINFO_EXTENSION))
        ];
    }
    
    return $files;
}

function clean_path_display($path) {
    $parts = explode('/', $path);
    $cleaned = array_slice($parts, -3); // Show only last 3 parts
    return implode('/', $cleaned);
}

function format_size($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    }
    return $bytes . ' bytes';
}

function handle_file_upload($target_dir) {
    if (!ALLOW_UPLOADS || !isset($_FILES['newfile'])) return false;
    
    $target_path = $target_dir . '/' . basename($_FILES['newfile']['name']);
    return move_uploaded_file($_FILES['newfile']['tmp_name'], $target_path);
}

function get_file_icon($filename) {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return match($ext) {
        'jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp' => '🖼️',
        'mp4', 'mkv', 'avi', 'mov', 'wmv', 'flv' => '🎥',
        'mp3', 'wav', 'flac', 'aac', 'ogg' => '🎵',
        'pdf' => '📕',
        'doc', 'docx' => '📄',
        'xls', 'xlsx' => '📊',
        'ppt', 'pptx' => '📽️',
        'zip', 'rar', '7z', 'tar', 'gz' => '🗜️',
        'txt', 'md', 'log' => '📜',
        'php', 'js', 'html', 'css', 'py', 'sh', 'c', 'cpp', 'java' => '💻',
        default => '📁'
    };
}


?>

