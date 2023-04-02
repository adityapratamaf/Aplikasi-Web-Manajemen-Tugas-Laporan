<?php
include 'db_connect.php';
$stat = array("Mulai", "Mulai", "Proses", "Tunda", "Telat", "Selesai");
$qry = $conn->query("SELECT * FROM project_list where id = " . $_GET['id'])->fetch_array();
foreach ($qry as $k => $v) {
	$$k = $v;
}
$tprog = $conn->query("SELECT * FROM task_list where project_id = {$id}")->num_rows;
$cprog = $conn->query("SELECT * FROM task_list where project_id = {$id} and status = 3")->num_rows;
$prog = $tprog > 0 ? ($cprog / $tprog) * 100 : 0;
$prog = $prog > 0 ?  number_format($prog, 2) : $prog;
$prod = $conn->query("SELECT * FROM user_productivity where project_id = {$id}")->num_rows;
if ($status == 0 && strtotime(date('Y-m-d')) >= strtotime($start_date)) :
	if ($prod  > 0  || $cprog > 0)
		$status = 2;
	else
		$status = 1;
elseif ($status == 0 && strtotime(date('Y-m-d')) > strtotime($end_date)) :
	$status = 4;
endif;
$manager = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where id = $manager_id");
$manager = $manager->num_rows > 0 ? $manager->fetch_array() : array();
?>


