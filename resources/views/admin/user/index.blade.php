@extends('layouts.app', ['title' => 'Users'])
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    @if(session()->get('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                </div>
                <div class="col-12">
                    <div class="card">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Image</th>
                                <th scope="col"> Name</th>
                                <th scope="col"> Email</th>
                                <th scope="col"> Phone</th>
                                <th scope="col"> Birthdate</th>
                                <th scope="col"> Balance</th>
                                <th scope="col"> Total income</th>
                                <th scope="col"> Total expenses</th>
                                <th scope="col"> Registered date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <th scope="row">{{$user->id}}</th>
                                    <td>
                                        <img width="100" src="{{$user->getUserImageUrl()}}">
                                    </td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->phone}}</td>
                                    <td>{{$user->birthdate}}</td>
                                    <td>$ {{number_format($user->balance, 2)}}</td>
                                    <td>$ {{number_format($user->transactionsSum(\App\Models\Category::TYPE_INCOME), 2)}}</td>
                                    <td>$ {{number_format($user->transactionsSum(\App\Models\Category::TYPE_EXPENSE), 2)}}</td>
                                    <td>{{$user->created_at}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <?php echo $users->render(); ?>
                </div>

            </div>
        </div>
    </section>
@stop