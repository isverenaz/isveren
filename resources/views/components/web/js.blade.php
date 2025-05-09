@if($page == 'jobs')
    <script>
        let filterData = '';
        let page = 1;
        let loading = false;
        let scrollTimeout;
        let disablePost = false;

        const ENDPOINT = "https://isveren.az/vacancy/";

        // Filter dəyişəndə
        $('#filterForm select, #filterForm input[type=checkbox]').on('change', function () {
            filterData = $('#filterForm').serialize();
            page = 1;
            disablePost = false;
            $(".data-wrapper").html(""); // Köhnə nəticələri sil
            infinteLoadMore(page); // filterlə datanı gətir
        });
        $('#filterFormMobile select, #filterFormMobile input[type=checkbox]').on('change', function () {
            filterData = $('#filterFormMobile').serialize();
            page = 1;
            disablePost = false;
            $(".data-wrapper").html(""); // Köhnə nəticələri sil
            infinteLoadMore(page); // filterlə datanı gətir
        });
        // Filter dəyişəndə
        $('#statusAndShortByForm select').on('change', function () {
            filterData = $('#statusAndShortByForm').serialize();
            page = 1;
            disablePost = false;
            $(".data-wrapper").html(""); // Köhnə nəticələri sil
            infinteLoadMore(page); // filterlə datanı gətir
        });

        // Axtaris dəyişəndə Deskop
        $(document).ready(function () {
            function triggerSearch() {
                filterData = $('#searchForm').serialize();
                page = 1;
                disablePost = false;
                $(".data-wrapper").html(""); // Köhnə nəticələri sil
                infinteLoadMore(page); // filterlə datanı gətir
            }

            // input dəyişdikdə
            $('#searchForm input[type=text]').on('change', function () {
                triggerSearch();
            });

            // form submit (Enter basıldıqda)
            $('#searchForm').on('submit', function (e) {
                e.preventDefault(); // URL dəyişməsinin qarşısını al
                triggerSearch();
            });
        });
        // Axtaris dəyişəndə Mobail
        $(document).ready(function () {
            function triggerSearch() {
                filterData = $('#searchFormMobile').serialize();
                page = 1;
                disablePost = false;
                $(".data-wrapper").html(""); // Köhnə nəticələri sil
                infinteLoadMore(page); // filterlə datanı gətir
            }

            // input dəyişdikdə
            $('#searchFormMobile input[type=text]').on('change', function () {
                triggerSearch();
            });

            // form submit (Enter basıldıqda)
            $('#searchFormMobile').on('submit', function (e) {
                e.preventDefault(); // URL dəyişməsinin qarşısını al
                triggerSearch();
            });
        });

        // Scroll zamanı data yüklə
        $(window).scroll(function () {
            if (!loading && !disablePost && $(window).scrollTop() + $(window).height() >= ($(document).height() - 1620)) {
                if (scrollTimeout) clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(function () {
                    loading = true;
                    page++;
                    infinteLoadMore(page);
                }, 100);
            }
        });

        // Data yükləmə funksiyası
        function infinteLoadMore(page) {
            let ajaxUrl = ENDPOINT + "?page=" + page;
            if (filterData) ajaxUrl += '&' + filterData;

            $.ajax({
                url: ajaxUrl,
                datatype: "html",
                type: "get",
                beforeSend: function () {
                    $('.auto-load').show();
                }
            }).done(function (response) {
                if (!response.jobs || response.jobs.data == '') {
                    $('.auto-load').html("Artıq məlumatlar tapılmadı");
                    disablePost = true;
                    return;
                }

                $('.auto-load').hide();
                $(".data-wrapper").append(response.html);
            }).fail(function () {
                console.log("Xəta baş verdi");
            }).always(function () {
                loading = false;
            });
        }

        // URL-dən parametr götürmək üçün köməkçi funksiya
        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }
    </script>
