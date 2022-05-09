@extends('layout')

@section('title')
    Create new user
@endsection

@section('content')
    @parent

    <div class="alerts"></div>

    <form id="userCreateForm" class="col-md-7 col-lg-8"
          method="post" enctype="multipart/form-data"
    >
        <div class="row">

            <div class="form-group col-md-6">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Name">
            </div>
            <div class="form-group col-md-6">
                <label for="phone">Phone</label>
                <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone">
            </div>
            <div class="form-group col-md-6">
                <label for="email">Email address</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Email">
            </div>

            <div class="form-group col-md-6">
                <label for="position">Position</label>
                <select id="positions" class="form-control" name="position_id"></select>
            </div>

            <div class="form-group col-md-12">
                <label for="photo">Photo</label>
                <input type="file" id="photo" name="photo">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
        </div>
    </form>


    <script src="{{ asset('js/api.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/alert-manager.js') }}" type="text/javascript"></script>
    <script>

        document.addEventListener('DOMContentLoaded', function(){
            let alertManager = new AlertManager('alerts');
            let positionList = document.getElementById('positions');

            API.getPositions('/api/positions/',
                function (data) {
                    data.positions.forEach(function (position) {
                        var option = document. createElement("option");
                        option.innerHTML = position.name;
                        option.setAttribute('value', position.id);
                        positionList. appendChild(option);
                    });
                },
                function (error) {
                    alertManager.addAlert(error.message,'danger');
                });


            let form = document.getElementById('userCreateForm');
            form.addEventListener('submit', async function (e) {

                e.preventDefault();

                alertManager.clearAll();

                const result = await API.createToken('/api/token/');
                if(!result.success)
                {
                    alertManager.addAlert(result.message,'danger');
                    return;
                }

                let formData = new FormData(form);

                API.createUser('/api/users', {
                    method: 'POST', body: formData, headers: {
                        'Token': result.token,
                    },
                }, function (data) {
                    alertManager.addAlert(data.message,'success');
                }, function (data) {
                    alertManager.addAlert(data.message,'danger');
                    if(data.hasOwnProperty('fails'))
                    {
                        for (var key in data.fails) {
                            var message = data.fails[key];
                            alertManager.addAlert(message,'danger');
                        }
                    }
                });
            });
        });

    </script>
@endsection

