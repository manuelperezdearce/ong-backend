<?php
$active = $_GET['controller'] ?? 'proyectos';
?>
<header class="border-b border-black rounded-b-2xl shadow-lg">
    <nav class="max-w-[1200px] m-auto h-full flex justify-between">
        <a class="flex items-center a-logo" href="index.php?controller=proyectos&action=list">
            <img class="logo" src="./views/public/onglogo.png" alt="Logo del Sitio ONG">
            <p class="text-2xl font-bold">Friendly ONG</p>
        </a>
        <ul class="flex flex-wrap justify-end [&>*]:mx-4 h-full [&>*]:w-[90px] [&>*]:[&>*]:mx-auto">
            <li class="flex items-center">
                <a href="index.php?controller=proyectos&action=list"
                    class="<?= $active === 'proyectos' ? 'active' : '' ?>">Proyectos</a>
            </li>
            <li class="flex items-center">
                <a href="index.php?controller=eventos&action=list"
                    class="<?= $active === 'eventos' ? 'active' : '' ?>">Eventos</a>
            </li>
            <li class="flex items-center">
                <a href="index.php?controller=donaciones&action=list"
                    class="<?= $active === 'donaciones' ? 'active' : '' ?>">Donaciones</a>
            </li>
        </ul>
    </nav>
</header>