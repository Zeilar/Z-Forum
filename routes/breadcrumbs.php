<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push(__('Home'), route('index'));
});

// Home > [Table category]
Breadcrumbs::for('table_category', function ($trail, $tableCategory) {
    $trail->parent('home');
    $trail->push($tableCategory->title, route('tablecategory_show', [$tableCategory->id, $tableCategory->slug]));
});

// Home > [Table category] > [Table subcategory]
Breadcrumbs::for('table_subcategory', function ($trail, $tableSubcategory) {
    $trail->parent('table_category', $tableSubcategory->tableCategory);
    $trail->push($tableSubcategory->title, route('tablesubcategory_show', [$tableSubcategory->id, $tableSubcategory->slug]));
});

// Home > [Table category] > [Table subcategory] > [Thread]
Breadcrumbs::for('thread', function ($trail, $thread) {
    $trail->parent('table_subcategory', $thread->tableSubcategory);
    $trail->push($thread->title, route('thread_show', [$thread->id, $thread->slug]));
});

// Home > [Table category] > [Table subcategory] > [Thread] > [Post]
Breadcrumbs::for('post', function ($trail, $post) {
    $trail->parent('thread', $post->thread);
    $trail->push(__('Post'), route('post_permalink', [$post->id]));
});