-- PostgreSQL initialization script for MCF8
-- Converted from original MySQL schema to PostgreSQL compatibility

-- Create database is handled by POSTGRES_DB environment variable

-- Table for Contact Form Submissions
CREATE TABLE IF NOT EXISTS contact_messages (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT now()
);

-- Table for Bug Tracker (Bugreports)
CREATE TABLE IF NOT EXISTS bug_reports (
    id SERIAL PRIMARY KEY,
    minecraft_username VARCHAR(16) NOT NULL,
    discord_tag VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    steps_to_reproduce TEXT NOT NULL,
    severity VARCHAR(10) NOT NULL DEFAULT 'low' CHECK (severity IN ('low','medium','high','critical')),
    ip_address VARCHAR(45) NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT now()
);

-- Table for Player Ranking Leaderboard
CREATE TABLE IF NOT EXISTS players_ranking (
    id SERIAL PRIMARY KEY,
    username VARCHAR(16) NOT NULL UNIQUE,
    kills INT NOT NULL DEFAULT 0,
    deaths INT NOT NULL DEFAULT 0,
    points INT NOT NULL DEFAULT 1000,
    last_active TIMESTAMP WITH TIME ZONE DEFAULT now()
);

-- Table for Recent Deaths Logs
CREATE TABLE IF NOT EXISTS recent_deaths (
    id SERIAL PRIMARY KEY,
    victim VARCHAR(16) NOT NULL,
    killer VARCHAR(16),
    death_message VARCHAR(255) NOT NULL,
    killed_at TIMESTAMP WITH TIME ZONE DEFAULT now()
);

-- Seed Player Ranking with Mock Statistics (upsert by username)
INSERT INTO players_ranking (username, kills, deaths, points) VALUES
('AquaKnight', 142, 38, 1850),
('HydroPvP', 125, 42, 1720),
('WaveCrasher', 98, 31, 1600),
('FrostyGamer', 87, 45, 1490),
('CoralGazer', 74, 50, 1380),
('DeepBlue', 63, 40, 1250),
('TidalWave', 55, 52, 1120),
('StormyNight', 40, 48, 1010),
('OceanicSteve', 23, 35, 950),
('Kelpy', 12, 30, 820)
ON CONFLICT (username) DO UPDATE SET
    kills = EXCLUDED.kills,
    deaths = EXCLUDED.deaths,
    points = EXCLUDED.points;

-- Seed Recent Deaths with Mock logs
INSERT INTO recent_deaths (victim, killer, death_message) VALUES
('Kelpy', 'AquaKnight', 'Kelpy was slain by AquaKnight using [Trident of the Sea]'),
('OceanicSteve', NULL, 'OceanicSteve drowned while escaping a Guardian'),
('StormyNight', 'HydroPvP', 'StormyNight was shot by HydroPvP'),
('TidalWave', NULL, 'TidalWave tried to swim in lava'),
('Kelpy', 'WaveCrasher', 'Kelpy was slain by WaveCrasher'),
('FrostyGamer', NULL, 'FrostyGamer fell from a high place');
