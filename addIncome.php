<?php
    session_start();

    if(!isset($_SESSION['isLogged'])){
        header('Location: index.php');
        exit();
    }

    if(isset($_POST['amount'])){

        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);

        try{
            $connection = new mysqli($host, $db_user, $db_password, $db_name);
            if($connection->connect_errno != 0){
                throw new Exception(mysqli_connect_errno());
            }
            else {
                $amount = $_POST['amount'];
                $date = $_POST['date'];
                $incomeCategory = $_POST['incomeCategory'];
                $userID = $_SESSION['id'];

                $choosenIncomeCategoryQuery = $connection->query("SELECT id FROM `incomes_category_assigned_to_users` WHERE user_id='$userID' AND name='$incomeCategory'");
                if(!$choosenIncomeCategoryQuery) throw new Exception($connection->error);
                $choosenIncomeCategoryResult = $choosenIncomeCategoryQuery->fetch_assoc();
                $choosenIncomeCategoryId = $choosenIncomeCategoryResult['id']; 

                if($connection->query("INSERT INTO incomes VALUES(NULL, '$userID', '$choosenIncomeCategoryId', '$amount', '$date', 'some comment')")){
                
                $choosenIncomeCategoryQuery->close();

                header('Location: mainMenu.php');
                } else {
                    throw new Exception($connection->error);
                }
            }
            $connection->close();
        } 
        catch(Exception $e){
            echo '<span style="color:red;"><b>Server error! Please try later</b></span><br>';
            var_dump($e->getMessage());
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Income - $CashFlowControl</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,300;0,500;0,700;1,100;1,300;1,500;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;500;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <h1 class="text-center py-4 mb-0">$CashFlowControl</h1>
    <nav class="navbar navbar-dark navbar-expand-lg sticky-top" style="background-color: #457B9D"> 
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <div class="navbar-nav">
                    <a href="mainMenu.php" class="nav-item nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="1.5rem" fill="currentColor" class="bi bi-house-door" viewBox="0 0 16 16">
                            <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"/>
                        </svg> 
                        Home
                    </a>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <div class="navbar-nav">
                    <a href="addIncome.php" class="nav-item nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="1.5rem" fill="currentColor" class="bi bi-coin" viewBox="0 0 16 16">
                            <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9H5.5zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518l.087.02z"/>
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11zm0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"/>
                        </svg>
                        Add Income
                    </a>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <div class="navbar-nav">
                    <a href="addExpense.php" class="nav-item nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="1.5rem" fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
                            <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l.5 2H5V5H3.14zM6 5v2h2V5H6zm3 0v2h2V5H9zm3 0v2h1.36l.5-2H12zm1.11 3H12v2h.61l.5-2zM11 8H9v2h2V8zM8 8H6v2h2V8zM5 8H3.89l.5 2H5V8zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/>
                        </svg>
                        Add Expense
                    </a>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <div class="navbar-nav">
                    <a href="balanceSheet.php" class="nav-item nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="1.5rem" fill="currentColor" class="bi bi-clipboard-data" viewBox="0 0 16 16">
                            <path d="M4 11a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0v-1zm6-4a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0V7zM7 9a1 1 0 0 1 2 0v3a1 1 0 1 1-2 0V9z"/>
                            <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
                            <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/>
                        </svg>
                        Balance Sheet
                    </a>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <div class="navbar-nav">
                    <a href="#" class="nav-item nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="1.5rem" fill="currentColor" class="bi bi-tools" viewBox="0 0 16 16">
                            <path d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.356 3.356a1 1 0 0 0 1.414 0l1.586-1.586a1 1 0 0 0 0-1.414l-3.356-3.356a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3c0-.269-.035-.53-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814L1 0zm9.646 10.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708zM3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026L3 11z"/>
                        </svg>
                        Settings
                    </a>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <div class="navbar-nav">
                    <a href="logout.php" class="nav-item nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="1.5rem" fill="currentColor" class="bi bi-door-open" viewBox="0 0 16 16">
                            <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z"/>
                            <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117zM11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5zM4 1.934V15h6V1.077l-6 .857z"/>
                        </svg>
                        <?php echo "Log out ".$_SESSION['user']; ?>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <form method="post">
        <div class="container">
            <div class="row d-flex justify-content-center" style="background-color: #F1FAEE">
                <h2 class="display-4 py-3 mb-0 d-flex justify-content-center" style="background-color: #F1FAEE">Add Income:</h2>
                <div class="col-10 col-sm-8 col-lg-6 col-xl-4">
                    <div class="input-group pt-3">
                        <span class="input-group-text">Amount</span>
                        <input type="number" class="form-control" placeholder="0,00 $" required min="0" step="0.01" name="amount">
                    </div>
                    <div class="input-group py-3">
                        <span class="input-group-text">Date</span>
                        <input type="date" class="form-control" required name="date">
                    </div>
                    <p class="fs-4 mt-3 mb-1">Category of income:</p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="incomeCategory" id="incomeCat1" value="salary">
                        <label class="form-check-label" for="incomeCat1">salary</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="incomeCategory" id="incomeCat2" value="bank interest">
                        <label class="form-check-label" for="incomeCat2">bank interest</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="incomeCategory" id="incomeCat3" value="online sales">
                        <label class="form-check-label" for="incomeCat3">online sales</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="incomeCategory" id="incomeCat4" value="other">
                        <label class="form-check-label" for="incomeCat4">other</label>
                    </div>
                    <div class="input-group py-3">
                        <textarea class="form-control" placeholder="Describe the other"></textarea>
                    </div>
                    <div class="col d-flex justify-content-evenly py-4">
                        <button class="btn btn-lg btn-danger">Submit
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
                                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                <path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.235.235 0 0 1 .02-.022z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>       
        </div>
    </form>
   
    <footer>
        <div class="container">
            <div class="row">
                <div class="col d-flex justify-content-end pt-5 pb-2" style="background-color: #F1FAEE">
                    <div>
                        <a href="" class="btn btn-outline-dark btn-sm" onclick=" window.open('https://github.com/MarKowal')"> 
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.25em" height="1.25em" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                                <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
                            </svg>    
                        Made by MarKowal</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </div>
</body>
</html>