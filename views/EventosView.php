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
                    <div class="listItem flex flex-col md:flex-row bg-white rounded-xl shadow-md hover:shadow-xl overflow-hidden mb-6 transition-shadow duration-300">
                        <!-- Imagen -->
                        <div class="md:w-1/3 h-56 md:h-auto overflow-hidden">
                            <img src="<?= htmlspecialchars($evento["image"] ?? 'https://via.placeholder.com/300') ?>"
                                alt="Imagen del evento"
                                class="w-full h-full object-cover object-center hover:scale-105 transition-transform duration-300">
                        </div>

                        <!-- Contenido -->
                        <div class="p-6 md:w-2/3 flex flex-col justify-between gap-3">
                            <div>
                                <h2 class="text-2xl font-semibold text-gray-800 mb-2"><?= htmlspecialchars($evento["nombre"]) ?></h2>
                                <p class="text-gray-700 mb-2 leading-relaxed"><?= htmlspecialchars($evento["descripcion"]) ?></p>

                                <?php if (!empty($evento["fecha"])): ?>
                                    <p class="text-sm text-gray-500">
                                        <i class="fa fa-calendar mr-1"></i>
                                        <strong>Fecha:</strong> <?= htmlspecialchars($evento["fecha"]) ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <!-- Botón -->
                            <div class="mt-4">
                                <a href="index.php?controller=eventos&action=watch&id=<?= urlencode($evento["id_evento"]) ?>"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white font-medium rounded hover:bg-indigo-700 transition">
                                    <i class="fa fa-eye"></i> Ver Detalle
                                </a>
                            </div>
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
