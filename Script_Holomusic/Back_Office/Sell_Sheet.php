<?php
session_start();
include '../includes/connexion_check_admin.php';
$link = '../CSS/style_s.css';
$titre = 'Sells Management';
include '../includes/header_backoffice.php' ?>

<main>
    <div class="container pt-5">
        <h1>Sells Sheet</h1>
        <?php

        include '../includes/connexion_bdd.php';

        if (!isset($_POST['date']) || empty($_POST['date'])) {
            $_POST['date'] = "";
        }
        if (!isset($_POST['suser']) || empty($_POST['suser'])) {
            $_POST['suser'] = "";
        }
        if (!isset($_POST['produit']) || empty($_POST['produit'])) {
            $_POST['produit'] = "%";
        }
        if (!isset($_POST['statu']) || empty($_POST['statu'])) {
            $_POST['statu'] = "%";
        }
        ?>
        <div class="row form_row">
            <form style="padding-bottom: 10px" action="/admin/Sell_Sheet" method="post" class="formselect">
                <div class="select ">
                    <div class="col-md-2 pe-5">
                        <label class="form-label" for="buy_date" id="1"> Période : </label>
                        <select class="form-select" name="date" id="buy_date">

                            <option value="<?php echo date("Y/m/d", strtotime("-3 Months")); ?>" <?php echo $_POST['date'] == date("Y/m/d", strtotime("-3 Months")) ? 'selected' : ''; ?> >
                                les 3 derniers mois
                            </option>
                            <option value="<?php echo date("Y/m/d", strtotime("-6 Months")); ?>" <?php echo $_POST['date'] == date("Y/m/d", strtotime("-6 Months")) ? 'selected' : ''; ?> >
                                les 6 derniers mois
                            </option>
                            <option value="<?php echo date("Y/m/d", strtotime("-9 Months")); ?>" <?php echo $_POST['date'] == date("Y/m/d", strtotime("-9 Months")) ? 'selected' : ''; ?> >
                                les 9 derniers mois
                            </option>
                            <option value="<?php echo date("Y/m/d", strtotime("-12 Months")); ?>" <?php echo $_POST['date'] == date("Y/m/d", strtotime("-12 Months")) ? 'selected' : ''; ?> >
                                l'année dernière
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2 pe-5">
                        <label class="form-label" for="statu" id="2">Status :</label>
                        <select class="form-select" name="statu" id="statu">

                            <option <?php echo $_POST['statu'] == "%" ? 'selected' : ''; ?> value="%">Tous</option>
                            <option <?php echo $_POST['statu'] == 0 ? 'selected' : ''; ?> value="0">Non livrés</option>
                            <option <?php echo $_POST['statu'] == 1 ? 'selected' : ''; ?> value="1">Livrés</option>
                        </select>
                    </div>
                    <div class="col-md-2 pe-5">
                        <label class="form-label" for="user" id="3">Produit :</label>
                        <select class="form-select" name="produit" id="produit">

                            <option <?php echo $_POST['produit'] == "%" ? 'selected' : ''; ?> value="%">Tous les
                                articles
                            </option>
                            <option <?php echo $_POST['produit'] == "Casquette" ? 'selected' : ''; ?> value="Casquette">
                                Casquette
                            </option>
                            <option <?php echo $_POST['produit'] == "T-shirts" ? 'selected' : ''; ?> value="T-shirts">
                                T-shirts
                            </option>
                            <option <?php echo $_POST['produit'] == "Tasses" ? 'selected' : ''; ?> value="Tasses">Tasses
                            </option>
                            <option <?php echo $_POST['produit'] == "Echarpes" ? 'selected' : ''; ?> value="Echarpes">
                                Echarpes
                            </option>
                        </select>

                    </div>
                    <div class="col-md-2 pe-5">
                        <label class="form-label" for="suser">Utilisateurs :</label>
                        <input class="form-control" type="search" name="suser" id="suser"
                               value="<?php echo !empty($_POST['suser']) ? $_POST['suser'] : ''; ?>">
                    </div>
                    <input class="btn btn-custom" style="height: 40px" type="submit"
                           value="Filtrer">


                </div>
            </form>
        </div>


        <table class="table table-bordered table-success table-striped">
            <?php

            if (empty($_POST['suser'])) {
                $_POST['suser'] = '%';
            }
            $q = 'SELECT `Order`.id,`Order`.date,Products.Description,`Order`.Status, User.username FROM `Order` INNER JOIN Products_Order ON
        `Order`.id = Products_Order.Order_id INNER JOIN User ON `Order`.User_id = User.idUser INNER JOIN Products ON
        Products.id = Products_Order.Products_id WHERE `Order`.date >= :time AND User.username LIKE :user AND
        Products_Order.Products_id LIKE :Article AND `Order`.Status LIKE :statu ORDER BY `Order`.id DESC LIMIT 10 ';
            $req = $bdd->prepare($q);
            $req->execute(['time' => $_POST['date'],
                'user' => $_POST['suser'],
                'Article' => $_POST['produit'],
                'statu' => $_POST['statu']]);
            $donnees = $req->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <tr>
                <th>Commande ID</th>
                <th>Horodatage</th>
                <th>Produit</th>
                <th>Status</th>
                <th>User</th>
            </tr>
            <?php
            foreach ($donnees as $index => $value) {
                echo '<tr>';
                foreach ($value as $i => $valeur) {
                    echo '<td>' . $valeur . '</td>';
                }
                echo '</tr>';
            }
            ?>
        </table>
    </div>
</main>
<footer>
    <?php
    //include 'includes/footer.html';
    ?>
</footer>
</body>
</html>