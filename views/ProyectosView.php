<?php

class ProyectosView
{
    public function renderLista($proyectos)
    {
?>
        <h1>Lista de Proyectos</h1>

        <?php include_once __DIR__ . "/components/crearButton.php"; ?>

        <?php if (empty($proyectos)): ?>
            <p>No hay proyectos disponibles.</p>
        <?php else: ?>
            <section class="container">
                <?php foreach ($proyectos as $proyecto): ?>
                    <div class="listItem">
                        <h2><?= htmlspecialchars($proyecto["title"]) ?></h2>
                        <p><?= htmlspecialchars($proyecto["description"]) ?></p>
                        <p><strong>Estado:</strong> <?= htmlspecialchars($proyecto["status"]) ?></p>
                        <div class="list-item-controllers">
                            <a href="index.php?controller=proyectos&action=watch&id=<?= urlencode($proyecto["id"]) ?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>



                        </div>
                    </div>
                <?php endforeach; ?>
            </section>

        <?php endif; ?>
    <?php
    }

    public function renderOne($proyecto)
    {
    ?>
        <h1 class="text-2xl font-bold mb-4">Detalle del Proyecto</h1>
        <?php if (empty($proyecto)): ?>
            <p>Proyecto no encontrado.</p>
        <?php else: ?>
            <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
                <dl>
                    <?php foreach ($proyecto as $campo => $valor): ?>
                        <div class="mb-3">
                            <dt class="font-semibold"><?= htmlspecialchars(ucfirst($campo)) ?>:</dt>
                            <dd class="ml-2"><?= nl2br(htmlspecialchars($valor)) ?></dd>
                        </div>
                    <?php endforeach; ?>
                </dl>
                <div class="mt-6 flex gap-2">
                    <a href="index.php?controller=proyectos&action=list" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Volver a la lista</a>
                    <a href="index.php?controller=proyectos&action=edit&id=<?= urlencode($proyecto['id'] ?? '') ?>" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                        <i class="fa fa-pencil" aria-hidden="true"></i> Editar
                    </a>
                    <a href="index.php?controller=proyectos&action=delete&id=<?= urlencode($proyecto['id'] ?? '') ?>" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700" onclick="return confirm('¿Seguro que deseas eliminar este proyecto?');">
                        <i class="fa fa-trash" aria-hidden="true"></i> Eliminar
                    </a>
                </div>
            </div>
        <?php endif; ?>
    <?php
    }
    public function renderEdit($proyecto, $campos)
    {
    ?>
        <h1 class="text-2xl font-bold mb-4">Editar Proyecto</h1>
        <form action="index.php?controller=proyectos&action=edit&id=<?= urlencode($proyecto['id']) ?>" method="POST" class="max-w-md mx-auto bg-white p-6 rounded shadow">
            <?php foreach ($campos as $campo): ?>
                <div class="mb-4">
                    <label for="<?= $campo['name'] ?>" class="block font-semibold mb-1"><?= $campo['label'] ?></label>
                    <?php if ($campo['type'] === 'textarea'): ?>
                        <textarea id="<?= $campo['name'] ?>" name="<?= $campo['name'] ?>" class="w-full border px-3 py-2 rounded" <?= $campo['required'] ? 'required' : '' ?>><?= htmlspecialchars($proyecto[$campo['name']] ?? '') ?></textarea>
                    <?php else: ?>
                        <input
                            type="<?= $campo['type'] ?>"
                            id="<?= $campo['name'] ?>"
                            name="<?= $campo['name'] ?>"
                            class="w-full border px-3 py-2 rounded"
                            value="<?= htmlspecialchars($proyecto[$campo['name']] ?? '') ?>"
                            <?= $campo['required'] ? 'required' : '' ?>>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Guardar cambios</button>
            <a href="index.php?controller=proyectos&action=list" class="ml-2 text-blue-600 hover:underline">Cancelar</a>
        </form>
<?php
    }
}