<!-- PRINT -->
<div class="card-body p-0">
	<div class="table-responsive" id="printable">

		<!-- DETAIL -->
		<div class="row">
			<div class="col-lg-12">
				<div class="card card-outline card-primary">

					<div class="card-header">
						<span><b>Detail Pekerjaan :</b></span>
						<?php if ($_SESSION['login_type'] != 3) : ?>
							<div class="card-tools">
								<button class="btn btn-primary btn-sm bg-gradient-success btn-success" id="print"><i class="fa fa-print"></i> &nbsp;Cetak</button>
							</div>
						<?php endif; ?>
					</div>

					<div class="card-body">
						<div class="col-md-12">
							<div class="row">
								<div class="col-sm-6">
									<dl>
										<dt><b class="border-bottom border-primary">Pekerjaan</b></dt>
										<dd><?php echo ucwords($name) ?></dd>

										<dt><b class="border-bottom border-primary">Klien</b></dt>
										<dd><?php echo ucwords($client) ?></dd>


										<dt><b class="border-bottom border-primary">Harga</b></dt>
										<dd><?php echo "Rp. " . number_format(ucwords($price))  ?></dd>


										<dt><b class="border-bottom border-primary">Deskripsi</b></dt>
										<dd><?php echo html_entity_decode($description) ?></dd>
									</dl>
								</div>

								<div class="col-md-6">
									<dl>
										<dt><b class="border-bottom border-primary">Tanggal Mulai</b></dt>
										<dd><?php echo date("d M Y", strtotime($start_date)) ?></dd>
									</dl>
									<dl>
										<dt><b class="border-bottom border-primary">Tanggal Selesai</b></dt>
										<dd><?php echo date("d M Y", strtotime($end_date)) ?></dd>
									</dl>
									<dl>
										<dt><b class="border-bottom border-primary">Status Pekerjaan</b></dt>
										<dd>
											<?php
											if ($stat[$status] == 'Pending') {
												echo "<span class='badge badge-secondary'>{$stat[$status]}</span>";
											} elseif ($stat[$status] == 'Mulai') {
												echo "<span class='badge badge-primary'>{$stat[$status]}</span>";
											} elseif ($stat[$status] == 'Proses') {
												echo "<span class='badge badge-info'>{$stat[$status]}</span>";
											} elseif ($stat[$status] == 'Tunda') {
												echo "<span class='badge badge-warning'>{$stat[$status]}</span>";
											} elseif ($stat[$status] == 'Telat') {
												echo "<span class='badge badge-danger'>{$stat[$status]}</span>";
											} elseif ($stat[$status] == 'Selesai') {
												echo "<span class='badge badge-success'>{$stat[$status]}</span>";
											}
											?>
										</dd>
									</dl>
									<dl>
										<dt><b class="border-bottom border-primary">Manager</b></dt>
										<dd>
											<?php if (isset($manager['id'])) : ?>
												<div class="d-flex align-items-center mt-1">
													<img class="img-circle img-thumbnail p-0 shadow-sm border-info img-sm mr-3" src="assets/uploads/<?php echo $manager['avatar'] ?>" alt="Avatar">
													<b><?php echo ucwords($manager['name']) ?></b>
												</div>
											<?php else : ?>
												<small><i>Manajer Tidak Ada</i></small>
											<?php endif; ?>
										</dd>
									</dl>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>



		<!-- KARYAWAN -->
		<div class="row">
			<div class="col-md-4">
				<div class="card card-outline card-primary">
					<div class="card-header">
						<span><b>Karyawan :</b></span>
						<div class="card-tools">
							<!-- <button class="btn btn-primary bg-gradient-primary btn-sm" type="button" id="edit_project.php">Tim</button> -->
						</div>
					</div>

					<div class="card-body">
						<ul class="users-list clearfix">
							<?php
							if (!empty($user_ids)) :
								$members = $conn->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where id in ($user_ids) order by concat(firstname,' ',lastname) asc");
								while ($row = $members->fetch_assoc()) :
							?>
									<li>
										<img src="assets/uploads/<?php echo $row['avatar'] ?>" alt="User Image">
										<a> <?php echo ucwords($row['name']) ?></a>
										<!-- <a class="users-list-name" href="javascript:void(0)"><?php echo ucwords($row['name']) ?></a> -->
										<!-- <span class="users-list-date">Today</span> -->
									</li>
							<?php
								endwhile;
							endif;
							?>
						</ul>
					</div>
				</div>
			</div>

			<!-- DAFTAR TUGAS -->
			<div class="col-md-8">
				<div class="card card-outline card-primary">
					<div class="card-header">
						<span><b>Daftar Tugas :</b></span>
						<?php if ($_SESSION['login_type'] != 3) : ?>
							<div class="card-tools">
								<button class="btn btn-primary bg-gradient-primary btn-sm" type="button" id="new_task"><i class="fa fa-edit"></i> &nbsp;Tambah Tugas</button>
							</div>
						<?php endif; ?>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-condensed m-0 table-hover">
								<colgroup>
									<col width="5%">
									<col width="25%">
									<col width="25%">
									<col width="20%">
									<col width="15%">
								</colgroup>
								<thead>
									<th>No</th>
									<th>Tugas</th>
									<th>Deskripsi</th>
									<th>Status Tugas</th>
									<th>Aksi</th>
								</thead>
								<tbody>
									<?php
									$i = 1;
									$tasks = $conn->query("SELECT * FROM task_list where project_id = {$id} order by task desc");
									while ($row = $tasks->fetch_assoc()) :
										$trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
										unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
										$desc = strtr(html_entity_decode($row['description']), $trans);
										$desc = str_replace(array("<li>", "</li>"), array("", ", "), $desc);
									?>
										<tr>
											<td class="text-center"><?php echo $i++ ?></td>
											<td class=""><?php echo ucwords($row['task']) ?></td>
											<td class="">
												<p class="truncate"><?php echo strip_tags($desc) ?></p>
											</td>
											<td>
												<?php
												if ($row['status'] == 1) {
													echo "<span class='badge badge-secondary'>Tunda</span>";
												} elseif ($row['status'] == 2) {
													echo "<span class='badge badge-primary'>Proses</span>";
												} elseif ($row['status'] == 3) {
													echo "<span class='badge badge-success'>Selesai</span>";
												} elseif ($row['status'] == 4) {
													echo "<span class='badge badge-danger'>Gagal</span>";
												}
												?>
											</td>
											<td>
												<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
													Aksi
												</button>
												<div class="dropdown-menu" style="">
													<a class="dropdown-item view_task" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-task="<?php echo $row['task'] ?>">Lihat</a>
													<div class="dropdown-divider"></div>
													<?php if ($_SESSION['login_type'] != 3) : ?>
														<a class="dropdown-item edit_task" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-task="<?php echo $row['task'] ?>">Edit</a>
														<div class="dropdown-divider"></div>
														<a class="dropdown-item delete_task" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Hapus</a>
													<?php endif; ?>
												</div>
											</td>
										</tr>
									<?php
									endwhile;
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>


		<!-- Laporan -->
		<div class="row">
			<div class="col-md-12">
				<div class="card card-outline card-primary">
					<div class="card-header">
						<b>Daftar Laporan :</b>
						<div class="card-tools">
							<button class="btn btn-primary bg-gradient-primary btn-sm" type="button" id="new_productivity"><i class="fa fa-edit"></i> &nbsp;Tambah Laporan</button>
						</div>
					</div>
					<div class="card-body">
						<?php
						$progress = $conn->query("SELECT p.*,concat(u.firstname,' ',u.lastname) as uname,u.avatar,t.task FROM user_productivity p inner join users u on u.id = p.user_id inner join task_list t on t.id = p.task_id where p.project_id = $id order by unix_timestamp(p.date_created) desc ");
						while ($row = $progress->fetch_assoc()) :
						?>
							<div class="post">

								<div class="user-block">
									<?php if ($_SESSION['login_id'] == $row['user_id']) : ?>
										<span class="btn-group dropleft float-right">
											<span class="btndropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">
												<i class="fa fa-ellipsis-v"></i>
											</span>
											<div class="dropdown-menu">
												<a class="dropdown-item manage_progress" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-task="<?php echo $row['task'] ?>">Edit</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item delete_progress" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Hapus</a>
											</div>
										</span>

									<?php endif; ?>
									<img class="img-circle img-bordered-sm" src="assets/uploads/<?php echo $row['avatar'] ?>" alt="user image">
									<span class="username">
										<!-- <a><?php echo ucwords($row['uname']) ?>[ <?php echo ucwords($row['task']) ?> ]</a> -->
										<a><?php echo ucwords($row['task']) ?></a>

									</span>
									<span class="description">
										<span>
											<?php
											if ($row['subject'] == 3) {
												echo "<span class='badge badge-primary'>Sesuai Rencana</span>";
											} elseif ($row['subject'] == 4) {
												echo "<span class='badge badge-danger'>Tidak Sesuai Rencana</span>";
											}
											?>
										</span>
										<br>
										<span class="fa fa-user"></span>
										<span>Penanggung Jawab : <?php echo ucwords($row['uname']) ?></span>
										<br>
										<span class="fa fa-calendar-day"></span>
										<span>Tanggal Mulai : <?php echo date('d M Y', strtotime($row['date'])) ?></span>
										<span> - </span>
										<span>Tanggal Selesai : <?php echo date('d M Y', strtotime($row['date_end'])) ?></span>
										<span> | </span>
										<span class="fa fa-clock"></span>
										<span>Jam Mulai : <?php echo date('h:i A', strtotime($row['date'] . ' ' . $row['start_time'])) ?></span>
										<span> - </span>
										<span>Jam Selesai : <?php echo date('h:i A', strtotime($row['date'] . ' ' . $row['end_time'])) ?></span>
									</span>

								</div>
								<!-- /.user-block -->
								<div>
									<?php echo ucwords($row['comment']) ?>
									<!-- <?php echo html_entity_decode($row['comment']) ?> -->
								</div>


								<!-- Picture Task -->





							</div>
							<div class="post clearfix"></div>
						<?php endwhile; ?>
					</div>
				</div>
			</div>
		</div>
	</div>


