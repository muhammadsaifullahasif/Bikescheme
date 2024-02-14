<?php

include "function.php";

$query = mysqli_query($conn, "SELECT * FROM users WHERE role='2'");
if(mysqli_num_rows($query) > 0) {
    while($result = mysqli_fetch_assoc($query)) {
        $id = $result['id'];
        $user_name_query = mysqli_fetch_assoc(mysqli_query($conn, "SELECT meta_value FROM user_meta WHERE user_id='$id' && meta_key='user_cnic'"));
        $user_name = $user_name_query['meta_value'];
        $transaction_query = mysqli_query($conn, "UPDATE transaction SET user_cnic='$user_name' WHERE user_id='$id'");
    }
}

/*echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE role='2'"));
$query = mysqli_query($conn, "SELECT * FROM users WHERE role='2'");
if(mysqli_num_rows($query) > 0) {
    $i = 1;
    while($result = mysqli_fetch_assoc($query)) {
        $id = $result['id'];
        $update = mysqli_query($conn, "INSERT INTO user_meta(user_id, meta_name, meta_key, meta_value) VALUES('$id', 'User Special Note', 'user_special_note', '')");
        if($update) {
            echo $i.'<br>';
        }
        $i++;
    }
}*/

?>