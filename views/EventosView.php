<?php

class EventosView
{
    public function renderLista($eventos)
    {
?>
        <h1>Lista de Eventos</h1>
        <?php include_once __DIR__ . "/components/crearButton.php"; ?>
        <?php if (empty($eventos)): ?>
            <p>No hay eventos disponibles.</p>
        <?php else: ?>
            <?php foreach ($eventos as $evento): ?>
                <div class="listItem">
                    <h2><?= htmlspecialchars($evento["name"]) ?></h2>
                    <p><?= htmlspecialchars($evento["description"]) ?></p>
                    <p><strong>Fecha:</strong> <?= htmlspecialchars($evento["date"]) ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
<?php
    }
}
