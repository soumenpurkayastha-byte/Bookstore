<!DOCTYPE html>
<html>
<head>
    <title>User Profile - Bookstore</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
            color: #333;
        }

        .profile-container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #2c3e50;
        }

        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            margin: auto;
        }

        form {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button {
            padding: 10px 15px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #2980b9;
        }

        .success-message {
            text-align: center;
            color: green;
            margin-bottom: 15px;
        }

        .logout {
            text-align: right;
            margin-bottom: 20px;
        }

        .logout a {
            text-decoration: none;
            color: white;
            background: #e74c3c;
            padding: 8px 12px;
            border-radius: 6px;
        }

        .logout a:hover {
            background: #c0392b;
        }

        .activity {
            margin-top: 30px;
        }

        .activity h3 {
            margin-bottom: 15px;
        }

        .activity ul {
            list-style: none;
            padding: 0;
        }

        .activity ul li {
            background: #f9f9f9;
            padding: 10px;
            margin-bottom: 8px;
            border-radius: 6px;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <div class="logout">
        <a href="/logout"><i class="fa fa-sign-out-alt"></i> Logout</a>
    </div>

    <h2>My Profile</h2>

    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif

    <img src="{{ asset('images/avatar.png') }}" alt="Profile Picture" class="profile-picture">

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="{{ $user->name }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="{{ $user->email }}" required>
        </div>

        <div class="form-group">
            <label for="password">New Password (leave blank to keep current)</label>
            <input type="password" id="password" name="password" placeholder="********">
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <input type="text" id="role" value="{{ $user->is_seller ? 'Seller' : 'Buyer' }}" disabled>
        </div>

        <button type="submit">Save Changes</button>
    </form>

    <div class="activity">
        <h3>Recent Activity</h3>
        <ul>
            <li>Books purchased: 5</li>
            <li>Books listed for sale: 3</li>
            <li>Last login: {{ now()->format('d M Y, H:i') }}</li>
        </ul>
    </div>
</div>

</body>
</html>
