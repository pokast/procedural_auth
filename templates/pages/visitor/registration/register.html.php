<?php $theme = extends_of("themes/base_visitor.html.php"); ?>

<?php $title = "Inscription"; ?>

<h1 class="text-center my-3 display-5">Inscription</h1>

<div class="container my-3">
    <div class="row">
        <div class="col-12 col-md-8 col-lg-5 mx-auto bg-white p-4 shadow-lg border">
            <form method="post">
                <div class="mb-3">
                    <label for="first_name">Prénom</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" value="<?= old('first_name') ?>" />
                    <div class="text-danger"><?= formErrors('first_name'); ?></div>
                </div>
                <div class="mb-3">
                    <label for="last_name">Nom</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" value="<?= old('last_name') ?>" />
                    <div class="text-danger"><?= formErrors('last_name'); ?></div>
                </div>
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?= old('email') ?>" />
                    <div class="text-danger"><?= formErrors('email'); ?></div>
                </div>
                <div class="mb-3">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" class="form-control" />
                    <div class="text-danger"><?= formErrors('password'); ?></div>
                </div>
                <div class="mb-3">
                    <label for="confirm_password">Confirmation du mot de passe</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" />
                    <div class="text-danger"><?= formErrors('confirm_password'); ?></div>
                </div>
                <div class="mb-3">
                    <input type="submit" class="btn btn-primary" value="S'inscrire" formnovalidate />
                </div>
            </form>
        </div>
    </div>
</div>