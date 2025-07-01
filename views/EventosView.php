<?php

class EventosView
{
    public function renderLista($eventos)
    {
?>
        <h1 class="text-2xl my-4 text-center font-bold">Lista de Eventos</h1>
        <?php include_once __DIR__ . "/components/crearButton.php"; ?>
        <?php if (empty($eventos)): ?>
            <p>No hay eventos disponibles.</p>
        <?php else: ?>
            <section class="container">
                <?php foreach ($eventos as $evento): ?>
                    <div class="listItem">
                        <p><strong>ID <?= $evento["id"] ?></strong></p>
                        <h2><?= htmlspecialchars($evento["name"]) ?></h2>
                        <p><?= htmlspecialchars($evento["description"]) ?></p>
                        <p><strong>Fecha:</strong> <?= htmlspecialchars($evento["date"]) ?></p>
                        <div class="list-item-controllers">
                            <a href="index.php?controller=eventos&action=watch&id=<?= urlencode(strval($evento["id"])) ?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>

        <?php endif; ?>
    <?php
    }
    public function renderOne($evento)
    {
    ?>
        <h1 class="text-2xl my-4 text-center font-bold">Detalle del Evento</h1>
        <?php if (empty($evento)): ?>
            <p>Evento no encontrado.</p>
        <?php else: ?>
            <div class="max-w-xl mx-auto listItem">
                <dl>
                    <?php foreach ($evento as $campo => $valor): ?>
                        <div class="mb-3">
                            <dt class="font-semibold"><?= htmlspecialchars(ucfirst($campo)) ?>:</dt>
                            <dd class="ml-2"><?= nl2br(htmlspecialchars($valor)) ?></dd>
                        </div>
                    <?php endforeach; ?>
                </dl>
                <div class="mt-6 flex gap-2">
                    <a href="index.php?controller=eventos&action=list" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Volver a la lista</a>
                    <a href="index.php?controller=eventos&action=edit&id=<?= urlencode($evento['id'] ?? '') ?>" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                        <i class="fa fa-pencil" aria-hidden="true"></i> Editar
                    </a>
                    <a href="index.php?controller=eventos&action=delete&id=<?= urlencode($evento['id'] ?? '') ?>" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700" onclick="return confirm('¿Seguro que deseas eliminar este evento?');">
                        <i class="fa fa-trash" aria-hidden="true"></i> Eliminar
                    </a>
                </div>
            </div>
        <?php endif; ?>
    <?php
    }
    public function renderEdit($evento, $campos)
    {
    ?>
        <h1 class="text-2xl my-4 text-center font-bold">Editar Evento</h1>
        <form action="index.php?controller=eventos&action=edit&id=<?= urlencode($evento['id']) ?>" method="POST" class="max-w-md mx-auto listItem">
            <?php foreach ($campos as $campo): ?>
                <div class="mb-4">
                    <label for="<?= $campo['name'] ?>" class="block font-semibold mb-1"><?= $campo['label'] ?></label>
                    <?php if ($campo['type'] === 'textarea'): ?>
                        <textarea id="<?= $campo['name'] ?>" name="<?= $campo['name'] ?>" class="w-full border px-3 py-2 rounded" <?= $campo['required'] ? 'required' : '' ?>><?= htmlspecialchars($evento[$campo['name']] ?? '') ?></textarea>
                    <?php else: ?>
                        <input
                            type="<?= $campo['type'] ?>"
                            id="<?= $campo['name'] ?>"
                            name="<?= $campo['name'] ?>"
                            class="w-full border px-3 py-2 rounded"
                            value="<?= htmlspecialchars($evento[$campo['name']] ?? '') ?>"
                            <?= $campo['required'] ? 'required' : '' ?>>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Guardar cambios</button>
            <a href="index.php?controller=eventos&action=list" class="ml-2 text-blue-600 hover:underline">Cancelar</a>
        </form>
<?php
    }
}
