@extends('layout');


@section('main')
  
   <!-- main -->
   <main class="container">
    <h2 class="header-title">All Blog Posts</h2>
    
    @include('includes.flash-message')

    
    <div class="searchbar" style="display: flex; justify-content:space-evenly; margin:20px;">
      <button type="button" onclick="window.location.href='{{ route("blog") }}' " >Reset</button>
      <form action="">
        <input type="text" placeholder="Search..." name="search" />

        <button type="submit">
          <i class="fa fa-search"></i>
        </button>

      </form>
    </div>
    <div class="categories">
      @if ($categories->isNotEmpty())
      <ul>
        @foreach ( $categories as $category )

        <li><a href="{{ route('blog',['category' =>$category->name ])}}">{{ $category->name}}</a></li>
        
        @endforeach
       
      </ul>
      @endif
      
    </div>
    <section class="cards-blog latest-blog">
      @if ($posts->isNotEmpty())
      @foreach ( $posts as $post )
      
      <div class="card-blog-content">
        
        @auth {{--if someone is logged in so it will shows an edit and delete button --}}
        @if (auth()->user()->id === $post->user->id)
          
        <div class="post-buttons" style="display: flex;">
          <a href="{{ route('blog.edit',$post)}}" style="color:white; background-color:green; padding:8px; margin:2px;">
            edit
          </a>
          {{-- <a href="" onclick="deletePost({{$post->id}})" style="color:white; background-color:red; padding:8px; margin:2px;">
            delete
          </a> --}}
          <form action="{{ route('blog.delete',$post)}}" method="post" onsubmit="return confirm('Are you sure you want to delete this post?');">
            @csrf
            @method('delete')
            <input type="submit" value="Delete" style="color:white; background-color:red; padding:8px; margin:2px;"/>
          </form>
        </div>
        
        @endif
        @endauth
        <img src="{{ asset($post->imagePath)}}" alt="" />
        <p>
          {{$post->created_at->diffForHumans()}}
          <span>Written By {{$post->user->name}}</span>
        </p>
        <h4>
          <a href="{{route('singleBlog',$post)}}">{{$post->title}}</a>
        </h4>
      </div>
      @endforeach
        
      @endif
      


    </section>
    

      {{ $posts->links('pagination::default') }}   {{--changing in directory views->vendor->pagination->default.blade --}}

  </main>
    
@endsection

@section('script')

{{-- <script type="text/javascript"> --}}

{{-- // function deletePost(id){
//   // alert(id);
//   var url = '{{route("blog.delete","ID")}}';
//  var newUrl = url.replace("Id",id);
//  if(confirm("Are you sure you want to delete this post?")){
//   $.ajax({
//     url: newUrl,
//     type: 'delete',
//     data:{},
//     dataType: 'json',
//     headers: {
//       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content');
//     },
//     success: function(response){
       
//       if(response['status']== true){
//         window.location.href = "route('blog')";
//       }

//     }
//   });

//  }

// } --}}

{{-- </script> --}}
  
@endsection