<!DOCTYPE html>
<html>
<head>
    <title>Website App - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { border-bottom: 1px solid #eee; padding-bottom: 20px; margin-bottom: 30px; }
        .user-info { background: #f8f9fa; padding: 20px; border-radius: 6px; margin-bottom: 20px; }
        .btn { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; margin-right: 10px; }
        .btn:hover { background: #0056b3; }
        .btn-danger { background: #dc3545; }
        .btn-danger:hover { background: #c82333; }
        .btn-success { background: #28a745; }
        .btn-success:hover { background: #218838; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Website App Dashboard</h1>
            <p>Welcome to the main application dashboard</p>
        </div>
        
        <div class="user-info">
            <h3>User Information</h3>
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
        </div>
        
        <div class="actions">
            <a href="{{ $software_app_url }}?sso_token={{ session('sso_token') }}" class="btn btn-success">
                Access Software App
            </a>
            
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Logout from Both Apps</button>
            </form>
        </div>
        
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
            <h3>SSO Status</h3>
            <p>✅ You are logged into both applications</p>
            <p>🔐 Single Sign-On is active</p>
        </div>
    </div>
</body>
</html>