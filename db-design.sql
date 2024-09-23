CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    type ENUM('Book', 'DVD', 'Furniture') NOT NULL,
    weight DECIMAL(5, 2) NULL, -- Applicable for Books
    size DECIMAL(10, 2) NULL,  -- Applicable for DVDs
    height DECIMAL(5, 2) NULL, -- Applicable for Furniture
    width DECIMAL(5, 2) NULL,  -- Applicable for Furniture
    length DECIMAL(5, 2) NULL, -- Applicable for Furniture
    CHECK (type != 'Book' OR weight IS NOT NULL),  -- Enforce that Books have weight
    CHECK (type != 'DVD' OR size IS NOT NULL),     -- Enforce that DVDs have size
    CHECK (type != 'Furniture' OR (height IS NOT NULL AND width IS NOT NULL AND length IS NOT NULL)) -- Enforce that Furniture has dimensions
);
