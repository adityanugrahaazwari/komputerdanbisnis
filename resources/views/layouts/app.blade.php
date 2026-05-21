<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RBAC Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal flex">

    <!-- Sidebar -->
    <div class="bg-gray-900 shadow-xl h-screen fixed w-64">
        <div class="p-4 bg-gray-800 text-white text-xl font-bold text-center">
            Admin Panel
        </div>
        <ul class="list-reset flex flex-col mt-4">
            @foreach($dynamicMenus as $menu)
                {{-- Cek apakah menu butuh permission dan user punya permission itu --}}
                @if(!$menu->permission_slug || auth()->user()->can($menu->permission_slug))
                    <li class="w-full h-full py-2 px-4">
                        @if($menu->url)
                            <a href="{{ url($menu->url) }}" class="block text-gray-300 hover:text-white hover:bg-gray-800 rounded px-2 py-2">
                                <i class="{{ $menu->icon }} mr-2 w-5 text-center"></i> {{ $menu->title }}
                            </a>
                        @else
                            {{-- Dropdown / Parent Menu --}}
                            <div class="block text-gray-400 uppercase text-xs font-bold px-2 py-2 mt-4">
                                <i class="{{ $menu->icon }} mr-2 w-5 text-center"></i> {{ $menu->title }}
                            </div>
                            @if($menu->children->count() > 0)
                                <ul class="list-reset ml-4 mt-2">
                                    @foreach($menu->children as $child)
                                        @if(!$child->permission_slug || auth()->user()->can($child->permission_slug))
                                            <li class="py-1">
                                                <a href="{{ url($child->url) }}" class="block text-gray-300 hover:text-white hover:bg-gray-800 rounded px-2 py-1 text-sm">
                                                    <i class="{{ $child->icon }} mr-2 w-5 text-center"></i> {{ $child->title }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content flex-1 bg-gray-100 mt-12 md:mt-2 pb-24 md:pb-5 ml-64">
        <div class="bg-white p-4 shadow mb-6 flex justify-between items-center">
            <div class="font-bold text-gray-800 text-xl">
                @yield('header', 'Dashboard')
            </div>
            <div>
                <span class="mr-4 text-gray-600">Halo, {{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm">Logout</button>
                </form>
            </div>
        </div>

        <div class="p-6">
            @yield('content')
        </div>
    </div>

</body>
</html>
