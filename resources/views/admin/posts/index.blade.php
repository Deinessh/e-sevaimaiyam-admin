<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - E-Sevai Maiyam</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0d9488;
            --primary-hover: #0f766e;
            --bg-color: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --glass-bg: rgba(255, 255, 255, 0.9);
            --glass-border: rgba(255, 255, 255, 0.4);
            --shadow: 0 10px 40px -10px rgba(0,0,0,0.1);
        }
        body { 
            font-family: 'Inter', sans-serif; 
            background: linear-gradient(135deg, #f0fdfa 0%, #e0f2fe 100%); 
            color: var(--text-main); 
            margin: 0; 
            padding: 2rem; 
            min-height: 100vh;
        }
        .container { 
            max-width: 900px; 
            margin: 0 auto; 
            background: var(--glass-bg); 
            backdrop-filter: blur(16px);
            padding: 2.5rem; 
            border-radius: 20px; 
            box-shadow: var(--shadow);
            border: 1px solid var(--glass-border);
        }
        .header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 2rem; 
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }
        .header-title {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .logo {
            background: var(--primary);
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }
        h1 { margin: 0; font-size: 1.5rem; font-weight: 700; }
        .header-actions {
            display: flex;
            gap: 1rem;
        }
        .btn { 
            display: inline-flex; 
            align-items: center;
            gap: 0.5rem;
            background-color: var(--primary); 
            color: white; 
            padding: 0.75rem 1.25rem; 
            text-decoration: none; 
            border-radius: 10px; 
            border: none; 
            cursor: pointer; 
            font-weight: 600;
            font-size: 0.95rem; 
            transition: all 0.3s ease;
        }
        .btn:hover { 
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.2); 
        }
        .btn-outline {
            background: transparent;
            color: var(--text-muted);
            border: 1px solid #cbd5e1;
        }
        .btn-outline:hover {
            background: #f1f5f9;
            color: var(--text-main);
            box-shadow: none;
        }
        .btn-danger { 
            background-color: #ef4444; 
            padding: 0.5rem 0.875rem;
            font-size: 0.875rem;
        }
        .btn-danger:hover { 
            background-color: #dc2626; 
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 1rem; text-align: left; border-bottom: 1px solid #e2e8f0; }
        th { font-weight: 600; color: var(--text-muted); font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; }
        td { font-size: 0.95rem; }
        .success-msg { 
            background-color: #f0fdf4; 
            color: #166534; 
            padding: 1rem; 
            border-radius: 10px; 
            margin-bottom: 1.5rem;
            border: 1px solid #bbf7d0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-title">
                <div class="logo"><i class="fa-solid fa-pen-nib"></i></div>
                <h1>Manage Blog Posts</h1>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.posts.create') }}" class="btn">
                    <i class="fa-solid fa-plus"></i> Create Post
                </a>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn btn-outline">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="success-msg">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th style="width: 70px;">Image</th>
                    <th>Title</th>
                    <th>Date Published</th>
                    <th style="width: 120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                <tr>
                    <td>
                        @if($post->image)
                            <img src="{{ $post->image }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;" alt="thumb">
                        @else
                            <div style="width: 50px; height: 50px; background: #f1f5f9; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #cbd5e1;"><i class="fa-solid fa-image"></i></div>
                        @endif
                    </td>
                    <td style="font-weight: 500;">{{ $post->title }}</td>
                    <td style="color: var(--text-muted);">{{ $post->published_at ? $post->published_at->format('M d, Y') : 'N/A' }}</td>
                    <td>
                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">
                                <i class="fa-solid fa-trash-can"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align: center; padding: 3rem 1rem; color: var(--text-muted);">
                        <i class="fa-solid fa-folder-open" style="font-size: 2rem; margin-bottom: 1rem; color: #cbd5e1; display: block;"></i>
                        No posts found. Create one to get started.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
