<?php
if (isset($_GET['message']) && !empty('message') && isset($_GET['type']) && !empty('type')) {
    echo '<div style="margin-top:100px; margin-left:50px; margin-right:50px;" class="alert alert-' . htmlspecialchars($_GET['type']) . ' alert-dismissible fade show" role="alert">' . htmlspecialchars($_GET['message']) . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
}
?>