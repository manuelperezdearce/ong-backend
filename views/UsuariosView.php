<?php

// phpinfo();

class UsuariosView
{
    public function loginView()
    {
?>
        <section>
            <?= $this->ingresarView() ?>
            <?= $this->registrarView() ?>
        </section>

    <?php
    }

    private function ingresarView()
    {
    ?>
        <form action="index.php?controller=usuarios&action=addUserControl" method="POST" class="max-w-lg mx-auto bg-white p-6 rounded shadow mt-10 space-y-4">
            <h2 class="text-2xl font-bold text-center mb-4">Iniciar Sesión</h2>

            <label class="block">
                <span class="block text-gray-700 font-medium">Email</span>
                <input type="email" name="email" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </label>

            <label class="block">
                <span class="block text-gray-700 font-medium">Contraseña</span>
                <input type="password" name="password" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </label>

            <button type="submit"
                class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700 transition">
                Ingresar
            </button>
        </form>
    <?php
    }

    private function registrarView()
    {
    ?>
        <form action="index.php?controller=usuarios&action=addUserControl" method="POST" class="max-w-lg mx-auto bg-white p-6 rounded shadow mt-10 space-y-4">
            <h2 class="text-2xl font-bold text-center mb-4">Registro de Usuario</h2>

            <label class="block">
                <span class="block text-gray-700 font-medium">Nombre</span>
                <input type="text" name="name" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </label>

            <label class="block">
                <span class="block text-gray-700 font-medium">Email</span>
                <input type="email" name="email" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </label>

            <label class="block">
                <span class="block text-gray-700 font-medium">Contraseña</span>
                <input type="password" name="password" required
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </label>

            <label class="block">
                <span class="block text-gray-700 font-medium">Rol</span>
                <select name="rol"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="user" selected>Usuario</option>
                    <option value="admin">Administrador</option>
                </select>
            </label>

            <button type="submit"
                class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700 transition">
                Registrarse
            </button>
        </form>
<?php
    }
}

?>