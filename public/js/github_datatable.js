window.onload = function () {

    var table = $('#githubTable').DataTable();
    $.fn.dataTable.ext.errMode = 'none';

    function sendToHistory() {
        $.post(searchAddUrl, $("#githubSearch").serialize())
            .fail(function(data) {
                var error = $('#errorAddSearch');
                $('#errorAddSearch span').text(data.responseJSON.message)
                error.show(500);
                setTimeout(function() {
                    error.hide(500);
                }, 4000);
            });
    }

    function buildTable(owner, repo) {
        table.destroy();
        table = $('#githubTable').DataTable({
            ajax: {
                url: 'https://api.github.com/repos/' + owner + '/' + repo + '/stats/contributors',
                dataSrc: function(data) {
                    //workaround callback success
                    sendToHistory();
                    return data;
                }
            },
            "order": [[2, "desc"]],
            columns: [
                {data: 'author.avatar_url'},
                {data: 'author.login'},
                {data: 'total'}
            ],
            columnDefs: [
                {
                    "targets": 0,
                    "data": 'author.avatar_url',
                    "sortable": false,
                    "render": function (data, type, full, meta) {
                        return "<img class='img-rounded dataTable-avatar' src='" + data + "' alt='" + full.author.login + "' title='" + full.author.login + "'>"
                    }
                },
                {
                    "targets": 1,
                    "data": 'author.login',
                    "render": function (data, type, full, meta) {
                        return "<a href='" + full.author.url + "'>" + data + "</a>"
                    }
                }
            ]
        }).on('error.dt', function (e, settings, techNote, message) {
            showError();
            table.destroy();
            table = $('#githubTable').DataTable();
        }).on('success.dt', function() {
            console.log('fdsfsd');
        });
    }

    function prepareSearchValue(value) {
        var valueParts = value.trim().split("/");
        $("#errorSearch").hide();
        if (valueParts.length !== 2) {
            showError();
            return false;
        }
        var owner = valueParts[0],
            repo = valueParts[1];

        return {owner: owner, repo: repo};
    }

    function submitAction() {
        $("#errorSearch").hide();
        var searchForm = $("#githubSearch").serializeArray(),
            data = searchForm[0].value,
            value = prepareSearchValue(data);

        if (value) {
            buildTable(value.owner, value.repo);
        }
    }

    var search = getUrlParameter('repo_search');
    if (search) {
        $("#repo_search").val(search)
        submitAction();
    }

    $('#githubSearch').on('submit', function (e) {
        e.preventDefault();
        submitAction();
    })
};