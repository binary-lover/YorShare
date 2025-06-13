    </div>
    <script src="/assets/js/main.js"></script>
    <script>
document.querySelectorAll('.clickable-row').forEach(row => {
    const fileNameCell = row.querySelector('.file-name');

    if (fileNameCell) {
        fileNameCell.addEventListener('click', (e) => {
            const href = row.dataset.href;
            if (href) {
                const isFile = !href.startsWith('?path=');
                window.open(href, isFile ? '_blank' : '_self');
            }
            e.stopPropagation(); // Prevent click from bubbling
        });
    }
});

</script>

</body>
</html>

