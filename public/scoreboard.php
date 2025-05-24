<?php require_once __DIR__ . '/../includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Competition Scoreboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --accent: #f093fb;
            --gold: #ffd700;
            --silver: #c0c0c0;
            --bronze: #cd7f32;
            --success: #48bb78;
            --bg-primary: #0f0f23;
            --bg-secondary: #1a1a2e;
            --bg-tertiary: #16213e;
            --text-primary: #e2e8f0;
            --text-secondary: #a0aec0;
            --text-muted: #718096;
            --border: #2d3748;
            --glass: rgba(26, 26, 46, 0.8);
            --shadow-lg: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
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
            overflow-x: hidden;
        }

        /* Animated background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 20%, rgba(102, 126, 234, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(240, 147, 251, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 60%, rgba(118, 75, 162, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
            animation: backgroundPulse 15s ease-in-out infinite;
        }

        @keyframes backgroundPulse {
            0%, 100% { opacity: 0.7; }
            50% { opacity: 1; }
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
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 4px;
            background: linear-gradient(90deg, var(--gold), var(--accent), var(--primary));
            border-radius: 2px;
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
        }

        .main-title {
            font-size: 4rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--gold), var(--accent), var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            text-shadow: 0 0 30px rgba(255, 215, 0, 0.3);
            animation: titleGlow 4s ease-in-out infinite alternate;
        }

        @keyframes titleGlow {
            0% { filter: drop-shadow(0 0 20px rgba(255, 215, 0, 0.3)); }
            100% { filter: drop-shadow(0 0 40px rgba(255, 215, 0, 0.6)); }
        }

        .subtitle {
            color: var(--text-secondary);
            font-size: 1.2rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .live-indicator {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, var(--success), #38a169);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 1rem;
            box-shadow: 0 8px 25px rgba(72, 187, 120, 0.3);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .live-dot {
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
            animation: blink 1.5s ease-in-out infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        .scoreboard-container {
            background: var(--glass);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 2rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
            animation: slideInUp 1s ease-out;
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

        .scoreboard-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--border);
        }

        .scoreboard-title {
            font-size: 1.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .scoreboard-title i {
            color: var(--gold);
            font-size: 1.5rem;
        }

        .refresh-indicator {
            color: var(--text-muted);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .refresh-spinner {
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .leaderboard {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .participant-row {
            display: flex;
            align-items: center;
            padding: 1.5rem;
            border-radius: 16px;
            border: 1px solid var(--border);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            animation: fadeInSlide 0.8s ease-out forwards;
            opacity: 0;
        }

        .participant-row:nth-child(1) { animation-delay: 0.1s; }
        .participant-row:nth-child(2) { animation-delay: 0.2s; }
        .participant-row:nth-child(3) { animation-delay: 0.3s; }
        .participant-row:nth-child(4) { animation-delay: 0.4s; }
        .participant-row:nth-child(5) { animation-delay: 0.5s; }
        .participant-row:nth-child(n+6) { animation-delay: 0.6s; }

        @keyframes fadeInSlide {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .participant-row:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.2);
        }

        /* Podium positions */
        .rank-1 {
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.15), rgba(255, 215, 0, 0.05));
            border-color: var(--gold);
            box-shadow: 0 0 30px rgba(255, 215, 0, 0.2);
        }

        .rank-1::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--gold), #ffd700, var(--gold));
        }

        .rank-2 {
            background: linear-gradient(135deg, rgba(192, 192, 192, 0.15), rgba(192, 192, 192, 0.05));
            border-color: var(--silver);
            box-shadow: 0 0 20px rgba(192, 192, 192, 0.2);
        }

        .rank-2::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--silver), #c0c0c0, var(--silver));
        }

        .rank-3 {
            background: linear-gradient(135deg, rgba(205, 127, 50, 0.15), rgba(205, 127, 50, 0.05));
            border-color: var(--bronze);
            box-shadow: 0 0 20px rgba(205, 127, 50, 0.2);
        }

        .rank-3::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--bronze), #cd7f32, var(--bronze));
        }

        .regular-rank {
            background: rgba(22, 33, 62, 0.6);
        }

        .rank-badge {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.4rem;
            margin-right: 1.5rem;
            position: relative;
        }

        .rank-1 .rank-badge {
            background: linear-gradient(135deg, var(--gold), #ffd700);
            color: var(--bg-primary);
            box-shadow: 0 8px 25px rgba(255, 215, 0, 0.4);
        }

        .rank-1 .rank-badge::after {
            content: '👑';
            position: absolute;
            top: -8px;
            right: -8px;
            font-size: 1.2rem;
        }

        .rank-2 .rank-badge {
            background: linear-gradient(135deg, var(--silver), #c0c0c0);
            color: var(--bg-primary);
            box-shadow: 0 8px 25px rgba(192, 192, 192, 0.4);
        }

        .rank-3 .rank-badge {
            background: linear-gradient(135deg, var(--bronze), #cd7f32);
            color: white;
            box-shadow: 0 8px 25px rgba(205, 127, 50, 0.4);
        }

        .regular-rank .rank-badge {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .participant-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .participant-name {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .participant-meta {
            color: var(--text-muted);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .score-display {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 0.25rem;
        }

        .total-score {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .rank-1 .total-score { color: var(--gold); }
        .rank-2 .total-score { color: var(--silver); }
        .rank-3 .total-score { color: var(--bronze); }

        .score-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .no-score {
            opacity: 0.5;
        }

        .no-score .total-score {
            color: var(--text-muted);
            font-style: italic;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .main-title {
                font-size: 2.5rem;
            }

            .scoreboard-container {
                padding: 1.5rem;
            }

            .participant-row {
                padding: 1rem;
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .rank-badge {
                margin-right: 0;
            }

            .score-display {
                align-items: center;
            }

            .scoreboard-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }

        /* Trophy animations for top 3 */
        .rank-1 .rank-badge,
        .rank-2 .rank-badge,
        .rank-3 .rank-badge {
            animation: trophyBounce 3s ease-in-out infinite;
        }

        @keyframes trophyBounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        /* Score animation */
        .total-score {
            animation: scoreGlow 2s ease-in-out infinite alternate;
        }

        @keyframes scoreGlow {
            0% { text-shadow: 0 0 5px rgba(226, 232, 240, 0.3); }
            100% { text-shadow: 0 0 20px rgba(226, 232, 240, 0.6); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="main-title">
                <i class="fas fa-trophy"></i>
                Competition Scoreboard
            </h1>
            <p class="subtitle">
                <i class="fas fa-chart-line"></i>
                Live Competition Results
            </p>
            <div class="live-indicator">
                <div class="live-dot"></div>
                Live Updates
            </div>
        </div>
        
        <div class="scoreboard-container">
            <div class="scoreboard-header">
                <h2 class="scoreboard-title">
                    <i class="fas fa-medal"></i>
                    Current Rankings
                </h2>
                <div class="refresh-indicator">
                    <i class="fas fa-sync-alt refresh-spinner"></i>
                    Auto-refresh: 10s
                </div>
            </div>
            
            <div class="leaderboard">
                <?php 
                $scores = getScores();
                $rank = 0;
                foreach ($scores as $score): 
                    $rank++;
                    
                    // Determine rank class
                    $rankClass = 'regular-rank';
                    if ($rank <= 3 && $score['total_score'] !== null) {
                        $rankClass = "rank-{$rank}";
                    }
                    
                    // Check if participant has no score
                    $noScore = $score['total_score'] === null;
                    $displayScore = $noScore ? 'Not Scored' : $score['total_score'];
                ?>
                <div class="participant-row <?= $rankClass ?> <?= $noScore ? 'no-score' : '' ?>">
                    <div class="rank-badge">
                        <?= $rank ?>
                    </div>
                    
                    <div class="participant-info">
                        <div class="participant-name">
                            <?= htmlspecialchars($score['user_name']) ?>
                        </div>
                        <div class="participant-meta">
                            <i class="fas fa-user"></i>
                            Participant #<?= $rank ?>
                            <?php if ($rank <= 3 && !$noScore): ?>
                                <span style="margin-left: 0.5rem;">
                                    <?php if ($rank === 1): ?>
                                        <i class="fas fa-crown" style="color: var(--gold);"></i> Champion
                                    <?php elseif ($rank === 2): ?>
                                        <i class="fas fa-medal" style="color: var(--silver);"></i> Runner-up
                                    <?php else: ?>
                                        <i class="fas fa-award" style="color: var(--bronze);"></i> Third Place
                                    <?php endif; ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="score-display">
                        <div class="total-score">
                            <?= $displayScore ?>
                        </div>
                        <div class="score-label">
                            <?= $noScore ? 'Pending' : 'Total Points' ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <script>
        // Enhanced auto-refresh with smooth transitions
        let refreshCountdown = 10;
        let refreshTimer;
        
        function updateRefreshIndicator() {
            const indicator = document.querySelector('.refresh-indicator');
            if (indicator) {
                indicator.innerHTML = `
                    <i class="fas fa-sync-alt refresh-spinner"></i>
                    Auto-refresh: ${refreshCountdown}s
                `;
            }
        }
        
        function startRefreshCountdown() {
            refreshTimer = setInterval(() => {
                refreshCountdown--;
                updateRefreshIndicator();
                
                if (refreshCountdown <= 0) {
                    // Add fade out effect before refresh
                    document.body.style.opacity = '0.8';
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                }
            }, 1000);
        }
        
        // Start the countdown when page loads
        startRefreshCountdown();
        
        // Add hover effects for participant rows
        document.querySelectorAll('.participant-row').forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
        
        // Add click effect for engagement
        document.querySelectorAll('.participant-row').forEach(row => {
            row.addEventListener('click', function() {
                // Add ripple effect
                const ripple = document.createElement('div');
                ripple.style.cssText = `
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(102, 126, 234, 0.3);
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    pointer-events: none;
                `;
                
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = (event.clientX - rect.left - size / 2) + 'px';
                ripple.style.top = (event.clientY - rect.top - size / 2) + 'px';
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
        
        // Add CSS for ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>