<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task 1</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
</head>
<body>
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Products</h2>
            </div>
            <div class="pull-right mb-2">
                <a class="btn btn-success" href="{{ route('products.create') }}"> Create New Product</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>S.No</th>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Description</th>
            <th>Comments</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($products as $product)


            <tr>
                <td>{{ $product->id }}</td>
                <td><img src="{{ Storage::url($product->image) }}" height="75" width="75" alt="" /></td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->description }}</td>

                <td>@foreach($product->comments as $comment)
                        {{ $comment->message }}
                   @endforeach
                <td>
                    <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                        <a class="btn btn-primary" href="{{ route('products.edit',$product->id) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <form action="{{ route('comments.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <h2>Add Comment</h2>
                                <div class="form-group">
                                    <strong> Name:</strong>
                                    <input type="text" name="name" class="form-control" placeholder=" Name">
                                    @error('name')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">


                                <div class="form-group">
                                    <strong>Message:</strong>
                                    <textarea class="form-control" style="height:150px" name="message" placeholder="Message"></textarea>
                                    <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                    @error('message')
                                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary ml-3">Submit</button>
                        </div>

                    </form>

                </td>
            </tr>

        @endforeach
    </table>

{!! $products->links() !!}

    <table class="table table-bordered">
        <tr>
            <th>S.No</th>
            <th>Name</th>
            <th>Price</th>
            <th>Product name</th>
        </tr>

        @php
            $i = 1;
        @endphp

        @foreach ($comments as $comment)
            <tr>
                <td>{{ $i}}</td>
                <td>{{ $comment->name }}</td>
                <td>{{ $comment->message }}</td>
                <td>{{ $comment->product->name }}</td>
            </tr>
            @php
                $i++;
            @endphp
        @endforeach
    </table>
</body>
</html>
