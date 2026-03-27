DROP DATABASE IF EXISTS student_course_hub;
CREATE DATABASE student_course_hub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE student_course_hub;

DROP TABLE IF EXISTS InterestedStudents;
DROP TABLE IF EXISTS ProgrammeModules;
DROP TABLE IF EXISTS Programmes;
DROP TABLE IF EXISTS Modules;
DROP TABLE IF EXISTS AdminUsers;
DROP TABLE IF EXISTS Staff;
DROP TABLE IF EXISTS Levels;

CREATE TABLE Levels (
    LevelID INT PRIMARY KEY,
    LevelName VARCHAR(50) NOT NULL
);

CREATE TABLE Staff (
    StaffID INT PRIMARY KEY,
    Name VARCHAR(150) NOT NULL,
    JobTitle VARCHAR(150) NULL,
    Department VARCHAR(150) NULL,
    Bio TEXT NULL,
    Photo VARCHAR(255) NULL
);

CREATE TABLE AdminUsers (
    AdminID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(100) NOT NULL UNIQUE,
    PasswordHash VARCHAR(255) NOT NULL,
    FullName VARCHAR(150) NOT NULL,
    Role ENUM('super_admin', 'editor', 'mailer') NOT NULL DEFAULT 'editor',
    IsActive TINYINT(1) NOT NULL DEFAULT 1,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Modules (
    ModuleID INT PRIMARY KEY AUTO_INCREMENT,
    ModuleName VARCHAR(150) NOT NULL,
    ModuleLeaderID INT NULL,
    Description TEXT NULL,
    Image VARCHAR(255) NULL,
    ImageAlt VARCHAR(255) NULL,
    CONSTRAINT fk_modules_staff FOREIGN KEY (ModuleLeaderID) REFERENCES Staff(StaffID)
        ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE Programmes (
    ProgrammeID INT PRIMARY KEY AUTO_INCREMENT,
    ProgrammeName VARCHAR(150) NOT NULL,
    LevelID INT NOT NULL,
    ProgrammeLeaderID INT NULL,
    Description TEXT NULL,
    Image VARCHAR(255) NULL,
    ImageAlt VARCHAR(255) NULL,
    IsPublished TINYINT(1) NOT NULL DEFAULT 1,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UpdatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_programmes_level FOREIGN KEY (LevelID) REFERENCES Levels(LevelID)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_programmes_staff FOREIGN KEY (ProgrammeLeaderID) REFERENCES Staff(StaffID)
        ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE ProgrammeModules (
    ProgrammeModuleID INT PRIMARY KEY AUTO_INCREMENT,
    ProgrammeID INT NOT NULL,
    ModuleID INT NOT NULL,
    Year INT NOT NULL,
    CONSTRAINT fk_pm_programme FOREIGN KEY (ProgrammeID) REFERENCES Programmes(ProgrammeID)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_pm_module FOREIGN KEY (ModuleID) REFERENCES Modules(ModuleID)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT uq_programme_module_year UNIQUE (ProgrammeID, ModuleID, Year)
);

CREATE TABLE InterestedStudents (
    InterestID INT PRIMARY KEY AUTO_INCREMENT,
    ProgrammeID INT NOT NULL,
    StudentName VARCHAR(100) NOT NULL,
    Email VARCHAR(255) NOT NULL,
    IsActive TINYINT(1) NOT NULL DEFAULT 1,
    WithdrawToken VARCHAR(64) NULL,
    RegisteredAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    WithdrawnAt TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT fk_interest_programme FOREIGN KEY (ProgrammeID) REFERENCES Programmes(ProgrammeID)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT uq_interest_programme_email UNIQUE (ProgrammeID, Email)
);

CREATE INDEX idx_programmes_name ON Programmes (ProgrammeName);
CREATE INDEX idx_programmes_published_level ON Programmes (IsPublished, LevelID);
CREATE INDEX idx_modules_name ON Modules (ModuleName);
CREATE INDEX idx_interest_email_active ON InterestedStudents (Email, IsActive);
CREATE INDEX idx_pm_programme_year ON ProgrammeModules (ProgrammeID, Year);

INSERT INTO Levels (LevelID, LevelName) VALUES
(1, 'Undergraduate'),
(2, 'Postgraduate');

INSERT INTO Staff (StaffID, Name, JobTitle, Department, Bio, Photo) VALUES
(1, 'Dr. Alice Johnson', 'Senior Lecturer', 'Computer Science', 'Specialises in software engineering and programme leadership.', NULL),
(2, 'Dr. Brian Lee', 'Senior Lecturer', 'Computer Science', 'Focuses on mathematics and systems thinking for computing students.', NULL),
(3, 'Dr. Carol White', 'Lecturer', 'Computing', 'Interested in computing systems and embedded technologies.', NULL),
(4, 'Dr. David Green', 'Lecturer', 'Cyber Security', 'Teaches databases, cyber security, and applied digital systems.', NULL),
(5, 'Dr. Emma Scott', 'Principal Lecturer', 'Software Engineering', 'Leads curriculum development in software design and agile delivery.', NULL),
(6, 'Dr. Frank Moore', 'Lecturer', 'Data Science', 'Teaches algorithms, data structures, and computing fundamentals.', NULL),
(7, 'Dr. Grace Adams', 'Lecturer', 'Cyber Security', 'Works on network defence, security awareness, and digital forensics.', NULL),
(8, 'Dr. Henry Clark', 'Senior Lecturer', 'Artificial Intelligence', 'Researches AI, machine learning, and intelligent applications.', NULL),
(9, 'Dr. Irene Hall', 'Lecturer', 'Artificial Intelligence', 'Teaches supervised and unsupervised machine learning methods.', NULL),
(10, 'Dr. James Wright', 'Lecturer', 'Cyber Security', 'Focuses on penetration testing and ethical hacking practice.', NULL),
(11, 'Dr. Sophia Miller', 'Professor', 'Artificial Intelligence', 'Leads postgraduate AI and machine learning research initiatives.', NULL),
(12, 'Dr. Benjamin Carter', 'Professor', 'Cyber Security', 'Specialises in cyber threat intelligence and security governance.', NULL),
(13, 'Dr. Chloe Thompson', 'Senior Lecturer', 'Data Science', 'Works on big data systems and cloud analytics platforms.', NULL),
(14, 'Dr. Daniel Robinson', 'Senior Lecturer', 'Artificial Intelligence', 'Researches autonomous systems and human-centred AI.', NULL),
(15, 'Dr. Emily Davis', 'Professor', 'Software Engineering', 'Leads postgraduate software engineering and emerging technologies teaching.', NULL),
(16, 'Dr. Nathan Hughes', 'Lecturer', 'Computing', 'Focuses on ethics, cloud systems, and distributed computing.', NULL),
(17, 'Dr. Olivia Martin', 'Lecturer', 'Computing', 'Interested in quantum computing and advanced algorithmic methods.', NULL),
(18, 'Dr. Samuel Anderson', 'Lecturer', 'Law & Technology', 'Teaches privacy, governance, and cyber law.', NULL),
(19, 'Dr. Victoria Hall', 'Senior Lecturer', 'Artificial Intelligence', 'Specialises in deep learning and neural network systems.', NULL),
(20, 'Dr. William Scott', 'Lecturer', 'Human-Centred Computing', 'Explores interaction design and human-AI systems.', NULL);

INSERT INTO AdminUsers (Username, PasswordHash, FullName, Role) VALUES
('admin', '$2y$12$vQ65nY5OTztKpP51NpSNiOYCrC7.fXhLmSXN3GfbFfMPqIEqnLNju', 'System Administrator', 'super_admin'),
('editor', '$2y$12$/wX365jOm3/mKrdt.rmnm.H/ZLYjKdiWmivK8Vee.58yE5rHSWKhS', 'Programme Editor', 'editor'),
('mailer', '$2y$12$u6UkOwR42fripZXr1g0wJOlfqtb7j93t3oLRbTVxq4iRnqVSP1ziO', 'Mailing List Officer', 'mailer');

INSERT INTO Modules (ModuleID, ModuleName, ModuleLeaderID, Description, Image, ImageAlt) VALUES
(1, 'Introduction to Programming', 1, 'Covers the fundamentals of programming using Python and Java.', NULL, 'Students learning introductory programming concepts.'),
(2, 'Mathematics for Computer Science', 2, 'Teaches discrete mathematics, linear algebra, and probability theory.', NULL, 'Mathematics content supporting computer science study.'),
(3, 'Computer Systems & Architecture', 3, 'Explores CPU design, memory management, and assembly language.', NULL, 'Illustration of computer systems and hardware architecture.'),
(4, 'Databases', 4, 'Covers SQL, relational database design, and NoSQL systems.', NULL, 'Database systems and SQL concepts.'),
(5, 'Software Engineering', 5, 'Focuses on agile development, design patterns, and project management.', NULL, 'Software engineering and team development activities.'),
(6, 'Algorithms & Data Structures', 6, 'Examines sorting, searching, graphs, and complexity analysis.', NULL, 'Algorithm and data structure visual concepts.'),
(7, 'Cyber Security Fundamentals', 7, 'Provides an introduction to network security, cryptography, and vulnerabilities.', NULL, 'Cyber security concepts and digital protection.'),
(8, 'Artificial Intelligence', 8, 'Introduces AI concepts such as neural networks, expert systems, and robotics.', NULL, 'Artificial intelligence and machine reasoning concepts.'),
(9, 'Machine Learning', 9, 'Explores supervised and unsupervised learning, including decision trees and clustering.', NULL, 'Machine learning concepts and data models.'),
(10, 'Ethical Hacking', 10, 'Covers penetration testing, security assessments, and cybersecurity laws.', NULL, 'Ethical hacking and security testing activities.'),
(11, 'Computer Networks', 1, 'Teaches TCP/IP, network layers, and wireless communication.', NULL, 'Network infrastructure and communication systems.'),
(12, 'Software Testing & Quality Assurance', 2, 'Focuses on automated testing, debugging, and code reliability.', NULL, 'Software testing and quality assurance practices.'),
(13, 'Embedded Systems', 3, 'Examines microcontrollers, real-time OS, and IoT applications.', NULL, 'Embedded systems and connected devices.'),
(14, 'Human-Computer Interaction', 4, 'Studies UI/UX design, usability testing, and accessibility.', NULL, 'Human-computer interaction and interface design.'),
(15, 'Blockchain Technologies', 5, 'Covers distributed ledgers, consensus mechanisms, and smart contracts.', NULL, 'Blockchain and distributed ledger technologies.'),
(16, 'Cloud Computing', 6, 'Introduces cloud services, virtualization, and distributed systems.', NULL, 'Cloud computing infrastructure and services.'),
(17, 'Digital Forensics', 7, 'Teaches forensic investigation techniques for cybercrime.', NULL, 'Digital forensics and incident investigation.'),
(18, 'Final Year Project', 8, 'A major independent project where students develop a software solution.', NULL, 'Independent project development and research activity.'),
(19, 'Advanced Machine Learning', 11, 'Covers deep learning, reinforcement learning, and cutting-edge AI techniques.', NULL, 'Advanced machine learning and AI research.'),
(20, 'Cyber Threat Intelligence', 12, 'Focuses on cybersecurity risk analysis, malware detection, and threat mitigation.', NULL, 'Threat intelligence and cyber risk analysis.'),
(21, 'Big Data Analytics', 13, 'Explores data mining, distributed computing, and AI-driven insights.', NULL, 'Big data and analytics workflows.'),
(22, 'Cloud & Edge Computing', 14, 'Examines scalable cloud platforms, serverless computing, and edge networks.', NULL, 'Cloud and edge computing technologies.'),
(23, 'Blockchain & Cryptography', 15, 'Covers decentralized applications, consensus algorithms, and security measures.', NULL, 'Blockchain systems and cryptographic foundations.'),
(24, 'AI Ethics & Society', 16, 'Analyzes ethical dilemmas in AI, fairness, bias, and regulatory considerations.', NULL, 'Ethical issues surrounding AI and society.'),
(25, 'Quantum Computing', 17, 'Introduces quantum algorithms, qubits, and cryptographic applications.', NULL, 'Quantum computing principles and qubit systems.'),
(26, 'Cybersecurity Law & Policy', 18, 'Explores digital privacy, GDPR, and international cyber law.', NULL, 'Cybersecurity law, privacy, and policy topics.'),
(27, 'Neural Networks & Deep Learning', 19, 'Delves into convolutional networks, GANs, and AI advancements.', NULL, 'Neural networks and deep learning models.'),
(28, 'Human-AI Interaction', 20, 'Studies AI usability, NLP systems, and social robotics.', NULL, 'Human-AI interaction and intelligent interface design.'),
(29, 'Autonomous Systems', 11, 'Focuses on self-driving technology, robotics, and intelligent agents.', NULL, 'Autonomous systems and robotics concepts.'),
(30, 'Digital Forensics & Incident Response', 12, 'Teaches forensic analysis, evidence gathering, and threat mitigation.', NULL, 'Incident response and forensic analysis workflows.'),
(31, 'Postgraduate Dissertation', 13, 'A major research project where students explore advanced topics in computing.', NULL, 'Postgraduate dissertation research activity.');

INSERT INTO Programmes (ProgrammeID, ProgrammeName, LevelID, ProgrammeLeaderID, Description, Image, ImageAlt, IsPublished) VALUES
(1, 'BSc Computer Science', 1, 1, 'A broad computer science degree covering programming, AI, cybersecurity, and software engineering.', NULL, 'Students exploring computer science topics.', 1),
(2, 'BSc Software Engineering', 1, 2, 'A specialised degree focusing on the development and lifecycle of software applications.', NULL, 'Software engineering degree showcase.', 1),
(3, 'BSc Artificial Intelligence', 1, 3, 'Focuses on machine learning, deep learning, and AI applications.', NULL, 'Artificial intelligence course showcase.', 1),
(4, 'BSc Cyber Security', 1, 4, 'Explores network security, ethical hacking, and digital forensics.', NULL, 'Cyber security degree showcase.', 1),
(5, 'BSc Data Science', 1, 5, 'Covers big data, machine learning, and statistical computing.', NULL, 'Data science degree showcase.', 1),
(6, 'MSc Machine Learning', 2, 11, 'A postgraduate degree focusing on deep learning, AI ethics, and neural networks.', NULL, 'Machine learning postgraduate course showcase.', 1),
(7, 'MSc Cyber Security', 2, 12, 'A specialised programme covering digital forensics, cyber threat intelligence, and security policy.', NULL, 'Postgraduate cyber security course showcase.', 1),
(8, 'MSc Data Science', 2, 13, 'Focuses on big data analytics, cloud computing, and AI-driven insights.', NULL, 'Postgraduate data science course showcase.', 1),
(9, 'MSc Artificial Intelligence', 2, 14, 'Explores autonomous systems, AI ethics, and deep learning technologies.', NULL, 'Postgraduate AI course showcase.', 1),
(10, 'MSc Software Engineering', 2, 15, 'Emphasises software design, blockchain applications, and cutting-edge methodologies.', NULL, 'Postgraduate software engineering course showcase.', 0);

INSERT INTO ProgrammeModules (ProgrammeID, ModuleID, Year) VALUES
(1, 1, 1), (1, 2, 1), (1, 3, 1), (1, 4, 1),
(2, 1, 1), (2, 2, 1), (2, 3, 1), (2, 4, 1),
(3, 1, 1), (3, 2, 1), (3, 3, 1), (3, 4, 1),
(4, 1, 1), (4, 2, 1), (4, 3, 1), (4, 4, 1),
(5, 1, 1), (5, 2, 1), (5, 3, 1), (5, 4, 1),
(1, 5, 2), (1, 6, 2), (1, 7, 2), (1, 8, 2),
(2, 5, 2), (2, 6, 2), (2, 12, 2), (2, 14, 2),
(3, 5, 2), (3, 9, 2), (3, 8, 2), (3, 10, 2),
(4, 7, 2), (4, 10, 2), (4, 11, 2), (4, 17, 2),
(5, 5, 2), (5, 6, 2), (5, 9, 2), (5, 16, 2),
(1, 11, 3), (1, 13, 3), (1, 15, 3), (1, 18, 3),
(2, 13, 3), (2, 15, 3), (2, 16, 3), (2, 18, 3),
(3, 13, 3), (3, 15, 3), (3, 16, 3), (3, 18, 3),
(4, 15, 3), (4, 16, 3), (4, 17, 3), (4, 18, 3),
(5, 9, 3), (5, 14, 3), (5, 16, 3), (5, 18, 3),
(6, 19, 1), (6, 24, 1), (6, 27, 1), (6, 29, 1), (6, 31, 1),
(7, 20, 1), (7, 26, 1), (7, 30, 1), (7, 23, 1), (7, 31, 1),
(8, 21, 1), (8, 22, 1), (8, 27, 1), (8, 28, 1), (8, 31, 1),
(9, 19, 1), (9, 24, 1), (9, 28, 1), (9, 29, 1), (9, 31, 1),
(10, 23, 1), (10, 22, 1), (10, 25, 1), (10, 26, 1), (10, 31, 1);

INSERT INTO InterestedStudents (ProgrammeID, StudentName, Email, IsActive, WithdrawToken) VALUES
(1, 'John Doe', 'john.doe@example.com', 1, 'token-john-001'),
(4, 'Jane Smith', 'jane.smith@example.com', 1, 'token-jane-001'),
(6, 'Alex Brown', 'alex.brown@example.com', 1, 'token-alex-001'),
(9, 'Priya Patel', 'priya.patel@example.com', 1, 'token-priya-001');
