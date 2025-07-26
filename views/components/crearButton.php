<?php if (!empty($_SESSION['username']) && $_SESSION['rol'] === 'admin'): ?>

    <a href="index.php?controller=<?= $_GET["controller"] ?>&action=create"
        class="inline-block m-auto px-5 py-2 bg-green-600 text-white font-semibold rounded shadow hover:bg-green-700 transition">
        <i class="fa fa-plus mr-2"></i>Crear nuevo <?= ucfirst($_GET["controller"]) ?>
    </a>

<?php endif; ?>