@elseif($page == 'home')
    <script>
        let filterData = '';
        let page = 1;
        let loading = false;
        let scrollTimeout;
        let disablePost = false;

        const ENDPOINT = "/";

        // Filter dəyişəndə
        $('#filterForm select, #filterForm input[type=checkbox]').on('change', function () {
            filterData = $('#filterForm').serialize();
            page = 1;
            disablePost = false;
            $(".data-wrapper").html(""); // Köhnə nəticələri sil
            infinteLoadMore(page); // filterlə datanı gətir
        });
        $('#filterFormMobile select, #filterFormMobile input[type=checkbox]').on('change', function () {
            filterData = $('#filterFormMobile').serialize();
            page = 1;
            disablePost = false;
            $(".data-wrapper").html(""); // Köhnə nəticələri sil
            infinteLoadMore(page); // filterlə datanı gətir
        });
        // Filter dəyişəndə
        $('#statusAndShortByForm select').on('change', function () {
            filterData = $('#statusAndShortByForm').serialize();
            page = 1;
            disablePost = false;
            $(".data-wrapper").html(""); // Köhnə nəticələri sil
            infinteLoadMore(page); // filterlə datanı gətir
        });

        // Axtaris dəyişəndə Deskop
        $(document).ready(function () {
            function triggerSearch() {
                filterData = $('#searchForm').serialize();
                page = 1;
                disablePost = false;
                $(".data-wrapper").html(""); // Köhnə nəticələri sil
                infinteLoadMore(page); // filterlə datanı gətir
            }

            // input dəyişdikdə
            $('#searchForm input[type=text]').on('change', function () {
                triggerSearch();
            });

            // form submit (Enter basıldıqda)
            $('#searchForm').on('submit', function (e) {
                e.preventDefault(); // URL dəyişməsinin qarşısını al
                triggerSearch();
            });
        });
        // Axtaris dəyişəndə Mobail
        $(document).ready(function () {
            function triggerSearch() {
                filterData = $('#searchFormMobile').serialize();
                page = 1;
                disablePost = false;
                $(".data-wrapper").html(""); // Köhnə nəticələri sil
                infinteLoadMore(page); // filterlə datanı gətir
            }

            // input dəyişdikdə
            $('#searchFormMobile input[type=text]').on('change', function () {
                triggerSearch();
            });

            // form submit (Enter basıldıqda)
            $('#searchFormMobile').on('submit', function (e) {
                e.preventDefault(); // URL dəyişməsinin qarşısını al
                triggerSearch();
            });
        });

        // Scroll zamanı data yüklə
        $(window).scroll(function () {
            if (!loading && !disablePost && $(window).scrollTop() + $(window).height() >= ($(document).height() - 1620)) {
                if (scrollTimeout) clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(function () {
                    loading = true;
                    page++;
                    infinteLoadMore(page);
                }, 100);
            }
        });

        // Data yükləmə funksiyası
        function infinteLoadMore(page) {
            let ajaxUrl = ENDPOINT + "?page=" + page;
            if (filterData) ajaxUrl += '&' + filterData;

            $.ajax({
                url: ajaxUrl,
                datatype: "html",
                type: "get",
                beforeSend: function () {
                    $('.auto-load').show();
                }
            }).done(function (response) {
                if (!response.jobs || response.jobs.data == '') {
                    $('.auto-load').html("Artıq məlumatlar tapılmadı");
                    disablePost = true;
                    return;
                }

                $('.auto-load').hide();
                $(".data-wrapper").append(response.html);
            }).fail(function () {
                console.log("Xəta baş verdi");
            }).always(function () {
                loading = false;
            });
        }

        // URL-dən parametr götürmək üçün köməkçi funksiya
        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }
    </script>
