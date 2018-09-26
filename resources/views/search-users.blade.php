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
        body {
            background: #00464b url('https://images.pexels.com/photos/933149/pexels-photo-933149.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260');
        }

        img {
            height: 100px;
            width: 100px;
            opacity: 0.2;
        }

        #modalImage {
            opacity: 1;
            width: 100%;
            height: 450px;
        }

        .close {
            color: white;
            width: 20px;
            height: 30px;
        }

        tr:hover img {
            opacity: 1;
        }

        th {
            width: 140px;
            color: rgba(14, 108, 38, 0.87)
        }

        td {

            width: 140px;
            color: rgba(14, 108, 38, 0.87)

        }

        .m0 {
            margin: 0;
        }

        a:hover {
            background-color: #117a8b;
            color: white;
        }

        .center {
            text-align: center;
        }

        .followers {
            width: 300px;
        }

        .repo {
            width: 300px;
        }

        .errorMessage {
            color: red;
            font-size: 25px;
        }

        .margin-10 {
            margin-bottom: 10px;
        }

        .mini-cube {
            width: 100px;
        }

        .errorList {
            width: 1100px;
            text-align: center;
        }

        table {
            border-collapse: separate;
            border-spacing: 0px 10px;

        }

        .badge {
            background-color: rgba(0, 58, 64, 0.87);
            color: rgba(14, 108, 38, 0.87)
        }

        .my-btn {
            background-color: rgba(0, 45, 50, 0.87);
            color: rgba(14, 108, 38, 0.87);
        }

        .my-btn2 {
            border-color: #0e6c26;
            background-color: #1b1e21;
            color: rgba(14, 108, 38, 0.87);
        }

        .grenText {
            color: #0e6c26;
            font-size: 18px;
            font-weight: bold;
        }

        .my-input {
            border-color: #0e6c26;
            background-color: #1b1e21;
            color: rgba(14, 108, 38, 0.87);
        }

        .my-input:focus {
            border-color: #0e6c26;
            background-color: #1b1e21;
            color: rgba(14, 108, 38, 0.87);
        }

        .link {
            text-decoration: none;
            display: block;
        }

        .link:hover {
            background-color: #1b1e21;
            text-decoration: none;
        }

    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <form method="get" class="form-inline mb-4 mt-4 offset-1">

            <label class="grenText mr-4" for="username">Search Users in GitHub</label>
            <input type="text" class="form-control my-input mr-2" id="username" value=" {{request()->get('username')}}"
                   name="username"/>
            <label class="grenText mr-2" for="sort">Sort</label>
            <select name="sort" class="form-control my-input mr-4">
                <option value="followers">Followers</option>
                <option value="repositories" {{request()->get('sort')=='repositories'?'selected':''}}>Repositories
                </option>
                <option value="joined" {{request()->get('sort')=='joined'?'selected':''}}>Join</option>
                <option value="default" {{request()->get('sort')=='default'?'selected':''}}>Default</option>
                <label class="grenText mr-2" for="username">Location</label>
            </select>
            <label class="grenText mr-2" for="location">Location</label>
            <select name="location" class="form-control my-input mr-4" value="{{request()->get('location')}}" selected>
                <option value="" {{request()->get('location')==''?'selected':''}}>World</option>
                <option value="Armenia" {{request()->get('location')=='Armenia'?'selected':''}}>Armenia</option>
                <option value="USA" {{request()->get('location')=='USA'?'selected':''}}>USA</option>
                <option value="Russia" {{request()->get('location')=='Russia'?'selected':''}}>Russia</option>
            </select>
            <button class="btn my-btn2 ">Search</button>

        </form>
    </div>
    <div class="well">
        <table class="table-dark table-bordered ">
            @if($errorMessage)
                <td class="errorList "><p class="errorMessage">{{$errorMessage}}</p></td>
            @else
                <thead>
                <tr>
                    <th class="center ">UserAvatar</th>
                    <th class="center">UserName</th>
                    <th class="center followers">Folowers</th>
                    <th class="center">#</th>
                    <th class="center repo">Repository</th>
                    <th class="center">#</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($userArr as $userObj)

                    <tr class="margin-10">
                        <td class="center mini-cube"><img src="{{$userObj->avatar_url}}" class="avatar"
                                                          data-toggle="modal" data-target="#exampleModalLong" alt="">
                        </td>
                        <td class="center">
                            <p class="m0"> {{$userObj->login}}</p>
                            <span class="m0"> { {{$userObj->score}} }  </span>
                            <a class="link" href="{{$userObj->html_url}}" target="_blank">Show in GitHub</a>
                        </td>

                        <td class="followers   {{$userObj->login}}"></td>
                        <td class="center">
                            <a href="/get-followers/{{$userObj->login}}/1" class="btn my-btn followersShow"
                               data-name={{$userObj->login}}>ViewFollowers</a>
                        </td>
                        <td class="repo   {{$userObj->login.'-repos'}}"></td>
                        <td class="center ">
                            <a href="/get-repos/{{$userObj->login}}/1" class="btn my-btn reposShow"
                               data-name={{$userObj->login.'-repos'}}>GetRepo</a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            @endif
        </table>
        <div>
        </div>
    </div>

