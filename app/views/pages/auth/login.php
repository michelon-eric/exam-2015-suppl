<?php /** @var \Lib\Systems\Views\View $this */
$this->title = 'Login';
$this->navbar = true;
$this->navbar_title = 'Login';
?>

<?= $this->extend('layout/base') ?>

<?= $this->section('content') ?>

<?= $this->include('pages/auth/partials/login') ?>

<?= $this->end_section() ?>