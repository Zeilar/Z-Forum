<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push(__('Home'), route('index'));
});

// Home > [Table category]
Breadcrumbs::for('category', function ($trail, $category) {
    $trail->parent('home');
    $trail->push($category->title, route('category_show', [$category->id, $category->slug]));
});

// Home > [Table category] > [Table subcategory]
Breadcrumbs::for('subcategory', function ($trail, $subcategory) {
    $trail->parent('category', $subcategory->category);
    $trail->push($subcategory->title, route('subcategory_show', [$subcategory->id, $subcategory->slug]));
});

// Home > [Table category] > [Table subcategory] > [Thread]
Breadcrumbs::for('thread', function ($trail, $thread) {
    $trail->parent('subcategory', $thread->subcategory);
    $trail->push($thread->title, route('thread_show', [$thread->id, $thread->slug]));
});

// Home > [Table category] > [Table subcategory] > [Thread] > [New]
Breadcrumbs::for('thread_new', function ($trail, $subcategory) {
    $trail->parent('subcategory', $subcategory);
    $trail->push(__('New thread'), route('subcategory_show', [$subcategory->id, $subcategory->slug]));
});

// Home > [Table category] > [Table subcategory] > [Thread] > [Post]
Breadcrumbs::for('post', function ($trail, $post) {
    $trail->parent('thread', $post->thread);
    $trail->push(__('Post'), route('post_permalink', [$post->id]));
});