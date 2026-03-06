<?php
// List view for Door-to-Door insured orders
// Expects $orders (array), $pager (array with total/perPage/currentPage/lastPage), $search, $tipe, $ada_asuransi
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LBNI Sales Orders</title>
    <link href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <style>
        /* Table border color */
        .table.table-bordered {
            border: 2px solid #0d6efd;
        }
        .table.table-bordered th,
        .table.table-bordered td {
            border: 1px solid #0d6efd;
        }
        /* Header/title row color */
        .table thead th {
            background-color: #0d6efd !important;
            color: #ffffff;
            border-color: #0d6efd !important;
        }
        /* Pagination active color tweak to match */
        .pagination .page-item.active .page-link {
            background-color: #0b5ed7;
            border-color: #0b5ed7;
        }
    </style>
</head>
<body>
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">LBNI Sales Orders</h1>
        <div>
            <?php $jsonUrl = '/sales_order' . '?' . http_build_query(['search' => $search ?? '', 'tipe' => $tipe, 'ada_asuransi' => $ada_asuransi]); ?>
            <a href="<?= $jsonUrl ?>" class="btn btn-outline-secondary btn-sm">Export JSON</a>
        </div>
    </div>

    <form class="row g-2 mb-3" method="get" action="/sales_order">
        <input type="hidden" name="tipe" value="<?= esc($tipe) ?>">
        <input type="hidden" name="ada_asuransi" value="<?= esc($ada_asuransi) ?>">

        <div class="col-md-8">
            <input type="text" name="search" class="form-control" placeholder="Search by SO, customer, sales, kargo or notes" value="<?= esc($search ?? '') ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="/sales_order" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    <?php $total = $pager['total'] ?? 0; $perPage = $pager['perPage'] ?? 0; $currentPage = $pager['currentPage'] ?? 1; $lastPage = $pager['lastPage'] ?? 1; ?>
    <div class="mb-2 text-muted">Total: <strong><?= number_format($total) ?></strong> <?php if ($total>0): ?>&middot; Page <?= esc($currentPage) ?> of <?= esc($lastPage) ?><?php endif; ?></div>

    <?php if (empty($orders)): ?>
        <div class="alert alert-info">No orders found.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th style="width:60px">#</th>
                    <th>No S O</th>
                    <th>Tipe</th>
                    <th>Qty</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Pelanggan</th>
                    <th>Sales</th>
                    <th>Kategori Kargo</th>
                    <th>Asuransi</th>
                    <th>Tagihan Asuransi</th>
                    <th>Harga Jual</th>
                    <th>Rencana Berangkat (ETD)</th>
                    <th style="width:90px">Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($orders as $i => $o): ?>
                    <tr>
                        <td><?= ($pager['perPage'] ?? count($orders)) * (($pager['currentPage'] ?? 1) - 1) + ($i + 1) ?></td>
                        <td><?= esc($o['no_s_o'] ?? '') ?></td>
                        <td><?= esc($o['tipe'] ?? '') ?></td>
                        <td><?= esc($o['qty'] ?? '') ?></td>
                        <td><?= esc($o['tanggal'] ?? '') ?></td>
                        <td><?= esc($o['jam'] ?? '') ?></td>
                        <td><?= esc($o['nama_pelanggan'] ?? '') ?></td>
                        <td><?= esc($o['nama_salesman'] ?? '') ?></td>
                        <td><?= esc($o['kategori_kargo'] ?? '') ?></td>
                        <td><?= esc($o['asuransi'] ?? '') ?></td>
                        <td><?= esc($o['tagihan_asuransi'] ?? '') ?></td>
                        <td><?= esc($o['harga_jual'] ?? '') ?></td>
                        <td><?= esc($o['tanggal_rencana_berangkat_etd'] ?? '') ?></td>
                        <td><a href="/sales_order/view/<?= esc($o['id_s_o'] ?? '') ?>" class="btn btn-sm btn-outline-primary">View</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if (($pager['lastPage'] ?? 1) > 1): ?>
            <?php
            $baseUrl = '/sales_order';
            $searchParam = $search ?? '';
            $tipeParam = $tipe;
            $adaParam = $ada_asuransi;
            $current = (int) ($pager['currentPage'] ?? 1);
            $last = (int) ($pager['lastPage'] ?? 1);
            $start = max(1, $current - 2);
            $end = min($last, $current + 2);
            ?>

            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item <?= $current <= 1 ? 'disabled' : '' ?>">
                        <?php $qp = http_build_query(['page' => $current - 1, 'search' => $searchParam, 'tipe' => $tipeParam, 'ada_asuransi' => $adaParam]); ?>
                        <a class="page-link" href="<?= $current > 1 ? $baseUrl . '?' . $qp : '#' ?>">&laquo; Prev</a>
                    </li>

                    <?php if ($start > 1): ?>
                        <?php $qp = http_build_query(['page' => 1, 'search' => $searchParam, 'tipe' => $tipeParam, 'ada_asuransi' => $adaParam]); ?>
                        <li class="page-item"><a class="page-link" href="<?= $baseUrl . '?' . $qp ?>">1</a></li>
                        <?php if ($start > 2): ?><li class="page-item disabled"><span class="page-link">&hellip;</span></li><?php endif; ?>
                    <?php endif; ?>

                    <?php for ($p = $start; $p <= $end; $p++): ?>
                        <?php $qp = http_build_query(['page' => $p, 'search' => $searchParam, 'tipe' => $tipeParam, 'ada_asuransi' => $adaParam]); ?>
                        <li class="page-item <?= $p === $current ? 'active' : '' ?>"><a class="page-link" href="<?= $baseUrl . '?' . $qp ?>"><?= $p ?></a></li>
                    <?php endfor; ?>

                    <?php if ($end < $last): ?>
                        <?php if ($end < $last - 1): ?><li class="page-item disabled"><span class="page-link">&hellip;</span></li><?php endif; ?>
                        <?php $qp = http_build_query(['page' => $last, 'search' => $searchParam, 'tipe' => $tipeParam, 'ada_asuransi' => $adaParam]); ?>
                        <li class="page-item"><a class="page-link" href="<?= $baseUrl . '?' . $qp ?>"><?= $last ?></a></li>
                    <?php endif; ?>

                    <li class="page-item <?= $current >= $last ? 'disabled' : '' ?>">
                        <?php $qp = http_build_query(['page' => $current + 1, 'search' => $searchParam, 'tipe' => $tipeParam, 'ada_asuransi' => $adaParam]); ?>
                        <a class="page-link" href="<?= $current < $last ? $baseUrl . '?' . $qp : '#' ?>">Next &raquo;</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>

    <?php endif; ?>
</div>
<script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