</div>
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     aria-hidden="true">
    <div class="modal-dialog" role="document">


        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <img id="modalImage" src="" alt="">

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
        var page = 0;
        var repoPage = 0;
        $('.followersShow').on('click', function (e) {
            e.preventDefault();


            var selector = e.target.attributes.getNamedItem('data-name').value;
            if (!($("." + selector + "> p.errorMessage").length)) {
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: $(this).attr('href'),
                    success: function (response) {
                        if (response.success) {
                            if (response.collection.length) {

                                e.toElement.innerHTML = 'LoadMore'
                                $.each(response.collection, function (index, value) {
                                    $("." + selector).append(
                                        " <a href='" + value['html_url'] + "' class='badge badge-info'  target='_blank'>" + value['login'] + "</a> ")
                                });
                                var basepage = e.target.href;
                                basepage = basepage.slice(0, -(page.toString().length));
                                page = ++response['page'];
                                basepage = basepage + page;
                                e.target.href = basepage;
                            } else {

                                $("." + selector).append('<p class="errorMessage center">No more Followers</p>')
                            }
                        } else {
                            if (response.validationMessage) {

                                alert(
                                    response.validationMessage['username'] ?
                                        response.validationMessage['username'] : response.validationMessage['page'])
                            } else
                                alert(response.message)
                        }
                    }
                })
            }
        })

        $('.reposShow').on('click', function (e) {
            e.preventDefault();
            var selector = e.target.attributes.getNamedItem('data-name').value;
            if (!($("." + selector + "> p.errorMessage").length)) {
                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    url: $(this).attr('href'),
                    success: function (response) {
                        if (response.success) {
                            if (response.repoArr.length) {

                                e.toElement.innerHTML = 'GetMore';
                                $.each(response.repoArr, function (index, value) {
                                    $("." + selector).append(
                                        "<a href='" + value['html_url'] + "' class='badge badge-info' title='" + value['description'] + "' target='_blank'>" + value['name'] + "</a> ")
                                });
                                var basepage = e.target.href;

                                basepage = basepage.slice(0, -(repoPage.toString().length));
                                repoPage = ++response['page'];
                                basepage = basepage + repoPage;
                                e.target.href = basepage;
                            } else {
                                $("." + selector).append('<p class="errorMessage center">No odher repository</p>')
                            }
                        } else {
                            if (response.validationMessage) {
                                alert(
                                    response.validationMessage['username'] ?
                                        response.validationMessage['username'] : response.validationMessage['page'])
                            } else
                                alert(response.message)
                        }


                    }


                })
            }
        })
        $('.avatar').on("click", function (e) {
            e.preventDefault();
            console.log()
            $('#modalImage').attr('src', $(this).attr('src'))
        })
    })
</script>
</body>
</html>