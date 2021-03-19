<?php


namespace App\Http\Controllers\Post;


use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController
{
    public function list()
    {
        $posts = Post::with('category','user','tags')->paginate(10);
        $page = 'posts/';

        return view('post.table', compact('posts', 'page'));
    }

    public function author(User $user)
    {
        $posts = $user->posts()->paginate(10);
        $page = 'posts/author/' . $user->id;

        return view('pages.index', compact('posts', 'page'));
    }

    public function category(Category $category)
    {
        $posts = $category->posts()->paginate(10);
        $page = 'posts/category/' . $category->id;

        return view('pages.index', compact('posts', 'page'));
    }

    public function tag(Tag $tag)
    {
        $posts = $tag->posts()->paginate(10);
        $page = 'posts/tag/' . $tag->id;

        return view('pages.index', compact('posts', 'page'));
    }

    public function authorAndCategory($author, $category)
    {
        $posts = Post::whereHas('user', function (\Illuminate\Database\Eloquent\Builder $query) use ($author, $category) {
            $query->where('user_id', '=', $author);
            $query->where('category_id', '=', $category);
        })->paginate(10);

        $page = 'posts/author/' . $author . '/category/' . $category;
        return view('pages.index', compact('posts', 'page'));
    }

    public function authorAndCategoryAndTag($author, $category, $tag)
    {
        $posts = Post::whereHas('tags', function (\Illuminate\Database\Eloquent\Builder $query) use ($author, $category, $tag) {
            $query->where('user_id', '=', $author);
            $query->where('category_id', '=', $category);
            $query->where('tag_id', '=', $tag);

        })->paginate(10);

        $page = 'posts/author/' . $author . '/category/' . $category . '/tag/' . $tag;
        return view('pages.index', compact('posts', 'page'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('post.form', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required', 'min:5', 'unique:posts,title'],
            'body'        => ['required', 'min:5'],
            'category_id' => ['required', 'exists:categories,id'],
            'tags'        => ['required', 'exists:tags,id'],
        ]);

        $data['user_id'] = Auth::id();
        $post = Post::create($data);
        $post->tags()->attach($data['tags']);

        return redirect()->route('posts')->with('success', "Post \"{$post->title}\" successfully saved");
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $tag_ids = $post->tags->pluck('id')->toArray();

        return view('post.form', compact('categories', 'tags', 'post', 'tag_ids'));
    }

    public function update(Post $post, Request $request)
    {
        $data = $request->validate([
            'title'       => ['required', 'min:5', 'unique:posts,title,' . $post->id],
            'body'        => ['required', 'min:5'],
            'category_id' => ['required', 'exists:categories,id'],
            'tags'        => ['required', 'exists:tags,id'],
        ]);

        $post->update($data);
        $post->tags()->sync($data['tags']);

        return redirect()->route('posts')->with('success', "Post \"{$post->title}\" successfully saved");
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts')->with('success', "Post \"{$post->title}\" successfully deleted");
    }
}
