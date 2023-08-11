@extends('layout')

@section('head')
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
@endsection


@section('main')

<main class="container" style="background-color:#fff;" >

    <section id="contact-us">
        <h1 style="padding-top: 50px; ">Create New Post</h1>
         @if (Session::has('success'))
           <p style="width: 100%; color:#fff; background-color:green; text-align:center; font-size:20px; font-weight:600;  padding:5px;margin-bottom:5px; ">
            {{Session::get('success')}}
          </p>
         @endif
          <!-- Blog Form -->
          <div class="contact-form">
            <form action="{{ route('blog.store')}}" method="post" enctype="multipart/form-data">
              @csrf
              <!-- Name -->
              <label for="title"><span>Title</span></label>
              <input type="text" id="title" name="title" value="{{old('title')}}" />
              @error('title')
               <p style="color:red; margin-bottom:25px;">{{$message}}</p> 
              @enderror

              {{-- dropDown --}}
              <label for="category">Category</label>
              <select id="categories" name="category_id">
                <option selected disabled>Select Category</option>
                @foreach ($categories as $category )
                <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
              </select>
              @error('category_id')
              <p style="color:red; margin-bottom:25px;">{{$message}}</p> 
             @enderror
  
              <!-- Email -->
              <label for="image"><span>Image</span></label>
              <input type="file" id="image" name="image" value="" />
              @error('image')
              <p style="color:red; margin-bottom:25px;">{{$message}}</p>
                
              @enderror
  
              <!-- Subject -->
              <label for="body"><span>Body</span></label>
              <textarea id="body" name="body">{{old('body')}}</textarea>
              @error('body')
              <p style="color:red; margin-bottom:25px;">{{$message}}</p>
                
              @enderror  
  
               <!-- Button -->
              <input type="submit" value="Submit" />
            </form>
          </div>
    </section>
</main>
    
@endsection


@section('script')

<script>   // create-blog-post
  CKEDITOR.replace( 'body' );
  </script>
    
@endsection