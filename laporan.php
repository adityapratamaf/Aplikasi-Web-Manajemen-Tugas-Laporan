<?php include 'db_connect.php' ?>

<!-- PRINT -->
<div class="card-body p-0">
  <div class="table-responsive" id="printable">

    <div class="col-md-12">
      <div class="card card-outline card-primary">
        <div class="card-header">
          <b>Laporan</b>
          <div class="card-tools">
            <button class="btn btn-flat btn-sm bg-gradient-success btn-success" id="print"><i class="fa fa-print"></i> &nbsp;Cetak</button>
          </div>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-condensed m-0 table-hover">

              <colgroup>
                <col width="5%">
                <col width="20%">
                <col width="15%">
                <col width="15%">
                <col width="5%">
                <col width="5%">
                <col width="5%">
                <col width="17%">
                <col width="15%">
              </colgroup>
              <thead>
                <th>No</th>
                <th>Pekerjaan</th>
                <th>Klien</th>
                <th>Harga</th>
                <th>Tugas</th>
                <th>Selesai</th>
                <th>Durasi</th>
                <th>Perkembangan</th>
                <th>Status Pekerjaan</th>
              </thead>

              <tbody>
                <?php
                $i = 1;
                $stat = array("Mulai", "Mulai", "Proses", "Tunda", "Telat", "Selesai");
                $where = "";
                if ($_SESSION['login_type'] == 2) {
                  $where = " where manager_id = '{$_SESSION['login_id']}' ";
                } elseif ($_SESSION['login_type'] == 3) {
                  $where = " where concat('[',REPLACE(user_ids,',','],['),']') LIKE '%[{$_SESSION['login_id']}]%' ";
                }
                $qry = $conn->query("SELECT * FROM project_list $where order by name asc");
                while ($row = $qry->fetch_assoc()) :
                  $tprog = $conn->query("SELECT * FROM task_list where project_id = {$row['id']}")->num_rows;
                  $cprog = $conn->query("SELECT * FROM task_list where project_id = {$row['id']} and status = 3")->num_rows;
                  $prog = $tprog > 0 ? ($cprog / $tprog) * 100 : 0;
                  $prog = $prog > 0 ?  number_format($prog, 2) : $prog;
                  $prod = $conn->query("SELECT * FROM user_productivity where project_id = {$row['id']}")->num_rows;
                  $dur = $conn->query("SELECT sum(time_rendered) as duration FROM user_productivity where project_id = {$row['id']}");
                  $dur = $dur->num_rows > 0 ? $dur->fetch_assoc()['duration'] : 0;
                  if ($row['status'] == 0 && strtotime(date('Y-m-d')) >= strtotime($row['start_date'])) :
                    if ($prod  > 0  || $cprog > 0)
                      $row['status'] = 2;
                    else
                      $row['status'] = 1;
                  elseif ($row['status'] == 0 && strtotime(date('Y-m-d')) > strtotime($row['end_date'])) :
                    $row['status'] = 4;
                  endif;
                ?>

                  <tr>
                    <td class="text-center">
                      <?php echo $i++ ?>
                    </td>
                    <td>
                      <a>
                        <?php echo ucwords($row['name']) ?>
                      </a>
                      <br>
                      <small>
                        Tanggal Mulai : <?php echo date("d M Y", strtotime($row['start_date'])) ?>
                        <br>
                        Tanggal Selesai : <?php echo date("d M Y", strtotime($row['end_date'])) ?>
                      </small>
                    </td>

                    <td>
                      <p><?php echo ucwords($row['client']) ?></p>
                    </td>

                    <td>
                      <p><?php echo "Rp. " . number_format(ucwords($row['price']))  ?></p>
                    </td>

                    <td>
                      <?php echo number_format($tprog) ?>
                    </td>
                    <td>
                      <?php echo number_format($cprog) ?>
                    </td>
                    <td>
                      <?php echo number_format($dur) . ' Hr/s' ?>
                    </td>
                    <td class="project_progress">
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-blue" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prog ?>%">
                        </div>
                      </div>
                      <small>
                        <?php echo $prog ?>% Selesai
                      </small>
                    </td>
                    <td class="project-state">
                      <?php
                      if ($stat[$row['status']] == 'Pending') {
                        echo "<span class='badge badge-secondary'>{$stat[$row['status']]}</span>";
                      } elseif ($stat[$row['status']] == 'Mulai') {
                        echo "<span class='badge badge-primary'>{$stat[$row['status']]}</span>";
                      } elseif ($stat[$row['status']] == 'Proses') {
                        echo "<span class='badge badge-info'>{$stat[$row['status']]}</span>";
                      } elseif ($stat[$row['status']] == 'Tunda') {
                        echo "<span class='badge badge-warning'>{$stat[$row['status']]}</span>";
                      } elseif ($stat[$row['status']] == 'Telat') {
                        echo "<span class='badge badge-danger'>{$stat[$row['status']]}</span>";
                      } elseif ($stat[$row['status']] == 'Selesai') {
                        echo "<span class='badge badge-success'>{$stat[$row['status']]}</span>";
                      }
                      ?>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>

<script>
  $('#print').click(function() {
    start_load()
    var _h = $('head').clone()
    var _p = $('#printable').clone()
    var _d = "<p class='text-center'><b>Laporan Pekerjaan (<?php echo date("d M Y") ?>)</b></p>"
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
</script>