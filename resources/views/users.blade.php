
@extends('layout')

@section('styles')
    @parent

    <link href="{{ asset('css/user-card.css') }}" rel="stylesheet">

    <style>
        .users-list{
            padding:0;
        }
        .users-list li{
            list-style:none;
        }

        .algn-center{
            text-align: center;
        }
    </style>

@endsection

@section('title')
    All users
@endsection

@section('content')
    @parent

    <div class="alerts"></div>

    <ul id="users" class="row users-list">

    </ul>
    <div class="algn-center">
        <button id="btnShowMore" type="button" class="btn btn-default" >Показать еще</button>
    </div>


    <script src="{{ asset('js/api.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/alert-manager.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/users-list.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/user-list-item.js') }}" type="text/javascript"></script>
    <script>

        document.addEventListener('DOMContentLoaded', function(){
            let usersList = new UsersList('users');
            let alertManager = new AlertManager('alerts');

            UsersLoader
                .setUrl('/api/users')
                .setPage(1)
                .setCount(6)
                .onSuccess(function (data) {
                    data.users.forEach(function (user) {
                        usersList. appendChild(user);
                    });
                    UsersLoader.setPage(UsersLoader.getPage() + 1);
                })
                .onFail(function (error) {
                    alertManager.addAlert(error.message,'danger');
                })
                .loadMore();


            let btn = document.getElementById('btnShowMore');
            btn.addEventListener('click', function () {

                alertManager.clearAll();

                UsersLoader.loadMore();
            });
        });

        class UsersLoader
        {
            static page;
            static count;
            static offset;
            static url;
            static callbackSuccess;
            static callbackFail;

            static onSuccess(callback)
            {
                this.callbackSuccess = callback;
                return this;
            }

            static onFail(callback)
            {
                this.callbackFail = callback;
                return this;
            }

            static prepareUrl()
            {
                let url = this.page ? this.url + '?page=' + this.page : this.url;
                url = this.count ? url + '&count=' + this.count : url;
                return this.offset ? url + '&offset=' + this.offset : url;
            }

            static loadMore()
            {
                let url = this.prepareUrl();
                API.getUsers(url, this.callbackSuccess, this.callbackFail, this.page);
            }

            static setUrl(url)
            {
                this.url = url;
                return this;
            }

            static setPage(page)
            {
                this.page = page;
                return this;
            }

            static getPage()
            {
                return this.page;
            }

            static setCount(count)
            {
                this.count = count;
                return this;
            }

            static setOffset(offset)
            {
                this.offset = offset;
                return this;
            }
        }

    </script>
@endsection
