<?= $this->extend('layout/page') ?>

<?= $this->section('content') ?>

<?= session()->get('test') ?>
from view

<?= $this->end_section('content') ?>