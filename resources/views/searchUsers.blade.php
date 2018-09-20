<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
        img {
            height: 100px;
            width: 100px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row offset-1">
        <form method="get">
            <input type="text" class="col-5" name="searchName"/>
            <button class="btn btn-success ">Search</button>
            <div class="well">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>UserName</th>
                        <th>Folowers</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($userArr as $userObj)
                        <tr>
                            <td><img style="height: 100px;width: 100px" src="{{$userObj['avatar_url']}}" alt=""></td>
                            <td>{{$userObj['login']}}</td>
                            <td>
                                <a href="/getfollowers/{{$userObj['login']}}/1" class="btn btn-info followersShow"
                                   data-name={{$userObj['login']}}>LoadFollowers</a>
                            </td>
                            <td class="followers {{$userObj['login']}}"></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div>
                </div>
            </div>

        </form>


    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {
        var dataValue = $(".followers").data("name");
        var page = 0;
        $('.followersShow').on('click', function (e) {

            $.ajax({
                type: "GET",
                dataType: "json",
                url: $(this).attr('href'),
                success: function (response) {
                    if (response.success) {
                        if (response.collection.length) {
                            page = ++response['page'];
                            var selector = e.target.attributes.getNamedItem('data-name').value;
                            $.each(response.collection, function (index, value) {
                                $("." + selector).append("<span class='badge badge-primary'>" + value['login'] + "</span> ")
                            })
                            var basepage = e.target.href
                            basepage = basepage.slice(0, -1);
                            page = basepage + page;
                            e.target.href = page;
                        } else {
                            alert('No more followers');
                        }
                    } else {
                        alert(response.message)
                    }
                }
            })
            return false;
        })
    })
</script>
</body>
</html>