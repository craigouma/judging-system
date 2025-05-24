<?php require_once __DIR__ . '/../includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Judge Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #667eea;
            --primary-dark: #5a67d8;
            --secondary: #764ba2;
            --success: #48bb78;
            --error: #f56565;
            --warning: #ed8936;
            --bg-primary: #0f0f23;
            --bg-secondary: #1a1a2e;
            --bg-tertiary: #16213e;
            --text-primary: #e2e8f0;
            --text-secondary: #a0aec0;
            --border: #2d3748;
            --shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-lg: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
            color: var(--text-primary);
            min-height: 100vh;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 2px;
        }

        h1 {
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            text-shadow: 0 0 30px rgba(102, 126, 234, 0.3);
        }

        .subtitle {
            color: var(--text-secondary);
            font-size: 1.1rem;
            font-weight: 400;
        }

        .alert {
            padding: 1rem 1.5rem;
            margin: 1.5rem 0;
            border-radius: 12px;
            border-left: 4px solid;
            position: relative;
            overflow: hidden;
            animation: slideInDown 0.5s ease-out;
        }

        .alert::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1));
            pointer-events: none;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(72, 187, 120, 0.1), rgba(72, 187, 120, 0.05));
            color: #68d391;
            border-left-color: var(--success);
            box-shadow: 0 8px 32px rgba(72, 187, 120, 0.2);
        }

        .alert-error {
            background: linear-gradient(135deg, rgba(245, 101, 101, 0.1), rgba(245, 101, 101, 0.05));
            color: #fc8181;
            border-left-color: var(--error);
            box-shadow: 0 8px 32px rgba(245, 101, 101, 0.2);
        }

        .card {
            background: rgba(26, 26, 46, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2rem;
            margin: 2rem 0;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 32px 64px -12px rgba(102, 126, 234, 0.4);
        }

        .card h2 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card h2 i {
            color: var(--primary);
            font-size: 1.2rem;
        }

        form {
            display: grid;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        label {
            font-weight: 500;
            color: var(--text-primary);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input[type="text"] {
            padding: 1rem;
            border: 2px solid var(--border);
            border-radius: 12px;
            background: rgba(45, 55, 72, 0.5);
            color: var(--text-primary);
            font-size: 1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        input[type="text"]:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:active {
            transform: translateY(-1px);
        }

        .table-container {
            overflow-x: auto;
            border-radius: 16px;
            background: rgba(26, 26, 46, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: linear-gradient(135deg, var(--bg-tertiary), rgba(22, 33, 62, 0.8));
            color: var(--text-primary);
            font-weight: 600;
            padding: 1.5rem 1rem;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
            border-bottom: 2px solid var(--border);
        }

        td {
            padding: 1.25rem 1rem;
            border-bottom: 1px solid var(--border);
            color: var(--text-secondary);
            transition: all 0.3s ease;
        }

        tr:hover td {
            background: rgba(102, 126, 234, 0.05);
            color: var(--text-primary);
        }

        tr:last-child td {
            border-bottom: none;
        }

        .id-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .username {
            font-family: 'Monaco', 'Menlo', monospace;
            background: rgba(45, 55, 72, 0.5);
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-size: 0.9rem;
        }

        .display-name {
            font-weight: 500;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            animation: fadeInUp 0.6s ease-out;
        }

        .card:nth-child(2) { animation-delay: 0.1s; }
        .card:nth-child(3) { animation-delay: 0.2s; }
        .card:nth-child(4) { animation-delay: 0.3s; }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            .card {
                padding: 1.5rem;
            }
            
            table {
                font-size: 0.9rem;
            }
            
            th, td {
                padding: 1rem 0.5rem;
            }
        }

        /* Add subtle particle animation background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(102, 126, 234, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(118, 75, 162, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-gavel"></i> Judge Management</h1>
            <p class="subtitle">Administer and manage your judging panel</p>
        </div>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> Judge added successfully!
            </div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>
        
        <div class="card">
            <h2><i class="fas fa-plus-circle"></i> Add New Judge</h2>
            <form action="/judging-system/add-judge" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required placeholder="Enter username">
                </div>
                <div class="form-group">
                    <label for="display_name">Display Name</label>
                    <input type="text" id="display_name" name="display_name" required placeholder="Enter display name">
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Add Judge
                </button>
            </form>
        </div>
        
        <div class="card">
            <h2><i class="fas fa-users"></i> Existing Judges</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag"></i> ID</th>
                            <th><i class="fas fa-user"></i> Username</th>
                            <th><i class="fas fa-id-badge"></i> Display Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (getJudges() as $judge): ?>
                        <tr>
                            <td><span class="id-badge"><?= $judge['id'] ?></span></td>
                            <td><span class="username"><?= htmlspecialchars($judge['username']) ?></span></td>
                            <td><span class="display-name"><?= htmlspecialchars($judge['display_name']) ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>