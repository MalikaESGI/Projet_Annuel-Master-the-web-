<?php
session_start();
include '../includes/connexion_check_admin.php';
$link = '../CSS/style_s.css';
$titre = 'Add a new User';
include '../includes/header_backoffice.php';
include_once '../includes/connexion_bdd.php';
?>
<div style="margin-top: 100px" class="container">
    <form action="/admin/verification_add_user?idUser=" method="POST">
        <div class="row">
            <div class="offset-1 col-4 pb-3">
                <label class="form">Username</label>
                <input type="text" class="form-control custom" name="username">
            </div>

            <div class="offset-1 col-4 pb-3">
                <label class="form">Name</label>
                <input type="text" class="form-control custom" name="name">
            </div>
        </div>
        <div class="row">
            <div class="offset-1 col-4 pb-3">
                <label class="form">First Name</label>
                <input type="text" class="form-control custom" name="firstname">
            </div>

            <div class="offset-1 col-4 pb-3">
                <label class="form">Password</label>
                <input type="password" class="form-control custom" name="password">
            </div>
        </div>
        <div class="row">
            <div class="offset-1 col-4 pb-3">
                <label class="form">Email</label>
                <input type="text" class="form-control custom" name="email">
            </div>
            <div class="offset-1 col-4 pb-3">
                <label class="form">Status</label>
                <select class="form-select" name="status">
                    <option value="1">User</option>
                    <option value="2">Admin</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="offset-1 col-4 pb-3">
                <label class="form">Birthdate</label>
                <input type="date" class="form-control custom" name="birthdate" value="">
            </div>
        </div>
        <input type="submit" value="Create" class="btn btn-custom offset-9  my-4">
    </form>
</div>

