<?php

/** @var \Lib\Systems\Views\View $this */ ?>

<?php $this->data['title'] = ($type === 'regular' ? 'Web-App' : 'Web-App (Manager)'); ?>
<?= $this->include('layout/floatingheader') ?>

<?= $this->render_section('include') ?>

<div>
    <?= $this->render_section('content') ?>
</div>

<?= $this->include('layout/footer') ?>