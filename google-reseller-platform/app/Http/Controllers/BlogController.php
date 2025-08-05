<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of published blog posts.
     */
    public function index()
    {
        $posts = Post::with(['author', 'category'])
            ->published()
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        $categories = Category::withCount('posts')->get();

        return view('blog.index', compact('posts', 'categories'));
    }

    /**
     * Display the specified blog post.
     */
    public function show(Post $post)
    {
        if ($post->status !== 'published' || $post->published_at > now()) {
            abort(404);
        }

        $relatedPosts = Post::with(['author', 'category'])
            ->published()
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->limit(3)
            ->get();

        return view('blog.show', compact('post', 'relatedPosts'));
    }

    /**
     * Display posts by category.
     */
    public function category(Category $category)
    {
        $posts = Post::with(['author', 'category'])
            ->published()
            ->where('category_id', $category->id)
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        $categories = Category::withCount('posts')->get();

        return view('blog.category', compact('posts', 'categories', 'category'));
    }
}
