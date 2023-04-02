<?php
include 'db_connect.php';
if (isset($_GET['id'])) {
	$qry = $conn->query("SELECT * FROM task_list where id = " . $_GET['id'])->fetch_array();
	foreach ($qry as $k => $v) {
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<dl>
		<dt><b class="border-bottom border-primary">Tugas</b></dt>
		<dd><?php echo ucwords($task) ?></dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Status</b></dt>
		<dd>
			<?php
			if ($status == 1) {
				echo "<span class='badge badge-secondary'>Tunda</span>";
			} elseif ($status == 2) {
				echo "<span class='badge badge-primary'>Proses</span>";
			} elseif ($status == 3) {
				echo "<span class='badge badge-success'>Selesai</span>";
			} elseif ($status == 4) {
				echo "<span class='badge badge-danger'>Gagal</span>";
			}
			?>
		</dd>
	</dl>
	<dl>
		<dt><b class="border-bottom border-primary">Deskripsi</b></dt>
		<dd><?php echo html_entity_decode($description) ?></dd>
	</dl>
</div>