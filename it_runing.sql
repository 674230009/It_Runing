CREATE TABLE competitors (
    competitor_id VARCHAR(20) PRIMARY KEY,
    competitor_prefix VARCHAR(10) NULL,
    competitor_firstname VARCHAR(50) NOT NULL,
    competitor_lastname VARCHAR(50) NOT NULL,
    competitor_email VARCHAR(100) NOT NULL,
    competitor_phone VARCHAR(100) NULL,
    major VARCHAR(100) NULL,
    shirt_size VARCHAR(50) NULL,
    register_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
