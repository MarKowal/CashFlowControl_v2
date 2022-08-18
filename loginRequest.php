<?php
    session_start();
    
    //zabezpieczenie jezeli nie ustawiono POSTEM loginu i hasla:
    if((!isset($_POST['login'])) || (!isset($_POST['password']))){
        header('Location: index.php');
        exit();
    }
    
    
    
    require_once "connect.php";    
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    //jezeli nie nawiazano polaczenie z baza:
    if($connection->connect_errno != 0){
        echo "ERROR:".$connection->connect_errno;
    }
    //lub jezeli nawiazano polaczenie z baza:
    else {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        //$password = htmlentities($password, ENT_QUOTES, "UTF-8");

        //zapytanie SQL to takze lancuch string
        //zapytanie zamykam w cudzyslow, a zmienne w apostrofy
        //$sql = "SELECT * FROM users WHERE username='$login' AND password='$password'";
        //if na wypadek jezeli zapytanie $sql jest blednie napisane:
        if($sqlResult = $connection->query(sprintf(
            //"SELECT * FROM users WHERE username='%s' AND password='%s'",
            "SELECT * FROM users WHERE username='%s'",
            mysqli_real_escape_string($connection, $login)
            //mysqli_real_escape_string($connection, $password)
        ))){
            $numberOfUsers = $sqlResult->num_rows;
            if($numberOfUsers>0){
                
                $row = $sqlResult->fetch_assoc();

                if(password_verify($password, $row['password'])){
                    //isLogged to FLAGA spr czy user jest zalogowany:
                    $_SESSION['isLogged'] = true;

                    //$row = $sqlResult->fetch_assoc();
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['user'] = $row['username'];
                    
                    unset($_SESSION['error']);
                    $sqlResult->close();
                    header('Location: mainMenu.php');
                } else {
                    $_SESSION['error'] = 
                    '<div class="container ">
                        <div class="row d-flex justify-content-center" style="background-color: #F1FAEE">
                            <span class="display-4 py-3 mb-0 d-flex justify-content-center" style="background-color: #F1FAEE">Invalid login or password!</span>
                        </div>
                    </div>';              
                    header('Location: login.php');
                }

            } else {
                $_SESSION['error'] = 
                '<div class="container ">
                    <div class="row d-flex justify-content-center" style="background-color: #F1FAEE">
                        <span class="display-4 py-3 mb-0 d-flex justify-content-center" style="background-color: #F1FAEE">Invalid login or password!</span>
                    </div>
                </div>';              
                header('Location: login.php');
                
            }
        }

        $connection->close();
    }
?>
