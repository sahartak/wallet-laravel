<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$title}}</div>
                <div class="card-body">
                    <form method="POST" action='{{ route("transaction.$action") }}'>
                        @csrf
                        <div class="form-group row">
                            <label for="category_id" class="col-md-4 col-form-label text-md-right">Category</label>

                            <div class="col-md-6">
                                @if($categories)
                                    <select id="category_id" name="category_id"
                                            class="form-control @error('category_id') is-invalid @enderror">
                                        @foreach($categories as $id => $name)
                                            <option data-type="{{$categoryTypes[$id]}}" @if(old('category_id') == $id ) selected @endif value="{{$id}}">{{$name}}</option>
                                        @endforeach
                                    </select>
                                @endif
                                <a href="{{ route('category.create')}}" target="_blank">Add category</a>
                                @error('category_id')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="transaction_amount" class="col-md-4 col-form-label text-md-right">Amount</label>

                            <div class="col-md-6">
                                <input id="transaction_amount" type="number" min="1"
                                       class="form-control @error('amount') is-invalid @enderror" name="amount"
                                       value="{{ old('amount') }}" autocomplete="false">
                                @error('amount')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="note" class="col-md-4 col-form-label text-md-right">Note</label>

                            <div class="col-md-6">
                                <textarea id="note" class="form-control @error('note') is-invalid @enderror" name="note">{{ old('note') }}
                                </textarea>
                                @error('note')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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