<?php
$passport = \Config\Services::passport();

$menu = [
    ['name' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt', 'url' => 'dashboard'],
    ['name' => 'Akun', 'icon' => 'fas fa-users', 'url' => 'user', 'child' => [
        ['name' => 'Akun Panitia', 'icon' => 'far fa-circle', 'url' => 'user/committe'],
        ['name' => 'Akun Peserta', 'icon' => 'far fa-circle', 'url' => 'user/participant'],
    ]],
    ['name' => 'Tryout', 'icon' => 'fas fa-edit', 'url' => 'tryout'],
    ['name' => 'Soal', 'icon' => 'fas fa-copy', 'url' => 'package'],
    // ['name' => 'Scoring', 'icon' => 'fas fa-sort-numeric-down', 'url' => 'scoring'],
    ['name' => 'Logout', 'icon' => 'fas fa-sign-out-alt', 'url' => 'logout'],
];

$current = explode('/', $_SERVER['REQUEST_URI'])[0];
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <!-- <img src="../../dist/img/AdminLTELogo.png" alt="..." class="brand-image img-circle elevation-3" style="opacity: .8"> -->
        <span class="brand-text font-weight-light"><b>ITBxUGM</b></span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= $passport->picture ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= $passport->name ?></a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="true">

                <?php foreach ($menu as $menuitem) : ?>
                    <li class="nav-item">
                        <a href="<?= base_url($menuitem['url']) ?>" class="nav-link <?= ($menuitem['url'] === $current) ? 'active' : ''; ?>">
                            <i class="nav-icon <?= $menuitem['icon'] ?>"></i>
                            <p><?= $menuitem['name'] ?><?= isset($menuitem['child']) ? "<i class='fas fa-angle-left right'></i>" : ''; ?></p>
                        </a>
                        <?php if (isset($menuitem['child'])) : ?>
                            <ul class="nav nav-treeview">
                                <?php foreach ($menuitem['child'] as $child) : ?>
                                    <li class="nav-item">
                                        <a href="<?= base_url($child['url']) ?>" class="nav-link">
                                            <i class="nav-icon <?= $child['icon'] ?>"></i>
                                            <p><?= $child['name'] ?></p>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
