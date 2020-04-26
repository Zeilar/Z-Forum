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

// Home > [Messages]
Breadcrumbs::for('messages', function ($trail) {
    $trail->parent('home');
    $trail->push(__('Messages'), route('dashboard_messages'));
});

// Home > [Messages] > [Message]
Breadcrumbs::for('message', function ($trail, $message) {
    $trail->parent('messages');
    $trail->push($message->title, route('dashboard_message', [$message->id]));
});

// Home > [Messages] > [New Message]
Breadcrumbs::for('message_new', function ($trail) {
    $trail->parent('messages');
    $trail->push(__('New message'), route('message_new'));
});

// Home > [Account]
Breadcrumbs::for('account', function ($trail) {
    $trail->parent('home');
    $trail->push(__('Account'), route('dashboard_account'));
});