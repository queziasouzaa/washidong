<?php
require 'config.php';

$con = mysqli_connect($DBSERVER, $DBUSERNAME, $DBPASSWORD, $DBNAME) or die(mysqli_error());

$userId = $_POST['user'];

$query = "
    SELECT books.id, books.name, books.rating, books.genre
    FROM books
    INNER JOIN recommendations ON books.id = recommendations.book_id
    WHERE recommendations.user_id = '$userId'
    ORDER BY books.rating DESC
    LIMIT 10
";

$result = mysqli_query($con, $query);

$response = '';

while ($row = mysqli_fetch_assoc($result)) {
    $response .= '<tr>
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['name'] . '</td>
                    <td>' . $row['rating'] . '</td>
                    <td>' . $row['genre'] . '</td>
                    <td><button class="btn btn-primary">Ver</button></td>
                  </tr>';
}

echo $response;

mysqli_close($con);
?>
