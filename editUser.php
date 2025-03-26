<!DOCTYPE html>
<html>

<head>
    <title>Sistem Informasi Akademik::Edit Data User</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap533/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/styleku.css">
    <script src="bootstrap533/jquery/3.3.1/jquery-3.3.1.js"></script>
    <script src="bootstrap533/js/bootstrap.js"></script>
</head>

<body>
    <?php
    require "fungsi.php";
    require "head.html";
    $id = $_GET['kode'];
    $sql = "select * from user where iduser='$iduser'";
    $qry = mysqli_query($koneksi, $sql);
    $row = mysqli_fetch_assoc($qry);
    ?>
    <div class="utama">
        <h2 class="mb-3 text-center">EDIT DATA USER</h2>
        <div class="row">
            <div class="col-sm-3 text-center">
            </div>
            <div class="col-sm-9">
                <form enctype="multipart/form-data" method="post" action="sv_editUser.php">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input class="form-control" type="text" name="username" id="username" value="<?php echo $row['username'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input class="form-control" type="text" name="password" id="password" value="<?php echo $row['password'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <input class="form-control" type="status" name="status" id="status" value="<?php echo $row['status'] ?>">
                    </div>
                    <div>
                        <button class="btn btn-primary" type="submit" id="submit">Simpan</button>
                    </div>
                    <input type="hidden" name="iduser" id="iduser" value="<?php echo $iduser ?>">
                </form>
            </div>
        </div>
    </div>
    <!-- script>
		$('#submit').on('click',function(){
			var id 		= $('#iduser').val();
			var username	= $('#username').val();
			var password 	= $('#password').val();
			$.ajax({
				method	: "POST",
				url		: "sv_editUser.php",
				data	: {iduser:iduser, username:username, password:password}
			});
		});
	</script -->
</body>

</html>