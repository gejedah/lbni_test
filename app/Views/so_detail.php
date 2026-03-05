<?php
// Detail view for a single SO order
// Expects $order as an associative array (one element of the array returned by getSalesOrder())
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sales Order Detail</title>
    <link href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <style>
        /* Card tweaks */
        .detail-card {
            border: 2px solid #0d6efd;
            box-shadow: 0 2px 8px rgba(13,110,253,0.08);
        }
        .detail-card .card-header {
            background: linear-gradient(90deg, #0d6efd 0%, #0b5ed7 100%);
            color: #fff;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        /* Table-like detail */
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 6px;
        }
        .detail-table th,
        .detail-table td {
            padding: 10px 12px;
            border: 1px solid #0d6efd33;
            vertical-align: top;
        }
        .detail-table th {
            width: 220px;
            background-color: #e7f1ff;
            color: #0b5ed7;
            text-align: left;
            font-weight: 600;
            white-space: nowrap;
        }
        .detail-table tbody tr:nth-child(even) td {
            background-color: #fbfcff;
        }
        .detail-keterangan {
            white-space: pre-wrap;
        }
        @media (max-width: 767px) {
            .detail-table th { width: 40%; }
        }
    </style>
</head>
<body>
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Sales Order Detail</h1>
        <a href='/sales_order' class="btn btn-outline-secondary btn-sm">Back to list</a>
    </div>

    <?php if (empty($order)): ?>
        <div class="alert alert-warning">Order not found.</div>
    <?php else: ?>
        <div class="card detail-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Order Details</strong>
                <large class="text-white-50">No S O: <?= esc($order['no_s_o'] ?? '') ?></large>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="detail-table">
                        <tbody>
                            <tr>
                                <th>Tipe</th>
                                <td><?= esc($order['tipe'] ?? '') ?></td>
                            </tr>
                            <tr>
                                <th>Qty</th>
                                <td><?= esc($order['qty'] ?? '') ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td><?= esc($order['tanggal'] ?? '') ?></td>
                            </tr>
                            <tr>
                                <th>Jam</th>
                                <td><?= esc($order['jam'] ?? '') ?></td>
                            </tr>
                            <tr>
                                <th>Pelanggan</th>
                                <td><?= esc($order['nama_pelanggan'] ?? '') ?> (<?= esc($order['kode_pelanggan'] ?? '') ?>)</td>
                            </tr>
                            <tr>
                                <th>Salesman</th>
                                <td><?= esc($order['nama_salesman'] ?? '') ?> (<?= esc($order['kode_salesman'] ?? '') ?>)</td>
                            </tr>
                            <tr>
                                <th>Kategori Kargo</th>
                                <td><?= esc($order['kategori_kargo'] ?? '') ?></td>
                            </tr>
                            <tr>
                                <th>Asuransi</th>
                                <td><?= esc($order['asuransi'] ?? '') ?></td>
                            </tr>
                            <tr>
                                <th>Tagihan Asuransi</th>
                                <td><?= esc($order['tagihan_asuransi'] ?? '') ?></td>
                            </tr>
                            <tr>
                                <th>Harga Jual</th>
                                <td><?= esc($order['harga_jual'] ?? '') ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Otorisasi</th>
                                <td><?= esc($order['tanggal_otorisasi'] ?? '') ?></td>
                            </tr>
                            <tr>
                                <th>Jadwal Kapal</th>
                                <td><?= esc($order['jadwal_kapal'] ?? '') ?> - <?= esc($order['kode_kapal'] ?? '') ?></td>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <td class="detail-keterangan"><?= nl2br(esc($order['keterangan_so'] ?? '')) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
