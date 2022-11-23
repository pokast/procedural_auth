<?php $theme = extends_of("themes/base_visitor.html.php") ?>

<?php $title = "Connexion"; ?>

<h1 class="text-center my-3 display-5">Connexion</h1>

<?php if( isset($_SESSION['bad_credentials']) && !empty($_SESSION['bad_credentials']) ) : ?>
    <div class="alert alert-danger text-center" role="alert">
        <?= $_SESSION['bad_credentials'] ?>
    </div>
    <?php unset($_SESSION['bad_credentials']); ?>
<?php endif ?>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-lg-5 mx-auto p-4 bg-white shadow-lg">
            <form method="post">
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?= old('email') ?>"/>
                    <div class="text-danger"><?= formErrors("email") ?></div>
                </div>
                <div class="mb-3">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" class="form-control"/>
                    <div class="text-danger"><?= formErrors("password") ?></div>
                </div>
                <div class="mb-3">
                    <input type="submit" class="btn btn-primary" formnovalidate/>
                </div>
            </form>
        </div>
    </div>
</div>