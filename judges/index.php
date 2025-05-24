<?php 
require_once __DIR__ . '/../includes/functions.php';

// Start session for messages
session_start();

// For demo purposes, we'll use judge_id=1
$judgeId = 1;
$judge = current(array_filter(getJudges(), function($j) use ($judgeId) {
    return $j['id'] == $judgeId;
}));

// Get and clear flash messages
$successMessage = $_SESSION['success_message'] ?? null;
$errorMessage = $_SESSION['error_message'] ?? null;
unset($_SESSION['success_message'], $_SESSION['error_message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Judge Portal - <?= htmlspecialchars($judge['display_name']) ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #667eea;
            --primary-dark: #5a67d8;
            --secondary: #764ba2;
            --accent: #f093fb;
            --success: #48bb78;
            --warning: #ed8936;
            --error: #f56565;
            --bg-primary: #0f0f23;
            --bg-secondary: #1a1a2e;
            --bg-tertiary: #16213e;
            --text-primary: #e2e8f0;
            --text-secondary: #a0aec0;
            --text-muted: #718096;
            --border: #2d3748;
            --shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-lg: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            --glass: rgba(26, 26, 46, 0.8);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 50%, var(--bg-tertiary) 100%);
            color: var(--text-primary);
            min-height: 100vh;
            line-height: 1.6;
            position: relative;
        }

        /* Animated background particles */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(102, 126, 234, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(240, 147, 251, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 50% 10%, rgba(118, 75, 162, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 3rem;
            padding: 2rem;
            background: var(--glass);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary), var(--accent), var(--secondary));
        }

        .judge-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .judge-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .judge-avatar::after {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, var(--primary), var(--accent), var(--secondary));
            border-radius: 22px;
            z-index: -1;
            animation: glow 3s ease-in-out infinite alternate;
        }

        @keyframes glow {
            0% { opacity: 0.5; }
            100% { opacity: 0.8; }
        }

        .judge-details h1 {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .judge-role {
            color: var(--text-secondary);
            font-size: 1.1rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-badge {
            background: linear-gradient(135deg, var(--success), #38a169);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 15px rgba(72, 187, 120, 0.3);
        }

        .main-content {
            background: var(--glass);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
            animation: slideInUp 0.8s ease-out;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--border);
        }

        .section-header h2 {
            font-size: 2rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .section-header i {
            font-size: 1.5rem;
            color: var(--primary);
        }

        .participants-grid {
            display: grid;
            gap: 1.5rem;
        }

        .participant-card {
            background: rgba(22, 33, 62, 0.6);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .participant-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .participant-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.2);
            border-color: var(--primary);
        }

        .participant-card:hover::before {
            opacity: 1;
        }

        .participant-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .participant-id {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--secondary), var(--primary));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 1.1rem;
        }

        .participant-details h3 {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .participant-meta {
            color: var(--text-muted);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .scoring-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .score-input-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(45, 55, 72, 0.5);
            padding: 0.75rem;
            border-radius: 12px;
            border: 2px solid var(--border);
            transition: all 0.3s ease;
        }

        .score-input-group:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .score-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
            font-weight: 500;
            white-space: nowrap;
        }

        input[type="number"] {
            width: 80px;
            padding: 0.5rem;
            border: none;
            background: transparent;
            color: var(--text-primary);
            font-size: 1.1rem;
            font-weight: 600;
            text-align: center;
            outline: none;
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        .submit-btn {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--primary);
            margin-bottom: 1rem;
            opacity: 0.7;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: var(--text-secondary);
        }

        .empty-state p {
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Message notification styles */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: var(--shadow-lg);
            z-index: 1000;
            animation: slideIn 0.3s ease-out, fadeOut 1s ease-in 3s forwards;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .success-notification {
            background: var(--success);
            color: white;
        }

        .error-notification {
            background: var(--error);
            color: white;
        }

        .notification i {
            font-size: 1.2rem;
        }

        @keyframes slideIn {
            from { transform: translateX(100%); }
            to { transform: translateX(0); }
        }

        @keyframes fadeOut {
            to { opacity: 0; }
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .header {
                flex-direction: column;
                text-align: center;
                gap: 1.5rem;
            }

            .judge-info {
                flex-direction: column;
                text-align: center;
            }

            .judge-details h1 {
                font-size: 2rem;
            }

            .participant-card {
                flex-direction: column;
                gap: 1.5rem;
                text-align: center;
            }

            .scoring-section {
                width: 100%;
                justify-content: center;
            }

            .main-content {
                padding: 1.5rem;
            }

            .notification {
                left: 20px;
                right: 20px;
                top: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Notification Messages -->
    <?php if ($successMessage): ?>
        <div class="notification success-notification">
            <i class="fas fa-check-circle"></i>
            <?= htmlspecialchars($successMessage) ?>
        </div>
    <?php endif; ?>

    <?php if ($errorMessage): ?>
        <div class="notification error-notification">
            <i class="fas fa-exclamation-circle"></i>
            <?= htmlspecialchars($errorMessage) ?>
        </div>
    <?php endif; ?>

    <div class="container">
        <div class="header">
            <div class="judge-info">
                <div class="judge-avatar">
                    <?= strtoupper(substr($judge['display_name'], 0, 2)) ?>
                </div>
                <div class="judge-details">
                    <h1>Welcome, <?= htmlspecialchars($judge['display_name']) ?></h1>
                    <div class="judge-role">
                        <i class="fas fa-gavel"></i>
                        Official Judge
                    </div>
                </div>
            </div>
            <div class="status-badge">
                <i class="fas fa-check-circle"></i>
                Active Session
            </div>
        </div>
        
        <div class="main-content">
            <div class="section-header">
                <i class="fas fa-users"></i>
                <h2>Participants Awaiting Scores</h2>
            </div>
            
            <div class="participants-grid">
                <?php 
                $participants = getUnscoredUsers($judgeId);
                if (empty($participants)): 
                ?>
                    <div class="empty-state">
                        <i class="fas fa-clipboard-check"></i>
                        <h3>All Caught Up!</h3>
                        <p>You have scored all participants in this round. Great work!</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($participants as $user): ?>
                    <div class="participant-card">
                        <div class="participant-info">
                            <div class="participant-id">
                                <?= $user['id'] ?>
                            </div>
                            <div class="participant-details">
                                <h3><?= htmlspecialchars($user['name']) ?></h3>
                                <div class="participant-meta">
                                    <i class="fas fa-user"></i>
                                    Participant #<?= $user['id'] ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="scoring-section">
                            <form action="/judging-system/submit-score" method="post">
                                <input type="hidden" name="judge_id" value="<?= $judgeId ?>">
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                
                                <div class="score-input-group">
                                    <span class="score-label">Score:</span>
                                    <input type="number" name="score" min="1" max="100" required placeholder="0-100">
                                    <div class="score-range"></div>
                                </div>
                                
                                <button type="submit" class="submit-btn">
                                    <i class="fas fa-paper-plane"></i>
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Real-time score validation
        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('input', function() {
                const value = parseInt(this.value);
                const container = this.closest('.score-input-group');
                
                container.classList.remove('score-low', 'score-medium', 'score-high');
                
                if (value >= 1 && value <= 100) {
                    container.classList.add(
                        value <= 40 ? 'score-low' :
                        value <= 70 ? 'score-medium' : 'score-high'
                    );
                }
            });
        });

        // Submit confirmation
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const score = this.querySelector('input[name="score"]').value;
                const participantName = this.closest('.participant-card').querySelector('h3').textContent;
                
                if (!confirm(`Submit score of ${score} for ${participantName}?`)) {
                    e.preventDefault();
                }
            });
        });
        
        // Auto-remove notifications after animation
        document.querySelectorAll('.notification').forEach(notification => {
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 500);
            }, 3000);
        });
    </script>
</body>
</html>