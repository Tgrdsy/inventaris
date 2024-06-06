<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Transaksi</title>
    <?php
    $koneksi = mysqli_connect('localhost', 'root', '', 'pertemuan5_07535');
    if ($koneksi->connect_error) {
        die("ERROR loh: " . $koneksi->connect_error);
    }
    ?>
    <style>
        input:focus {
            outline: none;
        }
        form {
            display: flex;
            flex-direction: column;
            width: 200px;
            margin-bottom: 20px;
        }
        input, button {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <h1>INVENTARIS</h1>
    <!-- button create -->
    <form action="" method="POST">
        <input type="submit" name="create" value="Create">
    </form>

    <?php
    // display form create
    if (isset($_POST['create'])) {
        echo "<h3>Create Data</h3>";
        echo "<form action='' method='POST'>";
        echo "<input type='number' name='id' placeholder='ID Transaksi'>";
        echo "<input type='number' name='idb' placeholder='ID Barang'>";
        echo "<input type='date' name='date' placeholder='Tanggal'>";
        echo "<input type='number' name='total' placeholder='Total'>";
        echo "<button type='submit' name='submit_create'>Create</button>";
        echo "</form>";
    }

    // handle form create
    if (isset($_POST['submit_create'])) {
        $id = $_POST['id'];
        $idb = $_POST['idb'];
        $date = $_POST['date'];
        $total = $_POST['total'];

        $query = "INSERT INTO transaksi (id_transaksi, id_barang, tanggal, total) VALUES ($id, $idb, '$date', $total)";
        if (mysqli_query($koneksi, $query)) {
            echo "Input Data Berhasil";
        } else {
            echo "Gagal Input Data: " . mysqli_error($koneksi);
        }
    }

    // display update form 
    if (isset($_POST['update'])) {
        $query = "SELECT * FROM transaksi where id_transaksi = " . $_POST['update'];
        $result = mysqli_query($koneksi, $query);
        $row = mysqli_fetch_assoc($result);
        echo "<h3>Update Data</h3>";
        echo "<form action='' method='POST'>";
        echo "<input type='hidden' name='id' value='" . $_POST['update'] . "'>";
        echo "<input type='number' name='u_barang' value='" . $row['id_barang'] . "'>";
        echo "<input type='date' name='u_tanggal' value='" . $row['tanggal'] . "'>";
        echo "<input type='number' name='u_total' value='" . $row['total'] . "'>";
        echo "<button type='submit' name='submit_update'>Update</button>";
        echo "</form>";
    }

    // handle form update
    if (isset($_POST['submit_update'])) {
        $id = $_POST['id'];
        $idb = $_POST['u_barang'];
        $tgb = $_POST['u_tanggal'];
        $total_b = $_POST['u_total'];
        $query = "UPDATE transaksi SET id_barang = $idb, tanggal = '$tgb', total = $total_b WHERE id_transaksi = $id";

        if (mysqli_query($koneksi, $query)) {
            echo "Update Data Berhasil";
        } else {
            echo "Gagal Update Data: " . mysqli_error($koneksi);
        }
    }

    // delete handler
    if (isset($_POST['del'])) {
        $query = "DELETE FROM transaksi WHERE id_transaksi = " . $_POST['del'];

        if (mysqli_query($koneksi, $query)) {
            echo "Hapus Data Berhasil";
        }
    }
    ?>

    <table border="1">
        <tr>
            <td>ID Transaksi</td>
            <td>ID Barang</td>
            <td>Tanggal Transaksi</td>
            <td>Total</td>
            <?php
            $transaksi = mysqli_query($koneksi, "SELECT * FROM transaksi");

            while ($key = mysqli_fetch_assoc($transaksi)) {
                echo "<tr>";
                echo "<td>" . $key['id_transaksi'] . "</td>";
                echo "<td>" . $key['id_barang'] . "</td>";
                echo "<td>" . $key['tanggal'] . "</td>";
                echo "<td>" . $key['total'] . "</td>";
                echo "<td>";
                echo "<form action='' method='POST' style='display:inline;'>";
                echo "<input name='update' type='hidden' value='" . $key['id_transaksi'] . "' />";
                echo "<button type='submit'>Update</button>";
                echo "</form>";
                echo "<form action='' method='POST' style='display:inline;'>";
                echo "<input name='del' type='hidden' value='" . $key['id_transaksi'] . "' />";
                echo "<button type='submit'>Delete</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }

            ?>
        </tr>
    </table>
</body>

</html>
