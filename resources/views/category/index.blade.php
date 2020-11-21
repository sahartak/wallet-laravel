@extends('layouts.app')
@section('content')
    @include('layouts._userNavbar')

    @if(!count($categories))
        <div class="card text-center">
            <div class="card-header">
            </div>
            <div class="card-body">
                <h5 class="card-title">No Category</h5>
                <p class="card-text">
                    <a href="{{route('category.create')}}">
                        Add category
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
                            @if(session()->get('error'))
                                <div class="alert alert-danger">
                                    {{ session()->get('error') }}
                                </div>
                            @endif
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">Category ID</th>
                                    <th scope="col"> Name</th>
                                    <th scope="col"> Type</th>
                                    <th scope="col"> Creation date </th>
                                    <th scope="col"> Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <th scope="row">{{$category->id}}</th>
                                        <td>{{$category->name}}</td>
                                        <td>{{ \App\Models\Category::TYPES[$category->type]}}</td>
                                        <td>{{$category->created_at}}</td>
                                        @if($category->user_id == \Illuminate\Support\Facades\Auth::user()->id )
                                            <td class="text-center">
                                                <form action="{{ route('category.destroy',$category->id) }}" method="POST">
                                                    <a class="btn btn-primary" href="{{route('category.edit', $category->id)}}">Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="delete-icon btn btn-danger" data-target="#confirm-delete" onclick="return confirm('Are you sure you want remove {{$category->name}} ?')">Delete</button>
                                                </form>
                                            </td>
                                        @else
                                            <td> </td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <?php echo $categories->render(); ?>
                    </div>

                </div>
            </div>

        </section>
        @endif

@stop