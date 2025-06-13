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
            <button id="theme-toggle" class="btn">🌓</button>
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
                <div class="file-upload-wrapper">
                    <label for="file-upload" class="custom-file-upload">📁 Choose File</label>
                    <input id="file-upload" type="file" name="newfile" required>
                </div>
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
            <tbody >
                <?php if ($current_path !== realpath(SHARED_ROOT)): ?>
                <tr>
                    <td colspan="4"><a href="?path=<?= urlencode(dirname($display_path)) ?>">📁 Parent Directory</a></td>
                </tr>
                <?php endif; ?>
                
                <?php foreach ($files as $file): ?>
                    <tr class="clickable-row" data-href="<?php 
                        if ($file['type'] === 'dir') {
                            echo '?path=' . urlencode($file['path']);
                        } else {
                            echo '/Shared/' . htmlspecialchars($file['path']);
                        }
                    ?>">
                        <td class="file-name">
                            <?php $icon = get_file_icon($file['name']); ?>
                            <span><?= $icon ?> <?= htmlspecialchars($file['name']) ?></span>
                        </td>
                        <td><?= format_size($file['size']) ?></td>
                        <td><?= date('Y-m-d H:i', $file['modified']) ?></td>
                        <td class="file-actions">
                            <?php if ($file['type'] !== 'dir'): ?>
                                <a href="/Shared/<?= htmlspecialchars($file['path']) ?>"
                                class="btn btn-download"
                                title="Download"
                                download
                                onclick="event.stopPropagation();">⬇️ Download</a>
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
