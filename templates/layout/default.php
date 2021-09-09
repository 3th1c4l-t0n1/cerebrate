<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
use Cake\Core\Configure;

$cakeDescription = 'Cerebrate';
$navbarVariant = !empty($darkMode) ? 'primary' : 'dark';
$navbarIsDark = false;
$sidebarVariant = !empty($darkMode) ? 'dark' : 'dark';
Configure::write('navbarVariant', $navbarVariant);
Configure::write('navbarIsDark', $navbarIsDark);
Configure::write('sidebarVariant', $sidebarVariant);
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?php
        if (empty($darkMode)) {
            echo $this->Html->css('bootstrap.css');
        } else {
            echo $this->Html->css('darkly-bootstrap.css');
        }
    ?>
    <?= $this->Html->css('main.css') ?>
    <?= $this->Html->css('font-awesome') ?>
    <?= $this->Html->css('layout.css') ?>
    <?= $this->Html->script('jquery-3.5.1.min.js') ?>
    <?= $this->Html->script('popper.min.js') ?>
    <?= $this->Html->script('bootstrap.bundle.js') ?>
    <?= $this->Html->script('main.js') ?>
    <?= $this->Html->script('bootstrap-helper.js') ?>
    <?= $this->Html->script('api-helper.js') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <?= $this->Html->css('bootstrap-additional.css') ?>
    <?= $this->Html->meta('favicon.ico', '/img/favicon.ico', ['type' => 'icon']); ?>
</head>
<body>
    <div class="main-wrapper">
        <header class="navbar top-navbar <?= sprintf('bg-%s navbar-%s', $navbarVariant, $navbarIsDark ? 'light' : 'dark') ?>">
            <?= $this->element('layouts/header') ?>
        </header>
        <div class="sidebar <?= empty($darkMode) ? 'bg-light' : 'bg-dark' ?>">
            <?= $this->element('layouts/sidebar') ?>
        </div>
        <main role="main" class="content">
            <div class="container-fluid mt-1">
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>
            </div>
        </main>
    </div>
    <div id="mainModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true"></div>
    <div id="mainToastContainer" style="position: absolute; top: 15px; right: 15px; z-index: 1080"></div>
    <div id="mainModalContainer"></div>
</body>

<script>
    const darkMode = (<?= empty($darkMode) ? 'false' : 'true' ?>)
</script>
</html>
