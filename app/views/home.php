<?= $this->extend('layout/page') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->end_section() ?>

<?= $this->section('include') ?>
<script type="module" src="<?= assets_path('js/home.js') ?>" defer></script>
<?= $this->end_section() ?>

<?= $this->section('content') ?>
meow
<?= $this->end_section() ?>