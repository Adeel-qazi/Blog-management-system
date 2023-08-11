<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Console\View\Components\Confirm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class BlogController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']); // we made apply a security check on every method except the index method because someone can see posts without authentication card 
    }

    public function index(Request $request)
    {

        if (!empty($request->get('search'))) {
            $posts = Post::where('title', 'like', '%' . $request->get('search') . '%')
                ->orWhere('body', 'like', '%' . $request->get('search') . '%')->latest()->paginate(4);


        } elseif (!empty($request->get('category'))) { // post would be related to category
            $posts = Category::where('name', $request->get('category'))->firstOrFail()->posts()->paginate(3)->withQueryString();

        } else {
            $posts = Post::latest()->paginate(4);
        }


        $categories = Category::all();

        $data['posts'] = $posts;
        $data['categories'] = $categories;
        return view('blogPosts.blog', $data);
    }


    public function create()
    { // route model binding
        $categories = Category::all();
        $data['categories'] = $categories;
        return view('blogPosts.create-blog-post', $data);
    }

    public function store(Request $request)
    {

        if (Post::latest()->first() !== null) {

            $postId = Post::latest()->first()->id + 1;
        } else {
            $postId = 1;
        }

        $data = [
            'title' => 'required',
            'image' => 'required|image',
            'body' => 'required',
            'category_id' => 'required'
        ];


        $validator = Validator::make($request->all(), $data);

        if ($validator->passes()) {
            $product = new Post();
            $product->title = $request->title;
            $product->slug = Str::slug($product->title, '-') . '-' . $postId;
            $product->user_id = Auth::user()->id;
            $product->category_id = $request->category_id;
            $product->body = $request->body;
            $product->imagePath = 'storage/' . $request->file('image')->store('postImages', 'public');
            $product->save();

            $request->session()->flash('success', 'Post created successfully');

            return redirect()->back();
        }

    }

    public function edit(Post $post)
    {
        if (auth()->user()->id !== $post->user->id) { // when other user will try to edit to someone's post so it will get an error
            abort(403);
        }
        // $post = Post::where('slug',$slug)->first();

        $data['post'] = $post;
        return view('blogPosts.edit', $data);
    }


    public function update(Request $request, Post $post)
    { // route model binding
        if (auth()->user()->id !== $post->user->id) { // when other user will try to update to someone's post so it will get an error
            abort(403);
        }

        $data = [
            'title' => 'required',
            'image' => 'required',
            'body' => 'required'
        ];


        $validator = Validator::make($request->all(), $data);

        $postId = $post->id;

        if ($validator->passes()) {
            $post->title = $request->title;
            $post->slug = Str::slug($post->title, '-') . '-' . $postId;
            $post->body = $request->body;
            $post->imagePath = 'storage/' . $request->file('image')->store('postImages', 'public');
            $post->save();

            $request->session()->flash('success', 'Post updated successfully');

            return redirect()->back();
        }

    }


    public function destroy(Request $request, Post $post)
    {

        $post->delete();
        $request->session()->flash('success', 'Post deleted successfully');

        return redirect()->back();
    }

    public function show(Post $post)
    { // route model binding
        $category = $post->category;
        $relatedPosts = $category->posts()
            ->where('id', '!=', $post->id)
            ->latest()->take(3)->get();       // elequont relationship

        $data['post'] = $post;
        $data['relatedPosts'] = $relatedPosts;
        return view('blogPosts.singleBlog', $data);
    }
}