@elseif($page == 'company-details')
    <script>
        let filterData = '';
        let page = 1;
        let loading = false;
        let scrollTimeout;
        let disablePost = false;

        const ENDPOINT = "https://isveren.az/company-details/{{$company['id']}}";

        // Filter dəyişəndə
        $('#filterForm select, #filterForm input[type=checkbox]').on('change', function () {
            filterData = $('#filterForm').serialize();
            page = 1;
            disablePost = false;
            $(".data-wrapper").html(""); // Köhnə nəticələri sil
            infinteLoadMore(page); // filterlə datanı gətir
        });
        $('#filterFormMobile select, #filterFormMobile input[type=checkbox]').on('change', function () {
            filterData = $('#filterFormMobile').serialize();
            page = 1;
            disablePost = false;
            $(".data-wrapper").html(""); // Köhnə nəticələri sil
            infinteLoadMore(page); // filterlə datanı gətir
        });
        // Filter dəyişəndə
        $('#statusAndShortByForm select').on('change', function () {
            filterData = $('#statusAndShortByForm').serialize();
            page = 1;
            disablePost = false;
            $(".data-wrapper").html(""); // Köhnə nəticələri sil
            infinteLoadMore(page); // filterlə datanı gətir
        });

        // Axtaris dəyişəndə Deskop
        $(document).ready(function () {
            function triggerSearch() {
                filterData = $('#searchForm').serialize();
                page = 1;
                disablePost = false;
                $(".data-wrapper").html(""); // Köhnə nəticələri sil
                infinteLoadMore(page); // filterlə datanı gətir
            }

            // input dəyişdikdə
            $('#searchForm input[type=text]').on('change', function () {
                triggerSearch();
            });

            // form submit (Enter basıldıqda)
            $('#searchForm').on('submit', function (e) {
                e.preventDefault(); // URL dəyişməsinin qarşısını al
                triggerSearch();
            });
        });
        // Axtaris dəyişəndə Mobail
        $(document).ready(function () {
            function triggerSearch() {
                filterData = $('#searchFormMobile').serialize();
                page = 1;
                disablePost = false;
                $(".data-wrapper").html(""); // Köhnə nəticələri sil
                infinteLoadMore(page); // filterlə datanı gətir
            }

            // input dəyişdikdə
            $('#searchFormMobile input[type=text]').on('change', function () {
                triggerSearch();
            });

            // form submit (Enter basıldıqda)
            $('#searchFormMobile').on('submit', function (e) {
                e.preventDefault(); // URL dəyişməsinin qarşısını al
                triggerSearch();
            });
        });

        // Scroll zamanı data yüklə
        $(window).scroll(function () {
            if (!loading && !disablePost && $(window).scrollTop() + $(window).height() >= ($(document).height() - 1620)) {
                if (scrollTimeout) clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(function () {
                    loading = true;
                    page++;
                    infinteLoadMore(page);
                }, 100);
            }
        });

        // Data yükləmə funksiyası
        function infinteLoadMore(page) {
            let ajaxUrl = ENDPOINT + "?page=" + page;
            if (filterData) ajaxUrl += '&' + filterData;

            $.ajax({
                url: ajaxUrl,
                datatype: "html",
                type: "get",
                beforeSend: function () {
                    $('.auto-load').show();
                }
            }).done(function (response) {
                if (!response.jobs || response.jobs.data == '') {
                    $('.auto-load').html("Artıq məlumatlar tapılmadı");
                    disablePost = true;
                    return;
                }

                $('.auto-load').hide();
                $(".data-wrapper").append(response.html);
            }).fail(function () {
                console.log("Xəta baş verdi");
            }).always(function () {
                loading = false;
            });
        }

        // URL-dən parametr götürmək üçün köməkçi funksiya
        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }
    </script>
@elseif($page == 'cv')
    <script>
        let filterData = '';
        let page = 1;
        let loading = false;
        let scrollTimeout;
        let disablePost = false;

        const ENDPOINT = "https://isveren.az/cv/";

        // Filter dəyişəndə
        $('#filterForm select, #filterForm input[type=checkbox]').on('change', function () {
            filterData = $('#filterForm').serialize();
            page = 1;
            disablePost = false;
            $(".data-wrapper").html(""); // Köhnə nəticələri sil
            infinteLoadMore(page); // filterlə datanı gətir
        });
        $('#filterFormMobile select, #filterFormMobile input[type=checkbox]').on('change', function () {
            filterData = $('#filterFormMobile').serialize();
            page = 1;
            disablePost = false;
            $(".data-wrapper").html(""); // Köhnə nəticələri sil
            infinteLoadMore(page); // filterlə datanı gətir
        });
        // Filter dəyişəndə
        $('#statusAndShortByForm select').on('change', function () {
            filterData = $('#statusAndShortByForm').serialize();
            page = 1;
            disablePost = false;
            $(".data-wrapper").html(""); // Köhnə nəticələri sil
            infinteLoadMore(page); // filterlə datanı gətir
        });

        // Axtaris dəyişəndə Deskop
        $(document).ready(function () {
            function triggerSearch() {
                filterData = $('#searchForm').serialize();
                page = 1;
                disablePost = false;
                $(".data-wrapper").html(""); // Köhnə nəticələri sil
                infinteLoadMore(page); // filterlə datanı gətir
            }

            // input dəyişdikdə
            $('#searchForm input[type=text]').on('change', function () {
                triggerSearch();
            });

            // form submit (Enter basıldıqda)
            $('#searchForm').on('submit', function (e) {
                e.preventDefault(); // URL dəyişməsinin qarşısını al
                triggerSearch();
            });
        });
        // Axtaris dəyişəndə Mobail
        $(document).ready(function () {
            function triggerSearch() {
                filterData = $('#searchFormMobile').serialize();
                page = 1;
                disablePost = false;
                $(".data-wrapper").html(""); // Köhnə nəticələri sil
                infinteLoadMore(page); // filterlə datanı gətir
            }

            // input dəyişdikdə
            $('#searchFormMobile input[type=text]').on('change', function () {
                triggerSearch();
            });

            // form submit (Enter basıldıqda)
            $('#searchFormMobile').on('submit', function (e) {
                e.preventDefault(); // URL dəyişməsinin qarşısını al
                triggerSearch();
            });
        });

        // Scroll zamanı data yüklə
        $(window).scroll(function () {
            if (!loading && !disablePost && $(window).scrollTop() + $(window).height() >= ($(document).height() - 1620)) {
                if (scrollTimeout) clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(function () {
                    loading = true;
                    page++;
                    infinteLoadMore(page);
                }, 100);
            }
        });

        // Data yükləmə funksiyası
        function infinteLoadMore(page) {
            let ajaxUrl = ENDPOINT + "?page=" + page;
            if (filterData) ajaxUrl += '&' + filterData;

            $.ajax({
                url: ajaxUrl,
                datatype: "html",
                type: "get",
                beforeSend: function () {
                    $('.auto-load').show();
                }
            }).done(function (response) {
                if (!response.cv || response.cv.data == '') {
                    $('.auto-load').html("Artıq məlumatlar tapılmadı");
                    disablePost = true;
                    return;
                }

                $('.auto-load').hide();
                $(".data-wrapper").append(response.html);
            }).fail(function () {
                console.log("Xəta baş verdi");
            }).always(function () {
                loading = false;
            });
        }

        // URL-dən parametr götürmək üçün köməkçi funksiya
        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }
    </script>
