$menus = \App\Models\Menu::where('location', 'admin')->orderBy('parent_id')->orderBy('order')->get();
foreach ($menus as $m) {
    echo str_pad($m->id, 3) . ' | ' . str_pad($m->parent_id ?? 'ROOT', 5) . ' | ' . str_pad($m->order, 2) . ' | ' . $m->title . PHP_EOL;
}
