<?php

class DonacionesView
{
    public function renderLista($donaciones)
    {
?>
        <h1>Lista de Donaciones</h1>
        <?php include_once __DIR__ . "/components/crearButton.php"; ?>
        <?php if (empty($donaciones)): ?>
            <p>No hay donaciones disponibles.</p>
        <?php else: ?>
            <?php foreach ($donaciones as $donaciones): ?>
                <div class="listItem">
                    <h2><?= htmlspecialchars($donaciones["title"]) ?></h2>
                    <p><?= htmlspecialchars($donaciones["description"]) ?></p>
                    <p><strong>Fecha:</strong> <?= htmlspecialchars($donaciones["goal"]) ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
<?php
    }
}
