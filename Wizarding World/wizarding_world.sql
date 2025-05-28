USE wizarding_world;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS spells (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    spell_name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Items table
CREATE TABLE IF NOT EXISTS items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    image_url VARCHAR(255) NOT NULL -- Ensuring no NULL values
);

-- Insert static items with proper image paths
INSERT INTO items (item_name, description, image_url) VALUES
('Invisibility Cloak', 'A cloak that renders the wearer invisible to the naked eye.', 'invisibility_cloak.jpg'),
('Elder Wand', 'The most powerful wand ever created, part of the Deathly Hallows.', 'elder_wand.jpg'),
('Resurrection Stone', 'A magical stone capable of summoning spirits of the dead.', 'resurrection_stone.jpg'),
('Marauder’s Map', 'A map showing every person within Hogwarts School.', 'marauders_map.jpg'),
('Firebolt', 'A top-tier broomstick used for high-speed flying and Quidditch.', 'firebolt.jpg');
