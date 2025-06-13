<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/file-functions.php';

// Get current path and files
$current_path = get_current_path();
$files = get_files_list($current_path);

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['newfile'])) {
    if (handle_file_upload($current_path)) {
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }
}

// Clean path for display
$display_path = clean_path_display($current_path);
?>
<?php include __DIR__ . '/includes/header.php'; ?>

    <div class="container">
        <div class="header">
            <h1>File Sharing</h1>
            <button id="theme-toggle" class="btn">🌓 Toggle Theme</button>
        </div>

        <div class="breadcrumb">
            <?php 
            $parts = explode('/', $display_path);
            $current = '';
            foreach ($parts as $part) {
                if (empty($part)) continue;
                $current .= '/' . $part;
            }
            ?>
        </div>

        <?php if (ALLOW_UPLOADS): ?>
        <div class="upload-form">
            <form method="post" enctype="multipart/form-data">
                <label for="file-upload" class="upload-label">Choose File</label>
                <input id="file-upload" type="file" name="newfile" required>
                <button type="submit" class="btn">Upload</button>
                <span class="file-name-display"></span>
            </form>
        </div>
        <?php endif; ?>

        <table class="file-list">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Size</th>
                    <th>Modified</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($current_path !== realpath(SHARED_ROOT)): ?>
                <tr>
                    <td colspan="4"><a href="?path=<?= urlencode(dirname($display_path)) ?>">📁 Parent Directory</a></td>
                </tr>
                <?php endif; ?>
                
                <?php foreach ($files as $file): ?>
                <tr>
                    <td class="file-name">
                        <?php if ($file['type'] === 'dir'): ?>
                            <a href="?path=<?= urlencode($file['path']) ?>">📁 <?= htmlspecialchars($file['name']) ?></a>
                        <?php else: ?>
                            <span>📄 <?= htmlspecialchars($file['name']) ?></span>
                        <?php endif; ?>
                    </td>
                    <td><?= format_size($file['size']) ?></td>
                    <td><?= date('Y-m-d H:i', $file['modified']) ?></td>
                    <td class="file-actions">
                        <?php if ($file['type'] !== 'dir'): ?>
                            <a href="/Shared/<?= htmlspecialchars($file['path']) ?>" 
                               class="action-btn download-btn" 
                               title="Download"
                               download>⬇️</a>
                            <?php else: ?>
                                <br>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?php include __DIR__ . '/includes/footer.php'; ?>
