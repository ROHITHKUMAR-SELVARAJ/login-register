<?php
require("config.php");

if(isset($_GET["email"]) && isset($_GET["token"])) 
{
    $query="SELECT * FROM users WHERE email='$_GET[email]' AND token='$_GET[token]'";
    $result=mysqli_query($con,$query);
    if($result)
    {
        if(mysqli_num_rows($result) == 1)
        {
            $result_fetch=mysqli_fetch_assoc($result);
            if($result_fetch['status']==0)
            {
                $update="UPDATE users SET 'status'=1 WHERE email='$result_fetch[email]'";
                if(mysqli_query($con,$update)){
                    echo "<script>
                    alert('Email Verification Successfull!');
                    window.location.href='index.php';
                    </script>";
                }
                else
                {
                    echo "<script>
                    alert('Registration Failed!');
                    window.location.href='index.php';
                    </script>";
                }
                        }
            else{
                echo "<script>
                    alert('Email Already Registered!');
                    window.location.href='index.php';
                    </script>";
            }
        }
    }
    else{
        echo "<script>
        alert('Registration Failed!');
        window.location.href='index.php';
        </script>";
    }


}

?>