</div>
</div>



<style>
	.users-list>li img {
		border-radius: 50%;
		height: 100px;
		width: 100px;
		object-fit: cover;
	}

	.users-list>li {
		width: 33.33% !important
	}

	.truncate {
		-webkit-line-clamp: 1 !important;
	}
</style>




<script>
	$('#print').click(function() {
		start_load()
		var _h = $('head').clone()
		var _p = $('#printable').clone()
		var _d = "<p class='text-center'><b>Laporan Detail Pekerjaan (<?php echo date("d M Y") ?>)</b></p>"
		_p.prepend(_d)
		_p.prepend(_h)
		var nw = window.open("", "", "width=900,height=600")
		nw.document.write(_p.html())
		nw.document.close()
		nw.print()
		setTimeout(function() {
			nw.close()
			end_load()
		}, 750)
	})



	$('#new_task').click(function() {
		uni_modal("<i class='fa fa-edit'></i> Tambah Tugas", "manage_task.php?pid=<?php echo $id ?>", "mid-large")
	})
	$('.edit_task').click(function() {
		uni_modal("<i class='fa fa-edit'></i> Edit Tugas", "manage_task.php?pid=<?php echo $id ?>&id=" + $(this).attr('data-id'), "mid-large")
	})
	$('.view_task').click(function() {
		uni_modal("<i class='fa fa-edit'></i> Detail Tugas", "view_task.php?id=" + $(this).attr('data-id'), "mid-large")
		// uni_modal("<i class='fa fa-edit'></i> Detail Tugas " + $(this).attr('data-task'), "view_task.php?id=" + $(this).attr('data-id'), "mid-large")
	})

	$('.delete_task').click(function() {
		_conf("Hapus Data ?", "delete_task", [$(this).attr('data-id')])
	})

	function delete_task($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_task',
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




	$('#new_productivity').click(function() {
		uni_modal("<i class='fa fa-edit'></i> Tambah Laporan", "manage_progress.php?pid=<?php echo $id ?>", 'large')
	})
	$('.manage_progress').click(function() {
		uni_modal("<i class='fa fa-edit'></i> Edit Laporan", "manage_progress.php?pid=<?php echo $id ?>&id=" + $(this).attr('data-id'), 'large')
	})
	$('.delete_progress').click(function() {
		_conf("Hapus Data ?", "delete_progress", [$(this).attr('data-id')])
	})

	function delete_progress($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_progress',
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