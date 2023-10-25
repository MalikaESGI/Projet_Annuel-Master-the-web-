<?php
session_start();
include '../includes/connexion_bdd.php';
include '../includes/connexion_check.php';
$id = $_GET['id'];
$sqlState = $bdd->prepare("SELECT * FROM Products WHERE id=?");
$sqlState->execute([$id]);
$product = $sqlState->fetch(PDO::FETCH_ASSOC);

$titre = 'Products '.$product['name'];
$script='';
$link='../CSS/details_prod.css';
$link2='';
include '../includes/header_index.php';
?>

<body>

<div class="container py-2">
    
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img class="img img-fluid w-75" src="../uploads/<?php echo $product['image'] ?>"
                     alt="<?php echo $product['name'] ?>">
            </div>
            <div class="col-md-6 details" >
                <?php
                $discount = $product['discount'];
                $price = $product['price'];
                ?>
                <div class="d-flex align-items-center">
                    <h1 class="w-100"><?php echo $product['name'] ?></h1>
                    <hr>
                    <?php if (!empty($discount)) {
                        ?>
                        <span class="badge text-bg-success">- <?php echo $discount ?> %</span>
                        <?php
                    } ?>
                </div>
                
                

                <p class="text-justify">
                    <?php echo $product['Description'] ?>
                </p>
               
                <div class="d-flex">
                    <?php
                    if (!empty($discount)) {
                        $total = $price - (($price * $discount) / 100);
                        ?>
                        <h5 class="mx-1">
                            <span class="badge text-bg-danger"><strik> <?php echo $price .' €'?> <i class="fa fa-solid fa-dollar"></i> </strik></span>
                        </h5>
                        <h5 class="mx-1">
                            <span class="badge text-bg-success"><?php echo $total.' €' ?> <i class="fa fa-solid fa-dollar"></i></span>
                        </h5>

                        <?php
                    } else {
                        $total = $price;
                        ?>
                        <h5>
                            <span class="badge text-bg-success"><?php echo $total.' €' ?> <i class="fa fa-solid fa-dollar"></i></span>
                        </h5>

                        <?php
                    }
                    ?>

                </div>
                
                    <?php
                    $idProduct = $product['id']; ?>
                   
                
                <form method="POST" action="cart">
                 <input type="hidden" class="form-control" name="id" value="<?php echo $product['id'] ?>">
                 <input type="submit" value="add to cart" class="btn btn-secondary my-2" name="add to cart">

                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html