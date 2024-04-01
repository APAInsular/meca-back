-- Create a new database
CREATE DATABASE YourDatabaseName;

-- Create a new user
CREATE USER 'YourUserName'@'localhost' IDENTIFIED BY 'YourPassword';

-- Grant permissions to the user for the database
GRANT ALL PRIVILEGES ON YourDatabaseName.* TO 'YourUserName'@'localhost';

-- Flush privileges to apply changes
FLUSH PRIVILEGES;
