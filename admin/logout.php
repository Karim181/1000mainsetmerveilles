<?php
/**
 * Déconnexion Admin
 * 1000 Mains et Merveilles
 */

auth_logout();

header('Location: ' . admin_url('login'));
exit;
