-- Doctrine Migration File Generated on 2019-12-30 21:13:02

-- Version 20191230211106
CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(104) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, age VARCHAR(255) DEFAULT NULL, uuid VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
INSERT INTO migration_versions (version, executed_at) VALUES ('20191230211106', CURRENT_TIMESTAMP);