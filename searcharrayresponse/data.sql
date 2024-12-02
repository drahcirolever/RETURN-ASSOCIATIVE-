CREATE TABLE user_accounts (
    username VARCHAR(100) NOT NULL UNIQUE,
    user_id INT AUTO_INCREMENT PRIMARY KEY,         -- Unique identifier for each user 
    first_name VARCHAR(100) NOT NULL,               -- User's first name
    last_name VARCHAR(100) NOT NULL,                -- User's last name
    password VARCHAR(255) NOT NULL,                 -- Encrypted password
    date_added DATETIME DEFAULT CURRENT_TIMESTAMP   -- Date and time the record was added
);

CREATE TABLE architecture (
    user_id INT AUTO_INCREMENT PRIMARY KEY,         -- Unique identifier for each user
    first_name VARCHAR(100) NOT NULL,               -- User's first name
    last_name VARCHAR(100) NOT NULL,                -- User's last name
    gender ENUM('Male', 'Female', 'Other') NOT NULL,-- User's gender (restricted values)
    specialization VARCHAR(255),                    -- User's field of specialization
    years_of_experience INT,                        -- User's years of experience
    date_added DATETIME DEFAULT CURRENT_TIMESTAMP,  -- Date and time the record was added
    added_by VARCHAR(100),                          -- Who added this user (username or ID)
    last_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
                                                    -- Last update timestamp
    last_updated_by VARCHAR(100)                   -- Who last updated the record
);

CREATE TABLE activity_logs (
    activity_log_id INT AUTO_INCREMENT PRIMARY KEY, -- Unique identifier for each activity log
    operation VARCHAR(50) NOT NULL,                 -- The type of operation (e.g., "INSERT", "UPDATE")
    user_id INT NOT NULL,                           -- The ID of the associated user
    first_name VARCHAR(100) NOT NULL,              -- The user's first name
    last_name VARCHAR(100) NOT NULL,               -- The user's last name
    gender ENUM('Male', 'Female', 'Other') NOT NULL, -- The user's gender (restricted values)
    specialization VARCHAR(255),                   -- The user's field of specialization
    years_of_experience INT,                       -- The user's years of experience
    username VARCHAR(100) NOT NULL,                -- The user's username
    date_added DATETIME DEFAULT CURRENT_TIMESTAMP  -- The date and time the record was added
);