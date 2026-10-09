/* =========================================================
   WALLPAPER MARKET
   SCRIPT.JS
   Menggunakan jQuery 3.7.1
========================================================= */

$(document).ready(function () {


    /* =====================================================
       1. EFEK HALAMAN
    ===================================================== */

    $(".cover-content")
        .hide()
        .fadeIn(1200);


    $(".about-header")
        .hide()
        .fadeIn(900);


    $(".fade-up").each(function (index) {

        $(this)
            .hide()
            .delay(index * 150)
            .fadeIn(700);

    });


    /* =====================================================
       2. ANIMASI KARTU
    ===================================================== */

    $(".collection-card, .feature-card, .service-box")
        .each(function (index) {

            $(this)
                .css("opacity", 0)
                .delay(index * 120)
                .fadeTo(600, 1);

        });


    /* =====================================================
       3. SMOOTH SCROLL
    ===================================================== */

    $('a[href^="#"]').on("click", function (e) {

        const target = $(this).attr("href");


        if (
            target !== "#" &&
            $(target).length
        ) {

            e.preventDefault();


            $("html, body").animate(
                {
                    scrollTop:
                        $(target).offset().top - 70
                },
                700
            );

        }

    });


    /* =====================================================
       4. FORM PESAN / KONSULTASI
    ===================================================== */

    const pesanForm = $("#pesanForm");


    if (pesanForm.length) {

        /*
         * Mengambil pilihan koleksi dari URL.
         * Contoh:
         * pesan.html?koleksi=minimalis
         */

        const params =
            new URLSearchParams(window.location.search);

        const koleksi =
            params.get("koleksi");


        if (
            koleksi &&
            $("#wallpaper").length
        ) {

            $("#wallpaper").val(koleksi);

        }


        /* =============================================
           SUBMIT FORM
        ============================================= */

        pesanForm.on("submit", function (e) {

            e.preventDefault();


            /* =========================================
               MENGAMBIL DATA FORM
            ========================================= */

            const nama =
                $("#nama").val().trim();


            const email =
                $("#email").val().trim();


            const ruangan =
                $("#ruangan").val();


            const wallpaper =
                $("#wallpaper").val();


            const pesan =
                $("#pesan").val().trim();


            const result =
                $("#pesanResult");


            /* =========================================
               VALIDASI NAMA
            ========================================= */

            if (nama === "") {

                tampilkanError(
                    result,
                    "Silakan masukkan nama Anda."
                );

                $("#nama").focus();

                return;

            }


            /* =========================================
               VALIDASI EMAIL
            ========================================= */

            if (email === "") {

                tampilkanError(
                    result,
                    "Silakan masukkan email Anda."
                );

                $("#email").focus();

                return;

            }


            /* =========================================
               VALIDASI RUANGAN
            ========================================= */

            if (ruangan === "") {

                tampilkanError(
                    result,
                    "Silakan pilih ruangan."
                );

                $("#ruangan").focus();

                return;

            }


            /* =========================================
               VALIDASI WALLPAPER
            ========================================= */

            if (wallpaper === "") {

                tampilkanError(
                    result,
                    "Silakan pilih jenis wallpaper."
                );

                $("#wallpaper").focus();

                return;

            }


            /* =========================================
               VALIDASI PESAN
            ========================================= */

            if (pesan === "") {

                tampilkanError(
                    result,
                    "Silakan tuliskan kebutuhan atau pertanyaan Anda."
                );

                $("#pesan").focus();

                return;

            }


            /* =========================================
               MENGAMBIL NAMA PILIHAN
            ========================================= */

            const namaRuangan =
                $("#ruangan option:selected").text();


            const namaWallpaper =
                $("#wallpaper option:selected").text();


            /* =========================================
               MENAMPILKAN HASIL
            ========================================= */

            result
                .hide()
                .removeClass(
                    "d-none alert-danger"
                )
                .addClass(
                    "alert alert-success"
                )
                .html(

                    "<strong>" +
                    "Permintaan konsultasi berhasil dikirim." +
                    "</strong><br><br>" +

                    "Nama: " +
                    escapeHTML(nama) +
                    "<br>" +

                    "Email: " +
                    escapeHTML(email) +
                    "<br>" +

                    "Ruangan: " +
                    escapeHTML(namaRuangan) +
                    "<br>" +

                    "Wallpaper: " +
                    escapeHTML(namaWallpaper) +
                    "<br>" +

                    "Pesan: " +
                    escapeHTML(pesan) +

                    "<br><br>" +

                    "<strong>Status:</strong> " +
                    "Menunggu konsultasi."

                )
                .fadeIn(600);


            /* =========================================
               SCROLL KE HASIL
            ========================================= */

            $("html, body").animate(
                {
                    scrollTop:
                        result.offset().top - 100
                },
                700
            );

        });

    }


    /* =====================================================
       5. EFEK TOMBOL
    ===================================================== */

    $(".cover-btn, .btn-primary")
        .on("mouseenter", function () {

            $(this)
                .stop(true)
                .animate(
                    {
                        opacity: 0.85
                    },
                    200
                );

        })
        .on("mouseleave", function () {

            $(this)
                .stop(true)
                .animate(
                    {
                        opacity: 1
                    },
                    200
                );

        });


    /* =====================================================
       6. EFEK KARTU KOLEKSI DAN GALERI
    ===================================================== */

    $(".collection-card, .gallery-card")
        .on("mouseenter", function () {

            $(this)
                .stop(true)
                .animate(
                    {
                        opacity: 0.92
                    },
                    200
                );

        })
        .on("mouseleave", function () {

            $(this)
                .stop(true)
                .animate(
                    {
                        opacity: 1
                    },
                    200
                );

        });


    /* =====================================================
       7. FAQ
    ===================================================== */

    $(".faq-question").on("click", function () {

        const answer =
            $(this).next(".faq-answer");


        answer
            .stop(true)
            .slideToggle(300);

    });


    /* =====================================================
       8. EFEK INPUT
    ===================================================== */

    $("input, select, textarea")
        .on("focus", function () {

            $(this)
                .addClass("input-focus");

        });


    $("input, select, textarea")
        .on("blur", function () {

            $(this)
                .removeClass("input-focus");

        });

});



/* =========================================================
   FUNGSI MENAMPILKAN ERROR
========================================================= */

function tampilkanError(result, pesan) {

    result
        .hide()
        .removeClass(
            "d-none alert-success"
        )
        .addClass(
            "alert alert-danger"
        )
        .text(pesan)
        .fadeIn(400);

}



/* =========================================================
   FUNGSI KEAMANAN
   Mencegah HTML dari input pengguna
========================================================= */

function escapeHTML(text) {

    return $("<div>")
        .text(text)
        .html();

}