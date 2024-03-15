<?php /** @var \Lib\Systems\Views\View $this */
$this->title = 'register';
$this->navbar = true;
$this->navbar_title = 'Register';
?>

<?= $this->extend('layout/base') ?>

<?= $this->section('content') ?>

<?php $this->include('pages/auth/partials/register') ?>

<?= $this->end_section() ?>