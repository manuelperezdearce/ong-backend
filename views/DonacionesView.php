<?php

class DonacionesView
{
    public function renderLista($donaciones)
    {
?>
        <h1 class="text-2xl my-4 text-center font-bold">Lista de Donaciones</h1>
        <?php include_once __DIR__ . "/components/crearButton.php"; ?>
        <?php if (empty($donaciones)): ?>
            <p>No hay donaciones disponibles.</p>
        <?php else: ?>
            <section class="container">
                <?php foreach ($donaciones as $donacion): ?>
                    <div class="listItem">
                        <p><strong>ID <?= $donacion["id"] ?></strong></p>
                        <h2><?= htmlspecialchars($donacion["title"] ?? $donacion["name"] ?? "Sin título") ?></h2>
                        <p><?= htmlspecialchars($donacion["description"] ?? "") ?></p>
                        <p><strong>Monto meta:</strong> <?= htmlspecialchars($donacion["goal"] ?? "") ?></p>
                        <p><strong>Monto recaudado:</strong> <?= htmlspecialchars($donacion["collected"] ?? "") ?></p>
                        <p><strong>Estado:</strong> <?= htmlspecialchars($donacion["status"] ?? "") ?></p>
                        <div class="list-item-controllers flex justify-between items-center">
                            <a href="index.php?controller=donaciones&action=watch&id=<?= urlencode($donacion["id"] ?? "") ?>">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                            <a href="index.php?controller=carrito&action=addCart&id=<?= urlencode($donacion["id"] ?? "") ?>"
                                class="inline-block px-5 py-2 bg-blue-600 text-white font-semibold rounded shadow hover:bg-blue-700 transition">
                                <i class="fa fa-heart mr-2"></i>Donar
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>

        <?php endif; ?>
    <?php
    }

    public function renderOne($donacion)
    {
    ?>
        <h1 class="text-2xl my-4 text-center font-bold">Detalle de la Donación</h1>
        <?php if (empty($donacion)): ?>
            <p>Donación no encontrada.</p>
        <?php else: ?>
            <div class="max-w-xl mx-auto listItem">
                <dl>
                    <?php foreach ($donacion as $campo => $valor): ?>
                        <div class="mb-3">
                            <dt class="font-semibold"><?= htmlspecialchars(ucfirst($campo)) ?>:</dt>
                            <dd class="ml-2"><?= nl2br(htmlspecialchars($valor)) ?></dd>
                        </div>
                    <?php endforeach; ?>
                </dl>
                <div class="mt-6 flex gap-2">
                    <a href="index.php?controller=donaciones&action=list" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Volver a la lista</a>
                    <a href="index.php?controller=donaciones&action=edit&id=<?= urlencode($donacion['id'] ?? '') ?>" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                        <i class="fa fa-pencil" aria-hidden="true"></i> Editar
                    </a>
                    <a href="index.php?controller=donaciones&action=delete&id=<?= urlencode($donacion['id'] ?? '') ?>" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700" onclick="return confirm('¿Seguro que deseas eliminar esta donación?');">
                        <i class="fa fa-trash" aria-hidden="true"></i> Eliminar
                    </a>
                </div>
            </div>
        <?php endif; ?>
    <?php
    }

    public function renderEdit($donacion, $campos)
    {
    ?>
        <h1 class="text-2xl my-4 text-center font-bold">Editar Donación</h1>
        <form action="index.php?controller=donaciones&action=edit&id=<?= urlencode($donacion['id']) ?>" method="POST" class="max-w-md mx-auto listItem">
            <?php foreach ($campos as $campo): ?>
                <div class="mb-4">
                    <label for="<?= $campo['name'] ?>" class="block font-semibold mb-1"><?= $campo['label'] ?></label>
                    <?php if ($campo['type'] === 'textarea'): ?>
                        <textarea id="<?= $campo['name'] ?>" name="<?= $campo['name'] ?>" class="w-full border px-3 py-2 rounded" <?= $campo['required'] ? 'required' : '' ?>><?= htmlspecialchars($donacion[$campo['name']] ?? '') ?></textarea>
                    <?php else: ?>
                        <input
                            type="<?= $campo['type'] ?>"
                            id="<?= $campo['name'] ?>"
                            name="<?= $campo['name'] ?>"
                            class="w-full border px-3 py-2 rounded"
                            value="<?= htmlspecialchars($donacion[$campo['name']] ?? '') ?>"
                            <?= $campo['required'] ? 'required' : '' ?>>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Guardar cambios</button>
            <a href="index.php?controller=donaciones&action=list" class="ml-2 text-blue-600 hover:underline">Cancelar</a>
        </form>
<?php
    }
}
