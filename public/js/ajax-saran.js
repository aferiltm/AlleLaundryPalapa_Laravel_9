// const base_url = $('meta[name="base_url"]').attr("content");
// $.ajaxSetup({
//     headers: {
//         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//     },
// });

// $(document).on("click", ".lihat-isi", function () {
//     let id = $(this).data("id");
//     $("#btn-kirim-balasan").data("id", id);
//     $("#btn-hapus-aduan").data("id", id);
//     $.ajax({
//         url: route("admin.complaint-suggestions.show", {
//             complaintSuggestion: id,
//         }),
//         method: "GET",
//         dataType: "json",
//         success: function (data) {
//             $("#kode_transaksi").html(data.transaction.transaction_code);
//             $("#total_harga").html(data.transaction.total);
//             $("#isi-aduan").html(data.feedback);
//             // $("#isi-review").html(data.review);
//             $("#balas").prop("disabled", false);
//             $("#balas").val("");
//         },
//     });
// });

// $(document).on("click", "#btn-kirim-balasan", function () {
//     let id = $(this).data("id");
//     if (id != "") {
//         let reply = $("#balas").val();
//         $.ajax({
//             url: route("admin.complaint-suggestions.update", {
//                 complaintSuggestion: id,
//             }),
//             data: {
//                 reply: reply,
//             },
//             method: "PATCH",
//             success: function () {
//                 alert("Balasan berhasil dikirim");
//                 location.reload();
//             },
//         });
//     }
// });

const base_url = $('meta[name="base_url"]').attr("content");
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$(document).on("click", ".lihat-isi", function () {
    let id = $(this).data("id");
    $("#btn-kirim-balasan").data("id", id);
    $("#btn-hapus-aduan").data("id", id);

    let url = base_url + "/complaint-suggestions/" + id;

    $.ajax({
        url: url,
        method: "GET",
        dataType: "json",
        success: function (data) {
            $("#isi-aduan").val(data.feedback);
            $("#kode_transaksi").val(data.transaction_code || '-'); // Tambahan ini
            $("#balas").prop("disabled", false);
            $("#balas").val(data.reply || "");

            if (data.reply && data.reply.trim() !== "") {
                $("#btn-kirim-balasan")
                    .text("Update Balasan")
                    .prop("disabled", false);
            } else {
                $("#btn-kirim-balasan")
                    .text("Kirim Balasan")
                    .prop("disabled", false);
            }
        },

        error: function (xhr, status, error) {
            alert("Terjadi kesalahan saat mengambil data: " + error);
        },
    });
});

$(document).on("click", "#btn-kirim-balasan", function () {
    let id = $(this).data("id");
    let reply = $("#balas").val();

    if (id === "" || id === undefined) {
        alert("Silakan pilih feedback terlebih dahulu");
        return;
    }

    if (reply.trim() === "") {
        alert("Silakan tulis balasan Anda");
        return;
    }

    let url = base_url + "/complaint-suggestions/" + id;

    $.ajax({
        url: url,
        data: {
            reply: reply,
            _method: "PATCH",
        },
        method: "POST",
        success: function (response) {
            alert("Balasan berhasil dikirim");
            window.location.href = window.location.href;
        },
        error: function (xhr, status, error) {
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                let errorMessage = "";
                Object.keys(xhr.responseJSON.errors).forEach(function (key) {
                    errorMessage += xhr.responseJSON.errors[key][0] + "\n";
                });
                alert("Error: " + errorMessage);
            } else {
                alert("Terjadi kesalahan saat mengirim balasan: " + error);
            }
        },
    });
});
