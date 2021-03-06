<?php
if (isset($_GET["vkey"])){
    //process verification
    $vkey = $_GET["vkey"];
    require_once 'connection.php';
    //prepare statement
    $sql = "SELECT vkey, verified, type FROM login WHERE vkey=?";

    if($stmt = $conn->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("s", $paramVKey);
        // Set parameters
        $paramVKey = $vkey;

        if($stmt->execute()){
            $stmt->store_result();
            // bind result
            $stmt->bind_result($vk , $ver, $type);
            $stmt->fetch();
            if($stmt->num_rows == 1){                  
               $sql = "update login set verified = 1 where vkey='$vkey'";
                if($conn->query($sql)){
                    require_once "includes/header.php";
                        echo "<div class='jumbotron text-center'>
                        <h1 class='display-3'>Congratulations! Your email has been verified.</h1>
                        <p class='lead'><strong>Enjoy your time with us.</strong></p>
                        <hr>
                        <p class='lead'>
                          <a class='btn btn-primary btn-sm' href='login.php?type=$type' role='button'>Go back</a>
                        </p>
                      </div></a>";
                }
            }
            // Close statement
            $stmt->close();
            // Close connection
            $conn->close();
        }
        else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
}
else{
    echo "something went wrong.";
}

?>