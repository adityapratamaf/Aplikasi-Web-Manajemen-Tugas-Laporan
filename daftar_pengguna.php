<?php include 'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<!-- <div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_user"><i class="fa fa-plus"></i>Tambah Pengguna</a>
			</div>
		</div> -->
		<div class="card-body">
			<table class="table tabe-hover table-condensed" id="list">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="25%">
					<col width="25%">
					<col width="20%">
					<col width="25%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">No</th>
						<th>Foto</th>
						<th>Nama</th>
						<th>Email</th>
						<th>Jabatan</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$type = array('', "Admin", "Manajer", "Karyawan");
					$qry = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users order by concat(firstname,' ',lastname) asc");
					while ($row = $qry->fetch_assoc()) :
					?>
						<tr>
							<td class="text-center"><?php echo $i++ ?></td>
							<td class="avatar"> <img class="img-circle img-bordered-sm" src="assets/uploads/<?php echo $row['avatar'] ?>" alt="user image"> </td>
							<td><?php echo ucwords($row['name']) ?></td>
							<td><?php echo $row['email'] ?></td>
							<td><?php echo $type[$row['type']] ?></td>
							<td>
								<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
									Aksi
								</button>
								<div class="dropdown-menu" style="">
									<a class="dropdown-item view_user" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Lihat</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="./index.php?page=edit_user&id=<?php echo $row['id'] ?>">Edit</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item delete_user" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Hapus</a>
								</div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<style>
	.avatar>img {
		border-radius: 50%;
		height: 75px;
		width: 75px;
		object-fit: cover;
	}
</style>

<script>
	$(document).ready(function() {
		$('#list').dataTable()
		$('.view_user').click(function() {
			uni_modal("<i class='fa fa-edit'></i> Detail Pengguna", "view_user.php?id=" + $(this).attr('data-id'))
		})
		$('.delete_user').click(function() {
			_conf("Hapus Data ?", "delete_user", [$(this).attr('data-id')])
		})
	})

	function delete_user($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_user',
			method: 'POST',
			data: {
				id: $id
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data Terhapus", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	}
</script>