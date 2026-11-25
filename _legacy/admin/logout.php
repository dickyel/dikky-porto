<?php
require_once dirname(__DIR__) . '/includes/bootstrap.php';
logout_user();
flash('success', 'Kamu sudah logout.');
redirect(base_url('admin/login.php'));
