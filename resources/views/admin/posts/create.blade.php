<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post - Admin Panel</title>
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
            max-width: 800px; 
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
        .btn { 
            display: inline-flex; 
            align-items: center;
            gap: 0.5rem;
            background-color: var(--primary); 
            color: white; 
            padding: 0.875rem 1.5rem; 
            text-decoration: none; 
            border-radius: 10px; 
            border: none; 
            cursor: pointer; 
            font-weight: 600;
            font-size: 1rem; 
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
            padding: 0.5rem 1rem;
            font-size: 0.95rem;
        }
        .btn-outline:hover {
            background: #f1f5f9;
            color: var(--text-main);
            box-shadow: none;
            transform: none;
        }
        .form-group { margin-bottom: 1.5rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-main); font-size: 0.95rem; }
        .form-control { 
            width: 100%; 
            padding: 0.875rem; 
            border: 1px solid #cbd5e1; 
            border-radius: 10px; 
            box-sizing: border-box; 
            font-family: inherit;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fff;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1);
        }
        .error-msg { color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.25rem; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-title">
                <div class="logo"><i class="fa-solid fa-pen-to-square"></i></div>
                <h1>Create New Blog Post</h1>
            </div>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Back to Posts
            </a>
        </div>

        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Post Title</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" placeholder="Enter an engaging title..." required>
                @error('title')
                    <div class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" style="background: #f1f5f9; padding: 1.25rem; border-radius: 12px; border: 1px dashed #cbd5e1;">
                <label style="margin-bottom: 0.75rem;"><i class="fa-solid fa-image"></i> Blog Cover Image</label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; align-items: start;">
                    <div>
                        <label for="image_file" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500;">Upload Image File (from PC)</label>
                        <input type="file" id="image_file" name="image_file" class="form-control" accept="image/*" style="padding: 0.5rem; background: #fff;">
                    </div>
                    <div>
                        <label for="image_url" style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500;">OR Paste Image URL (e.g. Unsplash)</label>
                        <input type="url" id="image_url" name="image_url" class="form-control" value="{{ old('image_url') }}" placeholder="https://...">
                    </div>
                </div>
                @error('image_file')
                    <div class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                @enderror
                @error('image_url')
                    <div class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="content" name="content" class="form-control" rows="12" placeholder="Write your blog post content here...">{{ old('content') }}</textarea>
                @error('content')
                    <div class="error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn">
                <i class="fa-solid fa-paper-plane"></i> Publish Post
            </button>
        </form>
    </div>

    <!-- CKEditor 4 Full CDN -->
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content', {
            height: 380,
            versionCheck: false,
            removeButtons: 'Save,NewPage,Preview,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Find,Replace,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,CopyFormatting,CreateDiv,BidiLtr,BidiRtl,Language,Anchor,Flash,PageBreak,Iframe,ShowBlocks,About'
        });
    </script>
</body>
</html>
