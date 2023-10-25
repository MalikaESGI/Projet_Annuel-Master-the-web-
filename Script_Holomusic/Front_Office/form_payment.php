<?php 
session_start();
include '../includes/connexion_bdd.php';
include '../includes/connexion_check.php';
$titre='Checkout';
$script='';
$link='../CSS/style_cart.css';
$link2='';
include '../includes/header_index.php';
?>

<div class="container mt-5">
<h2>Checkout</h2>
<?php
$User_id = $_SESSION['user_id'];

function save($name,$email, $Status,$adress, $postcode, $city, $country) {
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['Status'] = $Status;
    $_SESSION['address'] = $adress;
    $_SESSION['postcode'] = $postcode;
    $_SESSION['city'] = $city;
    $_SESSION['country'] = $country;
}
 // Function to clear form data in session
function clear() {
    unset($_SESSION['name']);
    unset($_SESSION['email']);
    unset($_SESSION['Status']);
    unset($_SESSION['address']);
    unset($_SESSION['postcode']);
    unset($_SESSION['city']);
    unset($_SESSION['country']);
}





?>
<main>
    <div class="container">
        <h2></h2>
        <?php
         if (isset($_POST['pay'])) { 
            $name = trim($_POST['name']) ;
            $email =trim($_POST['email']) ;
            $Status = trim($_POST['Status'] );  
            $address = trim($_POST['address']);
            $postcode = trim($_POST['postcode']);
            $city = trim ($_POST['city']);
            $country = trim($_POST['country']);
           
            // Save form data in session
            save($name, $email, $Status, $address, $postcode, $city, $country);
          
            

            if (!empty($name) && !empty($email) && !empty($address) &&  !empty($postcode) && !empty($city) && !empty($country)) {
                
                

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        The email is not validate
                    </div>
                    <?php
                }
                else{
                    require_once '../includes/connexion_bdd.php';
             
                $sqlState = $bdd->prepare('INSERT INTO `Order` (User_id,name,email,Status,address,postcode,city,country,date) 
                VALUES(?,?,?,?,?,?,?,?,NOW())');
                $sqlState->execute([htmlspecialchars($User_id),htmlspecialchars($name),htmlspecialchars($email), $Status,
                htmlspecialchars($address),htmlspecialchars($postcode),htmlspecialchars($city),htmlspecialchars($country)]);
                header('Location: /payment');
                
                clear();
                }
                      
            } elseif(empty($name)){
                ?>
                <div class="alert alert-danger" role="alert">
                 Please, Enter your name
                </div>
                <?php
            }
            elseif(empty($email)){
                ?>
                <div class="alert alert-danger" role="alert">
                Please, Enter your email
                </div>
                <?php
            }

            elseif(empty($address)){
                ?>
                <div class="alert alert-danger" role="alert">
                   Please,Enter your address 
                </div>
                <?php
        }
        elseif(empty($postcode)){
            ?>
            <div class="alert alert-danger" role="alert">
                 Please,Enter your postcode
            </div>
            <?php
         }
        elseif(empty($city)){
            ?>
            <div class="alert alert-danger" role="alert">
            Please,Enter your name of your city
            </div>
            <?php
            
        }
        elseif(empty($country)){
            ?>
            <div class="alert alert-danger" role="alert">
            Please,Enter your country 
            </div>
            <?php
            
        }
       
        }

    
?>
<form  method="post">

  
    
    
        <label for="name">Name</label>
        <input type="text" calss="form-control"  name="name"  class="form-control"  value="<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : '' ?>">
    
        
        <label for="email">Email</label>
        <input type="text"  class="form-control" name="email"   class="form-control" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : '' ?>">
    
    
        <input type="hidden" name="Status" value="0" >

        <label for="address">Address</label>
        <input type="text"  class="form-control" name="address"  class="form-control"  value="<?php echo isset($_SESSION['address']) ? $_SESSION['address'] : '' ?>" >
    
        <label for="postal_code">Postcode</label>
        <input type="text"  class="form-control" name="postcode"  class="form-control" value="<?php echo isset($_SESSION['postcode']) ? $_SESSION['postcode'] : '' ?>" >
        
        <label for="name">City</label>
        <input type="text" calss="form-control"  name="city" class="form-control" value="<?php echo isset($_SESSION['city']) ? $_SESSION['city'] : '' ?>">
    
        <label for="country">Country</label>
        <input type="text"  name="country"  class="form-control" value="<?php echo isset($_SESSION['country']) ? $_SESSION['country'] : '' ?>">
    
    <button type="submit" class="btn btn-primary" name="pay">pay</button>
</form>
</div>
</body>
</html>
