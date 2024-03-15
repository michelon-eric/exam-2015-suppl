<?php

/** @var \Lib\Systems\Views\View $this */ ?>

<?= $this->extend('layout/page') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->end_section() ?>

<?= $this->section('include') ?>
<script type="module" src="<?= assets_path('js/home.js') ?>" defer></script>
<?= $this->end_section() ?>

<?= $this->section('content') ?>

<button hx-get="/auth/signup" hx-trigger="click" class="btn text-white" hx-target="#target" hx-swap="innerHTML">
    [prrr meow]
</button>

<div id="target" class="text-white">
    huh
</div>

<?= $this->end_section() ?>