@extends('layouts.app')
@section('content')
    @include('layouts._userNavbar')

    @if(!count($transactions))
        <div class="card text-center">
            <div class="card-header">
            </div>
            <div class="card-body">
                <h5 class="card-title">No transaction</h5>
                <p class="card-text">
                    <a href="{{route('transaction.create')}}">
                        Add transaction
                    </a>
                </p>
            </div>
        </div>
        @else
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
                                    <th scope="col">Transaction ID</th>
                                    <th scope="col"> Category</th>
                                    <th scope="col"> Amount</th>
                                    <th scope="col"> Note </th>
                                    <th scope="col"> Transaction date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $transaction)
                                    <tr @if($transaction->category->type) class="table-success" @else class="table-danger" @endif>
                                        <th scope="row">{{$transaction->id}}</th>
                                        <td>{{$transaction->category->name ?? 'deleted category'}}</td>
                                        <td>$ {{ number_format($transaction->amount, 2)}}</td>
                                        <td>{{$transaction->note}}</td>
                                        <td>{{$transaction->created_at}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <?php echo $transactions->render(); ?>
                    </div>

                </div>
                <div class="card" style="width: 20%; float: right">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Total of income - $ {{ number_format($totalIncome, 2)}}</li>
                        <li class="list-group-item">Total of expenses - $ {{ number_format($totalExpense, 2)}}</li>
                        <li class="list-group-item"> Balance - $ {{ number_format($currentUser->balance, 2) }}</li>
                    </ul>
                </div>
            </div>

        </section>

        @endif

@stop