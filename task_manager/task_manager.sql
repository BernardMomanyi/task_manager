CREATE DATABASE IF NOT EXISTS task_manager;
USE task_manager;

-- Users Table with Role (Admin or User)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('Admin', 'User') DEFAULT 'User' -- Adding role column
);

-- Tasks Table
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    category ENUM('Assignment', 'Project', 'Exam', 'General') NOT NULL,
    priority ENUM('Low', 'Medium', 'High') DEFAULT 'Medium',
    deadline DATE NOT NULL,
    status ENUM('Pending', 'Completed') DEFAULT 'Pending',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Projects Table
CREATE DATABASE IF NOT EXISTS task_manager;
USE task_manager;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    deadline DATE NOT NULL,
    status ENUM('Pending', 'Completed') DEFAULT 'Pending',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    subject VARCHAR(100),
    title VARCHAR(255),
    due_date DATE NOT NULL,
    status ENUM('Pending', 'Submitted') DEFAULT 'Pending',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
CREATE DATABASE IF NOT EXISTS task_manager;
USE task_manager;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    category ENUM('Assignment', 'Project', 'Exam', 'General') NOT NULL,
    priority ENUM('Low', 'Medium', 'High') DEFAULT 'Medium',
    deadline DATE NOT NULL,
    status ENUM('Pending', 'Completed') DEFAULT 'Pending',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    project_name VARCHAR(255) NOT NULL,
    type ENUM('Individual', 'Team') NOT NULL,
    due_date DATE NOT NULL,
    status ENUM('In Progress', 'Completed') DEFAULT 'In Progress',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE exams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    subject VARCHAR(100) NOT NULL,
    exam_date DATE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
	);