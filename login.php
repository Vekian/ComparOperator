<?php include('header.php'); ?>

<div class="container">
    <div class="mt-5 pt-5"></div> 
    <form action="process/processlogin.php" method="POST">
        <div class="form-group col-12 col-md-6 mx-auto">
            <label for="exampleDropdownFormEmail2">Identifiant</label>
            <input type="email" class="form-control" id="exampleDropdownFormEmail2" placeholder="Admin">
        </div>
        <div class="form-group col-12 col-md-6 mx-auto">
            <label for="exampleDropdownFormPassword2">Mot de passe</label>
            <input type="password" class="form-control" id="exampleDropdownFormPassword2" placeholder="Password">
        </div>
        <div class="form-check col-12 col-md-6 mx-auto">
            <input type="checkbox" class="form-check-input" id="dropdownCheck2">
            <label class="form-check-label" for="dropdownCheck2">
                Remember me
            </label>
            <br>
            <button type="submit" class="btn btn-primary">OK</button>
        </div>
    </form>
</div>

<?php include('footer.php'); ?>
