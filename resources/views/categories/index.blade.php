@extends('layout');


@section('main')

<div class="categories-list" style="background-color:white; color:gray; height:100%;">
    <h1 style="text-align:center; font-size:30px; padding:20px; ">
        Category List
    </h1>
    
    @include('includes.flash-message')
    
    @if ($categories->isNotEmpty())
        
    @foreach ( $categories as $category )

    <div class="item" style="display: flex; justify-content:center;  padding:8px;">
        <p>{{$category->name}}</p>
        <div style="margin-top:5px;">
            <a href="{{ route('categories.edit',$category->id)}}" style="margin:8px; background:green; color:white; padding:5px;">Edit</a>
        </div>
        <form action="{{ route('categories.destroy',$category->id)}}" method="post" onsubmit="return confirm('Are you sure you want to delete this category');">
           @csrf
           @method('delete')
            <input type="submit" value="Delete" style="background:red; color:white; padding:5px;"/>
        </form>

       

    </div>

    @endforeach 
    @endif
    <div class="create-categories" style="text-align:center; margin-top:20px;">
        <a href="{{ route('categories.create') }}" style="color:chocolate; margin:7px;">Create Category<span>&#8594;</span></a>
      </div>
</div>
    
@endsection