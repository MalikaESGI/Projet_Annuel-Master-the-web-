<?php
session_start();
include '../includes/connexion_check_admin.php';
$titre = 'Add Products';
$link = '../CSS/style_back_officeM.css';
$script='';
include '../includes/header_backoffice.php';
include '../includes/message.php';
//include '../includes/connexion_bdd.php';
?> 
    <div class="container">
        <h2 class="mt-5">Add a New Product</h2>
        <form method="POST" action="verif_new_products.php" enctype="multipart/form-data">
            <label class="form">name</label>
            <input type="text" class="form-control custom" name="name" value="<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : '' ?>" >

            <label class="form">price</label>
            <input type="number" step="0.01" class="form-control custom" name="price" min="1" value="<?php echo isset($_SESSION['price']) ? $_SESSION['price'] : '' ?>" >                              
              
            <label class="form">description</label>
            <textarea class="form-control custom" name="description"> <?php echo isset($_SESSION['description']) ? $_SESSION['description'] : '' ?></textarea>


            <label class="form">discount</label>
            <input type="range" value="0" class="form-control custom" name="discount" min="0" max="90" value="<?php echo isset($_SESSION['discount']) ? $_SESSION['discount'] : '' ?>" id="discount">
            <span id="value">0</span>%
            <br>
            <label class="form">Image</label>
            <input type="file" class="form-control custom" name="image">

            <input type="submit" value="add products " class="btn btn-custom  my-4" name="add">


        </form>

        <script>

    const range = document.getElementById('discount');
    const value = document.getElementById('value');

    
    value.textContent = range.value;

   
    range.addEventListener('input', function() {
        value.textContent = range.value;
    });
</script>
    </div>
</main>
</body>
</html>