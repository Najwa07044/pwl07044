<!DOCTYPE html>
<html>

<head>
    <title>Sistem Informasi Akademik::Tambah Data User</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap533/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/styleku.css">
    <script src="bootstrap533/jquery/3.3.1/jquery-3.3.1.js"></script>
    <script src="bootstrap533/js/bootstrap.js"></script>
    <style>
        .error {
            color: red;
            font-size: 0.9em;
            display: none;
        }

        #nim {
            width: 150px;
        }

        #ajaxResponse {
            margin-top: 15px;
        }
    </style>
    <script>
        $(document).ready(function() {
            // membuat fungsi untuk mengecek NIM pada tabel mhs di database akademik12345
            function checkUsernameExists(username) {
                $.ajax({
                    // memanggil file cek_data_kembar.php
                    url: 'CekDataKembarUser.php',
                    type: 'POST',
                    data: {
                        username: username
                    },
                    success: function(response) {
                        if (response === 'exists') {
                            showError("* Data sudah ada, silahkan isikan yang lain");
                            $("#username").val("").focus();
                            return false;
                        } else {
                            hideError();
                            $("#username").focus();
                        }
                    }
                });
            }

            function validateNIM() {
                var username = $("#username").val();
                var errorMsg = "";
                // Cek apakah NIM kosong
                if (username.trim() === "") {
                    errorMsg = "* NIM tidak boleh kosong!";
                    showError(errorMsg);
                    return false;
                }
                // Cek panjang NIM
                else if (username.length !== 14) {
                    errorMsg = "* NIM harus terdiri dari 14 karakter (contoh: A12.2023.12345)";
                    showError(errorMsg);
                    return false;
                }
                // Cek format NIM
                else if (!/^[A-Z]\d{2}\.\d{4}\.\d{5}$/.test(username)) {
                    errorMsg = "* Format NIM tidak sesuai. Gunakan format: A12.2023.12345";
                    showError(errorMsg);
                    return false;
                }
                return true;
            }

            function showError(message) {
                $("#usernameError").text(message).show();
            }

            function hideError() {
                $("#usernameError").hide();
            }

            function formatUsername(input) {
                var value = input.value.replace(/\D/g, '');
                var formattedValue = '';
                if (value.length > 0) {
                    if (!/[A-Z]/.test(input.value[0])) {
                        formattedValue = 'A';
                    } else {
                        formattedValue = input.value[0];
                    }
                    if (value.length > 2) {
                        formattedValue += value.substr(0, 2) + '.';
                    } else {
                        formattedValue += value;
                    }
                    if (value.length > 6) {
                        formattedValue += value.substr(2, 4) + '.';
                    } else if (value.length > 2) {
                        formattedValue += value.substr(2);
                    }
                    if (value.length > 6) {
                        formattedValue += value.substr(6, 5);
                    }
                }
                input.value = formattedValue.substr(0, 14);
            }
            // Event listeners
            $("#username").on("blur", function() {
                if (validateUsername()) {
                    checkNIMExists($(this).val());
                }
            }).on("keypress", function(event) {
                if (event.which === 13) {
                    event.preventDefault();
                    if (validateUsername()) {
                        checkUsernameExists($(this).val());
                    }
                }
            }).on("input", function() {
                formatUsername(this);
                hideError();
            });
            // Form submission with AJAX
            $("#userForm").on("submit", function(event) {
                //Menghentikan perilaku submit form standar
                //Memungkinkan proses submit data melalui JavaScript
                event.preventDefault();
                //Memastikan NIM valid sebelum mengirim data ke server
                if (!validateUsername()) {
                    return false;
                }
                //Membuat objek FormData untuk menangkap semua data form
                var formData = new FormData(this);
                $.ajax({
                    // memanggil file sv_addMhs.php
                    url: 'sv_addUser.php',
                    type: 'POST',
                    data: formData,
                    //untuk mendukung upload file
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $("#ajaxResponse").html(response);
                    },
                    error: function() {
                        $("#ajaxResponse").html("Terjadi kesalahan saat mengirim data.");
                    }
                });
            });
        });
    </script>
</head>

<body>
    <?php
    require "head.html";
    ?>
    <div class="utama">
        <br><br><br>
        <h3>TAMBAH DATA USER</h3>
        <div class="alert alert-success alert-dismissible" id="success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        </div>
        <form method="post" action="sv_addUser.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">username:</label>
                <input class="form-control" type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input class="form-control" type="text" name="nama" id="nama">
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <input class="form-control" type="email" name="email" id="email">
            </div>
            <div>
                <button type="submit" class="btn btn-primary" value="Simpan">Simpan</button>
            </div>
        </form>
    </div>
    <!--
	<script>
		$(document).ready(function(){
			$('#butsave').on('click',function(){			
				$('#butsave').attr('disabled', 'disabled');
				var username 	= $('#username').val();
				var password	= $('#password').val();
				var status 	= $('#status').val();
				
				$.ajax({
					type	: "POST",
					url		: "sv_addUser.php",
					data	: {
								username:username,
								password:password,
								status:status
							  },
					contentType	:"undefined",					
					success : function(dataResult){						
						alert('success');
						$("#butsave").removeAttr("disabled");
						$('#fupForm').find('input:text').val('');
						$("#success").show();
						$('#success').html(dataResult);	
					}	   
				});
			});
		});
	</script>
	-->
</body>

</html>