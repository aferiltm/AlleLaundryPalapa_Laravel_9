const base_url = $('meta[name="base_url"]').attr("content");
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$(document).on("click", ".btn-detail", function () {
    let id_transaksi = $(this).data("id");
    let url = $(this).data("url");
    $("#id-transaksi-detail").html(id_transaksi);

    $.ajax({
        url: url,
        // url: "/transactions/" + id_transaksi,
        method: "GET",
        dataType: "json",
        // success: function (data) {
        //     // console.log(data);

        //     // Cek ada transaction_details atau transaction_details_kiloan
        //     let hasSatuan = data.transaction_details && data.transaction_details.length > 0;
        //     let hasKiloan = data.transaction_details_kiloan && data.transaction_details_kiloan.length > 0;

        //     // Show/hide tabel berdasarkan jenis transaksi
        //     if (hasSatuan) {
        //         $("#tbl-detail-transaksi").eq(0).show(); // Tabel satuan
        //         $("#tbl-detail-transaksi").eq(1).hide(); // Tabel kiloan
        //     } else if (hasKiloan) {
        //         $("#tbl-detail-transaksi").eq(0).hide();
        //         $("#tbl-detail-transaksi").eq(1).show();
        //     } else {
        //         $("#tbl-detail-transaksi").eq(0).hide();
        //         $("#tbl-detail-transaksi").eq(1).hide();
        //     }

        //     // Generate tabel satuan
        //     let table = "";
        //     if (hasSatuan) {
        //         let j = 1;
        //         $.each(data.transaction_details, function (i, val) {
        //             table += `
        //                 <tr>
        //                     <td>${j++}</td>
        //                     <td>${val.price_list?.item?.name || '-'}</td>
        //                     <td>${val.price_list?.service?.name || '-'}</td>
        //                     <td>${val.price_list?.category?.name || '-'}</td>
        //                     <td>${val.quantity || '0'}</td>
        //                     <td>${val.price || '0'}</td>
        //                     <td>${val.sub_total || '0'}</td>
        //                 </tr>
        //             `;
        //         });
        //     } else {
        //         table = '<tr><td colspan="7" class="text-center">Tidak ada data transaksi satuan</td></tr>';
        //     }
        //     $("#tbl-ajax").html(table);

        //     // Generate tabel kiloan
        //     let tableKiloan = "";
        //     if (hasKiloan) {
        //         let k = 1;
        //         $.each(data.transaction_details_kiloan, function (i, val) {
        //             tableKiloan += `
        //                 <tr>
        //                     <td>${k++}</td>
        //                     <td>${val.price_list_kiloan?.category_kiloan?.name || '-'}</td>
        //                     <td>${val.quantity || '0'}</td>
        //                     <td>${val.price || '0'}</td>
        //                     <td>${val.sub_total || '0'}</td>
        //                 </tr>
        //             `;
        //         });
        //     } else {
        //         tableKiloan = '<tr><td colspan="7" class="text-center">Tidak ada data transaksi kiloan</td></tr>';
        //     }
        //     $("#tbl-ajax-kiloan").html(tableKiloan);

        //     // Data lainnya
        //     $("#service-type").html(data.service_type?.name || "-");
        //     $("#payment-amount").html(data.payment_amount ? 'Rp ' + parseInt(data.payment_amount).toLocaleString('id-ID') : "-");
        //     $("#code-transaksi-detail").html(data.transaction_code || "-");

        //     $("#transactionDetailModal").modal("show");
        // },
        success: function (data) {
            // console.log(data);

            let hasSatuan = data.transaction_details && data.transaction_details.length > 0;
            let hasKiloan = data.transaction_details_kiloan && data.transaction_details_kiloan.length > 0;

            // Show/hide section berdasarkan jenis transaksi
            if (hasSatuan) {
                $("#section-satuan").show();
                $("#section-kiloan").hide();
            } else if (hasKiloan) {
                $("#section-satuan").hide();
                $("#section-kiloan").show();
            } else {
                $("#section-satuan").hide();
                $("#section-kiloan").hide();
            }

            // Tabel detail satuan
            let table = "";
            if (hasSatuan) {
                let j = 1;
                $.each(data.transaction_details, function (i, val) {
                    table += `
                        <tr>
                            <td>${j++}</td>
                            <td>${val.price_list?.item?.name || '-'}</td>
                            <td>${val.price_list?.service?.name || '-'}</td>
                            <td>${val.price_list?.category?.name || '-'}</td>
                            <td>${val.quantity || '0'}</td>
                            <td>${val.price || '0'}</td>
                            <td>${val.sub_total || '0'}</td>
                        </tr>
                    `;
                });
            } else {
                table = '<tr><td colspan="7" class="text-center">Tidak ada data transaksi satuan</td></tr>';
            }
            $("#tbl-ajax").html(table);

            // Tabel detail kiloan
            let tableKiloan = "";
            if (hasKiloan) {
                let k = 1;
                $.each(data.transaction_details_kiloan, function (i, val) {
                    tableKiloan += `
                        <tr>
                            <td>${k++}</td>
                            <td>${val.price_list_kiloan?.category_kiloan?.name || '-'}</td>
                            <td>${val.quantity || '0'}</td>
                            <td>${val.price || '0'}</td>
                            <td>${val.sub_total || '0'}</td>
                        </tr>
                    `;
                });
            } else {
                tableKiloan = '<tr><td colspan="5" class="text-center">Tidak ada data transaksi kiloan</td></tr>';
            }
            $("#tbl-ajax-kiloan").html(tableKiloan);

            // Data tambahan
            $("#service-type").html(data.service_type?.name || "-");
            $("#payment-amount").html(data.payment_amount ? 'Rp ' + parseInt(data.payment_amount).toLocaleString('id-ID') : "-");
            $("#code-transaksi-detail").html(data.transaction_code || "-");

            $("#transactionDetailModal").modal("show");
        },
        error: function (xhr) {
            console.error("Error details:", xhr.responseText);
            alert("Gagal mengambil detail transaksi. Silakan cek console untuk detail error.");
        }
    });
});


$(document).on("change", ".select-status", function () {
    let id_transaksi = $(this).data("id");
    if (confirm("Apakah anda yakin mengubah status transaksi ini?")) {
        let val = $(this).val();
        $.ajax({
            url: route("admin.transactions.update", {
                transaction: id_transaksi,
            }),
            data: {
                val: val,
            },
            method: "PATCH",
            success: function (data) {
                location.reload();
            },
        });
    } else {
        $(this).val($(this).data("val"));
        return;
    }
});

$(document).on("change", "#tahun", function () {
    let year = $(this).val();
    let option = "";
    $.ajax({
        url: route("admin.reports.get-month"),
        data: {
            year: year,
        },
        method: "POST",
        dataType: "json",
        success: function (data) {
            $.each(data, function (i, val) {
                option +=
                    '<option value="' +
                    val.Bulan +
                    '">' +
                    val.Bulan +
                    "</option>";
            });
            $("#bulan").html(option);
            $("#btn-cetak").removeClass("d-none");
        },
    });
});
