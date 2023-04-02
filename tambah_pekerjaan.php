<?php if (!isset($conn)) {
	include 'db_connect.php';
} ?>

<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-project">

				<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">

				<!-- Bagian 1 -->
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Pekerjaan</label>
							<input type="text" class="form-control form-control-sm" name="name" value="<?php echo isset($name) ? $name : '' ?>">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label for="">Status Pekerjaan</label>
							<select name="status" id="status" class="custom-select custom-select-sm">
								<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Mulai</option>
								<option value="3" <?php echo isset($status) && $status == 3 ? 'selected' : '' ?>>Tunda</option>
								<option value="5" <?php echo isset($status) && $status == 5 ? 'selected' : '' ?>>Selesai</option>
							</select>
						</div>
					</div>
				</div>

				<!-- Bagian 2 -->
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Klien</label>
							<input type="text" class="form-control form-control-sm" name="client" value="<?php echo isset($client) ? $client : '' ?>">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Harga</label>
							<input type="number" class="form-control form-control-sm" name="price" value="<?php echo isset($price) ? $price : '' ?>">
						</div>
					</div>
				</div>

				<!-- Bagian 3 -->
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Tanggal Mulai</label>
							<input type="date" class="form-control form-control-sm" autocomplete="off" name="start_date" value="<?php echo isset($start_date) ? date("Y-m-d", strtotime($start_date)) : '' ?>">
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Tanggal Selesai</label>
							<input type="date" class="form-control form-control-sm" autocomplete="off" name="end_date" value="<?php echo isset($end_date) ? date("Y-m-d", strtotime($end_date)) : '' ?>">
						</div>
					</div>
				</div>

				<div class="row">
					<?php if ($_SESSION['login_type'] == 1) : ?>
						<div class="col-md-6">
							<div class="form-group">
								<label for="" class="control-label">Manajer</label>
								<select class="form-control form-control-sm select2" name="manager_id">
									<option></option>
									<?php
									$managers = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where type = 2 order by concat(firstname,' ',lastname) asc ");
									while ($row = $managers->fetch_assoc()) :
									?>
										<option value="<?php echo $row['id'] ?>" <?php echo isset($manager_id) && $manager_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
									<?php endwhile; ?>
								</select>
							</div>
						</div>
					<?php else : ?>
						<input type="hidden" name="manager_id" value="<?php echo $_SESSION['login_id'] ?>">
					<?php endif; ?>
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Karyawan</label>
							<select class="form-control form-control-sm select2" multiple="multiple" name="user_ids[]">
								<option></option>
								<?php
								$employees = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where type = 3 order by concat(firstname,' ',lastname) asc ");
								while ($row = $employees->fetch_assoc()) :
								?>
									<option value="<?php echo $row['id'] ?>" <?php echo isset($user_ids) && in_array($row['id'], explode(',', $user_ids)) ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
								<?php endwhile; ?>
							</select>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="" class="control-label">Deskripsi</label>
							<textarea name="description" id="" cols="30" rows="10" class="summernote form-control">
						<?php echo isset($description) ? $description : '' ?>
					</textarea>
						</div>
					</div>
				</div>
			</form>
		</div>

		<div class="card-footer border-top border-info">
			<div class="d-flex w-100 justify-content-center align-items-center">
				<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-project">Simpan</button>
				<button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="location.href='index.php?page=daftar_pekerjaan'">Batal</button>
			</div>
		</div>
	</div>
</div>

<script>
	// var rupiah = document.getElementById("rupiah");
	// rupiah.addEventListener("keyup", function(e) {
	// 	// tambahkan 'Rp.' pada saat form di ketik
	// 	// gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
	// 	rupiah.value = formatRupiah(this.value, "Rp. ");
	// });

	// /* Fungsi formatRupiah */
	// function formatRupiah(angka, prefix) {
	// 	var number_string = angka.replace(/[^,\d]/g, "").toString(),
	// 		split = number_string.split(","),
	// 		sisa = split[0].length % 3,
	// 		rupiah = split[0].substr(0, sisa),
	// 		ribuan = split[0].substr(sisa).match(/\d{3}/gi);

	// 	// tambahkan titik jika yang di input sudah menjadi angka ribuan
	// 	if (ribuan) {
	// 		separator = sisa ? "." : "";
	// 		rupiah += separator + ribuan.join(".");
	// 	}

	// 	rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
	// 	return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
	// }

	$('#manage-project').submit(function(e) {
		e.preventDefault()
		start_load()
		$.ajax({
			url: 'ajax.php?action=save_project',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp) {
				if (resp == 1) {
					alert_toast('Data Tersimpan', "success");
					setTimeout(function() {
						location.href = 'index.php?page=daftar_pekerjaan'
					}, 2000)
				}
			}
		})
	})
</script>