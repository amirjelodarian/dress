<?php require_once 'Classes/initialize.php'; ?>
<?php 
    if(!empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['productId'])){
        if($SS->loggedIn()){
            if(!empty($_POST['score'])){
                switch ($_POST['score']){
                    case "1": $_POST['score'] = 1; break;
                    case "2": $_POST['score'] = 2; break;
                    case "3": $_POST['score'] = 3; break;
                    case "4": $_POST['score'] = 4; break;
                    case "5": $_POST['score'] = 5; break;
                    default: $_POST['score'] = ""; break;
                }
            }
            $Comments->insertComment($_POST['title'],$_POST['description'],$_POST['productId'],$_POST['score']);
            
        }else{
            echo 'برای ثبت نظر بایستی به حساب کاربری خود وارد شوید یا حسابی بسازید';
            echo '<br /><hr />';
            echo "<ul>
                    <li><a href='login.php?from=singleProduct.php?id={$_POST['productId']}'>ورود</a></li>
                    <li><a href='register.php?from=singleProduct.php?id={$_POST['productId']}'>ثبت نام</a></li>
                  </ul>";
        }
    }
?>