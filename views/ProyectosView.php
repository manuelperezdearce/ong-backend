<?php

class ProyectosView
{
    public function renderLista($proyectos)
    {
?>
        <h1 class="text-2xl my-4 text-center font-bold">Lista de Proyectos</h1>

        <?php include_once __DIR__ . "/components/crearButton.php"; ?>

        <?php if (empty($proyectos)): ?>
            <p>No hay proyectos disponibles.</p>
        <?php else: ?>
            <section class="container">
                <?php foreach ($proyectos as $proyecto): ?>
                    <div class="listItem bg-white rounded-lg shadow-md overflow-hidden flex flex-col md:flex-row md:items-center">
                        <div class="md:w-1/3 h-48 md:h-40 overflow-hidden">
                            <img src="<?= htmlspecialchars($proyecto['image']) ?>" alt="Imagen del proyecto"
                                class="w-full h-full object-cover object-center">
                        </div>
                        <div class="p-4 md:w-2/3 flex flex-col gap-2">
                            <h2 class="text-xl font-bold text-gray-800"><?= htmlspecialchars($proyecto["nombre"]) ?></h2>
                            <p class="text-gray-600"><?= htmlspecialchars($proyecto["descripcion"]) ?></p>
                            <p class="text-sm text-gray-500"><strong>Estado:</strong> <?= htmlspecialchars($proyecto["status"]) ?></p>
                            <div class="mt-2">
                                <a href="index.php?controller=proyectos&action=watch&id=<?= urlencode($proyecto["id_proyecto"]) ?>"
                                    class="inline-block text-blue-600 hover:text-blue-800 font-medium transition">
                                    <i class="fa fa-eye mr-1"></i> Ver detalle
                                </a>
                            </div>
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
        <h1 class="text-3xl my-6 text-center font-bold text-blue-800">Detalle del Proyecto</h1>

        <?php if (empty($proyecto)): ?>
            <p class="text-center text-red-500">Proyecto no encontrado.</p>
        <?php else: ?>
            <div class="max-w-5xl mx-auto bg-white shadow-md rounded p-6 border border-gray-200">
                <div class="flex flex-col md:flex-row gap-6 items-start">
                    <!-- Información del proyecto -->
                    <dl class="flex-1 space-y-4">
                        <?php foreach ($proyecto as $campo => $valor): ?>
                            <?php if ($campo !== 'image'): ?>
                                <div>
                                    <dt class="text-sm font-semibold text-gray-600"><?= htmlspecialchars(ucfirst($campo)) ?>:</dt>
                                    <dd class="text-md text-gray-800"><?= nl2br(htmlspecialchars($valor)) ?></dd>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </dl>

                    <!-- Imagen del proyecto -->
                    <?php if (!empty($proyecto['image'])): ?>
                        <div class="md:w-1/3 w-full">
                            <img src="<?= htmlspecialchars($proyecto['image']) ?>"
                                alt="Imagen del Proyecto"
                                class="w-full h-auto max-h-64 object-cover rounded-lg shadow-sm border border-gray-300" />
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mt-6 flex gap-3 justify-end">
                    <a href="index.php?controller=proyectos&action=list"
                        class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                        Volver a la lista
                    </a>

                    <?php if (!empty($_SESSION['username']) && ($_SESSION['rol'] ?? '') === 'admin'): ?>
                        <a href="index.php?controller=proyectos&action=edit&id=<?= urlencode($proyecto['id_proyecto'] ?? '') ?>"
                            class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                            <i class="fa fa-pencil mr-1"></i>Editar
                        </a>

                        <a href="index.php?controller=proyectos&action=delete&id=<?= urlencode($proyecto['id_proyecto'] ?? '') ?>"
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition"
                            onclick="return confirm('¿Seguro que deseas eliminar este proyecto?');">
                            <i class="fa fa-trash mr-1"></i>Eliminar
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php
    }

    public function renderEdit($proyecto, $campos)
    {
    ?>
        <h1 class="text-2xl my-4 text-center font-bold">Editar Proyecto</h1>
        <form action="index.php?controller=proyectos&action=edit&id=<?= urlencode($proyecto['id_proyecto']) ?>" method="POST" class="max-w-md mx-auto listItem">
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
