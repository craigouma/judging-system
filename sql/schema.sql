-- Users (participants)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Judges
CREATE TABLE judges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    display_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Scores
CREATE TABLE scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    judge_id INT NOT NULL,
    score INT NOT NULL CHECK (score BETWEEN 1 AND 100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (judge_id) REFERENCES judges(id),
    UNIQUE KEY unique_judge_user (judge_id, user_id)
);

-- Sample data
INSERT INTO users (name) VALUES 
('Participant 1'), ('Participant 2'), ('Participant 3'), ('Participant 4'), ('Participant 10'), ('Participant 11'), ('Participant 12');

INSERT INTO judges (username, display_name) VALUES 
('judge1', 'Judge One'), ('judge2', 'Judge Two'), ('judge3', 'Judge Three');