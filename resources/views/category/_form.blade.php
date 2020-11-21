<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$title}}</div>
                <div class="card-body">
                    <form method="POST" action='{{ route("category.$action", $category->id) }}'>
                        @if( $action == 'update')
                            @method('PATCH')
                        @endif
                        @csrf
                        <div class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">Type</label>

                            <div class="col-md-6">
                                    <select id="type" name="type"
                                            class="form-control @error('type') is-invalid @enderror">
                                        @foreach(\App\Models\Category::TYPES as $type => $typeName)
                                            <option
                                                    @if( old('type') == $type || $category->type == $type ) selected @endif
                                                    value="{{$type}}"> {{$typeName}}
                                            </option>
                                        @endforeach
                                    </select>
                                @error('type')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="name" class="form-control @error('name') is-invalid @enderror" name="name"
                                       value="{{ old('name', $category->name) }}" autocomplete="false">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('category.index')}}" target="_blank">My categories</a>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>