<h2 class="text-xl font-bold mb-4">Crear nuevo <?= htmlspecialchars($controller) ?></h2>
<form action="index.php?controller=<?= htmlspecialchars($controller) ?>&action=<?= htmlspecialchars($action) ?>" method="POST" class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <?php foreach ($campos as $campo): ?>
        <div class="mb-4">
            <label for="<?= $campo['name'] ?>" class="block font-semibold mb-1"><?= $campo['label'] ?></label>
            <?php if ($campo['type'] === 'textarea'): ?>
                <textarea id="<?= $campo['name'] ?>" name="<?= $campo['name'] ?>" class="w-full border px-3 py-2 rounded" <?= $campo['required'] ? 'required' : '' ?>></textarea>
            <?php else: ?>
                <input type="<?= $campo['type'] ?>" id="<?= $campo['name'] ?>" name="<?= $campo['name'] ?>" class="w-full border px-3 py-2 rounded" <?= $campo['required'] ? 'required' : '' ?>>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Crear</button>
</form>