@elseif($page == 'companies')
    <script>
        let filterData = '';
        let page = 1;
        let loading = false;
        let scrollTimeout;
        let disablePost = false;

        const ENDPOINT = "https://isveren.az/companies/";

        // Filter dəyişəndə
        /*$('#filterForm select, #filterForm input[type=checkbox]').on('change', function () {
            filterData = $('#filterForm').serialize();
            page = 1;
            disablePost = false;
            $(".data-wrapper").html(""); // Köhnə nəticələri sil
            infinteLoadMore(page); // filterlə datanı gətir
        });*/
        // Filter dəyişəndə
        $('#statusAndShortByForm select').on('change', function () {
            filterData = $('#statusAndShortByForm').serialize();
            page = 1;
            disablePost = false;
            $(".data-wrapper").html(""); // Köhnə nəticələri sil
            infinteLoadMore(page); // filterlə datanı gətir
        });

        // Axtaris dəyişəndə Deskop
        $(document).ready(function () {
            function triggerSearch() {
                filterData = $('#searchForm').serialize();
                page = 1;
                disablePost = false;
                $(".data-wrapper").html(""); // Köhnə nəticələri sil
                infinteLoadMore(page); // filterlə datanı gətir
            }

            // input dəyişdikdə
            $('#searchForm input[type=text]').on('change', function () {
                triggerSearch();
            });

            // form submit (Enter basıldıqda)
            $('#searchForm').on('submit', function (e) {
                e.preventDefault(); // URL dəyişməsinin qarşısını al
                triggerSearch();
            });
        });
        // Axtaris dəyişəndə Mobail
        $(document).ready(function () {
            function triggerSearch() {
                filterData = $('#searchFormMobile').serialize();
                page = 1;
                disablePost = false;
                $(".data-wrapper").html(""); // Köhnə nəticələri sil
                infinteLoadMore(page); // filterlə datanı gətir
            }

            // input dəyişdikdə
            $('#searchFormMobile input[type=text]').on('change', function () {
                triggerSearch();
            });

            // form submit (Enter basıldıqda)
            $('#searchFormMobile').on('submit', function (e) {
                e.preventDefault(); // URL dəyişməsinin qarşısını al
                triggerSearch();
            });
        });

        // Scroll zamanı data yüklə
        $(window).scroll(function () {
            if (!loading && !disablePost && $(window).scrollTop() + $(window).height() >= ($(document).height() - 1620)) {
                if (scrollTimeout) clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(function () {
                    loading = true;
                    page++;
                    infinteLoadMore(page);
                }, 100);
            }
        });

        // Data yükləmə funksiyası
        function infinteLoadMore(page) {
            let ajaxUrl = ENDPOINT + "?page=" + page;
            if (filterData) ajaxUrl += '&' + filterData;

            $.ajax({
                url: ajaxUrl,
                datatype: "html",
                type: "get",
                beforeSend: function () {
                    $('.auto-load').show();
                }
            }).done(function (response) {
                if (!response.companies || response.companies.data == '') {
                    $('.auto-load').html("Artıq məlumatlar tapılmadı");
                    disablePost = true;
                    return;
                }

                $('.auto-load').hide();
                $(".data-wrapper").append(response.html);
            }).fail(function () {
                console.log("Xəta baş verdi");
            }).always(function () {
                loading = false;
            });
        }

        // URL-dən parametr götürmək üçün köməkçi funksiya
        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }
    </script>
@endif
